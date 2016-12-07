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

namespace Modules\Solutions\Sitemap;

use Modules\Sitemap\Components\Sitemap;
use Modules\Solutions\Models\Solution;
use Modules\Solutions\SolutionsModule;

class SolutionsSitemap extends Sitemap
{
    public $nameColumn = 'court';

    public function getModelClass()
    {
        return Solution::className();
    }

    public function getLoc($data)
    {
        if(isset($data['id'])) {
            $id = $data['id'];
            return $this->reverse('solutions.view', [$id]);
        }elseif(isset($data['reversed'])) {
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
                'court' => SolutionsModule::t('Court solutions'),
                'reversed' => $this->reverse('solutions.index')
            ]
        ];
    }
}
