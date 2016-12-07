<?php
/**
 * Created by max
 * Date: 27/01/16
 * Time: 15:46
 */

namespace Modules\Cart\Components\Cart\Storage;

abstract class BaseStorage
{
    /**
     * @param $key
     * @void
     */
    abstract public function get($key);

    /**
     * @param $key
     * @param $value
     * @void
     */
    abstract public function set($key, $value);

    /**
     * @param $key
     * @void
     */
    abstract public function remove($key);

    /**
     * @param $key
     * @void
     */
    abstract public function clear();

    /**
     * @param $key
     * @return bool
     */
    abstract public function has($key);

    /**
     * @return int
     */
    public function count()
    {
        return count($this->getObjects());
    }

    /**
     * @return CartLine[]
     */
    abstract public function getObjects();
}