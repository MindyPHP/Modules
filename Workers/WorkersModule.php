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
 * @date 13/11/14 09:11
 */
namespace Modules\Workers;

use Mindy\Base\Module;

class WorkersModule extends Module
{
    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => $this->getName(),
                    'adminClass' => 'WorkerAdmin',
                ],
                [
                    'name' => WorkersModule::t('Departments'),
                    'adminClass' => 'DepartmentAdmin'
                ],
                [
                    'name' => WorkersModule::t('Reviews'),
                    'adminClass' => 'ReviewAdmin'
                ]

            ]
        ];
    }
}
