<?php

namespace Modules\User;

use Mindy\Base\Module;
use Mindy\Helper\Creator;

/**
 * Class UserModule
 * @package Modules\User
 */
class UserModule extends Module
{
    /**
     * @var string класс модели
     */
    public $userClass = '\Modules\User\Models\User';
    /**
     * Отправлять пользователю пароль на электронную почту при регистрации.
     * Используется в нескольких случаях: когда пользователь создан с помощью
     * метода @see \Modules\User\Models\UserManager:createRandomUser()
     * @var bool
     */
    public $sendUserPassword = false;
    /**
     * @var string класс формы профиля пользователя
     */
    public $profileFormClass = '\Modules\User\Forms\ProfileForm';
    /**
     * @var string класс модели профиля пользователя
     */
    public $profileModelClass = '\Modules\User\Models\Profile';
    /**
     * @var string
     */
    public $userRoute = 'user:profile';
    /**
     * @var array
     */
    public $profiles = [];

    /**
     * @return \Mindy\Orm\Model
     */
    public function getUserModel()
    {
        return Creator::createObject(['class' => $this->userClass]);
    }

    /**
     * @return \Mindy\Orm\Model
     */
    public function getProfileModel()
    {
        return Creator::createObject(['class' => $this->profileModelClass]);
    }

    /**
     * @return \Mindy\Form\ModelForm
     */
    public function getProfileForm()
    {
        return Creator::createObject(['class' => $this->profileFormClass]);
    }

    /**
     * @see parent::getVersion()
     * @return float
     */
    public function getVersion()
    {
        return 2.0;
    }

    /**
     * @see parent::getName()
     * @return string
     */
    public function getName()
    {
        return self::t('Users');
    }

    public function getProfiles()
    {
        return $this->profiles;
    }

    /**
     * @see parent::getMenu()
     * @return array
     */
    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => self::t('Users'),
                    'adminClass' => 'UserAdmin',
                ],
                [
                    'name' => self::t('Groups'),
                    'adminClass' => 'GroupAdmin',
                ],
                [
                    'name' => self::t('Permissions'),
                    'adminClass' => 'PermissionAdmin',
                ]
            ]
        ];
    }
}
