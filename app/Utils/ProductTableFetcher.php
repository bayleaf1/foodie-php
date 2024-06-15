<?php
namespace App\Utils;

use App\Models\Product;
use App\Utils\TableFetcher;

class ProductTableFetcher extends TableFetcher
{
    public function postConstruct()
    {
        $this->ModelClass = Product::class;
        $this->FILTERS = [
            "id" => function ($v) {
                $inexistent = -123;
                if ($v == "")
                    return ['id', '!=', $inexistent];
                return ['id', '=', $v];
            },
            "name" => function ($v) {
                return ['name', 'LIKE', '%' . $v . '%'];
            },
            "price" => function ($v) {
                return ['price', '=', $v];
            },
            "quantity" => function ($v) {
                return ['quantity', '=', $v];
            },
            "image" => function ($v) {
                return ['images', 'LIKE', '%' . $v . '%'];
            },
        ];
        $this->SORTING = [
            "id" => function ($v) {
                return ['id', $v];
            },
            "name" => function ($v) {
                return ['name', $v];
            },
            "price" => function ($v) {
                return ['price', $v];
            },
            "quantity" => function ($v) {
                return ['quantity', $v];
            },
            "image" => function ($v) {
                return ['images', $v];
            },
        ];
    }
}