<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 31/10/14.10.2014 17:12
 */

namespace Modules\Doc\Controllers;

use Modules\Core\Controllers\CoreController;

class ApiDocController extends CoreController
{
    public function actionView($file)
    {
        $path = $this->getModule()->getDocPath() . '/' . $file . '.html';
        if (file_exists($path)) {
            echo $this->render('doc/api/view.html', [
                'content' => file_get_contents($path)
            ]);
        } else {
            $this->error(404);
        }
    }
}
