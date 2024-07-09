<?php

namespace App\Http\Controllers;

// use App\Events\OrderUpdated;
// use App\Events\OrderCreated;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Mail\OrderCancelledMail;
use App\Mail\OrderConfirmedMail;
use App\Mail\OrderCreatedMail;
use App\Mail\OrderFinishedMail;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Utils\AppGenId;
use App\Utils\OrderTableFetcher;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    public function test()
    {
        $order = Order::latest();

        $order->invoice;
        // $order->
        Mail::to('dinucontpersonal@gmail.com')->send(new OrderFinishedMail($order));

        return response()->json([
            "orders" => "LALALALLALA",
        ]);
    }

    public function ordersForGuest()
    {
        $orders_id = request()->all();
        $orders = [];

        foreach ($orders_id as $id) {
            $o = Order::find($id);
            if (is_null($o))
                continue;
            $o->items();
            $o->invoice;

            $products = [];
            foreach ($o->items as $i) {
                $p = Product::find($i->product_id);
                array_push($products, [
                    "id" => $p->id,
                    "name" => $p->name,
                    "quantity" => $i->quantity
                ]);
            }

            array_push($orders, [
                "id" => $o->id,
                "status" => $o->status,
                "updated_at" => $o->updated_at,
                "products" => $products,
                "invoice_public_id" => is_null($o->invoice) ? null : $o->invoice->public_id,
            ]);
        }


        return response()->json([
            "orders" => $orders,
        ]);
    }

    public function table()
    {
        $f = new OrderTableFetcher();
        $table = $f->get(request()->query());

        return response()->json([
            "table" => $table
        ]);

    }

    public function cancel($order_id)
    {
        $order = Order::find($order_id);
        if ($order->status == "finished") {
            return response()->json(["error" => ["message" => "Can cancel only non finished order"]], 409);
        }

        if ($order->status == "canceled") {
            return response()->json(["error" => ["message" => "Order is already canceled"]], 409);
        }

        if ($order->status == "confirmed") {
            $order->items;
            foreach ($order->items as $i) {
                $p = Product::find($i['product_id']);
                $p->quantity += $i['quantity'];
                $p->save();
            }
        }

        $order->status = 'canceled';
        $order->save();

        $order->invoice;
        if (!is_null($order->invoice)) {
            $order->invoice->status = "canceled";
            $order->invoice->save();
        }

        Mail::to($order->email)->send(new OrderCancelledMail($order));

        // event(new OrderUpdated($order));
    }

    public function confirm($order_id)
    {
        $order = Order::find($order_id);

        if ($order->status != "created") {
            return response()->json(["error" => ["message" => "Order status must be created"]], 409);
        }

        $order->items;
        foreach ($order->items as $item) {
            $p = Product::find($item['product_id']);
            if ($p->quantity < $item['quantity'])
                return response()->json(["error" => ["message" => "Unavailable quantity"]], 422);

            $p->quantity = $p->quantity - $item['quantity'];
            $p->save();
        }
        $order->status = 'confirmed';
        $order->save();

        $invoice = Invoice::create([
            "status" => "created",
            "customer_email" => $order->email,
            "customer_phone" => $order->customer_phone,
            "customer_city" => $order->customer_city,
            "customer_address" => $order->customer_address,
            "customer_name" => $order->customer_name,
            "order_id" => $order->id,
            "public_id" => AppGenId::numeric(),
        ]);


        $invoice_products = [];
        $invoice_price = 0;
        foreach ($order->items as $item) {
            $p = Product::find($item->product_id);
            $total_price = $item->quantity * $p->price;
            $invoice_price += $total_price;

            $invoice_products[] = new InvoiceProduct([
                "name" => $p->name,
                "quantity" => $item->quantity,
                "total_price" => $total_price,
                "price" => $p->price,

                "product_id" => $p->id,
                "order_id" => $order->id,
                "invoice_id" => $invoice->id,
            ]);
        }


        $invoice->price = $invoice_price;
        $invoice->products()->saveMany($invoice_products);
        $invoice->save();

        $order->invoice;
        Mail::to($order->email)->send(new OrderConfirmedMail($order));


        // event(new OrderUpdated($order));

    }

    public function finalize($order_id)
    {
        $order = Order::find($order_id);
        if ($order->status != "confirmed") {
            return response()->json(["error" => ["message" => "Can finalize only confirmed order"]], 409);

        }
        $order->status = 'finished';
        $order->save();

        $order->invoice;
        $order->invoice->status = "finished";
        $order->invoice->save();

        Mail::to($order->email)->send(new OrderFinishedMail($order));

        // event(new OrderUpdated($order));

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fetch_all_orders_with_related_items = function () {
            $orders = Order::all();
            foreach ($orders as $order) {
                $order->items;
            }
            return $orders;
        };

        $enrich_orders_with_price = function ($orders) {
            foreach ($orders as $order) {
                $price = 0;
                foreach ($order->items as $item) {
                    $p = Product::find($item['product_id']);
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

        foreach ($body['items'] as $item) {
            $p = Product::find($item['product_id']);
            if ($p->quantity < $item['quantity']) {
                return response()->json(["error" => ["message" => "Unavailable quantity"]], 422);
            }
            $order_items[] = new OrderItem($item);
        }

        $order = Order::create([
            "status" => "created",
            "email" => $body['email'],
            "customer_phone" => $body['customer_phone'],
            "customer_city" => $body['customer_city'],
            "customer_address" => $body['customer_address'],
            "customer_name" => $body['customer_name'],
        ]);
        $order->items()->saveMany($order_items);

        Mail::to($order->email)->send(new OrderCreatedMail($order));


        // event(new OrderCreated($order));
        return response()->json(["order_id" => $order->id,]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->items;
        $order->invoice;
        foreach ($order->items as &$item) {
            $item->product = Product::find($item->product_id);
        }

        $products = array_reduce([...$order->items], function ($acc, $item) {
            return [
                ...$acc,
                [
                    "id" => $item->product->id,
                    "name" => $item->product->name,
                    "quantity" => $item->quantity,
                    "price" => $item->product->price * $item->quantity,
                ]
            ];
        }, []);

        $result = [
            "id" => $order->id,
            "invoice_id" => is_null($order->invoice) ? "" : $order->invoice->id,
            "status" => $order->status,
            "customer_email" => $order->email,
            "customer_name" => $order->customer_name,
            "customer_phone" => $order->customer_phone,
            "customer_address" => $order->customer_address,
            "customer_city" => $order->customer_city,
            "products" => $products,
            "price" => array_reduce($products, function ($acc, $p) {
                return $acc + $p['price'];
            }, 0),
            "can_be_canceled" => $order->status != "finished" && $order->status != "canceled",
            "can_be_confirmed" => $order->status == "created",
            "can_be_finished" => $order->status == "confirmed",
        ];
        return response()->json(["order" => $result]);
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
