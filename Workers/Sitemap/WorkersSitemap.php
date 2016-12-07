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
 * @date 05/12/14 17:45
 */
namespace Modules\Workers\Sitemap;

use Mindy\Base\Mindy;
use Modules\Workers\Models\Worker;
use Modules\Sitemap\Components\Sitemap;
use Modules\Workers\WorkersModule;

class WorkersSitemap extends Sitemap
{
    public function getModelClass()
    {
        return Worker::className();
    }

    public function getLoc($data)
    {
        if(isset($data['reversed'])) {
            return $data['reversed'];
        } elseif(isset($data['id'])) {
            return $this->reverse('workers.view', [$data['id']]);
        }
    }

    public function getExtraItems()
    {
        return [
            [
                'name' => WorkersModule::t('Workers'),
                'reversed' => $this->reverse('workers.list')
            ],
            [
                'name' => WorkersModule::t('Reviews'),
                'reversed' => $this->reverse('workers.reviews')
            ]
        ];
    }
}
