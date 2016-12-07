<?php
/**
 * Created by max
 * Date: 13/01/16
 * Time: 12:08
 */

namespace Modules\Cart\Components\Cart\Traits;

use Mindy\Base\Mindy;
use Modules\Cart\Components\Cart\Interfaces\ICartItem;

trait CartTrait
{
    /**
     * @param string $moduleName
     * @param string $component
     * @return \Modules\Cart\Components\Cart\Cart
     */
    public function getCart($moduleName = 'Cart', $component = 'cart')
    {
        return Mindy::app()->getModule($moduleName)->getComponent($component);
    }

    /**
     * @param bool $asArray
     * @param null $callback
     * @return \Modules\Cart\Components\Cart\CartLine[]
     */
    public function getObjects($asArray = false, $callback = null)
    {
        return $this->getCart()->getObjects($asArray, $callback);
    }

    /**
     * @param $product
     * @param int $quantity
     * @param array $data
     * @return bool
     */
    public function addToCart(ICartItem $product, $quantity = 1, array $data = [])
    {
        $cart = $this->getCart();
        if ($quantity > 0) {
            $cart->set($product, $quantity, $data);
            return true;
        }
        return false;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->getCart()->getQuantity();
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->getCart()->getPrice();
    }

    /**
     * @param $key string
     * @param $quantity int
     * @return bool
     */
    public function itemQuantity($key, $quantity)
    {
        return $this->getCart()->updateQuantityByKey($key, $quantity);
    }

    /**
     * @param $key string
     * @return bool
     */
    public function itemIncrease($key)
    {
        return $this->getCart()->increaseQuantityByKey($key);
    }

    /**
     * @param $key string
     * @return bool
     */
    public function itemDecrease($key)
    {
        return $this->getCart()->decreaseQuantityByKey($key);
    }

    /**
     * @param $key string
     * @return bool
     */
    public function itemRemove($key)
    {
        return $this->getCart()->removeByKey($key);
    }
}
