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
 * @date 25/02/15 16:43
 */
namespace Modules\Furniture\Forms;

use Mindy\Form\Fields\HiddenField;
use Mindy\Form\ModelForm;
use Modules\Furniture\Models\Request;

class RequestForm extends ModelForm
{
    public function getFields()
    {
        return [
            'furniture' => [
                'class' => HiddenField::className()
            ]
        ];
    }

    public function getModel()
    {
        return new Request;
    }
}