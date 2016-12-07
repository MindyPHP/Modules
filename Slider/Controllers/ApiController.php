<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 06/04/15 15:05
 */

namespace Modules\Slider\Controllers;

use Mindy\Base\Mindy;
use Modules\Core\Controllers\ApiBaseController;
use Modules\Slider\Models\Slide;

class ApiController extends ApiBaseController
{
    public function actionIndex()
    {
        $models = Slide::objects()->all();
        $data = [];
        foreach ($models as $model) {
            $data[] = $model->toArray();
        }
        echo $this->json($data);
        Mindy::app()->end();
    }
}
