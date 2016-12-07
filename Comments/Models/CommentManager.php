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
 * @date 11/09/14.09.2014 14:54
 */

namespace Modules\Comments\Models;

use Mindy\Orm\TreeManager;

class CommentManager extends TreeManager
{
    public function nospam()
    {
        $this->filter(['is_spam' => false]);
        return $this;
    }

    public function published()
    {
        d(1);
        $this->filter(['is_published' => true]);
        return $this;
    }
}
