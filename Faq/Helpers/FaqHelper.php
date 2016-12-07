<?php

namespace Modules\Faq\Helpers;

use Mindy\Pagination\Pagination;
use Modules\Faq\Models\Category;

class FaqHelper
{
    public static function getCategories($pager = true)
    {
        $qs = Category::objects();
        if ($pager) {
            $pager = new Pagination($qs);
            return [
                'categories' => $pager->paginate(),
                'pager' => $pager
            ];
        } else {
            return [
                'categories' => $qs->all()
            ];
        }
    }
}
