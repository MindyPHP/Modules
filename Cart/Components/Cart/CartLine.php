<?php
/**
 * Created by max
 * Date: 27/01/16
 * Time: 15:06
 */

namespace Modules\Cart\Components\Cart;

use Mindy\Helper\Traits\Accessors;
use Mindy\Helper\Traits\Configurator;
use Modules\Cart\Components\Cart\Interfaces\ICartItem;
use Serializable;

/**
 * Class CartLine
 * @package Modules\Cart\Components
 */
class CartLine implements Serializable
{
    use Configurator, Accessors;

    /**
     * @var ICartItem
     */
    private $_product;
    /**
     * @var int|float
     */
    private $_quantity = 1;
    /**
     * @var array
     */
    private $_data = [];
    /**
     * @var []IDiscount
     */
    private $_discounts = [];

    /**
     * @return array
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->_data = $data;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        $price = $this->getProduct()->getPrice($this->getData()) * $this->getQuantity();
        foreach ($this->getDiscounts() as $discount) {
            $price = $discount->applyDiscount($this);
        }
        return (float)$price;
    }

    /**
     * @return IDiscount[]
     */
    public function getDiscounts()
    {
        return $this->_discounts;
    }

    /**
     * @param IDiscount[] $discounts
     */
    public function setDiscounts(array $discounts)
    {
        $this->_discountss = $discounts;
    }

    /**
     * @return ICartItem
     */
    public function getProduct()
    {
        return $this->_product;
    }

    public function setProduct(ICartItem $product)
    {
        $this->_product = $product;
    }

    /**
     * @return int|float
     */
    public function getQuantity()
    {
        return $this->_quantity;
    }

    /**
     * @param $quantity int
     */
    public function setQuantity($quantity)
    {
        $this->_quantity = (int)$quantity;
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([
            'quantity' => $this->getQuantity(),
            'product' => $this->getProduct(),
            'data' => $this->getData(),
        ]);
    }

    public function toArray()
    {
        return [
            'quantity' => $this->getQuantity(),
            'product' => $this->getProduct()->toArray(),
            'data' => $this->getData(),
            'price' => $this->getPrice()
        ];
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->setQuantity($data['quantity']);
        $this->setProduct($data['product']);
        $this->setData($data['data']);
    }
}