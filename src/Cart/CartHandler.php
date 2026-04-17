<?php

namespace App\Cart;

class CartHandler
{
    public function handle(Cart $cart, CartItem $cartItem, CartInterface $strategy): Cart
    {
        return $strategy->add($cartItem, $cart);
    }
}
