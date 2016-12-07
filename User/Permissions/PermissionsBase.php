<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 20:05
 */

namespace Modules\User\Permissions;

use Mindy\Helper\Traits\Accessors;
use Mindy\Helper\Traits\Configurator;

/**
 * Права доступа для объектов имеют наивысший приоритет
 *
 * Class PermissionsBase
 * @package Modules\User\Permissions
 */
abstract class PermissionsBase
{
    use Accessors, Configurator;

    /**
     * Тип пользователь
     */
    const TYPE_USER = 1;
    /**
     * Тип группа пользователя
     */
    const TYPE_GROUP = 2;
    /**
     * Разрешение на просмотр объекта
     */
    const CAN_OBJECT_VIEW = 1;
    /**
     * Разрешение на просмотр и редактирование
     */
    const CAN_OBJECT_VIEW_UPDATE = 2;
    /**
     * Разрешение на просмотр и удаление;
     */
    const CAN_OBJECT_VIEW_DELETE = 3;
    /**
     * Разрешение на редактирование объекта
     */
    const CAN_OBJECT_UPDATE = 4;
    /**
     * Разрешение на редактирование и удаление объекта
     */
    const CAN_OBJECT_UPDATE_DELETE = 5;
    /**
     * Разрешение на удаление объекта
     */
    const CAN_OBJECT_DELETE = 6;
    /**
     * Запрет на какое либо из действий с объектом
     */
    const CAN_OBJECT_NONE = 7;

    /**
     * Режим отладки. Отображение ошибок бизнес правил
     * @var bool
     */
    public $showErrors = MINDY_DEBUG;
    /**
     * Доступный список прав доступа
     * @var array
     */
    private $_permissions = [];
    /**
     * @var array вида [code => array с ids групп]
     */
    private $_permissionsGroup = [];
    /**
     * @var array вида [code => array с ids пользователей]
     */
    private $_permissionsUser = [];
    /**
     * @var array вида
     * [
     *      class модели => [
     *          id модели => [
     *              user => [
     *                  id пользователя => [права доступа],
     *              ],
     *              group => [
     *                  id группы => [права доступа]
     *              ]
     *          ]
     *      ]
     * ]
     */
    private $_permissionsObject = [];

    /**
     * @param array $permissions
     */
    public function setPermissionsObject(array $permissions)
    {
        $this->_permissionsObject = $permissions;
    }

    /**
     * @param array $permissions
     */
    public function setPermissionsGroup(array $permissions)
    {
        $this->_permissionsGroup = $permissions;
    }

    /**
     * @param array $permissions
     */
    public function setPermissionsUser(array $permissions)
    {
        $this->_permissionsUser = $permissions;
    }

    /**
     * @param array $permissions
     */
    public function setPermissions(array $permissions)
    {
        $this->_permissions = $permissions;
    }

    /**
     * Проверка существования правила
     * @param $code
     * @return bool
     */
    public function hasPermission($code)
    {
        return array_key_exists($code, $this->_permissions);
    }

    /**
     * @return \Modules\User\Models\UserBase
     */
    abstract public function getUser();

    /**
     * Выполнение бизнес правил
     * Бизнес правило это inline функция php, которая возвращает
     * истину или ложь
     *
     * Пример использования:
     * >>> return $params['user']->id != 1;
     * >>> return empty($params['object']->address);
     *
     * Использовать в данном методе return $params['user']->can()
     * не рекомендуется во избежание рекурсии
     *
     * @param $bizRule
     * @param array $params
     * @return bool
     */
    public function executeBizRule($bizRule, array $params = [])
    {
        if ($bizRule === '' || $bizRule === null) {
            return true;
        } else {
            if (strpos($bizRule, 'return ') === false) {
                $bizRule = "return " . $bizRule;
            }
            $bizRule = 'extract($params);' . $bizRule;
            if (substr($bizRule, -1) !== ';') {
                $bizRule .= ';';
            }
            return $this->showErrors ? eval($bizRule) != 0 : @eval($bizRule) != 0;
        }
    }

    /**
     * Проверка прав доступа
     * @param $code string код прав доступа
     * @param array $params параметры для бизнес правил
     * @return bool
     */
    public function can($code, $params = [])
    {
        if (is_array($code)) {
            foreach ($code as $c) {
                if ($this->hasPermission($c) && $this->can($code, $params)) {
                    return true;
                }
            }
            return false;
        } else {
            /**
             * Пользователю суперадминистратор все разрешено по умолчанию
             */
            if ($this->getUser()->is_superuser) {
                return true;
            }

            /**
             * Проверяем глобальные правила без учета bizRule.
             * Если пользователю запрещено или у пользователя отсутствовали такой код прав доступа,
             * проверяем права группы и выполняем бизнес правило
             */
            return $this->canGlobal($code) || $this->canUser($code, $params) || $this->canGroup($code, $params);
        }
    }

