<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 02/03/16
 * Time: 14:17
 */

namespace Modules\Pages\Models;

use Mindy\Orm\Manager;

class FlatPageManager extends Manager
{
    /**
     * @return \Mindy\Orm\TreeQuerySet
     */
    public function published()
    {
        return $this->filter(['is_published' => true]);
    }
}