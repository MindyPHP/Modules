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

namespace Modules\Catalog\Forms;

use Mindy\Form\Fields\DropDownField;
use Mindy\Form\ModelForm;
use Modules\Catalog\CatalogModule;
use Modules\Catalog\Models\Category;
use Modules\Catalog\Models\Product;

class ProductForm extends ModelForm
{
    public function getFieldsets()
    {
        return [
            CatalogModule::t('Main information') => [
                'name', 'price', 'description','is_published'
            ],
            CatalogModule::t('Category settings') => [
                'category', 'categories'
            ]
        ];
    }

    public function getFields()
    {
        return [
            'category' => [
                'class' => DropDownField::className(),
                'choices' => function () {
                        $list = [];
                        $qs = Category::objects()->order(['root', 'lft']);
                        $parents = $qs->all();
                        foreach ($parents as $model) {
                            $level = $model->level ? $model->level - 1 : $model->level;
                            $list[$model->pk] = $level ? str_repeat("..", $level) . ' ' . $model->name : $model->name;
                        }

                        return $list;
                    },
                'label' => CatalogModule::t('Default category')
            ],
            'categories' => [
                'class' => DropDownField::className(),
                'choices' => function () {
                        $list = [];
                        $qs = Category::objects()->order(['root', 'lft']);
                        $parents = $qs->all();
                        foreach ($parents as $model) {
                            $level = $model->level ? $model->level - 1 : $model->level;
                            $list[$model->pk] = $level ? str_repeat("..", $level) . ' ' . $model->name : $model->name;
                        }

                        return $list;
                    },
                'label' => CatalogModule::t('Categories')
            ],
        ];
    }

    public function getModel()
    {
        return new Product;
    }

    public function getInlines()
    {
        return [
            ['product' => ImageInlineForm::className()]
        ];
    }
}
