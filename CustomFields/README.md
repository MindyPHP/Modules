# Кастомные поля

## Установка:

В modules.php в 'model' указываем модель, к которой будут подключаться кастомные поля:

```php
...
    'CustomFields' => [
        'model' => \Modules\Module\Models\Model::className()
    ],
...
```

В модели, к которой подключаются кастомные поля подключаем trait Modules\CustomFields\Components\CustomFields:

```php
...
use Modules\CustomFields\Components\CustomFields;
...
class * extends * {
    use CustomFields;
    ...
}
```

Так же в модели обязательно должно быть JsonField поле 'custom_data', в котором хранятся значения (помимо отдельных таблиц)
- это необходимо для быстрой выбоки значений без обращений к БД при выводе списка объектов с кастомными полям (например сравнение товаров).


## Типы полей

1. Строка
2. Словарь (список занчений лежит в JsonField поле 'list')
3. Число
4. Логическое

## Работа с полями

Установка значений:

```php
$field = CustomField::objects()->get(['id' => 3]);
$model->setCustomValue($field, $value);
$model->save()
```

Получение значения:

```php
$model->getCustomValue($field);
```

Получение списка значений (без запроса к БД - список значений дублируется внутри самой модели в поле 'custom_data'):

```php
$model->custom_data;
```

Фильтрация по кастомным полям:

```php
$qs = Model::objects()->getQuerySet();
$qs->filterCustom([1 => ['220', '380'], '1__between' => [0, 400], '3__gte' => 30, '4__lte' => 50]);
```

Доступные фильтры:

0. Пустой или default
1. between (BETWEEN)
2. gte (>=)
3. lte (<=)

