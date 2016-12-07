<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 12:02
 */

namespace Modules\Auth\Components;

use Mindy\Helper\Traits\Accessors;
use Mindy\Helper\Traits\Configurator;

class AuthBase
{
    use Accessors, Configurator;

    const AUTH_TIMEOUT_VAR = '__timeout';
    const AUTH_ABSOLUTE_TIMEOUT_VAR = '__absolute_timeout';

    private $_state = [];

    /**
     * Gets the persisted state by the specified name.
     * @param string $name the name of the state
     * @param mixed $defaultValue the default value to be returned if the named state does not exist
     * @return mixed the value of the named state
     */
    public function getState($name, $defaultValue = null)
    {
        return isset($this->_state[$name]) ? $this->_state[$name] : $defaultValue;
    }

    /**
     * Sets the named state with a given value.
     * @param string $name the name of the state
     * @param mixed $value the value of the named state
     */
    public function setState($name, $value)
    {
        $this->_state[$name] = $value;
    }

    /**
     * Removes the specified state.
     * @param string $name the name of the state
     */
    public function clearState($name)
    {
        unset($this->_state[$name]);
    }
}