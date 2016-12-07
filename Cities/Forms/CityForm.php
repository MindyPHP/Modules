<?php

/**
 * Created by PhpStorm.
 * User: aleksandrgordeev
 * Date: 26.08.15
 * Time: 9:54
 */
namespace Modules\Cities\Forms;

use Mindy\Form\Fields\CharField;
use Mindy\Form\Fields\MapField;
use Mindy\Form\ModelForm;
use Modules\Cities\Models\City;

class CityForm extends ModelForm
{



    public function getFields()
    {
        return [
            'name_ru' => [
                'class' => MapField::className(),
                'center' => [58.58735796286441, 49.6560005429687]
            ],
            'lat' => [
                'class' => CharField::className(),
                'html' => [
                    'readonly' => true
                ]
            ],
            'lng' => [
                'class' => CharField::className(),
                'html' => [
                    'readonly' => true
                ]
            ]
        ];
    }

    public function getModel()
    {
        return new City;
    }
}