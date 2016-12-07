<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 12:02
 */

namespace Modules\Auth\Forms\Activation;

use Mindy\Form\Fields\EmailField;
use Mindy\Form\Form;
use Modules\Auth\Models\ActivationKey;
use Modules\User\Models\User;
use Modules\Auth\AuthModule;

class EmailForm extends Form implements IActivationForm
{
    public function getFields()
    {
        return [
            'email' => [
                'class' => EmailField::class,
                'label' => AuthModule::t('Email'),
                'validators' => [
                    function ($value) {
                        $count = User::objects()->filter([
                            'email' => $value,
                            'is_active' => false
                        ])->count();
                        if ($count == 0) {
                            return AuthModule::t("User with this email address not found or account already activated");
                        }
                        return true;
                    }
                ]
            ]
        ];
    }

    /**
     * @return \Modules\User\Models\User|null
     */
    public function getUser()
    {
        return User::objects()->get([
            'email' => $this->email->getValue(),
            'is_active' => false
        ]);
    }

    /**
     * @return array|bool
     */
    public function save()
    {
        $user = $this->getUser();
        if ($user) {
            return (new ActivationKey([
                'type' => 'email',
                'user' => $user,
                'is_active' => true,
            ]))->save();
        }
        return false;
    }
}