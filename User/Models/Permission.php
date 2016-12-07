<?php

namespace Modules\User\Models;

use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;

/**
 * Class Permission
 * @package Modules\User
 */
class Permission extends Model
{
    public function __toString()
    {
        return (string)$this->name . ' (' . $this->code . ')';
    }

    public static function getFields()
    {
        return [
            "code" => [
                'class' => CharField::class,
                'verboseName' => self::t("Key"),
                'unique' => true,
                'helpText' => self::t("Rule code for developers to use in source code")
            ],
            "name" => [
                'class' => CharField::class,
                'verboseName' => self::t("Name"),
                'helpText' => self::t("Rule name")
            ],
            "bizrule" => [
                'class' => TextField::class,
                'null' => true,
                'verboseName' => self::t("Bussines rule"),
                'helpText' => self::t("More info in documentation")
            ],
            "is_locked" => [
                'class' => BooleanField::class,
                'verboseName' => self::t("Is locked"),
                'helpText' => self::t("Locked for editing. Editing allowed only for super-administrator.")
            ],
            "is_auto" => [
                'class' => BooleanField::class,
                'verboseName' => self::t("Is auto"),
                'helpText' => self::t("Rule created automatically by module. Editing allowed only for super-administrator.")
            ],
            "is_visible" => [
                'class' => BooleanField::class,
                'default' => true,
                'verboseName' => self::t("Is visible"),
                'helpText' => self::t('Rule is visible only to super-administrator')
            ],
            "is_default" => [
                'class' => BooleanField::class,
                'verboseName' => self::t("Is default"),
                'helpText' => self::t("Default rule. Rule applies to all users after creation")
            ],
            "is_global" => [
                'class' => BooleanField::class,
                'verboseName' => self::t("Is global"),
                'helpText' => self::t("Global rule. This type of rule has priority and overrides other rules. More info in documentation.")
            ],
        ];
    }
}
