<?php

namespace App\Cart;

use App\Entity\Product;

class CartItem
{
    public int $id;
    public Product $product;
    public float $price;
    public int $quantity;

    public function __construct(Product $product, int $quantity)
    {
        $this->id=$product->getId()?? rand(1000, 9999);
        $this->product = $product;
        $this->price=$product->getPrix()?? 1;
        $this->quantity = $quantity;

    }
    public function getTotal(): float
    {
        return $this->price * $this->quantity;
    }
}
