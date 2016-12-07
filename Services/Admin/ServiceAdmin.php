<?php
/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 15/09/14.09.2014 13:25
 */

namespace Modules\Services\Admin;

use Modules\Admin\Admin\Admin;
use Modules\Services\Models\Service;
use Modules\Services\Forms\ServiceForm;

class ServiceAdmin extends Admin
{
    public $columns = ['name', 'price', 'site'];

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModelClass()
    {
        return new Service;
    }

    public function getCreateForm()
    {
        return ServiceForm::class;
    }
}
