<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 19/02/15 06:40
 */
namespace Modules\Vacants;

use Mindy\Base\Mindy;
use Mindy\Base\Module;

class VacantsModule extends Module
{
    public static function preConfigure()
    {
        $tpl = Mindy::app()->template;
        $tpl->addHelper('get_vacants_file', ['\Modules\Vacants\Helpers\VacantsHelper', 'getFile']);
    }

    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => VacantsModule::t('Responses'),
                    'adminClass' => 'ResponseAdmin'
                ],
                [
                    'name' => VacantsModule::t('Departments'),
                    'adminClass' => 'DepartmentAdmin'
                ],
                [
                    'name' => VacantsModule::t('Vacancies'),
                    'adminClass' => 'VacancyAdmin'
                ],
                [
                    'name' => VacantsModule::t('Files'),
                    'adminClass' => 'FileAdmin'
                ]
            ]
        ];
    }
}