    /**
     * Проверка прав доступа по коду на переданного пользователя
     * По умолчанию все действия пользователю запрещены
     * Проверяем сущесвуют ли такой код прав доступа и есть ли pk пользователя в разрешенных
     * @param $code
     * @return bool
     */
    public function hasPermissionUser($code)
    {
        return isset($this->_permissionsUser[$code]) && in_array($this->getUser()->pk, $this->_permissionsUser[$code]);
    }

    /**
     * @param $code
     * @param $params
     * @return bool
     */
    private function canUser($code, $params)
    {
        return $this->hasPermissionUser($code) && $this->canBizRule($code, $params);
    }


    /**
     * Проверка прав доступа на группу пользователя по переданному коду.
     * Проверяем существуют ли такой код прав доступа и есть ли pk групп пользвователя в разрешенных
     * По умолчанию все действия на группу запрещены
     * @param $code
     * @return bool
     */
    public function hasPermissionGroup($code)
    {
        if (isset($this->_permissionsGroup[$code])) {
            $groups = $this->getUserGroups();
            foreach ($groups as $id) {
                if (in_array($id, $this->_permissionsGroup[$code])) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param $code
     * @param $params
     * @return bool
     */
    private function canGroup($code, $params)
    {
        return $this->hasPermissionGroup($code) && $this->canBizRule($code, $params);
    }

    /**
     * Получение бизнес правила
     * @param $code
     * @return null|string
     */
    public function getBizRule($code)
    {
        return $this->hasPermission($code) ? $this->_permissions[$code]['bizrule'] : null;
    }

    /**
     * Проверка выполнения бизнес правила по коду прав доступа
     * @param $code
     * @param $params
     * @return bool
     */
    public function canBizRule($code, $params)
    {
        return $this->executeBizRule($this->getBizRule($code), $params);
    }

    /**
     * Проверка глобально разрешенных прав доступа в обход всех остальных проверок.
     * При проверке не учитываются: пользователь, группа, персонал (is_staff) и супер пользователь (is_superuser)
     * @param $code
     * @return bool
     */
    public function canGlobal($code)
    {
        return $this->hasPermission($code) && (bool)$this->_permissions[$code]['is_global'];
    }

    /**
     * Возвращает плоский массив групп пользователя
     * @return array
     */
    public function getUserGroups()
    {
        return $this->getUser()->groups->valuesList(['id'], true);
    }

    /**
     * @see canObject()
     * @param $className
     * @param $pk
     * @return bool
     */
    public function canObjectView($className, $pk)
    {
        return
            $this->canObject($className, $pk, self::CAN_OBJECT_VIEW) ||
            $this->canObject($className, $pk, self::CAN_OBJECT_VIEW_UPDATE) ||
            $this->canObject($className, $pk, self::CAN_OBJECT_VIEW_DELETE);
    }

    /**
     * @see canObject()
     * @param $className
     * @param $pk
     * @return bool
     */
    public function canObjectUpdate($className, $pk)
    {
        return
            $this->canObject($className, $pk, self::CAN_OBJECT_UPDATE) ||
            $this->canObject($className, $pk, self::CAN_OBJECT_UPDATE_DELETE);
    }

    /**
     * @see canObject()
     * @param $className
     * @param $pk
     * @return bool
     */
    public function canObjectCreate($className, $pk)
    {
        return $this->canObjectUpdate($className, $pk);
    }

    /**
     * @see canObject()
     * @param $className
     * @param $pk
     * @return bool
     */
    public function canObjectDelete($className, $pk)
    {
        return
            $this->canObject($className, $pk, self::CAN_OBJECT_UPDATE_DELETE) ||
            $this->canObject($className, $pk, self::CAN_OBJECT_DELETE) ||
            $this->canObject($className, $pk, self::CAN_OBJECT_VIEW_DELETE);
    }

    /**
     * Проверка существования прав доступа для объекта
     * @param $className
     * @param $pk
     * @return bool
     */
    public function canObject($className, $pk, $permission)
    {
        $user = $this->getUser();
        if (isset($this->_permissionsObject[$className]) && isset($this->_permissionsObject[$className][$pk])) {
            $permissions = $this->_permissionsObject[$className][$pk];
            /**
             * Поверка наличия Id пользователя в массиве прав доступа данного объекта
             */
            if (isset($permissions['user']) && isset($permissions['user'][$user->id])) {
                /**
                 * Проверка доступа
                 */
                return in_array($permission, $permissions['user'][$user->id]);

            } else if (isset($permissions['group'])) {
                foreach ($this->getUserGroups() as $groupId) {
                    /**
                     * Поверка наличия Id группы пользователя в массиве прав доступа данного объекта
                     */
                    if (isset($permissions['group'][$groupId])) {
                        /**
                         * Проверка доступа
                         */
                        return in_array($permission, $permissions['group'][$groupId]);
                    }
                }
            }
        }

        return false;
    }
}