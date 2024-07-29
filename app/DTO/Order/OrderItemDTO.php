<?php

namespace App\DTO\Order;

use App\DTO\BaseDTO;


class OrderItemDTO extends BaseDTO
{
    public int $productId;
    public string $name;
    public int $quantity;
    public float $price;


    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        return $this->quantity * $this->price;
    }
}

