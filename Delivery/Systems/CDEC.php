<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 25/05/15 10:48
 */

namespace Modules\Delivery\Systems;

use Modules\Delivery\Components\DeliverySystem;
use Modules\Delivery\Components\IDeliverySystem;

class CDEC extends DeliverySystem implements IDeliverySystem
{
    public $url = "http://api.edostavka.ru/calculator/calculate_price_by_json.php";

    public $authLogin;
    public $authPassword;

    public $dateExecute;

    public $tariffListPriority = [];

    public $countTariffs = [
        10,
        11
    ];

    public function getTariffsNames()
    {
        return [
            10 => 'Экспресс лайт склад-склад',
            11 => 'Экспресс лайт склад-дверь',
        ];
    }

    public $defaultPickup = [
        'senderCityId' => 415
    ];

    public function __construct() {
        $this->dateExecute = date('Y-m-d');
    }

    protected function _getSecureAuthPassword() {
        return md5($this->dateExecute . '&' . $this->authPassword);
    }

    protected function _getRemoteData($data) {
//        d($data);
        $data_string = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json')
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    public function count($size, $place, $from = [])
    {
        $data = [];
        $data['version'] = "1.0";
        $data['dateExecute'] = $this->dateExecute;

        isset($this->authLogin) ? $data['authLogin'] = $this->authLogin : null;
        isset($this->authPassword) ? $data['secure'] = $this->_getSecureAuthPassword() : null;

        if (isset($place['receiverCityId']) || isset($place['receiverCityPostCode'])) {
            $data = array_merge($place, $data);
        } else {
            return null;
        }

        if (isset($from['senderCityId']) || isset($from['senderCityPostCode'])) {
            $data = array_merge($from, $data);
        } else {
            $data = array_merge($this->defaultPickup, $data);
        }

        $data['goods'] = [$size];

        $result = [];
        foreach ($this->countTariffs as $tariffId) {
            $tariffData = array_merge($data, ['tariffId' => $tariffId]);
            $answer = $this->_getRemoteData($tariffData);
            if (isset($answer['result'])) {
                $result[$tariffId] = $answer['result'];
            } else {
                $result[$tariffId] = null;
            }
        }

        return $result;
    }

    public function getCities()
    {
        return [];
    }
}