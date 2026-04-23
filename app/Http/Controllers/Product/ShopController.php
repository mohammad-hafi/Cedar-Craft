<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProduct;
use App\Models\Material;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.shop.shop',['products'=>Product::all(),
        'materials'=>Material::all()
        ]);
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
$user=Auth::user();
$product=Product::findOrFail($request->product);
$price=$product->price;
$order=$user->orders()->firstOrCreate([
    'user_id'=>$user->id,
    'status'=>'Pending'
]);
    $item=$order->items()->where('product_id',$product->id)->first();
    if($item){
       $newQuantity=$item->quantity + $request->quantity;
         $item->update([
            'quantity'=>$newQuantity,
            'price_at_purchase'=>$price * $newQuantity
         ]);
        return redirect()->route('shop.show',$request->product)->with('success','Product quantity updated in cart successfully');
    }else{
        $order->items()->create([
            'product_id'=>$product->id,
            'quantity'=>$request->quantity,
            'price_at_purchase'=>$price * $request->quantity
        ]);
        return redirect()->route('shop.show',$request->product)->with('success','Product added to cart successfully');
        }
    
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
    public function update(UpdateProduct $request, Product $product)
    {
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        
    }
}
