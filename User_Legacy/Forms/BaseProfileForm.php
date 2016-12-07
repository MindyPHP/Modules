<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 10/03/16
 * Time: 11:27
 */

namespace Modules\User\Forms;

use Mindy\Form\ModelForm;
use Modules\Main\MainModule;
use Modules\User\Models\User;

abstract class BaseProfileForm extends ModelForm
{
    public $exclude = [
        'is_superuser',
        'is_staff',
        'is_active',
        'site_id',
        'profile',
        'permissions',
        'groups',
        'password',
        'email',
        'username',
        'i_accept_rules',
        'activation_key',
        'key',
    ];

    public function getFieldsets()
    {
        return [
            MainModule::t('Main information') => [
                'last_name',
                'first_name',
                'middle_name',
                'avatar'
            ],
            MainModule::t('Contacts') => [
                'phone',
                'skype',
            ],
            MainModule::t('Work') => [
                'post',
                'direction',
                'job_start_at',
                'job_end_at'
            ],
            MainModule::t('Education') => [
                'classroom',
                'education_start_at',
                'education_end_at',
            ],
            MainModule::t('Social networks') => [
                'vk_link',
                'odnoklassniki_link',
                'facebook_link',
                'twitter_link'
            ]
        ];
    }

    public function getModel()
    {
        return new User;
    }
}