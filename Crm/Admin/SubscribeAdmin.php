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
 * @date 03/10/14 09:14
 */
namespace Modules\Crm\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Crm\Models\Subscribe;

class SubscribeAdmin extends ModelAdmin
{
    public function getModel()
    {
        return new Subscribe;
    }
} 