<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 16/05/16 16:47
 */

namespace Modules\Auth\Forms\Recovery;

use Mindy\Form\Fields\EmailField;
use Mindy\Form\Form;
use Modules\Auth\AuthModule;
use Modules\Auth\Models\LostPasswordKey;
use Modules\User\Models\User;

class EmailForm extends Form implements IRecoveryForm
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
                            'is_active' => true
                        ])->count();
                        if ($count == 0) {
                            return AuthModule::t("User with this email address not found");
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
            'is_active' => true
        ]);
    }

    /**
     * @return array|bool
     */
    public function save()
    {
        $user = $this->getUser();
        if ($user) {
            return (new LostPasswordKey([
                'type' => 'email',
                'user' => $user,
                'is_active' => true,
            ]))->save();
        }
        return false;
    }
}