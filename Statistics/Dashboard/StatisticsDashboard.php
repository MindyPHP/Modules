<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 12/05/16 09:54
 */

namespace Modules\Statistics\Dashboard;

use DateTime;
use Mindy\Helper\JavaScript;
use Modules\Admin\Components\Dashboard;
use Modules\Statistics\Models\Statistics;

class StatisticsDashboard extends Dashboard
{
    public function getData()
    {
        $first = new DateTime('first day of this month');
        $last = new DateTime('last day of this month');
        $labels = range($first->format('d'), $last->format('d'));
        $hits = [];
        $unique = [];

        foreach ($labels as $day) {
            $gteTime = date('Y-m-d H:i:s', strtotime(date('Y-m') . '-' . $day . ' 00:00:00'));
            $lteTime = date('Y-m-d H:i:s', strtotime(date('Y-m') . '-' . $day . ' 23:59:00'));

            $hits[] = Statistics::objects()->filter([
                'created_at__lte' => $lteTime,
                'created_at__gte' => $gteTime,
            ])->count();

            $unique[] = Statistics::objects()->filter([
                'created_at__lte' => $lteTime,
                'created_at__gte' => $gteTime,
            ])->group(['ip_address'])->count();
        }

        return [
            'options' => JavaScript::encode([
                'labels' => $labels,
                'series' => [$hits, $unique]
            ])
        ];
    }

    public function getTemplate()
    {
        return 'statistics/admin/dashboard/statistics.html';
    }
}