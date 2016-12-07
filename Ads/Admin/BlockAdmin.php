<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 24/02/16
 * Time: 16:36
 */

namespace Modules\Ads\Admin;

use Modules\Admin\Admin\Admin;
use Modules\Ads\Models\Block;

class BlockAdmin extends Admin
{
    public $getSearchFields = ['name', 'slug'];

    public $columns = ['name', 'slug'];

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModelClass()
    {
        return Block::class;
    }
}