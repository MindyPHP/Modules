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
 * @date 11/09/14.09.2014 13:35
 */

namespace Modules\Comments\Helper;


use Mindy\Http\Request;
use Mindy\Orm\HasManyManager;
use Mindy\Orm\Model;
use Mindy\Pagination\Pagination;
use Mindy\Utils\RenderTrait;

class CommentHelper
{
    use RenderTrait;

    public static function render_comments(Request $request, $template, Model $model, HasManyManager $manager)
    {
        $module = $manager->getModel()->getModule();
        if(property_exists($module, 'commentForm') && $module->commentForm) {
            $commentClass = $module->commentForm;
        } else {
            $commentClass = '\Modules\Comments\Forms\CommentForm';
        }
        $form = new $commentClass([
            'model' => $manager->getModel(),
            'toLink' => $manager->to
        ]);
        $qs = $manager->getQuerySet()->filter(['is_published' => true])->order(['root', 'lft']);
        $pager = new Pagination($qs);
        return self::renderTemplate($template, [
            'comments' => $pager->paginate(),
            'pager' => $pager,
            'form' => $form,
            'model' => $model,
            'request' => $request
        ]);
    }
}
