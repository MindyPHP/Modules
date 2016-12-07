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
 * @date 19/03/15 10:38
 */
namespace Modules\Goods\Forms;

use Mindy\Base\Mindy;
use Mindy\Form\Fields\DropDownField;
use Mindy\Form\Form;
use Modules\Goods\GoodsModule;
use Modules\Goods\Models\Category;

class ProductFilterForm extends Form
{
    public function getFields()
    {
        $categories = ['' => ''];
        $categoryModel = Mindy::app()->getModule('Goods')->categoryModel;
        $categoriesRaw = $categoryModel::objects()->order(['root', 'lft'])->valuesList(['name', 'level', 'id']);
        foreach ($categoriesRaw as $category) {
            $level = $category['level'] ? $category['level'] - 1 : $category['level'];
            $name = $category['name'];
            $categories[$category['id']] =  $level ? str_repeat("..", $level) . ' ' . $name : $name;
        }

        return [
            'category' => [
                'class' => DropDownField::className(),
                'label' => GoodsModule::t('Category'),
                'choices' => $categories
            ]
        ];
    }

    public function getQsFilter()
    {
        if ($this->isValid()) {
            $cleanedData = $this->cleanedData;
            if (isset($cleanedData['category']) && $cleanedData['category']) {
                $categoryId = $cleanedData['category'];
                $categoryModel = Mindy::app()->getModule('Goods')->categoryModel;
                $category = $categoryModel::objects()->get(['id' => $categoryId]);
                if ($category) {
                    $pkList = $category->tree()->descendants(true)->valuesList(['id'], true);
                    return ['category_id__in' => $pkList];
                }
            }
        }
    }
}