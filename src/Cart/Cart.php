<?php

namespace App\Cart;


use Symfony\Component\Uid\Uuid;
use DateTime;

class Cart
{
    public Uuid $identifier;
    public datetime $createdAt;
    /**
     * @var CartItem[] $Cartitems
     */
    public array $Cartitems = [];
    public function __construct()
    {
        $this->identifier = Uuid::v4();

    }
    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->Cartitems as $item) {
            $total += $item->getTotal();
        }
        return $total;
    }

}
