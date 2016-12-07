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
use Modules\Antibank\Forms\MoreForm;
use Modules\Antibank\Models\More;

class MoreAdmin extends ModelAdmin
{
    /**
     * @return \Mindy\Orm\Model
     */
    public function getModel()
    {
        return new More();
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
        return MoreForm::className();
    }

    public function getNames()
    {
        return [
            AntibankModule::t('partner more'),
            AntibankModule::t('partner more'),
            AntibankModule::t('partner more'),
        ];
    }
}