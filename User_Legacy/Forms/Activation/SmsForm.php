<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 29/03/16
 * Time: 17:32
 */

namespace Modules\User\Forms\Activation;

use Mindy\Base\Mindy;
use Mindy\Form\Fields\CharField;
use Mindy\Form\Form;
use Modules\User\Models\User;
use Modules\User\UserModule;

class SmsForm extends Form implements IActivationForm
{
    public function getFields()
    {
        return [
            'phone' => [
                'class' => CharField::class,
                'label' => UserModule::t('Phone'),
                'validators' => [
                    function ($value) {
                        $count = User::objects()->filter([
                            'phone' => $value,
                            'is_active' => false
                        ])->count();
                        if ($count == 0) {
                            return UserModule::t("User with this phone number not found");
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
            'phone' => $this->phone->getValue(),
            'is_active' => false
        ]);
    }

    public function send()
    {
        $user = $this->getUser();
        if ($user === null) {
            return false;
        }

        $smsKey = mt_rand(1000, 9999);
        $user->setAttributes([
            'sms_key' => $smsKey
        ])->save(['sms_key']);
        Mindy::app()->sms->fromCode('user.activation_sms', $user->phone, [
            'sms_key' => $smsKey
        ]);
        return true;
    }
}