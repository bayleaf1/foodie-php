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
                $inexistent = -123;
                if ($v == "")
                    return ['price', '!=', $inexistent];
                return ['price', '=', $v];
            },
            "quantity" => function ($v) {
                $inexistent = -123;
                if ($v == "")
                    return ['quantity', '!=', $inexistent];
                return ['quantity', '=', $v];
            },
            "image" => function ($v) {
                return ['images', 'LIKE', '%' . $v . '%'];
            },
            "category" => function ($v) {
                return ['category', 'LIKE', '%' . $v . '%'];
            },
            "state" => function ($v) {
                return ['state', 'LIKE', '%' . $v . '%'];
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
            "category" => function ($v) {
                return ['category', $v];
            },
            "state" => function ($v) {
                return ['state', $v];
            },
        ];
    }
}