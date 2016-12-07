<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 18/02/16
 * Time: 11:40
 */

namespace Modules\UserActions\Models;

use Mindy\Orm\Fields\IntField;
use Modules\Admin\Models\SettingsModel;
use Modules\UserActions\UserActionsModule;

class UserLogSettings extends SettingsModel
{
    public function __toString()
    {
        return UserActionsModule::t('User actions');
    }

    public static function getFields()
    {
        return [
            'count' => [
                'class' => IntField::class,
                'verboseName' => self::t('Number of saved messages'),
                'default' => 60
            ]
        ];
    }
}