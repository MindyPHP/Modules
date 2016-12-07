<?php
/**
 * 
 *
 * All rights reserved.
 * 
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 06/07/14.07.2014 18:48
 */

namespace Modules\Api;


use Mindy\Base\Module;
use Mindy\Helper\Alias;

class ApiModule extends Module
{
    public $api = [];

    public function getApiList()
    {
        if(empty($this->api)) {
            $path = Alias::get('application.config.api') . '.php';
            $this->api = include($path);
        }
        return $this->api;
    }
}
