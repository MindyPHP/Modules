<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 28/10/2014 13:06
 * @date 27/01/2016 16:07
 */

namespace Modules\Cart\Components\Cart;

use Mindy\Helper\Creator;
use Mindy\Helper\Traits\Accessors;
use Mindy\Helper\Traits\Configurator;
use Modules\Cart\Components\Cart\Interfaces\ICartItem;

class Cart
{
    use Accessors, Configurator;

    /**
     * @var string|array component configuration
     */
    public $storageConfig = [
        'class' => '\Modules\Cart\Components\Cart\Storage\SessionStorage'
    ];
    public $storageKey = 'cart';
    /**
     * @var \Modules\Cart\Components\Cart\Interfaces\IDiscount[]
     */
    public $discounts = [];
    /**
     * @var \Modules\Cart\Components\Cart\Storage\SessionStorage
     */
    private $_storage;
    /**
     * @var \Modules\Cart\Components\Cart\Interfaces\IDiscount[]
     */
    private $_discounts = null;

    /**
     * @return \Modules\Cart\Components\Cart\Storage\SessionStorage
     */
    public function getStorage()
    {
        if ($this->_storage === null) {
            $this->_storage = Creator::createObject($this->storageConfig, $this, $this->storageKey);
        }
        return $this->_storage;
    }

    /**
     * @param ICartItem $object
     * @param array $data
     * @return string
     */
    protected function makeKey(ICartItem $object, array $data)
    {
        return strtr("{class}{unique_id}", [
            "{class}" => get_class($object),
            "{unique_id}" => serialize(['unique_id' => $object->getUniqueId(), 'data' => $data])
        ]);
    }

    /**
     * @param ICartItem $object
     * @param array $data
     * @return mixed
     */
    public function get(ICartItem $object, array $data = [])
    {
        return $this->getStorage()->get($this->makeKey($object, $data));
    }

    /**
     * @param ICartItem $object
     * @param int $quantity
     * @param array $data
     * @return $this
     */
    public function set(ICartItem $object, $quantity = 1, array $data = [])
    {
        $key = $this->makeKey($object, $data);
        if ($this->has($object, $data)) {
            $item = $this->get($object, $data);
            $item->setQuantity($item->getQuantity() + 1);
            $this->getStorage()->set($key, $item);
        } else {
            $this->getStorage()->set($key, new CartLine([
                'product' => $object,
                'data' => $data,
                'quantity' => $quantity,
            ]));
        }

        return $this;
    }

    /**
     * @param $key
     * @return null
     */
    public function getPositionByKey($key)
    {
        $objects = $this->getStorage()->getObjects();
        $data = array_values(array_flip($objects));
        return isset($data[$key]) ? $data[$key] : null;
    }

    /**
     * @param $key
     * @param $quantity
     * @return bool
     */
    public function updateQuantityByKey($key, $quantity)
    {
        $positionKey = $this->getPositionByKey($key);
        if ($positionKey) {
            $storage = $this->getStorage();
            $item = $storage->get($positionKey);
            $item->setQuantity($quantity);
            $storage->set($positionKey, $item);
            return true;
        }
        return false;
    }

    /**
     * @param $key
     * @return bool
     */
    public function increaseQuantityByKey($key)
    {
        $positionKey = $this->getPositionByKey($key);
        if ($positionKey) {
            $storage = $this->getStorage();
            $item = $storage->get($positionKey);
            $item->setQuantity($item->getQuantity() + 1);
            $storage->set($positionKey, $item);
            return true;
        }
        return false;
    }

    /**
     * @param ICartItem $object
     * @param array $data
     * @return bool
     */
    public function increaseQuantity(ICartItem $object, array $data = [])
    {
        $item = $this->get($object, $data);
        if ($item) {
            $item->setQuantity($item->getQuantity() + 1);
            $this->getStorage()->set($this->makeKey($object, $data), $item);
            return true;
        }
        return false;
    }

    /**
     * @param $key
     * @return bool
     */
    public function decreaseQuantityByKey($key)
    {
        $positionKey = $this->getPositionByKey($key);
        if ($positionKey) {
            $storage = $this->getStorage();
            $item = $storage->get($positionKey);
            $item->setQuantity($item->getQuantity() - 1);
            $storage->set($positionKey, $item);
            return true;
        }
        return false;
    }

    /**
     * @param ICartItem $object
     * @param array $data
     * @return bool
     */
    public function decreaseQuantity(ICartItem $object, array $data = [])
    {
        $item = $this->get($object, $data);
        if ($item) {
            $item->setQuantity($item->getQuantity() - 1);
            $this->getStorage()->set($this->makeKey($object, $data), $item);
            return true;
        }
        return false;
    }

    /**
     * @param $key
     * @return bool
     */
    public function removeByKey($key)
    {
        if ($key = $this->getPositionByKey($key)) {
            $this->getStorage()->remove($key);
        }
    }

    /**
     * @param ICartItem $object
     * @param array $data
     */
    public function remove(ICartItem $object, array $data = [])
    {
        $this->getStorage()->remove($this->makeKey($object, $data));
    }

    /**
     * @param ICartItem $object
     * @param array $data
     * @return bool
     */
    public function has(ICartItem $object, array $data = [])
    {
        $key = $this->makeKey($object, $data);
        return $this->getStorage()->has($key);
    }

    /**
     * @return $this
     */
    public function clear()
    {
        $this->getStorage()->clear();
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        $quantity = 0;
        foreach ($this->getObjects() as $line) {
            $quantity += $line->getQuantity();
        }
        return $quantity;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        $total = 0;
        foreach ($this->getObjects() as $item) {
            $total += $item->getPrice();
        }
        return (float)$total;
    }

    /**
     * Force update all products in cart
     */
    public function forceUpdate()
    {
        /** @var \Mindy\Orm\Model $object */
        /** @var CartLine $item */
        /** @var ICartItem $newObject */
        $storage = $this->getStorage();
        $items = $storage->getObjects();
        $storage->clear();
        foreach ($items as $item) {
            $object = $item->getProduct();
            $newObject = $object->objects()->get([
                'pk' => $object->pk
            ]);

            if ($newObject !== null) {
                $this->set($newObject, $item->getQuantity(), $item->getData());
            }
        }
    }

    /**
     * @param $asArray bool
     * @return CartLine[]
     */
    public function getObjects()
    {
        $objects = $this->getStorage()->getObjects();
        $items = [];
        foreach ($objects as $obj) {
            $items[] = unserialize($obj);
        }
        return $items;
    }

    /**
     * @return bool
     */
    public function getIsEmpty()
    {
        return $this->getStorage()->count() === 0;
    }

    /**
     * Create CartLine from ICartItem and return price with discount
     * @param ICartItem $product
     * @param int $quantity
     * @param array $data
     * @return float
     */
    public function applyDiscount(ICartItem $product, $quantity = 1, array $data = [])
    {
        return (new CartLine([
            'quantity' => $quantity,
            'data' => $data,
            'product' => $product
        ]))->getPrice();
    }

    /**
     * @return \Modules\Cart\Components\Cart\Interfaces\IDiscount[]
     */
    public function getDiscounts()
    {
        if ($this->_discounts === null) {
            $this->_discounts = [];
            foreach ($this->discounts as $className) {
                $this->_discounts[] = Creator::createObject($className);
            }
        }

        return $this->_discounts;
    }
}
