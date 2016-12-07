<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 19/09/14
 * Time: 12:40
 */

namespace Modules\Antibank\Forms;

use Mindy\Form\Fields\LicenseField;
use Modules\Antibank\AntibankModule;
use Modules\Antibank\Fields\JsonListField;
use Modules\Antibank\Models\Survey;

class SurveyForm extends RequestForm
{
    public $mailTemplate = 'antibank.survey';

    public function getModel()
    {
        return new Survey();
    }

    public function getFields()
    {
        return [
            'description' => [
                'class' => JsonListField::className(),
                'label' => AntibankModule::t('Description by event'),
                'appenderText' => '+ добавить',
	            'appenderTemplate'=>'<span class="button round transparent full-red-on-hover" id="{id}">{text}</span>',
                'required' => true
            ]
        ];
    }
} 
