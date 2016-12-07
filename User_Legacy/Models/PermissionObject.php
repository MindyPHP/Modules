<?php

namespace Modules\User\Models;

use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Model;
use Modules\User\Components\Permissions;

/**
 * Class PermissionObject
 * @package Modules\User
 */
class PermissionObject extends Model
{
    public static function getFields()
    {
        return [
            'code' => [
                'class' => CharField::className(),
                'verboseName' => self::t("Permission code")
            ],
            'type' => [
                'class' => CharField::className(),
                'verboseName' => self::t("Type")
            ],
            'name' => [
                'class' => CharField::className(),
                'verboseName' => self::t("Permission name")
            ],
            'module' => [
                'class' => CharField::className(),
                'verboseName' => self::t("Module")
            ],
            'is_auto' => [
                'class' => BooleanField::className(),
                'verboseName' => self::t("Is auto")
            ],
            'is_locked' => [
                'class' => BooleanField::className(),
                'verboseName' => self::t("Is locked")
            ],
        ];
    }

    public function getObjectPermissions($modelName, $id)
    {
        $groups = $users = [];

        $models = $this->objects()->filter(['model_id' => $id, 'model_class' => $modelName])->all();
        foreach ($models as $model) {
            if ($model->type == Permissions::TYPE_USER) {
                $users[$model->owner_id][] = $model->permission_id;
            } else {
                $groups[$model->owner_id][] = $model->permission_id;
            }
        }

        return ['groups' => $groups, 'users' => $users];
    }

    public function clearObjectPermissions($modelName, $id)
    {
        return $this->objects()->filter(['model_id' => $id, 'model_class' => $modelName])->delete();
    }

    public function setObjectPermissions($modelName, $id, $permissions, $owner_id, $type = Permissions::TYPE_USER)
    {
        if (is_array($permissions)) {
            foreach ($permissions as $permission) {
                $perm = new self([
                    'permission_id' => $permission,
                    'owner_id' => $owner_id,
                    'model_class' => $modelName,
                    'model_id' => $id,
                    'type' => $type
                ]);
                $perm->save();
            }
        }
    }
}
