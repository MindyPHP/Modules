<?php
/**
 * Created by IntelliJ IDEA.
 * User: max
 * Date: 28/04/16
 * Time: 14:21
 */

namespace Modules\Admin\Controllers;

use Mindy\Base\Mindy;
use Modules\Core\Controllers\BackendController;

class AdminDispatchController extends BackendController
{
    public function allowedActions()
    {
        return ['dispatch'];
    }

    public function actionDispatchIndex()
    {
        $module = $this->getModule();
        $indexRoute = $module->getIndexRoute();
        $this->getRequest()->redirect(empty($indexRoute) ? 'admin:dashboard' : $indexRoute);
        Mindy::app()->end();
    }
    
    /**
     * Forward controller action to model admin class
     * @param $module string
     * @param $admin string
     * @param $action string
     * @throws \Mindy\Exception\HttpException
     */
    public function actionDispatch($module, $admin, $action)
    {
        $className = $this->getAdminClassName($module, $admin);
        if ($className === null) {
            $this->error(404);
        }

        if (isset($_POST['action'])) {
            $action = $_POST['action'];
        }

        $this->forward($className, $action, $_GET, $module);
    }

    /**
     * @param $module
     * @param $admin
     * @return null|string
     */
    protected function getAdminClassName($module, $admin)
    {
        $className = strtr('\Modules\{module}\Admin\{admin}', [
            '{module}' => $module,
            '{admin}' => $admin
        ]);

        return class_exists($className) ? $className : null;
    }
}