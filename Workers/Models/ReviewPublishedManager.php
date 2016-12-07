<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 19/11/14 10:11
 */
namespace Modules\Workers\Models;

use Mindy\Orm\Manager;

class ReviewPublishedManager extends Manager
{
    public function getQuerySet()
    {
        $qs = parent::getQuerySet();
        return $qs->filter(['status' => Review::STATUS_PUBLISHED]);
    }
}