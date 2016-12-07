<?php

namespace Modules\User\Forms;

use Mindy\Base\Mindy;
use Mindy\Form\Fields\CodeMirrorField;
use Mindy\Form\ModelForm;
use Modules\User\Models\Permission;
use Modules\User\UserModule;

/**
 * Class PermissionForm
 * @package Modules\User
 */
class PermissionForm extends ModelForm
{
    public function getFieldsets()
    {
        return [
            UserModule::t('Main information') => [
                'code', 'name', 'bizrule'
            ],
            UserModule::t('Settings') => [
                'is_visible', 'is_locked', 'is_default', 'is_global', 'is_auto'
            ],
        ];
    }

    public function getFields()
    {
        $model = $this->getInstance();
        $fields = parent::getFields();

        $user = Mindy::app()->user;
        if ($user) {
            if (!$user->is_superuser) {
                unset($fields['is_global']);
            }

            if (!$user->is_superuser && $model && $model->is_auto == 1) {
                unset($fields['is_locked']);
            }
        }

        return array_merge($fields, [
            'bizrule' => [
                'class' => CodeMirrorField::class,
                'options' => ['mode' => "text/x-php"]
            ]
        ]);
    }

    public function getModel()
    {
        return new Permission;
    }
}
