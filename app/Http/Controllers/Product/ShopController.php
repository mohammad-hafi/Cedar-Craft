<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.shop.shop',['products'=>Product::all()]);
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
    public function store(Request $request)
    {

       $request->validate([
            'quantity'=>'required|integer|min:1',
            'product'=>'required|exists:products,id',
            'price'=>'required|numeric|min:0'
            ]);
            $order= Order::create([
                 'user_id'=>Auth::user()->id
              ]);
         $order->items()->create([
            'product_id'=>$request->product,
            'quantity'=>$request->quantity,
            'price_at_purchase'=>$request->price
         ]);
         return redirect()->route('shop.show',$request->product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('pages.shop.show',['product'=>$product]);
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
    public function update(Request $request, Product $product)
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
