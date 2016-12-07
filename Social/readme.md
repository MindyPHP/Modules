# Модуль социальной авторизации

Модуль использует phpleague [oauth1](https://github.com/thephpleague/oauth1-client) и [oauth1](https://github.com/thephpleague/oauth2-client).

---

## Установка

В файле конфигурации при подключении модуля описать компонент и адаптеры:

`settings.php:`

```php
...
	'components' => [
        'social' => [
            'class' => 'Modules\Social\Components\Social',
            'providers' => require('social.php')
        ],
	]
...
```

`social.php`:

```php
return [
    'vk' => [
        'class' => 'Modules\Social\Components\Provider\OAuth2\Vkontakte',
        'config' => [
            'clientId' => '123',
            'clientSecret' => '123'
        ]
    ],
    'mailru' => [
        'class' => 'Modules\Social\Components\Provider\OAuth2\Mailru',
        'config' => [
            'clientId' => '123',
            'clientSecret' => '123'
        ]
    ],
    'google' => [
        'class' => 'Modules\Social\Components\Provider\OAuth2\Google',
        'config' => [
            'clientId'     => '123',
            'clientSecret' => '123',
            'hostedDomain' => 'http://mysupersite.com',
        ]
    ],
    'ok' => [
        'class' => 'Modules\Social\Components\Provider\OAuth2\Odnoklassniki',
        'config' => [
            'clientId' => '123',
            'clientPublic' => '123',
            'clientSecret' => '123'
        ]
    ],
    'twitter' => [
        'class' => 'Modules\Social\Components\Provider\OAuth1\Twitter',
        'config' => [
            'clientId' => '123',
            'clientSecret' => '123'
        ]
    ],
    'facebook' => [
        'class' => 'Modules\Social\Components\Provider\OAuth2\Facebook',
        'scope' => [
            'email'
        ],
        'config' => [
            'clientId' => '123',
            'clientSecret' => '123',
            'graphApiVersion' => 'v2.6',
        ]
    ]
];
```

Далее использовать в шаблоне в любом месте хелпер `{{ social() }}`

---

### Авторизация в popup

```js
function openPopup(url, width, height, left, top) {
    width = width || 700;
    height = height || 500;
    left = left || (window.screen.availWidth / 2) - (width / 2);
    top = top || (window.screen.availHeight / 2) - (height / 2);
    var settings = 'height=' + height + ',width=' + width + ',left=' + left + ',top=' + top + ',resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=yes,directories=no,status=yes';
    window.open(url, name, settings);
}

$(document).on('click', '.social-list a', function(e) {
    e.preventDefault();
    openPopup($(this).attr('href'));
    return false;
});
```

---

### Добавление провайдера

Для единого интерфейса работы с провайдерами нам пришлось создать дополнительную "обертку" над оригинальными oauth1 и oauth2 провайдерами.

Пример `Facebook.php`:

```php
<?php

namespace Modules\Social\Components\Provider\OAuth2;

use League\OAuth2\Client\Provider\Facebook as BaseFacebook;
use Modules\Social\Components\Provider\Provider;

class Facebook extends Provider
{
    public $attributeMap = [
        'id' => 'id',
        'email' => 'email',
        'name' => 'name',
        'link' => 'link',
        'gender' => 'gender',
        'birthday' => 'birthday'
    ];

    public $scope = ['email'];

    /**
     * @return \League\OAuth1\Client\Server\Server|\League\OAuth2\Client\Provider\AbstractProvider
     */
    public function getProviderClass()
    {
        return BaseFacebook::class;
    }
}
```