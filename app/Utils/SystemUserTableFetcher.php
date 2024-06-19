<?php
namespace App\Utils;

use App\Models\Order;
use App\Models\SystemUser;
use App\Utils\TableFetcher;

class SystemUserTableFetcher extends TableFetcher
{
    public function postConstruct()
    {
        $this->ModelClass = SystemUser::class;
        $this->FILTERS = [
            "id" => function ($v) {
                $inexistent = -123;
                if ($v == "")
                    return ['id', '!=', $inexistent];
                return ['id', '=', $v];
            },
            "name" => function ($v) {
                return ['status', 'LIKE', '%' . $v . '%'];
            },
            "email" => function ($v) {
                return ['email', 'LIKE', '%' . $v . '%'];
            },
            "role" => function ($v) {
                return ['role', 'LIKE', '%' . $v . '%'];
            },
        ];
        $this->SORTING = [
            "id" => function ($v) {
                return ['id', $v];
            },
            "name" => function ($v) {
                return ['status', $v];
            },
            "email" => function ($v) {
                return ['email', $v];
            },
            "role" => function ($v) {
                return ['role', $v];
            },
        ];
    }
}