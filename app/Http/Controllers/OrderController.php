<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderController extends Controller
{

    public function confirm($order_id)
    {
        $order = Order::find($order_id);
        $order->status = 'confirmed';
        $order->save();

        $order->items;
        foreach ($order->items as $item) {
            $p = Product::find($item['id']);
            $p->quantity = $p->quantity - $item['quantity'];
            $p->save();
        }
    }

    public function finalize($order_id)
    {
        $order = Order::find($order_id);
        $order->status = 'finished';
        $order->save();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fetch_all_orders_with_related_items = function () {
            $orders = Order::all();
            foreach ($orders as $order)
                $order->items;
            return $orders;
        };

        $enrich_orders_with_price = function ($orders) {
            foreach ($orders as $order) {
                $price = 0;
                foreach ($order->items as $item) {
                    $p = Product::find($item['id']);
                    $price += $p['price'] * $item['quantity'];
                }
                $order['price'] = $price;
            }

            return $orders;
        };

        return response($enrich_orders_with_price($fetch_all_orders_with_related_items()));
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
    public function store(StoreOrderRequest $request)
    {
        $body = $request->all();
        $order_items = [];
        foreach ($body['items'] as $product) {
            $order_items[] = new OrderItem($product);
        }

        $order = Order::create(["email" => $body['email'], "status" => "created",]);
        $order->items()->saveMany($order_items);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
    }
}
