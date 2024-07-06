<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    //
}

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
    public $headers = [];
    public function getProfile()
    {
        $this->ctx->get(
            '/api/system-users/profile',
            $this->headers
        )->assertJson([]);

    }
    public function post_construct()
    {
        $resp = $this->ctx->post(
            '/api/auth/register/system-user',
            [
                "email" => "test@mail.com",
                "name" => "Ion Mihai",
                "password" => "qwer1234",
                "c_password" => "qwer1234",
                "role" => "root"
            ]
        )->json();

        $this->headers = ["Authorization" => "Bearer " . $resp["accessToken"]];
    }

    public function create_products($products)
    {
        foreach ($products as $product) {
            $this->ctx->post(
                '/api/products',
                ["images" => ["test_mock.jpg"], "description" => "test description", "category" => "burger", "state" => "active", ...$product],
                $this->headers
            )->assertJson([]);

        }
    }
    public function confirm_order($order_id)
    {
        $res = $this->ctx->patch(
            '/api/orders/confirm/' . $order_id,
            [],
            $this->headers

        );
        return $res;
    }
    public function finalize_order($order_id)
    {
        $res = $this->ctx->patch(
            '/api/orders/finalize/' . $order_id,
            [],
            $this->headers

        );
        return $res;

    }

    public function cancel_order($order_id)
    {
        $res = $this->ctx->patch(
            '/api/orders/cancel/' . $order_id,
            [],
            $this->headers

        );
        return $res;
    }
}
class Guest extends Entity
{
    public function create_order($order)
    {
        $res = $this->ctx->post('/api/orders', [
            "email" => "default@default.com",
            "customer_name" => "Default Default",
            "customer_city" => "Default",
            "customer_address" => "Default",
            "customer_phone" => "1111111111",
            "items" => [],
            ...$order
        ]);
        return $res;
    }
}
class App extends Entity
{
    public $headers = [];

    public function set_headers($v)
    {
        $this->headers = $v;
    }
    public function has_products($products)
    {
        $this->ctx->get('/api/products', $this->headers)->assertJson($products);
    }
    public function has_order($order)
    {
        $this->ctx->get('/api/orders', $this->headers)->assertJson([$order]);
    }
    public function has_orders($orders)
    {
        $this->ctx->get('/api/orders', $this->headers)->assertJson($orders);
    }

    public function respond_with_status($response, $status)
    {
        $response->assertStatus($status);
    }
}
