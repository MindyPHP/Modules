<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 16:03
 */

namespace Modules\User\Helpers;

use Mindy\Base\Mindy;
use Mindy\Helper\Password;
use Modules\Auth\Models\ActivationKey;
use Modules\User\Models\Group;
use Modules\User\Models\Permission;
use Modules\User\Models\User;

class UserHelper
{
    /**
     * Создание пользователя
     * @param array $attributes
     * @param bool $notify
     * @return User
     */
    public static function createUser(array $attributes, $notify = true, $passwordHash = true)
    {
        if (!isset($attributes['username'])) {
            $attributes['username'] = self::generateUserName();
        }

        $rawPassword = null;
        if (isset($attributes['password']) && $passwordHash) {
            /** @var \Modules\Auth\PasswordHasher\IPasswordHasher $hasher */
            $rawPassword = $attributes['password'];
            $auth = Mindy::app()->auth;
            $hasher = $auth->getPasswordHasher(isset($extra['hash_type']) ? $extra['hash_type'] : $auth->defaultPasswordHasher);
            $attributes['password'] = $hasher->hashPassword($rawPassword);
        }

        $model = new User($attributes);

        if ($model->isValid() && $model->save()) {
            if ($notify && !$model->is_active) {
                $key = new ActivationKey([
                    'user' => $model,
                    'type' => empty($model->email) ? 'email' : 'sms'
                ]);

                if ($key->save()) {
                    $signal = Mindy::app()->signal;
                    $signal->send($model, 'user_registration', $model, $rawPassword);
                }
            }

            return $model;
        }

        return $model->getErrors();
    }

    /**
     * Добавление супер пользователя
     * @param array $attributes
     * @return User
     */
    public static function createSuperUser(array $attributes = [])
    {
        return self::createUser(array_merge($attributes, [
            'is_superuser' => true,
            'is_active' => true,
            'is_staff' => true
        ]), false);
    }

    /**
     * Добавление супер пользователя
     * @param array $attributes
     * @return User
     */
    public function createStaffUser(array $attributes = [], $notify = true)
    {
        return self::createUser(array_merge($attributes, [
            'is_staff' => true
        ]), $notify);
    }

    /**
     * Генерация псевдо-случайных чисел или символов для использования
     * в качестве ключа активации учетной записи
     * @param bool $numbersOnly
     * @param int $length
     * @return string
     * @throws \Mindy\Exception\Exception
     */
    public static function generateActivationKey($numbersOnly = false, $length = 5)
    {
        if ($numbersOnly) {
            $key = '';
            for ($i = 0; $i < $length; $i++) {
                $key .= mt_rand(0, 9);
            }
        } else {
            $key = substr(md5(Password::generateSalt()), 0, $length);
        }
        return $key;
    }

    /**
     * Генерация имени пользователя
     * @return string
     */
    private static function generateUserName()
    {
        return 'user_' . substr(self::generateActivationKey(), 0, 6);
    }
}