<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 12:02
 */

namespace Modules\Auth\Strategy;

use Mindy\Base\Mindy;
use Mindy\Helper\Creator;
use Modules\Auth\Components\Auth;
use Modules\User\Models\UserBase;

/**
 * Class BaseStrategy
 * @package Modules\Auth\Strategy
 * @method process \Modules\Auth\Strategy\BaseStrategy
 */
abstract class BaseStrategy
{
    /**
     * @var Auth
     */
    private $_auth;
    /**
     * @var array
     */
    private $_errors = [];

    /**
     * @param Auth $auth
     */
    public function setAuth(Auth $auth)
    {
        $this->_auth = $auth;
    }

    /**
     * @return Auth
     */
    public function getAuth()
    {
        return $this->_auth;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        /** @var \Modules\User\UserModule $module */
        $module = Mindy::app()->getModule('User');
        return Creator::createObject([
            'class' => $module->userClass
        ]);
    }

    /**
     * @param UserBase $user
     * @param $password
     * @return string
     * @throws \Exception
     */
    public function verifyPassword(UserBase $user, $password)
    {
        return $this->getAuth()->getPasswordHasher($user->hash_type)->verifyPassword($password, $user->password);
    }

    /**
     * @param $attribute
     * @param $error
     */
    public function addError($attribute, $error)
    {
        if (!isset($this->_errors[$attribute])) {
            $this->_errors[$attribute] = [];
        }
        $this->_errors[$attribute][] = $error;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }
}