<?php

namespace App\Cart;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Uid\Uuid;

class SessionCart implements CartInterface
{
    private const SESSION_KEY = 'cart';
    public function __construct(private  RequestStack $stack)
    {

    }

    public function add(cartItem $cartItem, Cart $cart): Cart
    {

        $cart->Cartitems[$cartItem->product->getId()] = $cartItem;
        $this->stack->getSession()->set(self::SESSION_KEY, $cart);
        return $cart;
    }

    public function remove(cartItem $cartItem, Cart $cart): Cart
    {
        unset($cart->Cartitems[$cartItem->product->getId()]);
        $this->stack->getSession()->set(self::SESSION_KEY, $cart);

        return $cart;
    }

    public function GetCart(string $key): Cart
    {
        $cart = $this->stack->getSession()->get(self::SESSION_KEY);
        if (!$cart instanceof Cart) {
            $cart = new Cart();
        }

        //
        return $cart;
    }

    public function ClearCart(string $identifier): void
    {
        $this->stack->getSession()->remove(self::SESSION_KEY);

    }
}
