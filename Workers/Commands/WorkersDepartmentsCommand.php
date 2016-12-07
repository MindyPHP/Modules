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
 * @date 19/03/15 17:03
 */
namespace Modules\Workers\Commands;

use Mindy\Console\ConsoleCommand;
use Modules\Workers\Models\Worker;

class WorkersDepartmentsCommand extends ConsoleCommand
{
    public function actionIndex()
    {
        $workers = Worker::objects()->all();
        foreach ($workers as $worker) {
            $department = $worker->department;
            if ($department) {
                $worker->departments = [$department];
                $worker->save();
            }
        }
    }
}