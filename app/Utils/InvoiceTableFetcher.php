<?php
namespace App\Utils;

use App\Models\Invoice;
use App\Models\Order;
use App\Utils\TableFetcher;

class InvoiceTableFetcher extends TableFetcher
{
    public function postConstruct()
    {
        $this->ModelClass = Invoice::class;
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
            "price" => function ($v) {
                return ['price', '=', $v];
            },
            "customer_email" => function ($v) {
                return ['customer_email', 'LIKE', '%' . $v . '%'];
            },
            "customer_name" => function ($v) {
                return ['customer_name', 'LIKE', '%' . $v . '%'];
            },
            "customer_city" => function ($v) {
                return ['customer_city', 'LIKE', '%' . $v . '%'];
            },
            "customer_phone" => function ($v) {
                return ['customer_city', 'LIKE', '%' . $v . '%'];
            },
        ];
        $this->SORTING = [
            "id" => function ($v) {
                return ['id', $v];
            },
            "status" => function ($v) {
                return ['status', $v];
            },
            "price" => function ($v) {
                return ['price', $v];
            },
            "customer_email" => function ($v) {
                return ['customer_email', $v];
            },
            "customer_name" => function ($v) {
                return ['customer_name', $v];
            },
            "customer_city" => function ($v) {
                return ['customer_city', $v];
            },
            "customer_phone" => function ($v) {
                return ['customer_phone', $v];
            },
        ];
    }
}