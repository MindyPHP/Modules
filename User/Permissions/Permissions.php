<?php

namespace Modules\User\Permissions;

use Mindy\Base\Mindy;
use Modules\User\Models\GroupPermission;
use Modules\User\Models\Permission;
use Modules\User\Models\PermissionObjectThrough;
use Modules\User\Models\UserPermission;

/**
 * Class Permissions
 * @package Modules\User
 */
class Permissions extends PermissionsBase
{
    /**
     * @var bool
     */
    public $autoFetch = true;

    public function getUser()
    {
        return Mindy::app()->user;
    }

    public function init()
    {
        if ($this->autoFetch) {
            $this->setPermissions($this->fetchPermissions());
            $this->setPermissionsUser($this->fetchPermissionsUser());
            $this->setPermissionsGroup($this->fetchPermissionsGroup());
            $this->setPermissionsObject($this->fetchPermissionsObject());
        }
    }

    /**
     * Получение прав доступа
     * @return array [code => permission]
     */
    protected function fetchPermissions()
    {
        $permissions = [];
        $perms = Permission::objects()->asArray()->all();
        foreach ($perms as $permission) {
            $permissions[$permission['code']] = $permission;
        }
        return $permissions;
    }

    /**
     * Получение прав доступа по пользователям
     * @return array [code => [user_id, user_id, ...]]
     */
    protected function fetchPermissionsUser()
    {
        $permissions = [];
        $permsUser = UserPermission::objects()->filter(['permission__code__isnull' => false])->all();
        foreach ($permsUser as $perm) {
            $permissions[$perm->permission->code][] = $perm->user_id;
        }
        return $permissions;
    }

    /**
     * Получение прав доступа по группам пользователей
     * @return array [code => [group_id, group_id, ...]]
     */
    protected function fetchPermissionsGroup()
    {
        $permissions = [];
        $permsUser = GroupPermission::objects()->filter(['permission__code__isnull' => false])->all();
        foreach ($permsUser as $perm) {
            $permissions[$perm->permission->code][] = $perm->group_id;
        }
        return $permissions;
    }

    /**
     * Получение прав доступа по объектам
     * @return array
     */
    protected function fetchPermissionsObject()
    {
        $permissions = [];
        $models = PermissionObjectThrough::objects()->all();
        foreach ($models as $model) {
            $permission = $model->permission;
            $className = $permission->object_class;
            $type = $model->type == self::TYPE_USER ? 'user' : 'group';

            if (!isset($permissions[$className][$permission->object_id])) {
                $permissions[$className][$permission->object_id] = [];
            }
            if (!isset($permissions[$className][$permission->object_id][$type])) {
                $permissions[$className][$permission->object_id][$type] = [];
            }
            $permissions[$className][$permission->object_id][$type][] = $model->owner_id;
        }
        return $permissions;
    }
}
