<?php
/**
 * Created by IntelliJ IDEA.
 * User: Max
 * Date: 08/02/16
 * Time: 14:45
 */

namespace Modules\Catalog\Models;

use Mindy\Orm\Manager;

class ProductManager extends Manager
{
    public function published()
    {
        $this->filter(['is_published' => true]);
        return $this;
    }
}