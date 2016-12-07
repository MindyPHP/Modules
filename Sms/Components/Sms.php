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
 * @date 09/12/14 16:35
 */

namespace Modules\Sms\Components;

use Mindy\Base\Mindy;
use Mindy\Exception\Exception;
use Mindy\Exception\HttpException;
use Mindy\Helper\Creator;
use Mindy\Helper\Traits\Accessors;
use Mindy\Helper\Traits\Configurator;
use Mindy\Orm\Model;
use Mindy\Helper\Traits\RenderTrait;
use Modules\Sms\Models\SmsTemplate;

class Sms
{
    use Configurator, Accessors, RenderTrait;

    /**
     * Current sender
     * @var \Modules\Sms\Senders\SmsSender
     */
    protected $_currentSender;
    /**
     * Senders objects
     * @var array
     */
    protected $_senders = [];
    /**
     * Senders configuration
     * @var array
     */
    public $senders = [];
    /**
     * @var
     */
    public $defaultSender;

    /**
     * @param null $name
     * @param null $id
     * @param bool $reinit
     * @throws Exception
     */
    public function getSender($name = null, $id = null, $reinit = false)
    {
        if (!$name) {
            if ($this->defaultSender) {
                $name = $this->defaultSender;
            } else {
                reset($this->senders);
                $name = key($this->senders);
            }
        }

        if ($this->hasSender($name)) {
            if ((isset($this->_senders[$name]) == false) || $reinit) {
                $this->setSender($name, $id);
            }
            return $this->_senders[$name];
        } else {
            throw new Exception("Sender: {$name} is not set");
        }

    }

    /**
     * @param null $name
     * @param null $id
     * @throws Exception
     */
    public function setSender($name = null, $id = null)
    {
        if (!$name) {
            if ($this->defaultSender) {
                $name = $this->defaultSender;
            } else {
                reset($this->senders);
                $name = key($this->senders);
            }
        }

        if ($this->hasSender($name)) {
            /* @var $sender \Modules\Sms\Senders\SmsSender */
            $sender = Creator::createObject($this->senders[$name]);
            $sender->setSmsModel($this->getSmsModel($id));
            $sender->getSmsModel()->sender = $name;
            $this->_senders[$name] = $sender;
            $this->_currentSender = $this->_senders[$name];
        } else {
            throw new Exception("Sender: {$name} is not set");
        }
    }

    /**
     * @param $sender
     * @return bool
     */
    public function hasSender($sender)
    {
        return isset($this->senders[$sender]);
    }

    /**
     * @param Model $model
     * @return $this
     * @throws Exception
     */
    public function setSmsModel(Model $model)
    {
        $this->_smsModel = $model;
        $this->setSender($model->sender);
        return $this;
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function getSmsModel($id = null)
    {
        $class = Mindy::app()->getModule('Sms')->model;
        if ($id) {
            return $class::objects()->filter(['pk' => $id])->limit(1)->get();
        } else {
            return new $class;
        }
    }

    /**
     * @return \Modules\Sms\Senders\SmsSender|void
     * @throws Exception
     */
    public function getCurrentSender()
    {
        if (!$this->_currentSender) {
            $this->_currentSender = $this->getSender();
        }
        return $this->_currentSender;
    }

    /**
     * @param $receiver
     * @param $message
     * @return mixed
     */
    public function send($receiver, $message)
    {
        $this->getCurrentSender()->setReceiver($receiver);
        $this->getCurrentSender()->setMessage($message);
        return $this->getCurrentSender()->send();
    }

    /**
     * @param $code
     * @param $receiver
     * @param $data
     * @return mixed
     * @throws HttpException
     */
    public function fromCode($code, $receiver, $data)
    {
        $template = $this->loadTemplateModel($code);
        $message = $this->renderString($template->template, $data);
        return $this->send($receiver, $message);
    }

    /**
     * @param $code
     * @return bool|\Mindy\Orm\Orm|null
     * @throws HttpException
     */
    protected function loadTemplateModel($code)
    {
        $maildb = SmsTemplate::objects()->filter(['code' => $code])->get();
        if ($maildb === null) {
            if (MINDY_DEBUG) {
                throw new HttpException(500, "Sms template with code $code do not exists");
            } else {
                return false;
            }
        }
        return $maildb;
    }
}
