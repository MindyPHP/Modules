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
 * @date 10/09/14.09.2014 12:26
 */

namespace Modules\Portfolio\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Portfolio\Forms\PortfolioForm;
use Modules\Portfolio\Models\Portfolio;

class PortfolioAdmin extends ModelAdmin
{
    public function getSearchFields()
    {
        return ['name'];
    }

    public function getColumns()
    {
        return ['name', 'category'];
    }

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModel()
    {
        return new Portfolio;
    }

    public function getCreateForm()
    {
        return PortfolioForm::className();
    }
}
