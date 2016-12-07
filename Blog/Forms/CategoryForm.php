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
 * @date 30/09/14.09.2014 16:08
 */

namespace Modules\Blog\Forms;


use Mindy\Form\Fields\UEditorField;
use Mindy\Form\ModelForm;
use Modules\Blog\Models\Category;

class CategoryForm extends ModelForm
{
    public $exclude = ['posts'];

    public function getFields()
    {
        return [
            'content' => [
                'class' => UEditorField::className()
            ]
        ];
    }

    public function getModel()
    {
        return new Category;
    }
}
