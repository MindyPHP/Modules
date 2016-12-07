<?php
/**
 * Created by IntelliJ IDEA.
 * User: max
 * Date: 11/05/16
 * Time: 13:17
 */

namespace Modules\User\Helpers;

use Mindy\Base\Mindy;
use Modules\Auth\Models\ActivationKey;
use Modules\Auth\Models\LostPasswordKey;
use Modules\User\Models\UserBase;

class UserSmsHelper
{
    private static function getSms()
    {
        return Mindy::app()->sms;
    }

    public static function activation(UserBase $user, ActivationKey $key)
    {
        return self::getSms()->fromCode('user.activation_sms', $user->phone, [
            'key' => $key->key
        ]);
    }

    public static function recovery(UserBase $user, LostPasswordKey $key)
    {
        $data = [
            'key' => $key->key,
            'recovery_link' => Mindy::app()->request->http->absoluteUrl(Mindy::app()->urlManager->reverse('auth:recovery_confirm', [
                    'type' => 'sms'
                ]) . http_build_query(['key' => $key->key]))
        ];
        return self::getSms()->fromCode('user.recovery_sms', $user->email, $data);
    }
}