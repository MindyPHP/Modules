<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 18/09/14
 * Time: 17:21
 */

namespace Modules\Antibank\Models;

use Mindy\Base\Mindy;
use Mindy\Orm\Fields\ForeignField;
use \Modules\Offices\Models\Office as DefaultOffice;
use Modules\Sites\SitesModule;

class Office extends DefaultOffice
{
    public static function getFields()
    {
        return array_merge(parent::getFields(), [
            'site' => [
                'class' => ForeignField::className(),
                'modelClass' => Mindy::app()->getModule('Sites')->modelClass,
                'verboseName' => SitesModule::t('Site')
            ]
        ]);
    }

    public static function getModuleName()
    {
        return 'Offices';
    }

    public function getModule()
    {
        return Mindy::app()->getModule('Offices');
    }
} 