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
 * @date 15/09/14.09.2014 16:17
 */

namespace Modules\Solutions\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Solutions\Models\Bank;
use Modules\Solutions\SolutionsModule;

class BankAdmin extends ModelAdmin
{
    public function getModel()
    {
        return new Bank;
    }

    public function getVerboseName()
    {
        return SolutionsModule::t('bank');
    }

    public function getVerboseNamePlural()
    {
        return SolutionsModule::t('banks');
    }
}
