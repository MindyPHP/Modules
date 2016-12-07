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
 * @date 09/12/14 17:17
 */

namespace Modules\Sms\Senders;

use Mindy\Helper\Traits\Configurator;

abstract class SmsSender
{
    use Configurator;

    /**
     * @var string
     */
    public $smsTicket;
    /**
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $receiver;

    /**
     * @var \Modules\Sms\Models\Sms
     */
    protected $_smsModel;

    public function setMessage($message = '')
    {
        $this->message = $message;
        $this->getSmsModel()->message = $message;
        return $this;

    }

    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
        $this->getSmsModel()->receiver = $receiver;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->getSmsModel()->message;
    }

    /**
     * @return mixed
     */
    public function getReceiver()
    {
        return $this->getSmsModel()->receiver;
    }

    /**
     * @return \Modules\Sms\Models\Sms
     */
    public function getSmsModel()
    {
        return $this->_smsModel;
    }

    /**
     * @param $model
     * @return $this
     */
    public function setSmsModel($model)
    {
        $this->_smsModel = $model;
        return $this;
    }

    public function getSmsTicket()
    {
        return $this->getSmsModel()->ticket;
    }

    public function setSmsTicket($ticket)
    {
        $this->smsTicket = $ticket;
        $this->getSmsModel()->ticket = $ticket;
        return $this;
    }

    public function setSent()
    {
        $this->getSmsModel()->setSent();
        return $this;
    }

    public function setError($message = '')
    {
        $this->getSmsModel()->setError($message);
        return $this;
    }

    abstract function send();
} 