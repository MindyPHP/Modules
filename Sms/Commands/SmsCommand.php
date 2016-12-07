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
 * @date 09/12/14 19:24
 */
namespace Modules\Sms\Commands;

use Mindy\Base\Mindy;
use Mindy\Console\ConsoleCommand;

class SmsCommand extends ConsoleCommand
{
    public function actionTest()
    {
        $phone = Mindy::app()->getModule('Sms')->testPhone;
        if ($phone) {
            if (Mindy::app()->sms->send($phone, 'Test')) {
                echo 'Message sent' . PHP_EOL;
            } else {
                echo 'Message not sent' . PHP_EOL;
            }
        } else {
            echo 'Test phone is not set' . PHP_EOL;
        }
    }

    public function actionTestFromCode()
    {
        $phone = Mindy::app()->getModule('Sms')->testPhone;
        if ($phone) {
            if (Mindy::app()->sms->fromCode('TEST', $phone, ['username' => 'testuser', 'phone' => 123456])) {
                echo 'Message sent' . PHP_EOL;
            } else {
                echo 'Message not sent' . PHP_EOL;
            }
        } else {
            echo 'Test phone is not set' . PHP_EOL;
        }
    }
}