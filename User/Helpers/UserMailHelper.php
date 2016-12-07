<?php
/**
 * Created by IntelliJ IDEA.
 * User: max
 * Date: 11/05/16
 * Time: 11:41
 */

namespace Modules\User\Helpers;

use Mindy\Base\Mindy;
use Modules\Auth\Models\ActivationKey;
use Modules\Auth\Models\LostPasswordKey;
use Modules\User\Models\UserBase;

class UserMailHelper
{
    /**
     * @return \Mindy\Mail\Mailer|\Modules\Mail\Components\DbMailer
     */
    private static function getMail()
    {
        return Mindy::app()->mail;
    }

    public static function create(UserBase $user, $password = null)
    {
        $template = $password === null ? 'user.create_user' : 'user.create_raw_user';
        return self::getMail()->fromCode($template, $user->email, [
            'model' => $user,
            'password' => $password
        ]);
    }

    /**
     * @return null|\Modules\Sites\Models\Site
     */
    private static function getSite()
    {
        if (Mindy::app()->hasModule('Sites')) {
            return Mindy::app()->getModule('Sites')->getSite();
        }

        return null;
    }

    public static function registration(UserBase $user, ActivationKey $key)
    {
        return self::getMail()->fromCode('auth:registration', $user->email, [
            'model' => $user,
            'site' => self::getSite(),
            'key' => $key->key,
            'activation_link' => Mindy::app()->request->http->absoluteUrl(Mindy::app()->urlManager->reverse('auth:activation', [
                    'type' => 'email'
                ]) . http_build_query(['key' => $key->key]))
        ]);
    }

    public static function activation(UserBase $user, ActivationKey $key)
    {
        return self::getMail()->fromCode('auth.activation_email', $user->email, [
            'key' => $key->key,
            'activation_link' => Mindy::app()->request->http->absoluteUrl(Mindy::app()->urlManager->reverse('auth:activation', [
                    'type' => 'email'
                ]) . http_build_query(['key' => $key->key]))
        ]);
    }

    public static function recovery(UserBase $user, LostPasswordKey $key)
    {
        $route = $key->type == 'email' ? 'auth:recovery_process' : 'auth:recovery_confirm';
        return self::getMail()->fromCode('auth.recovery_mail', $user->email, [
            'key' => $key->key,
            'recovery_link' => Mindy::app()->request->http->absoluteUrl(Mindy::app()->urlManager->reverse($route, [
                    'type' => $key->type
                ]) . '?' . http_build_query(['key' => $key->key]))
        ]);
    }
}