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
 * @date 14/11/14.11.2014 16:14
 */

namespace Modules\Geo\Admin;

use Modules\Admin\Admin\Admin;
use Modules\Geo\Models\Region;

class RegionAdmin extends Admin
{
    public $searchFields = ['name'];
    
    /**
     * @return \Mindy\Orm\Model
     */
    public function getModelClass()
    {
        return Region::class;
    }
}
