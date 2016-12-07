<?php

namespace Modules\Cart\Components\Cart\Storage;

/**
 * Class SessionStorage
 * @package Modules\Cart\Components
 */
class SessionStorage extends BaseStorage
{
    const KEY = 'cart';

    /**
     * Prepare array with productions in $_SESSION
     */
    public function __construct()
    {
        if (!isset($_SESSION[self::KEY])) {
            $_SESSION[self::KEY] = [];
        }
    }

    /**
     * @param $key
     * @return \Modules\Cart\Components\Cart\CartLine
     */
    public function get($key)
    {
        return unserialize($_SESSION[self::KEY][$key]);
    }

    /**
     * @param $key
     */
    public function remove($key)
    {
        unset($_SESSION[self::KEY][$key]);
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key, $value)
    {
        $_SESSION[self::KEY][$key] = serialize($value);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($_SESSION[self::KEY]);
    }

    /**
     * @return \Modules\Cart\Components\Cart\CartLine[]
     */
    public function getObjects()
    {
        return $_SESSION[self::KEY];
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $_SESSION[self::KEY]);
    }

    /**
     * @void
     */
    public function clear()
    {
        $_SESSION[self::KEY] = [];
    }
}
