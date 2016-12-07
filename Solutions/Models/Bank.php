<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 15/09/14.09.2014 15:48
 */

namespace Modules\Solutions\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Model;
use Modules\Solutions\SolutionsModule;

class Bank extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => SolutionsModule::t('Name')
            ],
            'region' => [
                'class' => ForeignField::className(),
                'modelClass' => Region::className(),
                'verboseName' => SolutionsModule::t('Region')
            ]
        ];
    }

    public function __toString()
    {
        return (string) $this->name;
    }
}
