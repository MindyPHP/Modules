<?php
/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 10/12/14 17:50
 */

namespace Modules\Cart\Components\Cart\Interfaces;

use Modules\Cart\Components\CartLine;

/**
 * Interface IDiscount
 * @package Modules\Cart\Components
 *
 * Example:
 * class ExampleDiscount implements IDiscount
 * {
 *      public function applyDiscount(CartLine $item)
 *      {
 *          if (Mindy::app()->user->isGuest === false) {
 *              // Дарим скидку зарегистрированным пользователям
 *              return $item->getPrice() - 200;
 *          } else {
 *              return $item->getPrice();
 *          }
 *      }
 * }
 */
interface IDiscount
{
    /**
     * Apply discount to CartItem position. If new prices is equal old price - return old price.
     * @param CartLine $item
     * @return int|float new price with discount
     */
    public function applyDiscount(CartLine $item);
}
