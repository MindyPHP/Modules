# Sms
Module for sms messages

## Component

```php
'sms' => [
    'class' => '\Modules\Sms\Components\Sms',
    'senders' => [
        'smsru' => [
            'class' => '\Modules\Sms\Senders\SmsruSender',
            'api_id' => 'API_KEY'
        ]
    ]
],
```

## Module

```php
'Sms' => [
    'testPhone' => '79111111111',
    'mainPhone' => '79111111111'
]
```

## Usage

With template:

```php
Mindy::app()->sms->fromCode('order.notify', '79111111111', ['foo' => $bar]);
```

Or

```php
Mindy::app()->sms->send('79111111111', 'Test message');
```
