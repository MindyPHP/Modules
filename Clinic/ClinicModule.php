<?php

namespace Modules\Clinic;

use Mindy\Base\Mindy;
use Mindy\Base\Module;

class ClinicModule extends Module
{
    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => self::t('Departments'),
                    'adminClass' => 'DepartmentAdmin',
                ],
                [
                    'name' => self::t('Pages'),
                    'adminClass' => 'PageAdmin',
                ],
                [
                    'name' => self::t('Workers'),
                    'adminClass' => 'WorkerAdmin',
                ],
                [
                    'name' => self::t('Categories'),
                    'adminClass' => 'CategoryAdmin',
                ]
            ]
        ];
    }
}
