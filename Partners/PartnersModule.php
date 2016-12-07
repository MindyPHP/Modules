<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 11/09/14.09.2014 14:25
 */

namespace Modules\Partners;

use Mindy\Base\Mindy;
use Mindy\Base\Module;

class PartnersModule extends Module
{
    public $logoSizes = [
        'preview' => [185, 56, 'method' => 'resize']
    ];

    public static function preConfigure()
    {
        $tpl = Mindy::app()->template;
        $tpl->addHelper('render_partners', ['\Modules\Partners\Helpers\PartnersHelper', 'renderPartners']);
        $tpl->addHelper('get_partners', ['\Modules\Partners\Helpers\PartnersHelper', 'getPartners']);
    }

    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => self::t('Partners'),
                    'adminClass' => 'PartnerAdmin',
                ],
            ]
        ];
    }
}