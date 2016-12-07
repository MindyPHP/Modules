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
 * @date 30/10/14.10.2014 17:28
 */

namespace Modules\Wiki;

use Mindy\Base\Mindy;
use Mindy\Base\Module;

class WikiModule extends Module
{
    public static function preConfigure()
    {
        $tpl = Mindy::app()->template;
        $urlManager = Mindy::app()->urlManager;
        $tpl->addHelper('wiki_links', function ($input) use ($urlManager) {
            preg_match_all('/<a href="([^">]+)">/', $input, $matches);
            foreach ($matches[0] as $i => $fullMatch) {
                $contentMatch = $matches[1][$i];
                if (mb_strpos($contentMatch, 'http://', null, 'utf-8')) {
                    continue;
                } else {
                    $url = $urlManager->reverse('wiki:view', $contentMatch);
                    $input = str_replace($matches[0][$i], '<a href="' . $url . '">', $input);
                }
            }
            return $input;
        });
    }
}
