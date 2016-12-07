<?php

namespace Modules\Reviews\Helpers;

use Mindy\Base\Mindy;

class ReviewsHelper
{
    public static function getReviews($pager = true, $form = null)
    {
        $module = Mindy::app()->getModule('Reviews');

        $formClass = $module->formClass;
        $modelClass = $module->modelClass;

        if (!$form) {
            $form = new $formClass();
        }
        if (!empty($_POST)) {
            $form->setAttributes($_POST);
        }
        $qs = $modelClass::objects()->published()->order(['-published_at']);
        if ($pager) {
            $pager = new \Mindy\Pagination\Pagination($qs);
            return [
                'reviews' => $pager->paginate(),
                'pager' => $pager,
                'form' => $form
            ];
        } else {
            return [
                'reviews' => $qs->all(),
                'form' => $form
            ];
        }
    }

    public static function getRandomReviews($limit = 3, $exclude = null)
    {
        $module = Mindy::app()->getModule('Reviews');
        $modelClass = $module->modelClass;
        $qs = $modelClass::objects()->published()->limit($limit)->order(['?']);
        if ($exclude) {
            $qs = $qs->exclude(['id' => $exclude]);
        }
        return $qs->all();
    }
} 
