<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 18/02/16
 * Time: 11:38
 */

namespace Modules\UserActions\Commands;

use DateTime;
use Mindy\Console\ConsoleCommand;
use Modules\Core\Components\ParamsHelper;
use Modules\UserActions\Models\UserLog;

class UserActionCommand extends ConsoleCommand
{
    public function actionCleanup()
    {
        $days = (int)ParamsHelper::get('UserActions.UserLog.count');
        $count = UserLog::objects()->filter([
            'created_at__gte' => new DateTime('+' . $days . ' days')
        ])->delete();

        echo 'Removed ' . $count . ' records' . PHP_EOL;
    }
}