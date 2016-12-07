<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 01/03/16
 * Time: 14:43
 */

namespace Modules\Admin\Helpers;

use Mindy\Base\Mindy;
use Mindy\Helper\Alias;
use Mindy\Helper\Traits\RenderTrait;

class AdminHelper
{
    use RenderTrait;

    static $menu = [];

    public static function renderMain($template = 'admin/menu/main.html')
    {
        return self::renderTemplate($template, [
            'apps' => self::fetchMenu()
        ]);
    }

    public static function renderUser($template = 'admin/menu/user.html')
    {
        static $userMenu = [];
        if (empty($userMenu)) {
            $path = Alias::get('application.config.user_menu') . '.php';
            if (is_file($path)) {
                $userMenu = include_once($path);
            }
        }
        return self::renderTemplate($template, [
            'apps' => $userMenu
        ]);
    }

    /**
     * Get menu by module
     * @param $name
     * @return null
     */
    public static function getModuleMenu($name)
    {
        $name = strtolower($name);
        $menu = self::fetchMenu();
        return isset($menu[$name]) ? $menu[$name] : null;
    }

    /**
     * Fetch menu from all modules
     * @return array
     */
    public static function fetchMenu()
    {
        if (empty(self::$menu)) {
            $modules = Mindy::app()->getModules();
            $user = Mindy::app()->user;

            foreach ($modules as $name => $config) {
                $adminCode = strtolower($name) . '.admin';
                $name = is_array($config) ? $name : $config;
                $module = Mindy::app()->getModule($name);

                if (method_exists($module, 'getMenu')) {
                    $items = $module->getMenu();
                    if (!empty($items)) {
                        $items['version'] = $module->getVersion();

                        $resultItems = [];

                        if (!isset($items['items'])) {
                            continue;
                        } else {
                            foreach ($items['items'] as $item) {
                                if (
                                    isset($item['adminClass']) &&
                                    $user->can($adminCode . '.' . strtolower($item['adminClass'])) ||
                                    !isset($item['code']) && $user->is_superuser
                                ) {
                                    $resultItems[] = $item;
                                }
                            }
                        }

                        if (empty($resultItems)) {
                            continue;
                        }

                        $items['items'] = $resultItems;
                        self::$menu[strtolower($name)] = $items;
                    }
                }
            }
        }

        return self::$menu;
    }
}