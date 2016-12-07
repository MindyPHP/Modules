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
 * @date 14/09/14.09.2014 13:51
 */

namespace Modules\Antibank\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Antibank\AntibankModule;
use Modules\Antibank\Forms\PartnerAdvantageForm;
use Modules\Antibank\Models\PartnerAdvantage;

class PartnerAdvantageAdmin extends ModelAdmin
{
    /**
     * @return \Mindy\Orm\Model
     */
    public function getModel()
    {
        return new PartnerAdvantage();
    }

    public function getColumns()
    {
        return ['id','name'];
    }

    public function getCreateForm()
    {
        return PartnerAdvantageForm::className();
    }

    public function getNames()
    {
        return [
            AntibankModule::t('partner advantage'),
            AntibankModule::t('partner advantages'),
            AntibankModule::t('partner advantages'),
        ];
    }
}