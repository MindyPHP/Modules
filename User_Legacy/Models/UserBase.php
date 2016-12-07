<?php

namespace Modules\User\Models;

use Mindy\Base\Mindy;
use Mindy\Helper\Params;
use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\EmailField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\HasManyField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\ManyToManyField;
use Mindy\Orm\Fields\PasswordField;
use Mindy\Orm\Model;
use Mindy\Validation\UniqueValidator;
use Modules\Sites\Models\Site;
use Modules\User\Traits\AuthTrait;
use Modules\User\Traits\PermissionTrait;

/**
 * Class UserBase
 * @package Modules\User
 * @method static \Modules\User\Models\UserManager objects($instance = null)
 */
abstract class UserBase extends Model
{
    use PermissionTrait, AuthTrait;

    const GUEST_ID = -1;

    const TRUSTED_FIELDS = [
        'id',
        'username',
        'name',
        'email',
        'last_login',
        'created_at',
        'is_staff',
        'is_superuser',
        'is_active'
    ];

    public static function getFields()
    {
        return [
            "username" => [
                'class' => CharField::class,
                'verboseName' => self::t("Username"),
                'unique' => true
            ],
            "email" => [
                'class' => EmailField::class,
                'verboseName' => self::t("Email"),
                'null' => true,
            ],
            "password" => [
                'class' => PasswordField::class,
                'null' => true,
                'verboseName' => self::t("Password"),
            ],
            "activation_key" => [
                'class' => CharField::class,
                'null' => true,
                'verboseName' => self::t("Activation key"),
            ],
            'avatar' => [
                'class' => ImageField::class,
                'verboseName' => self::t('Avatar'),
                'sizes' => [
                    'thumb' => [70, 70]
                ]
            ],
            "is_active" => [
                'class' => BooleanField::class,
                'verboseName' => self::t("Is active"),
            ],
            "is_staff" => [
                'class' => BooleanField::class,
                'verboseName' => self::t("Is staff"),
            ],
            "is_superuser" => [
                'class' => BooleanField::class,
                'verboseName' => self::t("Is superuser"),
                'helpText' => self::t('Superuser has all permissions')
            ],
            'last_login' => [
                'class' => DateTimeField::class,
                'null' => true,
                'verboseName' => self::t("Last login"),
                'editable' => false,
            ],
            'groups' => [
                'class' => ManyToManyField::class,
                'modelClass' => Group::class,
                'verboseName' => self::t("Groups"),
            ],
            'permissions' => [
                'class' => ManyToManyField::class,
                'modelClass' => Permission::class,
                'through' => UserPermission::class,
                'throughLink' => ['user_id', 'permission_id'],
                'verboseName' => self::t("Permissions"),
            ],
            'hash_type' => [
                'class' => CharField::class,
                'default' => 'mindy',
                'editable' => false,
                'verboseName' => self::t("Password hash strategy"),
            ],
            'key' => [
                'class' => ForeignField::class,
                'modelClass' => Key::class,
                'null' => true,
                'verboseName' => self::t("User key"),
            ],
            'created_at' => [
                'class' => DateTimeField::class,
                'autoNowAdd' => true,
                'editable' => false,
                'verboseName' => self::t('Created at')
            ],
            'site_id' => [
                'class' => IntField::class,
                'null' => true,
                'verboseName' => self::t('Site')
            ],
            'session' => [
                'class' => HasManyField::class,
                'modelClass' => Session::class,
                'editable' => false,
                'verboseName' => self::t('Session')
            ]
        ];
    }

    public function getSite()
    {
        if (class_exists('\Modules\Sites\Models\Site')) {
            \Modules\Sites\Models\Site::objects()->get(['id' => $this->site_id]);
        }
    }

    public function getIp()
    {
        return Mindy::app()->request->http->getUserHostAddress();
    }

    public function __toString()
    {
        return (string)$this->username;
    }

    /**
     * Get current user session model
     * @return Session
     */
    public function getSession()
    {
        return Session::objects()->notExpired()->latest()->get([
            'id' => Mindy::app()->session->getId()
        ]);
    }

    // TODO
    public function notifyRegistration()
    {
        return Mindy::app()->mail->fromCode('user.registration', $this->email, [
            'username' => $this->username,
            'sitename' => Params::get('core.sitename'),
            'activation_url' => Mindy::app()->urlManager->reverse('user:registration_activation', ['key' => $this->activation_key]),
        ]);
    }

    /**
     * @param null $instance
     * @return \Mindy\Orm\Manager|UserManager
     */
    public static function objectsManager($instance = null)
    {
        $className = get_called_class();
        return new UserManager($instance ? $instance : new $className);
    }

    public function beforeSave($owner, $isNew)
    {
        if ($isNew) {
            $owner->activation_key = substr(md5(time() . $owner->username . $owner->pk), 0, 10);
        }
    }
}
