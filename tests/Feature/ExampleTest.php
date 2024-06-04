<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->post('/api/products', ["name" => "Burger"]);
        $response->assertJson([
            "0" => [
                "name" => "Burger",
                "id" => 1
            ],
        ]);
        // $response->assertJson([2]);

        // $response = $this->get('/api/products');
        // $response->assertJson([1]);
    }
}
