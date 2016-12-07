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
 * @date 27/08/14.08.2014 17:33
 */

namespace Modules\Blog\Models;

use Mindy\Orm\Manager;

class PostManager extends Manager
{
    /**
     * @return \Mindy\Orm\TreeQuerySet
     */
    public function published()
    {
        $this->filter(['is_published' => true]);
        return $this;
    }
}
