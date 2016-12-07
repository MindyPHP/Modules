<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 12:02
 */

namespace Modules\Auth\Strategy;

use Modules\Auth\AuthModule;

class LocalStrategy extends BaseStrategy
{
    /**
     * Разрешение пользователю авторизоваться с не активированным аккаунтом
     * @var bool
     */
    public $allowInactive = true;

    public function process($name, $password)
    {
        $attribute = strpos($name, "@") > -1 ? 'email' : 'username';
        $model = $this->getModel();
        $instance = $model->objects()->get([$attribute => strtolower($name)]);
        if ($instance === null) {
            $this->addError($attribute, AuthModule::t('User not registered'));
            return false;
        }

        if ($this->verifyPassword($instance, $password)) {
            if ($instance->is_active) {
                return $instance;
            }

            if (!$instance->is_active && $this->allowInactive) {
                return $instance;
            } else {
                $this->addError($attribute, AuthModule::t('Account is not verified'));
            }
            return false;
        } else {
            $this->addError('password', AuthModule::t('Wrong password'));
            return false;
        }
    }
}