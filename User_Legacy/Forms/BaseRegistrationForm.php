<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 09/03/16
 * Time: 17:32
 */

namespace Modules\User\Forms;

use Mindy\Form\Fields\CharField;
use Mindy\Form\Fields\CheckboxField;
use Modules\Main\MainModule;
use Modules\User\Forms\RegistrationForm;
use Modules\User\Models\User;
use Modules\User\UserModule;

abstract class BaseRegistrationForm extends RegistrationForm
{
    public function getFields()
    {
        $fields = parent::getFields();

        $newFields = array_merge($fields, [
            'last_name' => [
                'class' => CharField::class,
                'label' => UserModule::t('Last name')
            ],
            'first_name' => [
                'class' => CharField::class,
                'label' => UserModule::t('First name')
            ],
            'middle_name' => [
                'class' => CharField::class,
                'label' => UserModule::t('Middle name')
            ],
            'phone' => [
                'class' => CharField::class,
                'label' => UserModule::t('Phone'),
                'hint' => 'На данный номер телефона придет смс с подтверждением регистрации',
                'validators' => [
                    function ($value) {
                        if (User::objects()->filter(['phone' => $value])->count() > 0) {
                            return UserModule::t("Phone must be a unique");
                        }
                        return true;
                    }
                ]
            ],
            'i_accept_license' => [
                'class' => CheckboxField::class,
                'required' => true,
                'label' => UserModule::t('I accept the license')
            ]
        ]);

        if (isset($fields['captcha'])) {
            $captcha = $fields['captcha'];
            unset($fields['captcha']);
            return array_merge($newFields, [$captcha]);
        }

        return $newFields;
    }
}