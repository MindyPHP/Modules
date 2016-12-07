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
 * @date 11/09/14.09.2014 14:25
 */

namespace Modules\Comments;

use Mindy\Base\Mindy;
use Mindy\Base\Module;

class CommentsModule extends Module
{
    /**
     * @var array akisment config
     */
    public $akisment = [];
    /**
     * @var bool
     */
    public $premoderate = true;
    /**
     * @var string
     */
    public $recaptchaPublicKey;
    /**
     * @var string
     */
    public $recaptchaSecretKey;

    public static function preConfigure()
    {
        $tpl = Mindy::app()->template;
        $tpl->addHelper('render_comments', ['\Modules\Comments\Helper\CommentHelper', 'render_comments']);
    }
}
