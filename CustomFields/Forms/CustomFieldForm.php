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
 * @date 26/03/15 11:18
 */
namespace Modules\CustomFields\Forms;

use Mindy\Form\ModelForm;
use Modules\CustomFields\CustomFieldsModule;
use Modules\CustomFields\Fields\JsonListField;
use Modules\CustomFields\Models\CustomField;

class CustomFieldForm extends ModelForm
{
    public function getFields()
    {
        return [
            'list' => [
                'class' => JsonListField::className(),
                'label' => CustomFieldsModule::t('Available options')
            ]
        ];
    }

    public function getModel()
    {
        return new CustomField;
    }
}