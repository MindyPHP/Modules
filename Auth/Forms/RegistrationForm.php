<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 12:02
 */

namespace Modules\Auth\Forms;

use Mindy\Form\Fields\CharField;
use Mindy\Form\Fields\EmailField;
use Mindy\Form\Fields\PasswordField;
use Mindy\Form\Form;
use Mindy\Validation\MinLengthValidator;
use Modules\Auth\AuthModule;
use Modules\User\Models\User;
use Modules\User\Helpers\UserHelper;

/**
 * Class RegistrationForm
 * @package Modules\User
 */
class RegistrationForm extends Form
{
    public function getFields()
    {
        return [
            'username' => [
                'class' => CharField::class,
                'label' => AuthModule::t('Username'),
                'required' => true,
                'validators' => [
                    function ($value) {
                        if (User::objects()->filter(['username' => $value])->count() > 0) {
                            return AuthModule::t("Username must be a unique");
                        }
                        return true;
                    }
                ]
            ],
            'email' => [
                'class' => EmailField::class,
                'label' => AuthModule::t('Email'),
                'required' => true,
                'validators' => [
                    function ($value) {
                        if (User::objects()->filter(['email' => $value])->count() > 0) {
                            return AuthModule::t("Email must be a unique");
                        }
                        return true;
                    }
                ]
            ],
            'password' => [
                'class' => PasswordField::class,
                'validators' => [
                    new MinLengthValidator(6)
                ],
                'required' => true,
                'label' => AuthModule::t('Password')
            ],
            'password_repeat' => [
                'class' => PasswordField::class,
                'validators' => [
                    new MinLengthValidator(6)
                ],
                'required' => true,
                'label' => AuthModule::t('Password repeat')
            ],
        ];
    }

    public function cleanPassword_repeat($value)
    {
        if ($this->password->getValue() !== $value) {
            $this->addError('password_repeat', AuthModule::t('Incorrect password repeat'));
        }
        return $value;
    }

    public function cleanEmail($value)
    {
        if (User::objects()->filter(['email' => strtolower($value)])->count() > 0) {
            $this->addError('email', AuthModule::t('This email address is already in use on the site'));
        }
        return $value;
    }

    public function cleanUsername($value)
    {
        if (User::objects()->filter(['username' => strtolower($value)])->count() > 0) {
            $this->addError('username', AuthModule::t('This username is already in use on the site'));
        }
        return $value;
    }

    public function getModel()
    {
        return new User;
    }

    public function save()
    {
        $attributes = [
            'username' => $this->username->getValue(),
            'password' => $this->password->getValue(),
            'email' => $this->email->getValue(),
        ];

        $model = UserHelper::createUser($attributes);
        if ($model->hasErrors() === false) {
            return $model;
        }
        return false;
    }
}
