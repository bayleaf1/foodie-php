<?php

namespace App\Http\Controllers;

use App\Events\OrderUpdated;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Utils\ProductTableFetcher;





class ProductController extends Controller
{

    public function sendMessage()
    {
        // event(new OrderUpdated("updated"));
        return response()->json(['status' => 'Message sent!']);
    }

    public function cart()
    {
        // $product = Product::find($id);
        // $product->images = json_decode($product->images);

        $body = request()->all();

        $result = [];

        foreach ($body as $p) {
            $product = Product::find($p['id']);
            $product->images = json_decode($product->images);
            array_push($result, [
                "id" => $product->id,
                "name" => $product->name,
                "image" => array_key_exists(0, $product->images) ? $product->images[0] : '',
                "price" => $product->price * $p['quantity'],
                "available" => $p['quantity'] <= $product->quantity,
                "quantity" => $p['quantity']
            ]);
        }

        return response()->json([
            "products" => $result
        ]);
    }

    public function showcase($id)
    {
        $product = Product::find($id);
        $product->images = json_decode($product->images);

        return response()->json([
            "product" => $product
        ]);
    }

    public function menu()
    {
        $products = Product::where('state', '=', 'active')->get();

        $menu = [];

        foreach ($products as $p) {
            if (!array_key_exists($p->category, $menu, ))
                $menu[$p->category] = [];

            array_push($menu[$p->category], $p);

        }


        return response()->json([
            "menu" => $menu,
            "products" => array_map(function ($i) {
                $i->images = json_decode($i->images);
                return $i;
            }, [...$products])
        ]);
    }
    public function table()
    {
        $f = new ProductTableFetcher();
        $table = $f->get(request()->query());

        return response()->json([
            "table" => [
                ...$table,
                "rows" => array_map(function ($i) {
                    $i->images = json_decode($i->images);
                    return $i;
                }, $table["rows"])
            ],
        ]);

    }

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
        $details = $request->validate([
            "name" => "required|string|min:2|max:80",
            "price" => "required|integer|min:0|max:10000",
            "quantity" => "required|integer|min:0|max:100000",
            "description" => "required|string|min:1|max:200",
            "images" => "required|array|between:1,100",
            "category" => "required|in:snack,salad",
            "state" => "required|in:active,inactive"
        ], [
            'images.required' => 'You have to upload one image'
        ]);

        $details = $request->all();
        $p = Product::create([...$details, "images" => json_encode($details['images']),]);
        return response()->json(["product_id" => $p->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
        return new ProductResource($product);
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
        $details = $request->validate([
            "name" => "required|string|min:2|max:80",
            "price" => "required|integer|min:0|max:10000",
            "quantity" => "required|integer|min:0|max:100000",
            "description" => "required|string|min:1|max:200",
            "images" => "required|array|between:1,100",
            "category" => "required|in:snack,salad",
            "state" => "required|in:active,inactive"
        ], [
            'images.required' => 'You have to upload one image'
        ]);

        $product->update([...$details, "images" => json_encode($details['images']),]);
        $product->save();

        return new ProductResource($product);

        // return response()->json(['data' => "reps"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
