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
 * @date 03/10/14.10.2014 16:43
 */

namespace Modules\Sape;

use Mindy\Base\Mindy;
use Mindy\Base\Module;
use Mindy\Helper\Alias;

class SapeModule extends Module
{
    /**
     * @var string
     */
    public static $sapeId = '753dcefacb8bf9b12d3527e86490e8c9';

    public static function preConfigure()
    {
        $tpl = Mindy::app()->template;
        $tpl->addHelper('sape_link', ['\Modules\Sape\Helper\SapeHelper', 'renderLink']);
        $tpl->addHelper('sape_article', ['\Modules\Sape\Helper\SapeHelper', 'renderArticle']);

        defined('_SAPE_USER') or define('_SAPE_USER', self::$sapeId);
        $path = realpath(Alias::get('www.' . _SAPE_USER . '.sape') . '.php');
        if(file_exists($path)) {
            require_once($path);
        } else {
            Mindy::app()->logger->error("Sape id file not found");
        }
    }
}
