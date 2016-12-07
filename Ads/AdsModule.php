<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 24/02/16
 * Time: 16:30
 */

namespace Modules\Ads;

use Mindy\Base\Mindy;
use Mindy\Base\Module;
use Modules\Ads\Library\AdsLibrary;

class AdsModule extends Module
{
    public $imageSizes = [];

    public static function preConfigure()
    {
        $tpl = Mindy::app()->template;
        $tpl->addLibrary(new AdsLibrary());
    }

    public function getDescription()
    {
        return self::t('Ad materials');
    }

    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => self::t('Blocks'),
                    'adminClass' => 'BlockAdmin',
                ],
                [
                    'name' => self::t('Ads'),
                    'adminClass' => 'AdAdmin',
                ]
            ]
        ];
    }
}