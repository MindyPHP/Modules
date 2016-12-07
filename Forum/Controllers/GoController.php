<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 04/06/15
 * Time: 18:10
 */

namespace Modules\Forum\Controllers;

use Modules\Core\Controllers\Controller;

class GoController extends Controller
{
    public function actionGo()
    {
        if (isset($_GET['url'])) {
            $this->redirect($_GET['url']);
        }

        $this->error(404);
    }
}
