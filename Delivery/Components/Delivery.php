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
 * @date 22/05/15 16:01
 */

namespace Modules\Delivery\Components;


use Mindy\Helper\Traits\Accessors;
use Mindy\Helper\Traits\Configurator;

class Delivery
{
    use Accessors, Configurator;

    public $systems = [];
    protected $_initialized = [];

    /**
     * @param $system
     * @param array $size
     * @param array $place
     * @return null
     */
    public function count($system, $size = [], $place = [], $from = [])
    {
        if ($delivery = $this->getSystem($system)) {
            return $delivery->count($size, $place, $from);
        }
        return null;
    }

    public function getCities($system)
    {
        if ($delivery = $this->getSystem($system)) {
            return $delivery->getCities();
        }
        return null;
    }

    /**
     * @param $name
     * @return null|\Modules\Delivery\Components\DeliverySystem
     */
    public function getSystem($name)
    {
        if (isset($this->_initialized[$name])) {
            return $this->_initialized[$name];
        }

        if (isset($this->systems[$name])) {
            return $this->initSystem($name, $this->systems[$name]);
        }

        return null;
    }

    /**
     * @param $name
     * @param $config
     * @return null
     */
    public function initSystem($name, $config)
    {
        if (isset($config['class'])) {
            $class = $config['class'];
            unset($config['class']);

            $system = new $class($config);
            $this->_initialized[$name] = $system;
            return $system;
        }

        return null;
    }
}