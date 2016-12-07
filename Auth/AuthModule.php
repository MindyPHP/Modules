<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 12:02
 */

namespace Modules\Auth;

use Mindy\Base\Mindy;
use Mindy\Base\Module;
use Mindy\Helper\Creator;
use Modules\User\Helpers\UserMailHelper;
use Modules\User\Helpers\UserSmsHelper;

class AuthModule extends Module
{
    public $profiles = [];
    /**
     * Класс формы регистрации пользователя
     * @var string
     */
    public $registrationFormClass = '\Modules\Auth\Forms\RegistrationForm';

    public static function preConfigure()
    {
        $signal = Mindy::app()->signal;
        $signal->handler('\Modules\User\Models\UserBase', 'registerUser', function ($key) {
            switch ($key->type) {
                case "email":
                    UserMailHelper::activation($key->user, $key);
                    break;
                case "sms":
                    UserSmsHelper::activation($key->user, $key);
                    break;
            }
        });
        $signal->handler('\Modules\Auth\Models\LostPasswordKey', 'afterSave', function ($owner, $isNew) {
            if ($isNew) {
                switch ($owner->type) {
                    case "email":
                        UserMailHelper::recovery($owner->user, $owner);
                        break;
                    case "sms":
                        UserSmsHelper::recovery($owner->user, $owner);
                        break;
                }
            }
        });
    }

    /**
     * @return \Modules\Auth\Forms\RegistrationForm
     */
    public function getRegistrationForm()
    {
        return $this->registrationFormClass;
    }
}