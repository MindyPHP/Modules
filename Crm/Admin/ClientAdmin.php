<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 03/10/14
 * Time: 08:17
 */

namespace Modules\Crm\Admin;


use Modules\Admin\Components\ModelAdmin;
use Modules\Crm\Models\Client;

class ClientAdmin extends ModelAdmin
{
    public function getModel()
    {
        return new Client;
    }
} 