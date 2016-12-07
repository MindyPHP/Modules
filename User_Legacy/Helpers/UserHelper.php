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
 * @date 19/11/14.11.2014 18:21
 */

namespace Modules\User\Helpers;

use Mindy\Helper\Traits\RenderTrait;
use Modules\User\Forms\LoginForm;
use Modules\User\Models\User;

class UserHelper
{
    use RenderTrait;

    public static function render($request, $template = "user/_login.html")
    {
        return self::renderTemplate($template, [
            'form' => new LoginForm,
            'request' => $request
        ]);
    }

    public static function userToJson(User $user, $token)
    {
        return [
            'id' => (int)$user->id,
            'name' => $user->name,
            'username' => $user->username,
            'is_staff' => (bool)$user->is_staff,
            'is_superuser' => (bool)$user->is_superuser,
            'is_active' => (bool)$user->is_active,
            'groups' => $user->groups->asArray()->all(),
            'permissions' => $user->permissions->asArray()->all(),
            'token' => $token
        ];
    }

    public static function checkIsActive(User $user)
    {
        if ($user->is_active == false) {
            return self::renderTemplate('user/_check_active.html', [
                'model' => $user
            ]);
        }
        return null;
    }
}
