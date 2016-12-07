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
use Modules\Ads\Models\Ad;

class AdAdmin extends Admin
{
    public $searchFields = ['name'];

    public $columns = ['name', 'block'];

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModelClass()
    {
        return Ad::class;
    }
}