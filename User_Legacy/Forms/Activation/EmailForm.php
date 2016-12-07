<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 29/03/16
 * Time: 17:20
 */

namespace Modules\User\Forms\Activation;

use Mindy\Base\Mindy;
use Mindy\Form\Fields\EmailField;
use Mindy\Form\Form;
use Modules\User\Models\User;
use Modules\User\UserModule;

class EmailForm extends Form implements IActivationForm
{
    public function getFields()
    {
        return [
            'email' => [
                'class' => EmailField::class,
                'label' => UserModule::t('Email'),
                'validators' => [
                    function ($value) {
                        $count = User::objects()->filter([
                            'email' => $value,
                            'is_active' => false
                        ])->count();
                        if ($count == 0) {
                            return UserModule::t("User with this email address not found");
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
    public function send()
    {
        $user = $this->getUser();
        if ($user === null) {
            return false;
        }
        /** @var \Modules\Mail\Components\DbMailer $mail */
        $mail = Mindy::app()->mail;
        $activationKey = User::objects()->generateActivationKey();
        $user->setAttributes([
            'activation_key' => $activationKey
        ])->save(['activation_key']);
        return $mail->fromCode('user.activation_email', $user->email, [
            'activation_key' => $activationKey
        ]);
    }
}