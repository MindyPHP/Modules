<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 27/11/14 15:22
 */

namespace Modules\Clinic\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Model;
use Modules\Clinic\ClinicModule;

class Worker extends Model
{
    public static function getFields()
    {
        return [
            'first_name' => [
                'class' => CharField::className(),
                'verboseName' => ClinicModule::t('First name')
            ],
            'middle_name' => [
                'class' => CharField::className(),
                'verboseName' => ClinicModule::t('Middle name')
            ],
            'last_name' => [
                'class' => CharField::className(),
                'verboseName' => ClinicModule::t('Last name')
            ],
            'role' => [
                'class' => CharField::className(),
                'verboseName' => ClinicModule::t('Role')
            ],
            'photo' => [
                'class' => ImageField::className(),
                'null' => true,
                'sizes' => [
                    'thumb' => [80, 80],
                ],
                'verboseName' => ClinicModule::t('Photo'),
            ],
            'department' => [
                'class' => ForeignField::className(),
                'modelClass' => Department::className(),
                'verboseName' => ClinicModule::t('Department')
            ]
        ];
    }

    public function __toString()
    {
        return (string)$this->getFullName();
    }

    public function getFullName()
    {
        return strtr("{last_name} {first_name} {middle_name}", [
            "{last_name}" => $this->last_name,
            "{first_name}" => $this->first_name,
            "{middle_name}" => $this->middle_name
        ]);
    }
}
