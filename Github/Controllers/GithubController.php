<?php

namespace Modules\Github\Controllers;

use Modules\Core\Controllers\Controller;
use Modules\Github\Models\Repo;

class GithubController extends Controller
{
    public function actionIndex()
    {
        $models = Repo::objects()->order(['name'])->all();

        echo $this->render('github/index.html', [
            'models' => $models
        ]);
    }
}
