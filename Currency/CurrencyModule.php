<?php

/**
 * User: max
 * Date: 01/10/15
 * Time: 21:35
 */

namespace Modules\Currency;

use Mindy\Base\Mindy;
use Mindy\Base\Module;
use Mindy\Helper\Json;

class CurrencyModule extends Module
{
    public static function preConfigure()
    {
        $tpl = Mindy::app()->template;
        $tpl->addHelper('get_currency_list', function () {
            return Json::encode([
                'RUB' => 'Рубль',
                'USD' => 'Доллар',
                'EUR' => 'Евро',
                'KZT' => 'Тенге',
                'UAH' => 'Украинская гривна',
                'BYR' => 'Белорусский рубль',
            ]);
        });
    }
}
