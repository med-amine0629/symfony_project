<?php

namespace App\Cart;

class ApiCart implements CartInterface
{
    private static array $store = [];

    public function add(CartItem $cartItem, Cart $cart): Cart
    {
        $cart->Cartitems[$cartItem->id] = $cartItem;
        return $cart;
    }

    public function remove(CartItem $cartItem, Cart $cart): Cart
    {
        unset($cart->Cartitems[$cartItem->id]);
        return $cart;
    }

    public function GetCart(string $key): Cart
    {
        if (isset(self::$store[$key]) && self::$store[$key] instanceof Cart) {
            return self::$store[$key];
        }
        $cart = new Cart();
        self::$store[$key] = $cart;
        return $cart;
    }

    public function ClearCart(string $key): void
    {
        unset(self::$store[$key]);
    }
}
