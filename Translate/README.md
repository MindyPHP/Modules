# Модуль перевода для Mindy

Модуль облегчает работу с мультиязычностью предоставляя интерфейс перевода для админ-панели и сборщик всех переводимых строк.

## Сбор данных

Консольная команда, которая соберет все использованные слова в словари помодульно:

```php
# php index.php translate collect
```

Так же можно указать конкретный модуль для сбора данных:

```php
# php index.php translate collect --module=Pages
```