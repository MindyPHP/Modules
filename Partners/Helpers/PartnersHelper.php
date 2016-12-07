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
 * @date 10/11/14 11:15
 */
namespace Modules\Partners\Helpers;

use Mindy\Utils\RenderTrait;
use Modules\Partners\Models\Partner;

class PartnersHelper
{
    use RenderTrait;

    public static function renderPartners()
    {
        return self::renderTemplate('partners/partners.html', [
            'partners' => self::getPartners()
        ]);
    }

    public static function getPartners()
    {
        return Partner::objects()->published();
    }
}