# Модуль расчета доставки

## Подключение

Подключение компонента происходит в *settings.php*:

```php
'components' => [
  ...
    'delivery' => [
              'class' => '\Modules\Delivery\Components\Delivery',
              'systems' => [
                  'dpd' => [
                      'class' => '\Modules\Delivery\Systems\DPD',
                      'login' => 'YOUR_LOGIN',
                      'password' => 'YOUR_KEY'
                  ],
                  'ems' => [
                      'class' => '\Modules\Delivery\Systems\EMS',
                  ],
                  'russianpost' => [
                      'class' => '\Modules\Delivery\Systems\RussianPost',
                  ],
                  'cdec' => [
                      'class' => '\Modules\Delivery\Systems\CDEC',
                  ]
              ]
          ]
  ...
]
```

## Доступные службы

### Почта России

Для russianpost входящие параметры обязательны такие, как указано ниже, а именно:

В размерах вес (weight), в пункте назначения индекс пункта назначения (cityZip)

```php
Mindy::app()->delivery->count('russianpost', ['weight' => 1.4], ['cityZip' => '420000']);
```

Вернет:

```
Array
(
    [ПростаяБандероль] => Array
    (
        [Название] => Простая бандероль
        [Количество] => 1
        [Тариф] => 147.50
        [Доставка] => 147.50
        [ПредельныйВес] => 2000
        [Проверено] => 1
        [СрокДоставки] => 4
        [ВычетНДС] => 1
        [Ценное] => 0
        [Товарное] => 0
        [КлассДоставки] => 0
    )
    ....
)
```

### EMS

EMS лучше не использовать, так как russianpost полностью покрывает и EMS тоже, причем лучше.

Получение списка городов, доступных для расчета (очень мало и в пьяном виде)

```php
Mindy::app()->delivery->getCities('ems');
```

Для ems входящие параметры обязательны такие, как указано ниже, а именно:

В размерах вес (weight), в пункте назначения код пунта назачения - его можно получить из списка выше (cityId)

```php
Mindy::app()->delivery->count('ems', ['weight' => 1.4], ['cityId' => 'city--kazan'])
```

Вернет:

```
800
```

### DPD

Получение списка городов, доступных для доставки DPD. Формат возврата есть в /extra/DPD/delivery.php

```php
Mindy::app()->delivery->getCities('dpd')
```

Для dpd входящие параметры обязательны такие, как указано ниже, а именно:

В размерах вес (weight), в пункте назначения идентификатор пункта назначения - его можно получить из списка выше (cityId),
либо наименование пункта назначения (cityName), например "Киров"
Из необязательных - можно указать размеры посылки в формате

```php
  'size' => [
      'width' => 30, // Ширина
      'height' => 120, // Высота
      'depth' => 50 // Глубина
  ]
```

```php
Mindy::app()->delivery->count('dpd', [
    'weight' => 1.4,
    'size' => [
        'width' => 30,
        'height' => 120,
        'depth' => 50
    ]
], ['cityId' => 48994107])
```

Вернет:

```php
[
    0 => [
        'serviceCode' => 'TEN'
        'serviceName' => 'DPD 10:00'
        'cost' => 1573.81
        'days' => 4
    ]
    1 => [
        'serviceCode' => 'DPT'
        'serviceName' => 'DPD 13:00'
        'cost' => 1388.65
        'days' => 4
    ]
    2 => [
        'serviceCode' => 'NDY'
        'serviceName' => 'DPD EXPRESS'
        'cost' => 6010.67
        'days' => 3
    ]
    3 => [
        'serviceCode' => 'BZP'
        'serviceName' => 'DPD 18:00'
        'cost' => 1203.5
        'days' => 4
    ]
    4 => [
        'serviceCode' => 'CUR'
        'serviceName' => 'DPD CLASSIC domestic'
        'cost' => 4623.59
        'days' => 4
    ]
    5 => [
        'serviceCode' => 'ECN'
        'serviceName' => 'DPD ECONOMY'
        'cost' => 925.77
        'days' => 5
    ]
    6 => [
        'serviceCode' => 'CSM'
        'serviceName' => 'DPD Consumer'
        'cost' => 1475
        'days' => 4
    ]
    7 => [
        'serviceCode' => 'PCL'
        'serviceName' => 'DPD CLASSIC Parcel'
        'cost' => 1947
        'days' => 4
    ]
]
```


### CDEC (edostavka.ru)

Получение стоимости доставки. Размеры указывать необходимо обязательно. Формата 2:
1. С указанием размеров и веса отправления

```php
[
    "weight" => 0.3,
    ​"length" => 10,
    ​"width" => 7,
    ​"height" => 5
]
```

2. С указанием объема и веса отправления

```php
[
    ​"weight" => 0.1,
    ​"volume" => 0.1
]
```

В пункте назначения можно передать receiverCityPostCode (почтовый индекс) либо receiverCityId (код по справочнику CDEC)

```php
Mindy::app()->delivery->count('cdec', [
    'weight' => 0.3,
    'volume' => 0.05
], ['receiverCityPostCode' => 420000])
```

Вернет по списку заданных возможных вариантов отправления (countTariffs в классе CDEC):

```php
[
    10 => [
        'price' => '1025'
        'deliveryPeriodMin' => '2'
        'deliveryPeriodMax' => '4'
        'deliveryDateMin' => '2015-08-21'
        'deliveryDateMax' => '2015-08-25'
        'tariffId' => 10
        'priceByCurrency' => 1025
        'currency' => 'RUB'
    ]
    11 => [
        'price' => '1105'
        'deliveryPeriodMin' => '2'
        'deliveryPeriodMax' => '4'
        'deliveryDateMin' => '2015-08-21'
        'deliveryDateMax' => '2015-08-25'
        'tariffId' => 11
        'priceByCurrency' => 1105
        'currency' => 'RUB'
    ]
]
```

