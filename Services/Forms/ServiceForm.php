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
 * @date 15/09/14.09.2014 16:28
 */

namespace Modules\Services\Forms;

use Mindy\Form\Fields\UEditorField;
use Mindy\Form\ModelForm;
use Modules\Services\Models\Service;

class ServiceForm extends ModelForm
{
    public function getModel()
    {
        return new Service;
    }

    public function getFields()
    {
        return [
            'description' => [
                'class' => UEditorField::class
            ]
        ];
    }
}
