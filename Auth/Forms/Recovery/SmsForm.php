<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 12:02
 */

namespace Modules\Auth\Forms\Recovery;

use Mindy\Form\Fields\CharField;
use Mindy\Form\Form;
use Modules\Auth\AuthModule;
use Modules\Auth\Models\LostPasswordKey;
use Modules\User\Models\User;

class SmsForm extends Form implements IRecoveryForm
{
    public function getFields()
    {
        return [
            'phone' => [
                'class' => CharField::class,
                'label' => AuthModule::t('Phone'),
                'validators' => [
                    function ($value) {
                        $count = User::objects()->filter([
                            'phone' => $value,
                            'is_active' => true
                        ])->count();
                        if ($count == 0) {
                            return AuthModule::t("User with this phone number not found or account already activated");
                        }
                        return true;
                    }
                ]
            ],
        ];
    }

    /**
     * @return \Modules\User\Models\User|null
     */
    public function getUser()
    {
        return User::objects()->get([
            'phone' => $this->phone->getValue(),
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
                'type' => 'sms',
                'user' => $user,
                'is_active' => true,
            ]))->save();
        }
        return false;
    }
}