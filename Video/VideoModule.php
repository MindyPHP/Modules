<?php

namespace Modules\Video;

use Mindy\Base\Module;

class VideoModule extends Module
{
    public function getVersion()
    {
        return '0.1';
    }

    public function getMenu()
    {
        return [
            'name' => self::t('Video'),
            'items' => [
                [
                    'name' => self::t('Video'),
                    'adminClass' => 'VideoAdmin',
                ],
                [
                    'name' => self::t('Categories'),
                    'adminClass' => 'CategoryAdmin',
                ]
            ]
        ];
    }
}
