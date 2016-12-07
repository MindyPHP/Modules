<?php

namespace Modules\Offices;

use Mindy\Base\Mindy;
use Mindy\Base\Module;
use Modules\Offices\Models\Office;

class OfficesModule extends Module
{
    public function getVersion()
    {
        return 1.0;
    }

    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => $this->getName(),
                    'adminClass' => 'OfficeAdmin',
                ],
                [
                    'name' => self::t('Categories'),
                    'adminClass' => 'CategoryAdmin',
                ]
            ]
        ];
    }
}
