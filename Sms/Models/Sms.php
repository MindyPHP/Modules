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
 * @date 09/12/14 16:20
 */
namespace Modules\Sms\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Sms\SmsModule;

class Sms extends Model
{
    const STATUS_INIT = 1;
    const STATUS_SENT = 2;
    const STATUS_ERROR = 3;

    public static function getFields() 
    {
        return [
            'receiver' => [
                'class' => CharField::className(),
                'verboseName' => SmsModule::t('Receiver')
            ],
            'message' => [
                'class' => TextField::className(),
                'verboseName' => SmsModule::t('Message')
            ],
            'error' => [
                'class' => TextField::className(),
                'verboseName' => SmsModule::t('Error'),
                'null' => true
            ],
            'sender' => [
                'class' => CharField::className(),
                'verboseName' => SmsModule::t('Receiver'),
                'null' => true
            ],
            'ticket' => [
                'class' => CharField::className(),
                'verboseName' => SmsModule::t('Ticket'),
                'null' => true
            ],
            'status' => [
                'class' => IntField::className(),
                'verboseName' => SmsModule::t('Status'),
                'choices' => [
                    self::STATUS_INIT => SmsModule::t('Initialized'),
                    self::STATUS_SENT => SmsModule::t('Sent'),
                    self::STATUS_ERROR => SmsModule::t('Error')
                ]
            ],
            'created_at' => [
                'class' => DateTimeField::className(),
                'autoNowAdd' => true,
                'verboseName' => SmsModule::t('Created at')
            ],
        ];
    }

    public function __toString()
    {
        return (string)strtr("{receiver}: {message}", [
            '{receiver}' => $this->receiver,
            '{message}' => $this->message,
        ]);
    }

    public function setError($message = '')
    {
        $this->error = $message;
        $this->status = self::STATUS_ERROR;
        $this->save();
    }

    public function setSent()
    {
        $this->status = self::STATUS_SENT;
        $this->save();
    }
}