<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 12/05/16 15:07
 */

namespace Modules\Mail\Models;

use Mindy\Orm\Fields\IntField;
use Mindy\Validation\MinLengthValidator;
use Modules\Admin\Models\SettingsModel;

class MailSettings extends SettingsModel
{
    public static function getFields()
    {
        return [
            'amount_days' => [
                'class' => IntField::class,
                'default' => 60,
                'verboseName' => self::t('Amount of days'),
                'helpText' => self::t('Amount of days for store mail messages'),
                'null' => false,
                'validators' => [
                    new MinLengthValidator(1)
                ]
            ]
        ];
    }

    public function __toString()
    {
        return self::t('Mail settings');
    }
}