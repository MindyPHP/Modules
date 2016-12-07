<?php
/**
 * 
 *
 * All rights reserved.
 * 
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 22/08/14.08.2014 15:37
 */

namespace Modules\Offices\Forms;


use Mindy\Base\Mindy;
use Mindy\Form\Fields\MapField;
use Mindy\Form\Fields\UEditorField;
use Mindy\Form\ModelForm;
use Mindy\Form\Fields\CharField;
use Modules\Offices\Models\Office;
use Modules\Offices\OfficesModule;

class OfficeForm extends ModelForm
{
    public function getFields()
    {
        return [
            'description' => [
                'class' => UEditorField::class
            ],
            'address' => [
                'class' => MapField::class,
                'center' => [58.58735796286441, 49.6560005429687]
            ],
            'lat' => [
                'class' => CharField::class,
                'html' => [
                    'readonly' => true
                ]
            ],
            'lng' => [
                'class' => CharField::class,
                'html' => [
                    'readonly' => true
                ]
            ]
        ];
    }

    public function getModel()
    {
        return new Office;
    }
}
