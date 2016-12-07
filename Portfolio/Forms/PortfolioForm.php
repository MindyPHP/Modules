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

namespace Modules\Portfolio\Forms;

use Mindy\Form\Fields\UEditorField;
use Mindy\Form\ModelForm;
use Modules\Files\Fields\FilesField;
use Modules\Portfolio\Models\Portfolio;

class PortfolioForm extends ModelForm
{
    public function getFields()
    {
        return [
            'description' => [
                'class' => UEditorField::class
            ],
            'images' => [
                'class' => FilesField::class,
                'relatedFileField' => 'image'
            ]
        ];
    }

    public function getModel()
    {
        return new Portfolio;
    }
}
