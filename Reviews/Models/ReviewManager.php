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
 * @date 27/08/14.08.2014 15:35
 */

namespace Modules\Reviews\Models;

use Mindy\Orm\Manager;

class ReviewManager extends Manager
{
    public function published()
    {
        return $this->filter([
            'is_published' => true
        ]);
    }
}