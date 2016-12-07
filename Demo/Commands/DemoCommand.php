<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 10/03/15 18:48
 */

namespace Modules\Demo\Commands;

use Mindy\Console\ConsoleCommand;
use Mindy\Query\ConnectionManager;

class DemoCommand extends ConsoleCommand
{
    public function actionIndex()
    {
        $db = ConnectionManager::getDb();
        $sql = file_get_contents(__DIR__ . '/../data/dump.sql');
        $db->createCommand($sql)->execute();
    }
}
