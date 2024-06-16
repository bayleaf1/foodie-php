<?php
namespace App\Utils;

use App\Models\Order;
use App\Utils\TableFetcher;

class OrderTableFetcher extends TableFetcher
{
    public function postConstruct()
    {
        $this->ModelClass = Order::class;
        $this->FILTERS = [
            "id" => function ($v) {
                $inexistent = -123;
                if ($v == "")
                    return ['id', '!=', $inexistent];
                return ['id', '=', $v];
            },
            "status" => function ($v) {
                return ['status', 'LIKE', '%' . $v . '%'];
            },
            "email" => function ($v) {
                return ['email', 'LIKE', '%' . $v . '%'];
            },
            "price" => function ($v) {
                return ['price', '=', $v];
            },
        ];
        $this->SORTING = [
            "id" => function ($v) {
                return ['id', $v];
            },
            "status" => function ($v) {
                return ['status', $v];
            },
            "email" => function ($v) {
                return ['email', $v];
            },
            "price" => function ($v) {
                return ['price', $v];
            },
        ];
    }
}