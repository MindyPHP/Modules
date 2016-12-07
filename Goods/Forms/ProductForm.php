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
 * @date 16/01/15 09:48
 */
namespace Modules\Goods\Forms;

use Mindy\Base\Mindy;
use Mindy\Form\Fields\DropDownField;
use Mindy\Form\Fields\WysiwygField;
use Mindy\Form\ModelForm;
use Modules\Files\Fields\FilesField;
use Modules\Goods\GoodsModule;
use Modules\Goods\Models\Product;

class ProductForm extends ModelForm
{
    public function getFields()
    {
        return [
            'description' => [
                'class' => WysiwygField::className(),
                'label' => GoodsModule::t('Description')
            ],
            'images' => [
                'class' => FilesField::className()
            ]
        ];
    }

    public function getModel()
    {
        $cls = Mindy::app()->getModule('Goods')->productModel;
        return new $cls;
    }
}