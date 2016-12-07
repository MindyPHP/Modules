<?php

namespace Modules\Portfolio;

use Mindy\Base\Module;

class PortfolioModule extends Module
{
    public $imageSizes = [
        'small' => [75, 75],
        'thumb' => [220, 172],
    ];

    public function getVersion()
    {
        return '0.1';
    }

    public function getMenu()
    {
        return [
            'name' => self::t('Portfolio'),
            'items' => [
                [
                    'name' => self::t('Category'),
                    'adminClass' => 'CategoryAdmin',
                ],
                [
                    'name' => self::t('Portfolio'),
                    'adminClass' => 'PortfolioAdmin',
                ]
            ]
        ];
    }
}
