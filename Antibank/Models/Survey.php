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
use Mindy\Orm\Fields\JsonField;
use Mindy\Orm\Model;
use Modules\Antibank\AntibankModule;

class Survey extends Model
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
            'description' => [
                'class' => JsonField::className(),
                'verboseName' => AntibankModule::t('Description by event')
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
