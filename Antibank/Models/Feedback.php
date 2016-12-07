<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 19/09/14
 * Time: 12:40
 */

namespace Modules\Antibank\Models;

use Mindy\Orm\Fields\EmailField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Antibank\AntibankModule;

class Feedback extends Model
{
    public static function getFields()
    {
        return [
            'city' => [
                'class' => CharField::className(),
                'verboseName' => AntibankModule::t('Your name'),
                'required' => true
            ],
            'username' => [
                'class' => CharField::className(),
                'verboseName' => AntibankModule::t('Your name'),
                'required' => true
            ],
            'phone' => [
                'class' => CharField::className(),
                'verboseName' => AntibankModule::t('Phone'),
                'required' => true
            ],
            'email' => [
                'class' => EmailField::className(),
                'verboseName' => AntibankModule::t('E-mail'),
                'required' => true
            ],
            'text' => [
                'class' => TextField::className(),
                'verboseName' => AntibankModule::t('Your question'),
                'required' => true
            ],
            'created_at' => [
                'class' => DateTimeField::className(),
                'autoNowAdd' => true,
                'verboseName' => AntibankModule::t('Request time')
            ]
        ];
    }

    public function __toString()
    {
        return $this->username;
    }
} 