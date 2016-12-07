<?php

namespace Modules\User\Models;

use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ManyToManyField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;

/**
 * Class Group
 * @package Modules\User
 */
class Group extends Model
{
    public static function getFields()
    {
        return [
            "name" => [
                'class' => CharField::class,
                'verboseName' => self::t("Name"),
            ],
            "description" => [
                'class' => TextField::class,
                'verboseName' => self::t("Description"),
                'null' => true
            ],
            "is_locked" => [
                'class' => BooleanField::class,
                'verboseName' => self::t("Is locked"),
            ],
            "is_visible" => [
                'class' => BooleanField::class,
                'default' => true,
                'verboseName' => self::t("Is visible"),
            ],
            "is_default" => [
                'class' => BooleanField::class,
                'verboseName' => self::t("Is default"),
            ],
            'permissions' => [
                'class' => ManyToManyField::class,
                'modelClass' => Permission::class,
                'through' => GroupPermission::class,
                'throughLink' => ['group_id', 'permission_id'],
                'verboseName' => self::t("Permissions"),
            ],
            'users' => [
                'class' => ManyToManyField::class,
                'modelClass' => User::class,
                'verboseName' => self::t("Users"),
                'editable' => false
            ]
        ];
    }

    public function __toString()
    {
        return (string)$this->name;
    }
}
