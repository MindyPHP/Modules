<?php

namespace Modules\User\Models;

use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Model;

/**
 * Class PermissionObject
 * @package Modules\User
 */
class PermissionObject extends Model
{
    public static function getFields()
    {
        return [
            'object_class' => [
                'class' => CharField::class,
                'verboseName' => self::t('Object class name'),
                'editable' => false
            ],
            'object_id' => [
                'class' => CharField::class,
                'verboseName' => self::t("Permission name"),
                'editable' => false
            ],
            'is_auto' => [
                'class' => BooleanField::class,
                'verboseName' => self::t("Is auto")
            ],
            'is_locked' => [
                'class' => BooleanField::class,
                'verboseName' => self::t("Is locked")
            ],
        ];
    }
}
