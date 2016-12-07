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
 * @date 19/02/15 07:23
 */
namespace Modules\Vacants\Helpers;

use Modules\Vacants\Models\File;

class VacantsHelper
{
    public static function getFile($code)
    {
        return File::objects()->filter(['code' => $code])->limit(1)->get();
    }
}