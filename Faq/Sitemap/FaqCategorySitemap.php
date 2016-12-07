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

namespace Modules\Faq\Sitemap;

use Modules\Faq\FaqModule;
use Modules\Faq\Models\Category;
use Modules\Sitemap\Components\Sitemap;

class FaqCategorySitemap extends Sitemap
{
    public function getModelClass()
    {
        return Category::className();
    }

    public function getLoc($data)
    {
        if (isset($data['url'])) {
            $url = $data['url'];
            return $this->reverse('faq:list', [$url]);
        } elseif (isset($data['reversed'])) {
            return $data['reversed'];
        }
        return '';
    }

    public function getLevel($data)
    {
        return isset($data['root']) ? 0 : 1;
    }

    public function getExtraItems()
    {
        return [
            [
                'root' => true,
                'name' => FaqModule::t('Faq'),
                'reversed' => $this->reverse('faq.index')
            ]
        ];
    }
}
