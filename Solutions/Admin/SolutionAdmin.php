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
 * @date 15/09/14.09.2014 16:13
 */

namespace Modules\Solutions\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Solutions\Forms\SolutionForm;
use Modules\Solutions\Models\Solution;
use Modules\Solutions\SolutionsModule;

class SolutionAdmin extends ModelAdmin
{
    public function getColumns()
    {
        return ['pk', 'region', 'bank', 'court', 'is_complete'];
    }

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModel()
    {
        return new Solution;
    }

    public function getCreateForm()
    {
        return SolutionForm::className();
    }

    public function getVerboseName()
    {
        return SolutionsModule::t('solution');
    }

    public function getVerboseNamePlural()
    {
        return SolutionsModule::t('solutions');
    }
}
