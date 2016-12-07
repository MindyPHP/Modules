<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 27/11/14 15:01
 */

namespace Modules\Clinic\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\HasManyField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Clinic\ClinicModule;

class Department extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => ClinicModule::t('Name')
            ],
            'phone' => [
                'class' => CharField::className(),
                'verboseName' => ClinicModule::t('Phone')
            ],
            'content' => [
                'class' => TextField::className(),
                'null' => true,
                'verboseName' => ClinicModule::t('Content')
            ],
            'content_after' => [
                'class' => TextField::className(),
                'null' => true,
                'verboseName' => ClinicModule::t('Content after pages')
            ],
            'prices' => [
                'class' => TextField::className(),
                'null' => true,
                'verboseName' => ClinicModule::t('Prices')
            ],
            'image' => [
                'class' => ImageField::className(),
                'null' => true,
                'sizes' => [
                    'thumb' => [
                        160, 104,
                        'method' => 'adaptiveResizeFromTop',
                        'options' => ['jpeg_quality' => 7]
                    ],
                    'resize' => [
                        978
                    ],
                ],
                'verboseName' => ClinicModule::t('Image'),
            ],
            'workers' => [
                'class' => HasManyField::className(),
                'modelClass' => Worker::className(),
                'verboseName' => ClinicModule::t('Workers'),
            ],
            'categories' => [
                'class' => HasManyField::className(),
                'modelClass' => Category::className(),
                'verboseName' => ClinicModule::t('Categories'),
            ],
            'position' => [
                'class' => IntField::className(),
                'editable' => false,
                'verboseName' => ClinicModule::t('Position')
            ]
        ];
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('clinic.detail', ['pk' => $this->pk]);
    }
}
