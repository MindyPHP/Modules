<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 19/09/14
 * Time: 12:40
 */

namespace Modules\Antibank\Models;


use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\EmailField;
use Mindy\Orm\Model;
use Modules\Antibank\AntibankModule;

class Consult extends Model
{
    public static function getFields()
    {
        return [
            'username' => [
                'class' => CharField::className(),
                'verboseName' => AntibankModule::t('Username'),
                'required' => false,
            ],
            'phone' => [
                'class' => CharField::className(),
                'verboseName' => AntibankModule::t('Phone'),
                'required' => true
            ],
            'email' => [
                'class' => EmailField::className(),
                'verboseName' => AntibankModule::t('E-mail')
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
