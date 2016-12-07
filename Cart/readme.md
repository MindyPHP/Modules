# Компонент работы с корзиной покупателя

Пример использования:

#### Model

```php
<?php

use Mindy\Helper\Traits\Accessors;
use Mindy\Helper\Traits\Configurator;
use Modules\Cart\Interfaces\ICartItem;

class Product implements ICartItem
{
    use Accessors, Configurator;

    public $id;

    public $price;

    public function __toString()
    {
        return (string)$this->id;
    }

    /**
     * @return mixed unique product identification
     */
    public function getUniqueId()
    {
        return $this->id;
    }

    /**
     * @return int|float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param $quantity int
     * @param $type mixed
     * @param $data array
     * @return int|float return total product price based on quantity and weight type
     */
    public function recalculate($quantity, $type, $data)
    {
        if ($type == '?') {
            return $quantity * ($this->getPrice() * 2);
        } else {
            return $quantity * $this->getPrice();
        }
    }
}
```

#### Controller

```php
<?php

class CartController extends BaseCartController
{
    public function addInternal($uniqueId, $quantity = 1)
    {
        $data = [
            'color' => 'white'
        ];
        $this->getCart()->add(new Product(['price' => 10, 'id' => 1]), $quantity, $data);
    }
}
```

## Система скидок

Так как в каждом интернет магазине своя бизнес логика был реализован только
интерфейс для работы со скидками. Вся остальная логика ложится на плечи
разработчика. Для данного решения серебрянной пули не существует.

Пример использования:

```php

<?php

namespace Foo\Bar;

use Mindy\Base\Mindy;

class ExampleDiscount implements IDiscount
{
    /**
     * Apply discount to CartItem position. If new prices is equal old price - return old price.
     * @param Cart $cart
     * @param CartItem $item
     * @return int|float new price with discount
     */
    public function applyDiscount(Cart $cart, CartItem $item)
    {
        if (Mindy::app()->user->isGuest === false) {
            // Дарим скидку зарегистрированным пользователям
            return $item->getPrice() - 200;
        } else {
            return $item->getPrice();
        }
    }
}
```

Далее указываем в компоненте корзины классы скидок:

```php
...
    'cart' => [
        'class' => '\Modules\Cart\Components\Cart',
        'discounts' => [
            '\Modules\Foo\Components\ExampleDiscount'
        ]
    ]
...
```

## Отображение старой / новой цены

```php
class Product implements ICartItem
{
    ...
    /**
     * @return float
     */
    public function getPriceWithDiscount()
    {
        $quantity = 1;
        $type = null;
        $data = [
            'color' => 'black'
        ];
        return Mindy::app()->cart->applyDiscount($this, $quantity, $type, $data);
    }

    ...
}
```
