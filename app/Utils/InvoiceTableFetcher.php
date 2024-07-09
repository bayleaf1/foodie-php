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
                $inexistent = -123;
                if ($v == "")
                    return ['price', '!=', $inexistent];
                return ['price', '=', $v];
            },
            "email" => function ($v) {
                return ['customer_email', 'LIKE', '%' . $v . '%'];
            },
            "name" => function ($v) {
                return ['customer_name', 'LIKE', '%' . $v . '%'];
            },
            "city" => function ($v) {
                return ['customer_city', 'LIKE', '%' . $v . '%'];
            },
            "phone" => function ($v) {
                return ['customer_phone', 'LIKE', '%' . $v . '%'];
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
            "email" => function ($v) {
                return ['customer_email', $v];
            },
            "name" => function ($v) {
                return ['customer_name', $v];
            },
            "city" => function ($v) {
                return ['customer_city', $v];
            },
            "phone" => function ($v) {
                return ['customer_phone', $v];
            },
        ];
    }
}