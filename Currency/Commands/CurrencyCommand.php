<?php

/**
 * User: max
 * Date: 01/10/15
 * Time: 21:35
 */

namespace Modules\Currency\Commands;

use Mindy\Console\ConsoleCommand;
use Modules\Currency\Helpers\CbrfHelper;
use Modules\Currency\Models\Currency;

class CurrencyCommand extends ConsoleCommand
{
    public function actionIndex()
    {
        $currency = [
            'USD',
            'EUR',
            'KZT',
            'UAH',
            'BYR',
        ];

        $cbr = new CbrfHelper();
        if ($cbr->load()) {
            $data = [];
            foreach ($currency as $c) {
                $data[strtoupper($c)] = $cbr->get(strtoupper($c));
            }
            (new Currency([
                'data' => $data
            ]))->save();
        }
    }
}
