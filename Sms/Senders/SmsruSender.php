<?php

namespace Modules\Sms\Senders;

class SmsruSender extends SmsSender
{
    const HOST = 'http://sms.ru/';
    const SEND = 'sms/send?';
    const STATUS = 'sms/status?';
    const COST = 'sms/cost?';
    const BALANCE = 'my/balance?';
    const LIMIT = 'my/limit?';
    const SENDERS = 'my/senders?';

    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $from;
    /**
     * @var string
     */
    public $time;
    /**
     * @var string public api key
     */
    public $api_id;

    public $statusMessages = [
        '100' => 'Сообщение принято к отправке.',
        '200' => 'Неправильный api_id',
        '201' => 'Не хватает средств на лицевом счету',
        '202' => 'Неправильно указан получатель',
        '203' => 'Нет текста сообщения',
        '204' => 'Имя отправителя не согласовано с администрацией',
        '205' => 'Сообщение слишком длинное (превышает 8 СМС)',
        '206' => 'Будет превышен или уже превышен дневной лимит на отправку сообщений',
        '207' => 'На этот номер (или один из номеров) нельзя отправлять сообщения, либо указано более 100 номеров в списке получателей',
        '208' => 'Параметр time указан неправильно',
        '209' => 'Вы добавили этот номер (или один из номеров) в стоп-лист',
        '210' => 'Используется GET, где необходимо использовать POST',
        '211' => 'Метод не найден',
        '220' => 'Сервис временно недоступен, попробуйте чуть позже.',
        '300' => 'Неправильный token (возможно истек срок действия, либо ваш IP изменился)',
        '301' => 'Неправильный пароль, либо пользователь не найден',
        '302' => 'Пользователь авторизован, но аккаунт не подтвержден (пользователь не ввел код, присланный в регистрационной смс)'
    ];

    public function send()
    {
        $url = self::HOST . self::SEND;
        $this->id = null;

        $params = $this->getDefaultParams();

        $params['to'] = $this->getReceiver();
        $params['text'] = $this->getMessage();

        if ($this->from) {
            $params['from'] = $this->from;
        }

        if ($this->time && $this->time < (time() + 7 * 60 * 60 * 24)) {
            $params['time'] = $this->time;
        }

        $result = $this->request($url, $params);

        $result = explode("\n", $result);

        $ticket = isset($result[1]) ? $result[1] : false;
        $code = isset($result[0]) ? $result[0] : false;

        if ($ticket) {
            $this->setSmsTicket($ticket);
            $this->setSent();
            return true;
        } else {
            $message = '';
            if ($code && array_key_exists($code, $this->statusMessages)) {
                $message = $this->statusMessages[$code];
            }
            $this->setError($message);
            return false;
        }
    }

    protected function getDefaultParams()
    {
        return ['api_id' => $this->api_id];
    }

    protected function request($url, $params = array())
    {
        $ch = curl_init($url);
        $options = [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POSTFIELDS => $params
        ];
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}