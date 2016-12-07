<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 19/05/16 08:23
 */

namespace Modules\Core\Controllers\Admin;

use Mindy\Base\Mindy;
use Modules\Core\Controllers\BackendController;

class RouteController extends BackendController
{
    public function actionList()
    {
        $routes = [];
        $reverse = Mindy::app()->urlManager->collector->reverse;
        foreach ($reverse as $route => $params) {
            $url = [];
            foreach ($params as $param) {
                if ($param['variable']) {
                    $url[] = '{' . $param['name'] . ($param['optional'] ? '?' : '') . '}';
                } else {
                    $url[] = $param['value'];
                }
            }
            $routes[] = ['route' => $route, 'url' => implode('', $url)];
        }
        echo $this->render('core/admin/route/list.html', [
            'module' => $this->getModule(),
            'routes' => $routes
        ]);
    }
}