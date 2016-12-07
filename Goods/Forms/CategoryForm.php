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
 * @date 16/01/15 09:47
 */
namespace Modules\Goods\Forms;

use Mindy\Base\Mindy;
use Mindy\Form\Fields\WysiwygField;
use Mindy\Form\ModelForm;
use Modules\Goods\GoodsModule;

class CategoryForm extends ModelForm
{
    public function getFields()
    {
        return [
            'description' => [
                'class' => WysiwygField::className(),
                'label' => GoodsModule::t('Description')
            ]
        ];
    }

    public function getModel()
    {
        $cls = Mindy::app()->getModule('Goods')->categoryModel;
        return new $cls;
    }
}