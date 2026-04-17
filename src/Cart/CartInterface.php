<?php

namespace App\Cart;

use Symfony\Component\Uid\Uuid;

interface CartInterface
{
public function add(cartItem $cartItem,Cart $cart):Cart;
public function remove(cartItem $cartItem,Cart $cart):Cart;
public function GetCart(string $key):Cart;
public function ClearCart(string $identifier):void;
}
