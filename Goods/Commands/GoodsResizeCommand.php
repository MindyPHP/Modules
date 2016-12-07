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
 * @date 23/01/15 10:39
 */
namespace Modules\Goods\Commands;

use Mindy\Base\Mindy;
use Mindy\Console\ConsoleCommand;
use Modules\Goods\Models\Product;


class GoodsResizeCommand extends ConsoleCommand
{
    public function actionIndex()
    {
        $sizes = array_keys(Mindy::app()->getModule('Goods')->productImageSizes);
        $cls = Mindy::app()->getModule('Goods')->productModel;
        foreach($cls::objects()->all() as $item) {
            echo $item->id . PHP_EOL;

            foreach($sizes as $size) {
                $field = $item->getField('image');
                $field->force = true;
                echo $field->value . PHP_EOL;
                if ($field->value) {
                    $field->sizeUrl($size);
                }
            }

            foreach($item->images as $image) {
                foreach($sizes as $size) {
                    $field = $image->getField('file');
                    $field->force = true;
                    echo $field->value . PHP_EOL;
                    if ($field->value) {
                        $field->sizeUrl($size);
                    }
                }
            }

            echo number_format(memory_get_usage(), 0, '.', ' ').PHP_EOL;
            echo number_format(memory_get_peak_usage(), 0, '.', ' ').PHP_EOL;
        }
    }
}