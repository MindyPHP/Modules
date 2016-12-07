<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 23/09/14
 * Time: 15:27
 */

namespace Modules\Antibank\Models;


use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Antibank\AntibankModule;

class PartnerAdvantage extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => AntibankModule::t('Advantage name'),
                'required' => true
            ],
            'description' => [
                'class' => TextField::className(),
                'verboseName' => AntibankModule::t('Advantage description'),
                'required' => true
            ],
            'file' => [
                'class' => ImageField::className(),
                'verboseName' => AntibankModule::t('Image')
            ],
            'position' => [
                'class' => IntField::className(),
                'verboseName' => AntibankModule::t('Advantage position'),
            ]
        ];
    }
} 