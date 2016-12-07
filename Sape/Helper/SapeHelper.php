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
 * @date 03/10/14.10.2014 16:44
 */

namespace Modules\Sape\Helper;

use SAPE_articles;
use SAPE_client;

class SapeHelper
{
    /**
     * @var \SAPE_client
     */
    private static $_linksClient;
    /**
     * @var \SAPE_articles
     */
    private static $_articlesClient;

    public static function renderLink($count = null, $force = false)
    {
        return self::getSapeLinksClient($force)->return_links($count);
    }

    public static function renderArticle($count = null, $force = false)
    {
        return self::getSapeArticlesClient($force)->return_announcements($count);
    }

    private static function getSapeLinksClient($force)
    {
        if (self::$_linksClient === null) {
            self::$_linksClient = new SAPE_client(['force_show_code' => $force]);
        }
        return self::$_linksClient;
    }

    private static function getSapeArticlesClient($force)
    {
        if (self::$_articlesClient === null) {
            self::$_articlesClient = new SAPE_articles(['force_show_code' => $force]);
        }
        return self::$_articlesClient;
    }
}
