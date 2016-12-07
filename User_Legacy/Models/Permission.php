<?php

namespace Modules\User\Models;

use Mindy\Base\Mindy;
use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Model;

/**
 * Class Permission
 * @package Modules\User
 */
class Permission extends Model
{
    const TYPE_USER = 0;
    const TYPE_GROUP = 1;

    public function __toString()
    {
        return (string) $this->code;
    }

    public static function getFields()
    {
        return [
            "code" => [
                'class' => CharField::className(),
                'verboseName' => self::t("Key"),
                'unique' => true,
                'helpText' => self::t("Rule code for developers to use in source code")
            ],
            "name" => [
                'class' => CharField::className(),
                'verboseName' => self::t("Name"),
                'helpText' => self::t("Rule name")
            ],
            "bizrule" => [
                'class' => CharField::className(),
                'null' => true,
                'verboseName' => self::t("Bussines rule"),
                'helpText' => self::t("More info in documentation")
            ],
            "is_locked" => [
                'class' => BooleanField::className(),
                'verboseName' => self::t("Is locked"),
                'helpText' => self::t("Locked for editing. Editing allowed only for super-administrator.")
            ],
            "is_auto" => [
                'class' => BooleanField::className(),
                'verboseName' => self::t("Is auto"),
                'helpText' => self::t("Rule created automatically by module. Editing allowed only for super-administrator.")
            ],
            "is_visible" => [
                'class' => BooleanField::className(),
                'default' => true,
                'verboseName' => self::t("Is visible"),
                'helpText' => self::t('Rule is visible only to super-administrator')
            ],
            "is_default" => [
                'class' => BooleanField::className(),
                'verboseName' => self::t("Is default"),
                'helpText' => self::t("Default rule. Rule applies to all users after creation")
            ],
            "is_global" => [
                'class' => BooleanField::className(),
                'verboseName' => self::t("Is global"),
                'helpText' => self::t("Global rule. This type of rule has priority and overrides other rules. More info in documentation.")
            ],
        ];
    }

    public function getTypes()
    {
        return [
            self::TYPE_USER => self::t('User'),
            self::TYPE_GROUP => self::t('Group'),
        ];
    }

    /**
     * @return \Modules\User\Components\Permissions
     */
    protected function getPermissions()
    {
        return Mindy::app()->getComponent('permissions');
    }
}
