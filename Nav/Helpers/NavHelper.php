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
 * @date 06/11/14 10:41
 */
namespace Modules\Nav\Helpers;

use Mindy\Utils\RenderTrait;
use Modules\Nav\Models\Nav;

class NavHelper
{
    use RenderTrait;

    public static function renderNav($slug)
    {
        $menu = Nav::objects()->get(['slug' => $slug]);
        if ($menu) {
            return self::renderTemplate('nav/nav.html', [
                'items' => $menu->tree()->descendants()->asTree()->all()
            ]);
        } else {
            return '';
        }
    }

    public static function multispan($text)
    {
        $words = array();
        $split = preg_split("//u", $text, -1, PREG_SPLIT_NO_EMPTY);
        $word = '';
        foreach($split as $key=>$letter) {
            if (preg_match('/\S/', $letter)) {
                $word .= $letter;
            } else {
                if (strlen($word) > 0) {
                    $words[] = $word;
                    $word = '';
                }
                $words[] = $letter;
            }
        }
        if (strlen($word) > 0) {
            $words[] = $word;
        }

        $wrapped = array();
        foreach($words as $word) {
            $wrapped[] = "<span>{$word}</span>";
        }
        return implode('', $wrapped);
    }
}