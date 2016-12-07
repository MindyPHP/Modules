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
 * @date 13/11/14 10:39
 */
namespace Modules\Workers\Forms;

use Mindy\Form\Fields\Select2Field;
use Mindy\Form\Fields\WysiwygField;
use Mindy\Form\ModelForm;
use Modules\Meta\Forms\MetaInlineForm;
use Modules\Workers\Models\Worker;
use Modules\Workers\WorkersModule;

class WorkerForm extends ModelForm
{
    public function getFieldsets()
    {
        return [
            WorkersModule::t('Main information') => [
                'last_name', 'name', 'middle_name',
                'email', 'phone', 'departments', 'role', 'level', 'short_description', 'description', 'image',
                'image_hover',
                'image_additional',
                'is_head',
                'is_published',
                'auto',
                'vk',
                'external_id'
            ]
        ];
    }

    public function getFields()
    {
        return [
            'description' => [
                'class' => WysiwygField::className(),
                'label' => WorkersModule::t('Description')
            ],
            'departments' => [
                'class' => Select2Field::className(),
                'label' => WorkersModule::t('Departments')
            ]
        ];
    }

    public function getInlines()
    {
        return [
            [
                'worker' => AwardForm::className()
            ],
            ['meta' => MetaInlineForm::className()]
        ];
    }

    public function getModel()
    {
        return new Worker;
    }
}
