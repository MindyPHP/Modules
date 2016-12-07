<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 01/03/16
 * Time: 14:37
 */

namespace Modules\Admin\Library;

use Mindy\Base\Mindy;
use Mindy\Helper\Text;
use Mindy\Template\Library;
use Modules\Admin\Helpers\AdminHelper;

class AdminLibrary extends Library
{
    /**
     * @return array
     */
    public function getHelpers()
    {
        return [
            'get_admin_user_menu' => [AdminHelper::class, 'renderUser'],
            'get_admin_main_menu' => [AdminHelper::class, 'renderMain'],
            'get_module_menu' => [AdminHelper::class, 'getModuleMenu'],
            'get_modules_menu' => function () {
                $data = [];
                $app = Mindy::app();
                $urlManager = $app->urlManager;
                foreach ($app->getModules() as $name => $params) {
                    $module = $app->getModule($name);
                    $menu = $module->getMenu();
                    if (empty($menu) || empty($menu['items'])) {
                        continue;
                    }

                    $user = Mindy::app()->getUser();
                    if (!empty($menu['items'])) {
                        $urls = [];
                        foreach ($menu['items'] as $item) {
                            if (
                                isset($item['url']) &&
                                $user->can('admin.' . Text::toUnderscore(str_replace(':', '.', $item['url'])))
                            ) {
                                $urls[] = $urlManager->reverse($item['url']);
                            } else if ($user->can('admin.' . Text::toUnderscore($module->getId()))) {
                                $urls[] = $urlManager->reverse('admin:action', [
                                    'module' => $name,
                                    'adminClass' => $item['adminClass'],
                                    'action' => 'list'
                                ]);
                            }
                        }

                        if (!empty($urls)) {
                            $data[$module->getName()] = [
                                'urls' => $urls,
                                'description' => $module->getDescription(),
                                'version' => $module->getVersion()
                            ];
                        }
                    }
                }
                ksort($data);
                return $data;
            }
        ];
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return [];
    }
}