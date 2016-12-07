<?php

/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 19/03/15 18:03
 */
namespace Modules\Workers\Forms;

use Mindy\Form\Fields\Select2Field;
use Mindy\Form\ModelForm;
use Modules\Workers\Models\Department;
use Modules\Workers\WorkersModule;

class DepartmentForm extends ModelForm
{
    public function getFields()
    {
        return [
            'staff' => [
                'class' => Select2Field::className(),
                'label' => WorkersModule::t('Workers')
            ]
        ];
    }

    public function getModel()
    {
        return new Department;
    }
}