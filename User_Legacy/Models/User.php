<?php

namespace Modules\User\Models;

/**
 * Class User
 * @package Modules\User
 * @method static \Modules\User\Models\UserManager objects($instance = null)
 */
class User extends UserBase
{
    public function getAbsoluteUrl()
    {
        return $this->reverse('user:view', ['username' => $this->username]);
    }
}
