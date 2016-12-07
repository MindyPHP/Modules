<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 03/07/14.07.2014 16:41
 */

namespace Modules\Blog\Sitemap;

use Modules\Blog\Models\Category;
use Modules\Sitemap\Components\Sitemap;

class CategorySitemap extends Sitemap
{
    public function getModelClass()
    {
        return Category::className();
    }

    public function getLastMod($data)
    {
        if (isset($data['updated_at'])) {
            $date = $data['updated_at'];
        } else {
            $date = $data['created_at'];
        }

        return $this->formatLastMod($date);
    }

    public function getLoc($data)
    {
        return $this->reverse('blog.list', ['url' => $data['url']]);
    }
}
