<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Entity
{
    public function __construct($ctx)
    {
        $this->ctx = $ctx;
        $this->post_construct();
    }

    public function post_construct()
    {
    }
}
class SystemUser extends Entity
{
    public function create_products($products)
    {
        foreach ($products as $product)
            $this->ctx->post('/api/products', $product);
    }
    public function confirm_order($order_id)
    {
        $res = $this->ctx->patch('/api/orders/confirm/' . $order_id);
        return $res;
    }
    public function finalize_order($order_id)
    {
        $res = $this->ctx->patch('/api/orders/finalize/' . $order_id);
        return $res;

    }

    public function cancel_order($order_id)
    {
        $res = $this->ctx->patch('/api/orders/cancel/' . $order_id);
        return $res;
    }
}
class Guest extends Entity
{
    public function create_order($order)
    {
        $res = $this->ctx->post('/api/orders', $order);
        return $res;
    }
}
class App extends Entity
{
    public function has_products($products)
    {
        $this->ctx->get('/api/products')->assertJson($products);
    }
    public function has_order($order)
    {
        $this->ctx->get('/api/orders')->assertJson([$order]);
    }
    public function has_orders($orders)
    {
        $this->ctx->get('/api/orders')->assertJson($orders);
    }

    public function respond_with_status($response, $status)
    {
        $response->assertStatus($status);
    }
}

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
    }

    // public function test_test()
    // {
    //     $resp = $this->post('/api/tokens/create');
    //     $token = $resp->json()["token"];
    //     // var_dump($token);
    //     // $resp->assertJson(["token" => "Asd",]);
    //     $resp = $this->get('/api/tokens', ["Authorization" => "Bearer " . $token]);
    //     $resp->assertJson([1]);
    // }

    public function test_product_quantity_is_restored_when_cancel_a_confirmed_order(): void
    {
        $system_user = new SystemUser($this);
        $guest = new Guest($this);
        $app = new App($this);

        $system_user->create_products([
            ["name" => "Coffe", "price" => 2, "quantity" => 10],
        ]);
        $app->has_products([
            ["name" => "Coffe", "price" => 2, "quantity" => 10],
        ]);

        $guest->create_order([
            "email" => "t1@m.com",
            "items" => [
                ["product_id" => 1, "quantity" => 2],
            ],
        ]);
        $system_user->cancel_order(1);
        $app->has_products([
            ["name" => "Coffe", "price" => 2, "quantity" => 10],
        ]);

        $guest->create_order([
            "email" => "t1@m.com",
            "items" => [
                ["product_id" => 1, "quantity" => 2],
            ],
        ]);
        $system_user->confirm_order(2);
        $system_user->cancel_order(2);
        $app->has_products([
            ["name" => "Coffe", "price" => 2, "quantity" => 10],
        ]);
    }
    public function test_system_user_can_cancel_only_not_finished_order(): void
    {

        $system_user = new SystemUser($this);
        $guest = new Guest($this);
        $app = new App($this);

        $system_user->create_products([
            ["name" => "Coffe", "price" => 2, "quantity" => 10],
        ]);
        $app->has_products([
            ["name" => "Coffe", "price" => 2, "quantity" => 10],
        ]);

        $guest->create_order([
            "email" => "t1@m.com",
            "items" => [
                ["product_id" => 1, "quantity" => 2],
            ],
        ]);
        $system_user->confirm_order(1);
        $system_user->cancel_order(1);
        $app->has_orders([["email" => "t1@m.com", "status" => "cancel"]]);

        $guest->create_order([
            "email" => "t1@m.com",
            "items" => [
                ["product_id" => 1, "quantity" => 2],
            ],
        ]);
        $system_user->confirm_order(2);
        $system_user->finalize_order(2);
        $response = $system_user->cancel_order(2);
        $app->respond_with_status($response, 409);

    }
    public function test_system_user_can_finalize_only_confirmed_order(): void
    {

        $system_user = new SystemUser($this);
        $guest = new Guest($this);
        $app = new App($this);

        $system_user->create_products([
            ["name" => "Coffe", "price" => 2, "quantity" => 10],
        ]);
        $app->has_products([
            ["name" => "Coffe", "price" => 2, "quantity" => 10],
        ]);
        $guest->create_order([
            "email" => "t1@m.com",
            "items" => [
                ["product_id" => 1, "quantity" => 2],
            ],
        ]);

        $response = $system_user->finalize_order(1);
        $app->respond_with_status($response, 409);

        $system_user->confirm_order(1);
        $response = $system_user->finalize_order(1);
        $app->respond_with_status($response, 200);

    }
    public function test_system_user_can_confirm_only_created_order(): void
    {
        $system_user = new SystemUser($this);
        $guest = new Guest($this);
        $app = new App($this);

        $system_user->create_products([
            ["name" => "Coffe", "price" => 2, "quantity" => 10],
        ]);
        $app->has_products([
            ["name" => "Coffe", "price" => 2, "quantity" => 10],
        ]);
        $guest->create_order([
            "email" => "t1@m.com",
            "items" => [
                ["product_id" => 1, "quantity" => 2],
            ],
        ]);

        $system_user->confirm_order(1);
        $response = $system_user->confirm_order(1);
        $app->respond_with_status($response, 409);
    }
    public function test_system_user_cant_confirm_order_cause_product_is_exhausted_by_another_order(): void
    {
        $system_user = new SystemUser($this);
        $guest = new Guest($this);
        $app = new App($this);

        $system_user->create_products([
            ["name" => "Coffe", "price" => 2, "quantity" => 10],
        ]);
        $app->has_products([
            ["name" => "Coffe", "price" => 2, "quantity" => 10],
        ]);
        $guest->create_order([
            "email" => "t1@m.com",
            "items" => [
                ["product_id" => 1, "quantity" => 8],
            ],
        ]);
        $guest->create_order([
            "email" => "t2@m.com",
            "items" => [
                ["product_id" => 1, "quantity" => 3],
            ],
        ]);
        $system_user->confirm_order(1);
        $response = $system_user->confirm_order(2);
        $app->respond_with_status($response, 422);
        $app->has_orders([
            ["email" => "t1@m.com", "status" => "confirmed"],
            ["email" => "t2@m.com", "status" => "created"]
        ]);
        // $app->respond_with_status($response, 422);
    }
    public function test_guest_create_order_with_excesive_quantity(): void
    {
        $system_user = new SystemUser($this);
        $guest = new Guest($this);
        $app = new App($this);

        $system_user->create_products([
            ["name" => "Coffe", "price" => 2, "quantity" => 10],
        ]);
        $app->has_products([
            ["name" => "Coffe", "price" => 2, "quantity" => 10],
        ]);

        $response = $guest->create_order([
            "email" => "t@m.com",
            "items" => [
                ["product_id" => 1, "quantity" => 20],
            ],
        ]);
        $app->respond_with_status($response, 422);
    }
    public function test_system_user_add_products_and_guest_create_order_then_it_is_confirmed_and_finalized(): void
    {
        $system_user = new SystemUser($this);
        $guest = new Guest($this);
        $app = new App($this);

        $system_user->create_products([
            ["name" => "Coffe", "price" => 2, "quantity" => 10],
            ["name" => "Snack", "price" => 3, "quantity" => 8]
        ]);
        $app->has_products([
            ["name" => "Coffe", "price" => 2, "quantity" => 10],
            ["name" => "Snack", "price" => 3, "quantity" => 8]
        ]);

        $guest->create_order([
            "email" => "t@m.com",
            "items" => [
                ["product_id" => 1, "quantity" => 2],
                ["product_id" => 2, "quantity" => 3],
            ],
        ]);
        $app->has_order([
            "email" => "t@m.com",
            "price" => 13,
            "status" => "created",
            "items" => [
                ["product_id" => 1, "quantity" => 2],
                ["product_id" => 2, "quantity" => 3],
            ]
        ]);

        $system_user->confirm_order(1);
        $app->has_order([
            "email" => "t@m.com",
            "status" => "confirmed",
        ]);
        $app->has_products([
            ["name" => "Coffe", "price" => 2, "quantity" => 8],
            ["name" => "Snack", "price" => 3, "quantity" => 5]
        ]);

        $system_user->finalize_order(1);
        $app->has_order([
            "email" => "t@m.com",
            "status" => "finished",
        ]);
    }
}


