<?php

namespace Modules\User\Forms;

use Mindy\Form\ModelForm;
use Modules\User\Models\User;
use Modules\User\UserModule;

/**
 * Class UserForm
 * @package Modules\User
 */
class UserForm extends ModelForm
{
    public function getFieldsets()
    {
        return [
            UserModule::t('Main information') => [
                'username',
                'email',
                'is_staff',
                'is_superuser',
                'is_active'
            ],
            UserModule::t('Extra information') => [
                'groups',
                'permissions'
            ],
        ];
    }

    public function getModel()
    {
        return new User;
    }
}
