# Multiple
Модуль для Mindy, позволяющий создавать/редактировать/удалять связанные HasMany модели в форме родителя.

## Установка

Клонируем модуль, добавляем его в **modules.php**

## Пример использования

В нашем модуле есть 2 модели: Item и Color. Одна модель Item может иметь несколько связанных моделей Color, и одна модель Color имеет только один связанный Item (типичный случай HasMany).

ItemAdmin:

```php
class ItemAdmin extends MultipleOwnerAdmin
{
    public function getColumns()
    {
        return ['name'];
    }

    public function getModel()
    {
        return new Color;
    }

    public function getMultiple()
    {
        return [
            'colors' => [
                'class' => ColorAdmin::className()
            ]
        ];
    }
}
```

В методе **getMultiple** ключом возвращаемого массива должно быть название поля, используемого в модели (в нашем случае *colors*)

Собственно, сам ColorAdmin:

```php
class ColorAdmin extends MultipleAdmin
{
    public $sortingColumn = 'position';
    public $ownerField = 'item';

    public function getColumns()
    {
        return ['name'];
    }
    
    public function getModel()
    {
        return new Color;
    }
}
```

Для справки, обе модели:

Item:

```php
class Item extends Model
{
    public static function getFields() 
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => self::t("Name")
            ],
            'colors' => [
                'class' => HasManyField::className(),
                'modelClass' => Color::className(),
                'verboseName' => self::t("Colors")
            ]
        ];
    }
}
```

Color:

```php
class Color extends Model
{
    public static function getFields() 
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => self::t("Name")
            ],
            'position' => [
                'class' => PositionField::className(),
                'editable' => false,
                'default' => 9999,
                'null' => true
            ],
            'item' => [
                'class' => ForeignField::className(),
                'modelClass' => Item::className(),
                'verboseName' => self::t("Item")
            ]
        ];
    }
}
```
