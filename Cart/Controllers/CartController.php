<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 28/10/14.10.2014 15:51
 */

namespace Modules\Cart\Controllers;

use Mindy\Base\Mindy;
use Modules\Cart\CartModule;
use Modules\Core\Controllers\FrontendController;
use Modules\Cart\Components\Cart\Traits\CartTrait;

/**
 * Class CartController
 * @package Modules\Cart\Controllers
 */
abstract class CartController extends FrontendController
{
    use CartTrait;

    /**
     * @var string
     */
    public $listTemplate = 'cart/list.html';

    public function actionAdd($uniqueId, $quantity = 1, $type = null)
    {
        $isAjax = $this->getRequest()->isAjax;
        $cart = $this->getCart();
        if ($this->addInternal($uniqueId, $quantity, $type)) {
            if ($isAjax) {
                echo $this->json([
                    'status' => true,
                    'price' => $cart->getPrice(),
                    'quantity' => $cart->getQuantity(),
                    'message' => [
                        'title' => CartModule::t('Product added')
                    ]
                ]);
                Mindy::app()->end();
            } else {
                $this->getRequest()->flash->success(CartModule::t('Product added'));
                $this->successRedirect();
            }
        } else {
            if ($isAjax) {
                echo $this->json([
                    'status' => false,
                    'price' => $cart->getPrice(),
                    'quantity' => $cart->getQuantity(),
                    'message' => [
                        'title' => CartModule::t('Error has occurred')
                    ]
                ]);
                Mindy::app()->end();
            } else {
                $this->getRequest()->flash->success(CartModule::t('Error has occurred'));
                $this->successRedirect();
            }
        }
    }

    abstract public function successRedirect();

    public function actionList()
    {
        $cart = $this->getCart();
        echo $this->render($this->listTemplate, [
            'objects' => $cart->getObjects(),
            'price' => $cart->getPrice(),
            'quantity' => $cart->getQuantity()
        ]);
    }

    public function actionQuantity($key, $quantity)
    {
        $isAjax = $this->getRequest()->isAjax;
        $cart = $this->getCart();
        if ($cart->updateQuantityByKey($key, $quantity)) {
            if ($isAjax) {
                echo $this->json([
                    'status' => true,
                    'price' => $cart->getPrice(),
                    'quantity' => $cart->getQuantity(),
                    'message' => [
                        'title' => CartModule::t('Quantity updated')
                    ]
                ]);
                Mindy::app()->end();
            } else {
                $this->getRequest()->flash->success(CartModule::t('Quantity updated'));
                $this->successRedirect();
            }
        } else {
            if ($isAjax) {
                echo $this->json([
                    'status' => false,
                    'price' => $cart->getPrice(),
                    'quantity' => $cart->getQuantity(),
                    'message' => [
                        'title' => CartModule::t('Error has occurred')
                    ]
                ]);
                Mindy::app()->end();
            } else {
                $this->getRequest()->flash->success(CartModule::t('Error has occurred'));
                $this->successRedirect();
            }
        }
    }

    public function actionIncrease($key)
    {
        $isAjax = $this->getRequest()->isAjax;
        $cart = $this->getCart();
        if ($cart->increaseQuantityByKey($key)) {
            if ($isAjax) {
                echo $this->json([
                    'status' => true,
                    'price' => $cart->getPrice(),
                    'quantity' => $cart->getQuantity(),
                    'message' => [
                        'title' => CartModule::t('Quantity updated')
                    ]
                ]);
                Mindy::app()->end();
            } else {
                $this->getRequest()->flash->success(CartModule::t('Quantity updated'));
                $this->successRedirect();
            }
        } else {
            if ($isAjax) {
                echo $this->json([
                    'status' => false,
                    'price' => $cart->getPrice(),
                    'quantity' => $cart->getQuantity(),
                    'error' => [
                        'title' => CartModule::t('Error has occurred')
                    ]
                ]);
                Mindy::app()->end();
            } else {
                $this->getRequest()->flash->success(CartModule::t('Error has occurred'));
                $this->successRedirect();
            }
        }
    }

    public function actionDecrease($key)
    {
        $isAjax = $this->getRequest()->isAjax;
        $cart = $this->getCart();
        if ($cart->decreaseQuantityByKey($key)) {
            if ($isAjax) {
                echo $this->json([
                    'status' => true,
                    'price' => $cart->getPrice(),
                    'quantity' => $cart->getQuantity(),
                    'message' => [
                        'title' => CartModule::t('Quantity updated')
                    ]
                ]);
                Mindy::app()->end();
            } else {
                $this->getRequest()->flash->success(CartModule::t('Quantity updated'));
                $this->successRedirect();
            }
        } else {
            if ($isAjax) {
                echo $this->json([
                    'status' => false,
                    'price' => $cart->getPrice(),
                    'quantity' => $cart->getQuantity(),
                    'error' => [
                        'title' => CartModule::t('Error has occurred')
                    ]
                ]);
                Mindy::app()->end();
            } else {
                $this->getRequest()->flash->success(CartModule::t('Error has occurred'));
                $this->successRedirect();
            }
        }
    }

    public function actionDelete($key)
    {
        $cart = $this->getCart();
        $deleted = $cart->removeByKey($key);
        $isAjax = $this->getRequest()->isAjax;
        if ($deleted) {
            if ($isAjax) {
                echo $this->json([
                    'status' => true,
                    'price' => $cart->getPrice(),
                    'quantity' => $cart->getQuantity(),
                    'message' => [
                        'title' => CartModule::t('Position sucessfully removed'),
                    ]
                ]);
                Mindy::app()->end();
            } else {
                $this->getRequest()->flash->success(CartModule::t('Position sucessfully removed'));
                $this->successRedirect();
            }
        } else {
            if ($isAjax) {
                echo $this->json([
                    'status' => false,
                    'price' => $cart->getPrice(),
                    'quantity' => $cart->getQuantity(),
                    'error' => [
                        'title' => CartModule::t('Error has occurred'),
                    ]
                ]);
                Mindy::app()->end();
            } else {
                $this->getRequest()->flash->error(CartModule::t('Error has occurred'));
                $this->successRedirect();
            }
        }
    }

    abstract protected function addInternal($uniqueId, $quantity, $type);
}
