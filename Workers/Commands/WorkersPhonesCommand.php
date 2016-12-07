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

use Mindy\Base\Mindy;
use Mindy\Console\ConsoleCommand;
use Modules\Workers\Models\Worker;

class WorkersPhonesCommand extends ConsoleCommand
{
    public function actionIndex()
    {
        $this->prepareWorkers();
        $phonesFile = Mindy::app()->basePath ."/../generate/phones.csv";
        $data = file_get_contents($phonesFile);
        $lines = explode("\n", $data);
        foreach($lines as $line) {
            $lineData = explode(';', $line);
            $name = isset($lineData[0]) ? $lineData[0] : null;
            $phone = isset($lineData[1]) ? $lineData[1] : null;
            $name = trim($name);
            $phone = $this->normalizePhone($phone);
            if ($name && $phone && strlen($phone) == 6) {
                $city = $this->generateCity($phone);
                $mobile = $this->generateMobile($phone);
                $worker = $this->getWorker($name);
                if (!$worker) {
                    echo "Worker: {$name} not found" . PHP_EOL;
                    continue;
                }
                $worker->phone = $city;
                $worker->phone_duplicate = $mobile;
                $worker->save();
            }
        }
    }

    public function prepareWorkers()
    {
        $workers = Worker::objects()->all();
        foreach($workers as $worker) {
            $worker->last_name = trim($worker->last_name);
            $worker->name = trim($worker->name);
            $worker->middle_name = trim($worker->middle_name);
            $worker->save();
        }
    }
    /**
     * @param $name
     * @return \Modules\Workers\Models\Worker|null
     */
    function getWorker($name)
    {
        $parts = explode(' ', $name);
        $worker = null;
        if (count($parts) == 3) {
            $lastName = $parts[0];
            $firstName = $parts[1];
            $middleName = $parts[2];

            $worker = Worker::objects()->limit(1)->filter([
                'last_name' => $lastName,
                'name' => $firstName,
                'middle_name' => $middleName
            ])->get();
        }
        return $worker;
    }

    function generateMobile($phone)
    {
        return '7964250' . substr($phone, 2, 4);
    }

    function generateCity($phone)
    {
        return '78332' . $phone;
    }

    function normalizePhone($phone)
    {
        $phone = trim($phone);
        return str_replace([' ', '-'], '', $phone);
    }
}