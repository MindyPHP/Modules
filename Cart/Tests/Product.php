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
 * @date 28/10/14.10.2014 16:05
 */

namespace Modules\Cart\Tests;

use Mindy\Helper\Traits\Accessors;
use Mindy\Helper\Traits\Configurator;
use Modules\Cart\Interfaces\ICartItem;

class Product implements ICartItem
{
    use Accessors, Configurator;

    public $id;

    public $price;

    public function __toString()
    {
        return (string)$this->id;
    }

    /**
     * @return mixed unique product identification
     */
    public function getUniqueId()
    {
        return $this->id;
    }

    /**
     * @return int|float
     */
    public function getPrice()
    {
        return $this->price;
    }
}
