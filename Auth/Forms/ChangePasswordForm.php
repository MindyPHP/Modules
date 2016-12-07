<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 12:02
 */

namespace Modules\Auth\Forms;

use Mindy\Base\Mindy;
use Mindy\Form\Fields\PasswordField;
use Mindy\Form\Form;
use Mindy\Validation\MinLengthValidator;
use Modules\User\Models\User;
use Modules\Auth\AuthModule;

/**
 * Class ChangePasswordForm
 * @package Modules\User
 */
class ChangePasswordForm extends Form
{
    /**
     * @var bool
     */
    private $_checkCurrentPassword = true;
    /**
     * @var \Modules\User\Models\User
     */
    private $_instance;

    public function init()
    {
        /**
         * Проверка на пустоту пароля необходима для пользователей
         * зарегистрированных через социальные сети с помощью модуля Social
         */
        $model = $this->getInstance();
        if (empty($model->password)) {
            $this->exclude[] = 'password_current';
        }

        parent::init();
    }

    /**
     * @param \Modules\User\Models\User
     */
    public function setInstance(User $model)
    {
        $this->_instance = $model;
    }

    /**
     * @return \Modules\User\Models\User
     */
    public function getInstance()
    {
        return $this->_instance;
    }

    /**
     * @param $value bool
     */
    public function setCheckCurrentPassword($value)
    {
        $this->_checkCurrentPassword = $value;
    }

    public function getFields()
    {
        $fields = [
            'password_current' => [
                'class' => PasswordField::class,
                'label' => AuthModule::t('Current password'),
                'hint' => AuthModule::t('Enter your current password to confirm')
            ],
            'password_create' => [
                'class' => PasswordField::class,
                'validators' => [
                    new MinLengthValidator(6)
                ],
                'label' => AuthModule::t('Password')
            ],
            'password_repeat' => [
                'class' => PasswordField::class,
                'validators' => [
                    new MinLengthValidator(6)
                ],
                'label' => AuthModule::t('Password repeat'),
                'hint' => AuthModule::t('Please repeat your password')
            ]
        ];

        /**
         * If user change password after recovery procedure or
         * user registered via social network
         */
        if (!$this->_checkCurrentPassword || empty($this->getInstance()->password)) {
            unset($fields['password_current']);
        }

        return $fields;
    }

    /**
     * Проверка соответствия текущего пароля
     * @param $value
     * @return null
     * @throws \Exception
     */
    public function cleanPassword_current($value)
    {
        $model = $this->getInstance();
        /** @var \Modules\Auth\Components\Auth $auth */
        $auth = Mindy::app()->auth;
        $hasher = $auth->getPasswordHasher($model->hash_type);
        if ($hasher->verifyPassword($this->password_current->getValue(), $model->password) === false) {
            $this->addError('password_current', 'Incorrect password');
            return null;
        }
        return $value;
    }

    /**
     * Проверка нового создаваемого пароля на корректность ввода
     * @param $value
     * @return null
     */
    public function cleanPassword_repeat($value)
    {
        if ($this->password_create->getValue() !== $value) {
            $this->addError('password_repeat', 'Incorrect password repeat');
            return null;
        }
        return $value;
    }

    /**
     * Сохранение нового пароля пользователя
     * @return bool
     */
    public function save()
    {
        return $this->getInstance()->changePassword($this->password_create->getValue());
    }
}
