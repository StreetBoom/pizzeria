<?php

namespace App\DTO\Order;

use App\DTO\BaseDTO;


class OrderDTO extends BaseDTO
{
    public int $userId;
    public float $total;
    public string $phone;
    public string $email;
    public string $address;
    public string $deliveryTime;

    public string $items;


}

