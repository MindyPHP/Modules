<?php

namespace Modules\User\Traits;

use Mindy\Base\Mindy;

/**
 * Class PermissionTrait
 * All rights reserved.
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 24/04/14.04.2014 22:01
 * @package Modules\User
 */
trait PermissionTrait
{
    /**
     * @var array for cached permissions
     */
    private $_access = [];

    public function getCacheTimeout()
    {
        return 60 * 60 * 10;
    }

    /**
     * Проверяем данную операцию для пользователя в кеше
     */
    public function can($code, $params = [])
    {
        /** @var \Modules\User\Models\UserBase $this */
        if ($this->is_superuser) {
            return true;
        }

        $cache = Mindy::app()->cache;
        $cacheId = 'permission_' . serialize([$code, $params, $this->pk]);
        $state = $cache->get($cacheId);
        if ($state === false) {
            /** @var \Modules\User\Permissions\Permissions $permissions */
            $permissions = Mindy::app()->permissions;
            $state = $permissions->can($code, $params);
            $cache->set($cacheId, (int)$state, $this->getCacheTimeout());
        }

        return $this->_access[$cacheId] = $state;
    }

    /**
     * @param $className
     * @param $pk
     * @param $operation
     * @return bool
     */
    public function canObject($className, $pk, $operation)
    {
        /** @var \Modules\User\Models\UserBase $this */
        if ($this->is_superuser) {
            return true;
        }

        $cache = Mindy::app()->cache;
        $cacheId = 'permission_' . serialize([$className, $pk, $operation, $this->pk]);
        $state = $cache->get($cacheId);
        if ($state === false) {
            /** @var \Modules\User\Permissions\Permissions $permissions */
            $permissions = Mindy::app()->permissions;
            $state = $permissions->canObject($className, $pk, $operation);
            $cache->set($cacheId, (int)$state, $this->getCacheTimeout());
        }

        return $this->_access[$cacheId] = $state;
    }
}
