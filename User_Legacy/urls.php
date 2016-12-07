<?php

return [
    '/' => [
        'name' => 'list',
        'callback' => '\Modules\User\Controllers\UserController:index'
    ],
    '/recover/' => [
        'name'     => 'recover',
        'callback' => '\Modules\User\Controllers\RecoverController:index'
    ],
    '/recover/{key}' => [
        'name'     => 'recover_activate',
        'callback' => '\Modules\User\Controllers\RecoverController:activate'
    ],
    '/profile' => [
        'name'     => 'profile',
        'callback' => '\Modules\User\Controllers\ProfileController:view',
    ],
    '/profile/update' => [
        'name'     => 'profile_update',
        'callback' => '\Modules\User\Controllers\ProfileController:update',
    ],
    '/password' => [
        'name'     => 'change_password',
        'callback' => '\Modules\User\Controllers\UserController:changepassword',
    ],
    '/registration' => [
        'name'     => 'registration',
        'callback' => '\Modules\User\Controllers\RegistrationController:index'
    ],
    '/registration/success' => [
        'name'     => 'registration_success',
        'callback' => '\Modules\User\Controllers\RegistrationController:success'
    ],
    '/registration/activation/{key}' => [
        'name'     => 'registration_activation',
        'callback' => '\Modules\User\Controllers\RegistrationController:activate'
    ],
    '/activation/email' => [
        'name' => 'activation_email',
        'callback' => '\Modules\User\Controllers\ActivationController:email'
    ],
    '/activation/email/success' => [
        'name' => 'activation_email_success',
        'callback' => '\Modules\User\Controllers\ActivationController:emailSuccess'
    ],

    '/activation/sms' => [
        'name' => 'activation_sms',
        'callback' => '\Modules\User\Controllers\ActivationController:sms'
    ],
    '/activation/sms/success' => [
        'name' => 'activation_sms_success',
        'callback' => '\Modules\User\Controllers\ActivationController:smsSuccess'
    ],
    '/activation/sms/confirm' => [
        'name' => 'activation_sms_сonfirm',
        'callback' => '\Modules\User\Controllers\ActivationController:smsConfirm'
    ],

    '/logout' => [
        'name'     => 'logout',
        'callback' => '\Modules\User\Controllers\AuthController:logout'
    ],
    '/login' => [
        'name'     => 'login',
        'callback' => '\Modules\User\Controllers\AuthController:login'
    ],
    '/{username:\w+}' => [
        'name'   => 'view',
        'callback' => '\Modules\User\Controllers\UserController:view'
    ],
];
