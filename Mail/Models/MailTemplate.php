<?php

namespace Modules\Mail\Models;

use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Mail\MailModule;

class MailTemplate extends Model
{
    public static function getFields()
    {
        return [
            'code' => [
                'class' => CharField::class,
                'null' => false,
                'unique' => true,
                'verboseName' => self::t('Code')
            ],
            'subject' => [
                'class' => CharField::class,
                'null' => false,
                'verboseName' => self::t('Subject')
            ],
            'message' => [
                'class' => TextField::class,
                'null' => false,
                'default' => '',
                'verboseName' => self::t('Message')
            ],
            'template' => [
                'class' => CharField::class,
                'null' => true,
                'verboseName' => self::t('Template')
            ],
            'is_locked' => [
                'class' => BooleanField::class,
                'default' => false,
                'verboseName' => self::t('Is locked')
            ]
        ];
    }

    public function __toString()
    {
        return (string)$this->code;
    }
}
