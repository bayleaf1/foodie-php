<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\SystemUser;
use Tests\App;
use Tests\Guest;

class AcceptanceTests extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
    }

    public function test_product_quantity_is_restored_when_cancel_a_confirmed_order(): void
    {
        $system_user = new SystemUser($this);
        $guest = new Guest($this);
        $app = new App($this);
        $app->set_headers($system_user->headers);

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
        $app->set_headers($system_user->headers);

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
        $app->has_orders([["email" => "t1@m.com", "status" => "canceled"]]);

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
        $app->set_headers($system_user->headers);


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
        $app->set_headers($system_user->headers);


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
        $app->set_headers($system_user->headers);


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
    public function test_guest_try_to_create_order_with_excesive_quantity(): void
    {
        $system_user = new SystemUser($this);
        $guest = new Guest($this);
        $app = new App($this);
        $app->set_headers($system_user->headers);


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
        $app->set_headers($system_user->headers);


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
