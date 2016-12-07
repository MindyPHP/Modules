<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 27/11/14 15:09
 */

namespace Modules\Clinic\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\DecimalField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Clinic\ClinicModule;

class Page extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'required' => true,
                'verboseName' => ClinicModule::t('Name')
            ],
            'price' => [
                'class' => CharField::className(),
                'verboseName' => ClinicModule::t('Price'),
                'null' => true
            ],
            'url' => [
                'class' => CharField::className(),
                'verboseName' => ClinicModule::t('External url'),
                'null' => true
            ],
            'content_short' => [
                'class' => TextField::className(),
                'null' => true,
                'verboseName' => ClinicModule::t('Short content')
            ],
            'content' => [
                'class' => TextField::className(),
                'null' => true,
                'verboseName' => ClinicModule::t('Content')
            ],
            'created_at' => [
                'class' => DateTimeField::className(),
                'autoNowAdd' => true,
                'editable' => false
            ],
            'updated_at' => [
                'class' => DateTimeField::className(),
                'autoNow' => true,
                'editable' => false
            ],
            'department' => [
                'class' => ForeignField::className(),
                'modelClass' => Department::className(),
                'verboseName' => ClinicModule::t('Department')
            ],
            'category' => [
                'class' => ForeignField::className(),
                'modelClass' => Category::className(),
                'verboseName' => ClinicModule::t('Category'),
                'null' => true
            ]
        ];
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('clinic.page_detail', ['pk' => $this->pk]);
    }
}
