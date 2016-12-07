<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 12:02
 */

namespace Modules\Auth\Forms;

use Mindy\Base\Mindy;
use Mindy\Form\Fields\CharField;
use Mindy\Form\Fields\PasswordField;
use Mindy\Form\Form;
use Modules\Auth\AuthModule;

/**
 * Class LoginForm
 * @package Modules\User
 */
class LoginForm extends Form
{
    public function getFields()
    {
        return [
            'username' => [
                'class' => CharField::class,
                'label' => AuthModule::t('Email or username'),
                'html' => [
                    'autocomplete' => "off",
                    'required'
                ]
            ],
            'password' => [
                'class' => PasswordField::class,
                'label' => AuthModule::t('Password'),
                'html' => [
                    'autocomplete' => "off",
                    'required'
                ]
            ]
        ];
    }

    /**
     * @return bool
     */
    public function login()
    {
        $username = $this->username->getValue();
        $password = $this->password->getValue();

        $auth = Mindy::app()->auth;
        $state = $auth->authenticate('local', $username, $password);
        if (is_array($state)) {
            $this->addErrors($state);
        }

        return $this->hasErrors() === false;
    }
}
