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
 * @date 03/10/14.10.2014 17:42
 */

namespace Modules\Sape\Controllers;

use Modules\Core\Controllers\CoreController;

class SapeController extends CoreController
{
    public function actionTemplate()
    {
        echo $this->render('sape/template.html');
    }
}
