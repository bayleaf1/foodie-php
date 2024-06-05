<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pr = Product::all();
        // var_dump($pr);


        return response($pr);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        // $details = $request->validate([
        //     "name" => "required|string|max:3",
        //     "price" => "required|integer|max:100000",
        // ]);
        $details = $request->all();
        Product::create($details);
        // echo gettype($values);

        // foreach ($values as $x => $value) {
        //     var_dump($value->name);
        // }


        // $pr1 = Product::create(["name" => "Pr 1"]);
        // $pr2 = Product::create(["name" => "Pr 2"]);

        // $order = Order::create(["name" => "First order", "email" => "test@mail.com"]);

        // $order->items()->saveMany([
        //     new OrderItem(["name" => "Oi 1", "product_id" => $pr1->id]),
        //     new OrderItem(["name" => "Oi 2", "product_id" => $pr2->id]),
        // ]);


        // $new_order = Order::first();
        // $new_order->items;

        // var_dump((string) $new_order);


        // $product = Product::create($request->all());    ]
        // var_dump($request->all()["name"]);
        // $p = Product::create($request->all());
        // $all = Product::all()->toJson();
        // return response($new_order);
        // ->json();

        // var_dump($all);
        // echo $p->id . ' ' . $p->name . ' ';
        // return response($all);
        // return response()->json([2]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
