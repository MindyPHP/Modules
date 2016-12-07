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
 * @date 15/05/15 14:44
 */
namespace Modules\CustomFields\Commands;

use Mindy\Console\ConsoleCommand;
use Mindy\Helper\Console;
use Modules\CustomFields\Models\CustomField;

class CollectDictsCommand extends ConsoleCommand
{
    public function actionIndex()
    {
        echo 'Use this command very carefully! You know what it does?' . PHP_EOL;
        if (Console::prompt("[y/N]") == 'y') {
            $fields = CustomField::objects()->filter(['type' => CustomField::TYPE_DICT])->all();
            foreach($fields as $field) {
                $valueClass = $field->getValueClass();
                $values = $valueClass::objects()->filter(['custom_field' => $field])->valuesList(['value'], true);
                $values = array_filter($values, function($v){
                    if ($v !== '') {
                        return true;
                    }
                    return false;
                });
                $values = array_unique($values);
                $values = array_combine($values, $values);
                $field->list = $values;
                $field->save();
            }
        }
    }
}