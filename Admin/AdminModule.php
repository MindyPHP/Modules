<?php

namespace Modules\Admin;

use Mindy\Base\Mindy;
use Mindy\Base\Module;
use Mindy\Helper\Alias;
use Modules\Admin\Library\AdminLibrary;

/**
 * Default permissions:
 * admin.change_settings
 *
 * Class AdminModule
 * @package Modules\Admin
 */
class AdminModule extends Module
{
    /**
     * @var null|\Closure
     */
    public $indexRoute = null;
    /**
     * @var array
     */
    protected $dashboards = [];

    public static function preConfigure()
    {
        Mindy::app()->template->addLibrary(new AdminLibrary());
    }

    public function getIndexRoute()
    {
        return $this->indexRoute ? $this->indexRoute->__invoke() : null;
    }

    /**
     * @return array
     */
    public function getDashboardClasses()
    {
        if (empty($this->dashboards)) {
            $path = Alias::get('application.config.dashboard') . '.php';
            if (is_file($path)) {
                $this->dashboards = include_once($path);
            }
        }
        return $this->dashboards;
    }

    public function getMenu()
    {
        return [
            'name' => self::t('Dashboard'),
            'items' => [
                [
                    'name' => self::t('Dashboard'),
                    'url' => 'admin:index'
                ],
            ]
        ];
    }
}
