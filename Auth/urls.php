<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 12:02
 */

return [
    /*
     * Авторизация, выход, регистрация
     */
    '/login' => [
        'name' => 'login',
        'callback' => '\Modules\Auth\Controllers\AuthController:login'
    ],
    '/logout' => [
        'name' => 'logout',
        'callback' => '\Modules\Auth\Controllers\AuthController:logout'
    ],
    '/registration/{profile:c}?' => [
        'name' => 'registration',
        'callback' => '\Modules\Auth\Controllers\RegistrationController:dispatch'
    ],

    /*
     * Изменение пароля
     */
    '/password/change' => [
        'name' => 'change_password',
        'callback' => '\Modules\Auth\Controllers\ChangePasswordController:index'
    ],
    '/password/succes' => [
        'name' => 'change_password_succes',
        'callback' => '\Modules\Auth\Controllers\ChangePasswordController:success'
    ],

    /*
     * Активация учетной записи после в случаях, если пользователь
     * не получал первого письма с активацей после регистрации.
     * Повторная активация.
     */
    '/activation/{type:s}' => [
        'name' => 'activation',
        'callback' => '\Modules\Auth\Controllers\ActivationController:form'
    ],
    '/activation/{type:s}/process' => [
        'name' => 'activation_process',
        'callback' => '\Modules\Auth\Controllers\ActivationController:process'
    ],
    '/activation/{type:s}/confirm' => [
        'name' => 'activation_confirm',
        'callback' => '\Modules\Auth\Controllers\ActivationController:confirm'
    ],
    '/activation/{type:s}/sended' => [
        'name' => 'activation_sended',
        'callback' => '\Modules\Auth\Controllers\ActivationController:sended'
    ],

    /*
     * Восстановление пароля
     */
    '/recovery/{type:s}' => [
        'name' => 'recovery',
        'callback' => '\Modules\Auth\Controllers\RecoveryController:form'
    ],
    '/recovery/{type:s}/process' => [
        'name' => 'recovery_process',
        'callback' => '\Modules\Auth\Controllers\RecoveryController:process'
    ],
    '/recovery/{type:s}/confirm' => [
        'name' => 'recovery_confirm',
        'callback' => '\Modules\Auth\Controllers\RecoveryController:confirm'
    ],
];