<?php

namespace Modules\User\Models;

use Mindy\Base\Mindy;

/**
 * Class User
 * @package Modules\User
 * @method static \Modules\User\Models\UserManager objects($instance = null)
 * @method static \Modules\User\UserModule getModule()
 */
class User extends UserBase
{
    public function __get($name)
    {
        $profiles = $this->getModule()->getProfiles();
        if (isset($profiles[$name])) {
            return $profiles[$name]($this);
        }
        return parent::__get($name);
    }

    public function getAbsoluteUrl()
    {
        $route = $this->getModule()->userRoute;
        if ($route) {
            return $this->reverse($route);
        }

        return null;
    }
}
