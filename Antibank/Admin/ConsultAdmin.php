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
use Modules\Antibank\Forms\ConsultForm;
use Modules\Antibank\Models\Consult;

class ConsultAdmin extends ModelAdmin
{
    /**
     * @return \Mindy\Orm\Model
     */
    public function getModel()
    {
        return new Consult();
    }

    public function getColumns()
    {
        return ['id','username'];
    }

    public function getCanCreate()
    {
        return false;
    }

    public function getActionsList()
    {
        return ['info', 'delete'];
    }

    public function getCreateForm()
    {
        return ConsultForm::className();
    }

    public function getNames()
    {
        return [
            AntibankModule::t('consultation'),
            AntibankModule::t('consultations'),
            AntibankModule::t('consultations'),
        ];
    }
}