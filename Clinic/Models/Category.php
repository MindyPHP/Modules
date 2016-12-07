<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 29/11/14 16:05
 */

namespace Modules\Clinic\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\HasManyField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Clinic\ClinicModule;

class Category extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => ClinicModule::t('Name')
            ],
            'content' => [
                'class' => TextField::className(),
                'verboseName' => ClinicModule::t('Content'),
                'null' => true
            ],
            'position' => [
                'class' => IntField::className(),
                'editable' => false,
                'default' => 0,
                'null' => true,
                'verboseName' => ClinicModule::t('Position')
            ],
            'department' => [
                'class' => ForeignField::className(),
                'modelClass' => Department::className(),
                'verboseName' => ClinicModule::t('Department')
            ],
            'pages' => [
                'class' => HasManyField::className(),
                'modelClass' => Page::className(),
                'verboseName' => ClinicModule::t('Pages'),
            ],
        ];
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    public function getAdminNames($instance = null)
    {
        $names = parent::getAdminNames($instance);
        $names[0] = $this->getModule()->t('Categories');
        return $names;
    }
}
