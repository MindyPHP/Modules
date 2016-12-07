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
 * @date 07/11/14 15:30
 */
namespace Modules\Advantages\Forms;

use Mindy\Form\Fields\CharField;
use Mindy\Form\Fields\WysiwygField;
use Mindy\Form\ModelForm;
use Modules\Advantages\AdvantagesModule;
use Modules\Advantages\Models\Advantage;

class AdvantageForm extends ModelForm
{
    public $exlcude = ['position'];

    public function getFields()
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'label' => AdvantagesModule::t('Name')
            ],
            'content' => [
                'class' => WysiwygField::className(),
                'label' => AdvantagesModule::t('Content')
            ],
        ];
    }

    public function getModel()
    {
        return new Advantage;
    }
}