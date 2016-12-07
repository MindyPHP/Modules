<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 01/12/14 18:00
 */

namespace Modules\Places\Forms;

use Mindy\Form\Fields\CharField;
use Mindy\Form\Fields\MapField;
use Mindy\Form\Fields\WysiwygField;
use Mindy\Form\ModelForm;
use Modules\Places\Models\Place;

class PlaceForm extends ModelForm
{
    public function getFields()
    {
        return [
            'content' => [
                'class' => WysiwygField::className(),
            ],
            'address' => [
                'class' => MapField::className(),
                'center' => [58.58735796286441, 49.6560005429687]
            ],
            'lat' => [
                'class' => CharField::className(),
                'html' => [
                    'readonly' => true
                ],
            ],
            'lng' => [
                'class' => CharField::className(),
                'html' => [
                    'readonly' => true
                ],
            ]
        ];
    }

    public function getModel()
    {
        return new Place;
    }

    public function getInlines()
    {
        return [
            ['place' => ImageForm::className()]
        ];
    }
}
