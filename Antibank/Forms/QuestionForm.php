<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 19/09/14
 * Time: 12:40
 */

namespace Modules\Antibank\Forms;

use Mindy\Form\Fields\TextField;
use Modules\Antibank\AntibankModule;
use Modules\Antibank\Models\Question;

class QuestionForm extends RequestForm
{
    public $mailTemplate = 'antibank.question';

    public function getModel()
    {
        return new Question();
    }

    public function getFields()
    {
        return [
            'phone' => [
                'class' => TextField::className(),
                'label' => AntibankModule::t('Phone'),
                'required' => true
            ],
        ];
    }
} 