// class Decoder
// {
//     public function __construct($coded)
//     {
//         $this->coded = $coded;
//     }
//     function _extract($regexp, $def_value)
//     {
//         $result = [];
//         preg_match($regexp, $this->coded, $result);
//         return array_key_exists(0, $result) ? $result[0] : $def_value;
//     }
// }
// class ProductDecoder extends Decoder
// {
//     public static function decode_multiple($products)
//     {
//         $result = [];
//         foreach ($products as $product) {
//             $result[] = ProductDecoder::decode($product);
//         }
//         return $result;
//     }
//     public static function decode($product)
//     {
//         $obj = new ProductDecoder($product);
//         return [
//             "price" => $obj->price(),
//             "name" => $obj->name(),
//             "quantity" => $obj->quantity()
//         ];
//     }


//     public function name()
//     {
//         return $this->_extract("/^[^\$X]*/", "DEFAULT_NAME_FROM_DECODER");
//     }
//     public function price()
//     {
//         return $this->_extract("/\d+/", 9999);
//     }
//     public function quantity()
//     {
//         return $this->_extract("/\d+$/", 9998);
//     }
// }

// class OrderDecoder extends Decoder
// {
//     // public static function decode_multiple($products)
//     // {
//     //     $result = [];
//     //     foreach ($products as $product) {
//     //         $result[] = ProductDecoder::decode($product);
//     //     }
//     //     return $result;
//     // }
//     public static function decode($order)
//     {
//         $obj = new OrderDecoder($order);
//         return [
//             "email" => $obj->email(),
//             "products" => $obj->products(),
//             "status" => $obj->status(),
//             // "price" => 
//         ];
//     }


//     public function email()
//     {
//         return $this->_extract("/[^-]*/", "DEFAULT_EMAIL_FROM_DECODER@mail.com");
//     }
//     public function products()
//     {
//         $products_as_string = $this->_extract("/(?<=>)[^=]*/", []);
//         return ProductDecoder::decode_multiple(explode('_', $products_as_string));
//     }
//     public function status()
//     {
//         return $this->_extract("/(?<=:)[a-z_]*/", "DEFAULT_STATUS_FROM_DECODER");
//     }

//     // public function quantity()
//     // {
//     //     return $this->_extract("/\d+$/", 9998);
//     // }
// }