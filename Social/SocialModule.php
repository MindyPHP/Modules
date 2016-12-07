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
 * @date 07/11/14.11.2014 18:43
 */

namespace Modules\Social;

use Mindy\Base\Mindy;
use Mindy\Base\Module;
use Modules\Social\Models\SocialProfile;

class SocialModule extends Module
{
    public static function preConfigure()
    {
        $tpl = Mindy::app()->template;
        $tpl->addHelper('social', ['\Modules\Social\Helpers\SocialHelper', 'render']);

        $signal = Mindy::app()->signal;
        $signal->handler('\Modules\User\Models\User', 'afterDelete', function($owner) {
            SocialProfile::objects()->filter(['user' => $owner])->delete();
        });
    }
}
