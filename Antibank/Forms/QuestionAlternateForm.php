<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 19/09/14
 * Time: 12:40
 */

namespace Modules\Antibank\Forms;

use Mindy\Form\Fields\EmailField;
use Mindy\Form\Fields\TextField;
use Modules\Antibank\AntibankModule;
use Modules\Antibank\Models\Question;

class QuestionAlternateForm extends RequestForm
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
                'required' => false
            ],
            'email' => [
                'class' => EmailField::className(),
                'label' => AntibankModule::t('E-mail'),
                'required' => false
            ]
        ];
    }

    public function isValid()
    {
        $valid = parent::isValid();
        $data = $this->cleanedData;
        if ((!$data['email']) && (!$data['phone'])) {
            $this->addError('phone', 'Заполните поле "E-mail" или "Телефон"');
            $this->getField('phone')->addError('Заполните поле "E-mail" или "Телефон"');
            $this->addError('email', 'Заполните поле "E-mail" или "Телефон"');
            $this->getField('email')->addError('Заполните поле "E-mail" или "Телефон"');
        }
        return $this->hasErrors() === false;
    }
} 