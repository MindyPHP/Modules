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
 * @date 12/09/14.09.2014 19:27
 */

namespace Modules\Forum;

use Mindy\Base\Mindy;
use Mindy\Base\Module;

class ForumModule extends Module
{
    public static function preConfigure()
    {
        $tpl = Mindy::app()->template;
        $tpl->addHelper('forum_navigation', ['Modules\Forum\Helpers\NavigationHelper', 'render']);
        $tpl->addHelper('add_noindex', function($str) {
            $url = Mindy::app()->urlManager->reverse('forum:go');
            return preg_replace('/((ftp|https?):\/\/([-\w\.]+)+(:\d+)?(\/([\w\/_\.]*(\?\S+)?)?)?)/i', $url . '?url=$1', $str);
        });
    }

    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => self::t('Forum'),
                    'adminClass' => 'ForumAdmin',
                ],
            ]
        ];
    }
}
