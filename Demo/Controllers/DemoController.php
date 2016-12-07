<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 10/03/15 13:56
 */

namespace Modules\Demo\Controllers;

use Modules\Core\Controllers\CoreController;

class DemoController extends CoreController
{
    public function actionIndex()
    {
        echo $this->render('demo/index.html');
    }
}
