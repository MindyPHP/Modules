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
 * @date 11/07/14.07.2014 16:04
 */

namespace Modules\Core\Controllers\Admin;

use Mindy\Base\Mindy;
use Modules\Core\Controllers\BackendController;

class ModulesController extends BackendController
{
    public function actionList()
    {
        $modules = [];
        $modulesRaw = Mindy::app()->getModules();
        foreach (array_keys($modulesRaw) as $name) {
            $modules[] = Mindy::app()->getModule($name);
        }

        echo $this->render('core/admin/module/list.html', [
            'module' => $this->getModule(),
            'modules' => $modules,
        ]);
    }

}
