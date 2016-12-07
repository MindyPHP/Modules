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
 * @date 28/08/14.08.2014 12:53
 */

namespace Modules\Offices\Admin;

use Modules\Admin\Admin\Admin;
use Modules\Offices\Forms\OfficeForm;
use Modules\Offices\Models\Office;

class OfficeAdmin extends Admin
{
    public $columns = ['name', 'address', 'is_published'];

    public $sortingColumn = 'position';

    public function getCreateForm()
    {
        return OfficeForm::class;
    }

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModelClass()
    {
        return Office::class;
    }
}
