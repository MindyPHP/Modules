<?php

namespace Modules\Services\Controllers;

use Modules\Core\Controllers\FrontendController;
use Modules\Services\Models\Service;

class ServiceController extends FrontendController
{
    public function actionList()
    {
        $models = Service::objects()->order(['position'])->all();
        echo $this->render("services/list.html", [
            'models' => $models
        ]);
    }

    public function actionView($pk)
    {
        $model = Service::objects()->get(['pk' => $pk]);
        if ($model === null) {
            $this->error(404);
        }
        $rate = $model->rate->all();

        echo $this->render("services/view.html", [
            'model' => $model,
            'rate' => $rate
        ]);
    }
}
