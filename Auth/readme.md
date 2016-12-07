# Модуль авторизации

Включает в себя следующие действия: Авторизация, Регистрация (email и sms), Восстановление пароля, Смена пароля, Активация учетной записи.

Поддерживает авторизацию и подтверждение по sms.

## Зависимости

`User`

## Установка

Распаковать архив в `Modules/Auth` или в директории `Modules` выполнить `git clone https://github.com/MindyPHP/Auth.git`

Добавить в `modules.php`:

```php
<?php
return [
    ...
    'Auth',
    ...
];
```

Добавить в `urls.php`:

```php
<?php

return [
    ...
    '/auth' => new Patterns('Auth.urls', 'auth'),
    ...
];

Подключить компонент в `settings.php`:

```php
<?php
return [
    'auth' => [
        'class' => '\Modules\Auth\Components\Auth',
        'allowAutoLogin' => true,
        'autoRenewCookie' => true,
        'strategies' => [
            'local' => ['class' => '\Modules\Auth\Strategy\LocalStrategy'],
        ]
    ],
];
```

## Стратегии авторизации

`LocalStrategy` - локальная авторизация по email || username с паролем.

## AuthKeyCheckMiddleware

Базовый класс `middleware` для авторизации по токену. Используется для RESTful.

## Генерация паролей

Модуль поддерживает типы авторизации: `django`, `bitrix`, `mindy`.
Использование: 

```php
<?php
return [
    'auth' => [
        'class' => '\Modules\Auth\Components\Auth',
        'allowAutoLogin' => true,
        'autoRenewCookie' => true,
        'strategies' => [
            'local' => ['class' => '\Modules\Auth\Strategy\LocalStrategy'],
        ],
        'passwordHashers' => [
            'mindy' => '\Modules\Auth\PasswordHasher\MindyPasswordHasher',
            'bitrix' => '\Modules\Auth\PasswordHasher\BitrixPasswordHasher',
            'django' => '\Modules\Auth\PasswordHasher\DjangoPasswordHasher',
        ];
        'defaultPasswordHasher' => 'mindy';
    ],
];
```

Генерация паролей:

```php
<?php
$rawPassword = '123456';
Mindy::app()->auth->getPasswordHasher('django')->hashPassword($rawPassword)
>>> OUTPUT: $2a$13$eZ5Fm53kTZqYne7KCFO/ieaj2AEuCizCzY9uZgghh6XYCyQ0GEY8W
```

Проверка пароля:

```php
<?php
$rawPassword = '123456';
$hash = '$2a$13$eZ5Fm53kTZqYne7KCFO/ieaj2AEuCizCzY9uZgghh6XYCyQ0GEY8W';
Mindy::app()->auth->verifyPassword($rawPassword, $hash);
>>> OUTPUT: true