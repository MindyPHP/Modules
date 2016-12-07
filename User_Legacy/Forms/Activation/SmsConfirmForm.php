<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 29/03/16
 * Time: 17:55
 */

namespace Modules\User\Forms\Activation;

use Mindy\Form\Form;
use Mindy\Form\Fields\CharField;
use Mindy\Validation\MinLengthValidator;
use Mindy\Validation\RequiredValidator;
use Modules\User\Models\User;
use Modules\User\UserModule;

class SmsConfirmForm extends Form
{
    public function getFields()
    {
        return [
            'code' => [
                'class' => CharField::class,
                'label' => UserModule::t('Code from SMS message'),
                'validators' => [
                    new MinLengthValidator(4),
                    new RequiredValidator(),
                    function ($value) {
                        $count = User::objects()->filter([
                            'sms_key' => $value,
                            'is_active' => false
                        ])->count();
                        if ($count == 0) {
                            return UserModule::t("Incorrect activation key");
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
            'sms_key' => $this->code->getValue(),
            'is_active' => false
        ]);
    }

    public function activate()
    {
        $user = $this->getUser();
        if ($user === null) {
            return false;
        }
        $user->is_active = true;
        $user->save(['is_active']);
        return true;
    }
}