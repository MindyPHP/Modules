<?php

namespace Modules\User\Forms;

use Mindy\Form\Fields\Select2Field;
use Mindy\Form\ModelForm;
use Modules\User\Models\Group;
use Modules\User\UserModule;

/**
 * Class GroupForm
 * @package Modules\User
 */
class GroupForm extends ModelForm
{
    public function getFieldsets()
    {
        return [
            UserModule::t('Main information') => [
                'name', 'description'
            ],
            UserModule::t('Settings') => [
                'is_visible', 'is_locked', 'is_default'
            ],
            UserModule::t('Permissions') => [
                'permissions'
            ],
        ];
    }

    public function getModel()
    {
        return new Group;
    }
}
