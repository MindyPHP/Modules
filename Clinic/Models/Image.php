<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 28/11/14 18:02
 */

namespace Modules\Clinic\Models;

use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Model;
use Modules\Clinic\ClinicModule;

class Image extends Model
{
    public static function getFields()
    {
        return [
            'image' => [
                'class' => ImageField::className(),
                'sizes' => [
                    'small' => [75, 75],
                    'thumb' => [220, 172],
                ],
                'null' => false,
                'verboseName' => ClinicModule::t('Image')
            ],
            'department' => [
                'class' => ForeignField::className(),
                'modelClass' => Department::className(),
                'verboseName' => ClinicModule::t('Department')
            ],
        ];
    }

    public function __toString()
    {
        return (string)$this->pk;
    }
}
