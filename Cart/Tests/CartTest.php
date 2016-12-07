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
 * @date 28/10/14.10.2014 13:07
 */

namespace Modules\Cart\Tests;

use Mindy\Helper\Traits\Accessors;
use Mindy\Helper\Traits\Configurator;
use Mindy\Tests\TestCase;
use Modules\Cart\Components\Cart;

class CartTest extends TestCase
{
    public function testCartItem()
    {
        $item = new Product(['price' => 10, 'id' => 1]);
        $this->assertEquals(10, $item->getPrice());
        $this->assertEquals(1, $item->getUniqueId());
        $this->assertInstanceOf('\Modules\Cart\Interfaces\ICartItem', $item);
    }

    public function testSimple()
    {
        $cart = new Cart();
        $this->assertEquals(0, $cart->getTotal());

        $cart->add(new Product(['price' => 10, 'id' => 1]));
        $this->assertEquals(10, $cart->getTotal());
        $cart->clear();

        $cart->add(new Product(['price' => 10, 'id' => 2]), 2);
        $this->assertEquals(20, $cart->getTotal());
        $cart->clear();

        $cart->add(new Product(['price' => 10, 'id' => 1]), 1, ['color' => 'black']);
        $cart->add(new Product(['price' => 10, 'id' => 1]), 1, ['color' => 'white']);
        $this->assertEquals(20, $cart->getTotal());
        $this->assertEquals(2, count($cart->getItems()));
        $cart->clear();
    }

    public function testCustomData()
    {
        $cart = new Cart();
        $cart->add(new Product(['price' => 10, 'id' => 1]), 1, ['color' => 'black']);
        $cart->add(new Product(['price' => 10, 'id' => 1]), 1, ['color' => 'white']);
        $cart->add(new Product(['price' => 10, 'id' => 1]), 1, ['color' => 'white']);
        $this->assertEquals(30, $cart->getTotal());
        $this->assertEquals(2, count($cart->getItems()));
        $cart->clear();
    }

    public function testIncrease()
    {
        $cart = new Cart();
        $cart->add(new Product(['price' => 10, 'id' => 1]), 1);
        $this->assertEquals(10, $cart->getTotal());
        $this->assertEquals(1, count($cart->getItems()));
        $cart->increaseQuantity(new Product(['price' => 10, 'id' => 1]));
        $this->assertEquals(2, $cart->getQuantity());
        $cart->decreaseQuantity(new Product(['price' => 10, 'id' => 1]));
        $this->assertEquals(1, $cart->getQuantity());
        $this->assertEquals(1, count($cart->getItems()));
        $cart->clear();
    }
}
