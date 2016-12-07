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
 * @date 22/05/15 15:59
 */

namespace Modules\Delivery\Components;


use Exception;
use Mindy\Helper\Traits\Accessors;
use Mindy\Helper\Traits\Configurator;

abstract class DeliverySystem
{
    use Accessors, Configurator;

    public $debug = false;

    abstract public function count($size, $place, $from);
    
    abstract public function getCities();

    public function init()
    {
        $this->debug = MINDY_DEBUG;
    }

    public function debug($message) {
        if ($this->debug) {
            die($message);
        }
    }
}