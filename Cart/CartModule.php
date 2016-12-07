<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 28/10/14.10.2014 13:05
 */

namespace Modules\Cart;

use Mindy\Base\Mindy;
use Mindy\Base\Module;

class CartModule extends Module
{
    /**
     * @var
     */
    public $listRoute;
    /**
     * @var array
     */
    public $cartConfig = [
        'class' => '\Modules\Cart\Components\Cart\Cart',
    ];

    public static function preConfigure()
    {
        $tpl = Mindy::app()->template;
        $tpl->addHelper('cart', function() {
            return Mindy::app()->getModule('Cart')->getCart();
        });
    }

    public function init()
    {
        $this->setComponent('cart', $this->cartConfig);
    }

    public function getCart()
    {
        return $this->getComponent('cart');
    }
}
