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
 * @date 19/11/14 10:21
 */
namespace Modules\Workers\Forms;

use Mindy\Form\Fields\CharField;
use Mindy\Form\Fields\HiddenField;
use Mindy\Form\Fields\TextAreaField;
use Mindy\Form\ModelForm;
use Modules\Workers\Models\Review;
use Modules\Workers\WorkersModule;

class ReviewForm extends ModelForm
{
    public $exclude = ['status', 'video', 'image', 'date'];

    public function getFields()
    {
        return [
            'worker' => [
                'class' => HiddenField::className()
            ],
            'name' => [
                'class' => CharField::className(),
                'label' => WorkersModule::t('Your name'),
                'required' => true,
                'html' => [
                    'placeholder' => WorkersModule::t('Your name')
                ]
            ],
            'phone' => [
                'class' => CharField::className(),
                'label' => WorkersModule::t('Your phone'),
                'required' => false,
                'html' => [
                    'placeholder' => WorkersModule::t('Your phone')
                ]
            ],
            'description' => [
                'class' => TextareaField::className(),
                'label' => WorkersModule::t('Whats your result?'),
                'required' => true,
                'html' => [
                    'placeholder' => WorkersModule::t('Whats your result?')
                ]
            ],
            'why' => [
                'class' => TextareaField::className(),
                'label' => WorkersModule::t('Why our company?'),
                'required' => false,
                'html' => [
                    'placeholder' => WorkersModule::t('Why our company?')
                ]
            ],
            'recommendations' => [
                'class' => TextareaField::className(),
                'label' => WorkersModule::t('Your recommendations?'),
                'required' => false,
                'html' => [
                    'placeholder' => WorkersModule::t('Your recommendations?')
                ]
            ],
        ];
    }

    public function getModel()
    {
        return new Review;
    }
}