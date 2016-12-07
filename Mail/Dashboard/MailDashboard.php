<?php
/**
 * Created by IntelliJ IDEA.
 * User: max
 * Date: 14/04/16
 * Time: 10:55
 */

namespace Modules\Mail\Dashboard;

use DateTime;
use Mindy\Helper\JavaScript;
use Modules\Admin\Components\Dashboard;
use Modules\Mail\Models\Mail;

class MailDashboard extends Dashboard
{
    public function getData()
    {
        $first = new DateTime('first day of this month');
        $last = new DateTime('last day of this month');
        $labels = range($first->format('d'), $last->format('d'));
        $sended = [];
        $readed = [];
        $errors = [];

        foreach ($labels as $day) {
            $gteTime = date('Y-m-d H:i:s', strtotime(date('Y-m') . '-' . $day . ' 00:00:00'));
            $lteTime = date('Y-m-d H:i:s', strtotime(date('Y-m') . '-' . $day . ' 23:59:00'));

            $sended[] = Mail::objects()->filter([
                'created_at__lte' => $lteTime,
                'created_at__gte' => $gteTime,
                'is_sended' => true
            ])->count();

            $readed[] = Mail::objects()->filter([
                'created_at__lte' => $lteTime,
                'created_at__gte' => $gteTime,
                'is_read' => true
            ])->count();

            $errors[] = Mail::objects()->filter([
                'created_at__lte' => $lteTime,
                'created_at__gte' => $gteTime,
                'error__isnull' => false
            ])->count();
        }

        return [
            'options' => JavaScript::encode([
                'labels' => $labels,
                'series' => [$sended, $readed, $errors]
            ])
        ];
    }

    public function getTemplate()
    {
        return 'mail/admin/dashboard/mail.html';
    }
}