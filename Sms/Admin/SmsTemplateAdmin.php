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
 * @date 09/12/14 20:15
 */
namespace Modules\Sms\Admin;

use Modules\Admin\Admin\Admin;
use Modules\Sms\Models\SmsTemplate;

class SmsTemplateAdmin extends Admin
{
    public $columns = ['id', 'code'];

    public function getModelClass()
    {
        return SmsTemplate::class;
    }
}