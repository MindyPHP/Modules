<?php

/**
 * User: max
 * Date: 22/07/15
 * Time: 15:00
 */

namespace Modules\UserActions\Dashboard;

use Modules\Admin\Components\Dashboard;
use Modules\UserActions\Models\UserLog;
use Modules\UserActions\Tables\UserLogTable;

class UserLogDashboard extends Dashboard
{
    public function getData()
    {
        $qs = UserLog::objects()->order(['-created_at']);
        $table = new UserLogTable($qs);
        return [
            'table' => $table
        ];
    }

    public function getTemplate()
    {
        return "user_actions/admin/dashboard/user_log.html";
    }
}
