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
 * @date 09/12/14 16:17
 */
namespace Modules\Sms\Models;

use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;

class SmsTemplate extends Model
{
    public static function getFields() 
    {
        return [
            'code' => [
                'class' => CharField::className(),
                'null' => false,
                'unique' => true,
                'verboseName' => self::t('Code')
            ],
            'template' => [
                'class' => TextField::className(),
                'null' => false,
                'verboseName' => self::t('Template')
            ],
            'is_locked' => [
                'class' => BooleanField::className(),
                'default' => false,
                'editable' => false,
                'verboseName' => self::t('Is locked')
            ]
        ];
    }
} 