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
 * @date 15/09/14.09.2014 15:43
 */

namespace Modules\Solutions\Forms;

use Mindy\Form\Fields\DropDownField;
use Mindy\Form\ModelForm;
use Modules\Chained\Fields\ChainedDropdownField;
use Modules\Solutions\Models\Solution;
use Modules\Solutions\SolutionsModule;

class SolutionFilterForm extends ModelForm
{
    public function getModel()
    {
        return new Solution;
    }

    public function getFields()
    {
        return [
            'region' => [
                'class' => DropDownField::className(),
                'label' => 'Выберите регион',
                'required' => false,
                'empty' => 'Все регионы'
            ],
            'bank' => [
                'class' => ChainedDropdownField::className(),
                'label' => 'Выберите банк',
                'chainsFrom' => 'region',
                'required' => false,
                'empty' => 'Все банки'
            ],
            'status' => [
                'class' => DropDownField::className(),
                'label' => SolutionsModule::t('Status'),
                'choices' => [
                    0 => 'Все',
                    Solution::STATUS_SUCCESS => 'Успешно',
                    Solution::STATUS_COMPLETE => 'Решено'
                ],
            ],
        ];
    }
}
