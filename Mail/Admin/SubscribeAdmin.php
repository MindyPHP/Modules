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
 * @date 17/11/14.11.2014 15:52
 */

namespace Modules\Mail\Admin;

use Mindy\Orm\Model;
use Modules\Admin\Admin\Admin;
use Modules\Mail\Models\Subscribe;

class SubscribeAdmin extends Admin
{
    public $columns = ['name', 'email', 'phones', 'sub_category'];

    public $searchFields = ['name', 'email', 'phones', 'site', 'sub_category'];

    /**
     * @param Model $model
     * @return \Mindy\Orm\QuerySet
     */
    public function getQuerySet(Model $model)
    {
        return $model->objects()->getQuerySet()->order(['name']);
    }

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModelClass()
    {
        return Subscribe::class;
    }
}
