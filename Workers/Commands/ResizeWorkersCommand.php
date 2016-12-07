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
 * @date 13/03/15 11:53
 */
namespace Modules\Workers\Commands;

use Mindy\Console\ConsoleCommand;
use Modules\Workers\Models\Worker;

class ResizeWorkersCommand extends ConsoleCommand
{
    public function getClasses()
    {
        return [
            [
                'class' => Worker::className(),
                'fields' => ['image' => ['list', 'sidebar', 'big'], 'image_hover' => ['list'], 'image_additional' => ['list', 'big']]
            ],
        ];
    }

    /**
     * @param $class
     * @param $fields
     */
    public function handleClass($class, $fields)
    {
        foreach($class::objects()->batch(10) as $iterator) {
            foreach($iterator as $item) {
                foreach($fields as $field => $sizes) {
                    $field = $item->getField($field);
                    $field->force = true;
                    if ($field->value) {
                        echo $field->value . PHP_EOL;
                        foreach ($sizes as $size) {
                            $field->sizeUrl($size);
                        }
                    }
                }
            }
        }
    }

    public function actionIndex()
    {
        foreach ($this->getClasses() as $data) {
            $this->handleClass($data['class'], $data['fields']);
            echo number_format(memory_get_peak_usage(), 0, '.', ' ') . PHP_EOL;
        }
    }
}