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
 * @date 15/09/14.09.2014 16:15
 */

namespace Modules\Solutions\Forms;

use Mindy\Form\Fields\WysiwygField;
use Mindy\Form\ModelForm;
use Modules\Chained\Fields\ChainedDropdownField;
use Modules\Solutions\Models\Solution;
use Modules\Solutions\SolutionsModule;

class SolutionForm extends ModelForm
{
    public $exclude = ['comments'];

    public function getFieldsets()
    {
        return [
            SolutionsModule::t('Main information') => [
                'region', 'bank', 'court', 'question',
                'result', 'document', 'content', 'status'
            ],
        ];
    }

    public function getModel()
    {
        return new Solution;
    }

    public function getFields()
    {
        return [
            'bank' => [
                'class' => ChainedDropdownField::className(),
                'label' => SolutionsModule::t('Bank'),
                'chainsFrom' => 'region',
                'required' => true

            ],
            'content' => [
                'class' => WysiwygField::className(),
                'label' => SolutionsModule::t('Content')
            ],
        ];
    }
}
