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
 * @date 15/09/14.09.2014 17:54
 */

namespace Modules\Antibank\Models;

use Mindy\Base\Mindy;
use Mindy\Orm\Fields\EmailField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ForeignField;
use Modules\Antibank\AntibankModule;
use Modules\Sites\Models\Site as MindySite;
use Modules\Solutions\Models\Region;
use Modules\Solutions\SolutionsModule;

class Site extends MindySite
{
    public static function getFields()
    {
        return array_merge(parent::getFields(), [
            'phone' => [
                'class' => CharField::className(),
                'verboseName' => AntibankModule::t('Phone')
            ],
            'email' => [
                'class' => EmailField::className(),
                'verboseName' => AntibankModule::t('Email')
            ],
            'region' => [
                'class' => ForeignField::className(),
                'modelClass' => Region::className(),
                'verboseName' => SolutionsModule::t('Region'),
                'required' => true,
            ]
        ]);
    }

    public static function getModuleName()
    {
        return 'Sites';
    }

    public function getModule()
    {
        return Mindy::app()->getModule('Sites');
    }
}
