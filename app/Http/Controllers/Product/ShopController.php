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
            $order= Order::create([
                 'user_id'=>Auth::user()->id
              ]);
         $order->items()->create([
            'product_id'=>$request->product,
            'quantity'=>$request->quantity,
            'price_at_purchase'=>$request->price * $request->quantity
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
    public function update(UpdateProduct $request, Product $product)
    {
     $product->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'material_id'=>$request->material,
            'price'=>$request->price,
            'stock'=>$request->stock,
            'dimentions'=>$request->dimentions
     ]);
     if($request->deleted_images){
        $ids=explode(',',$request->deleted_images);
        foreach($ids as $id){
            $image=ProductImages::find($id);
            if($image && $image->product_id == $product->id){
                Storage::disk('public')->delete($image->image);
                $image->delete();
            }
        }
     }
     if($request->hasFile('images')){
        foreach($request->file('images') as $images){
            $path=$images->store('products','public');
            $product->images()->create([
                'image'=>$path,
            ]);
        }
     }
     return back()->with('success','Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if(!auth()->user()->is_admin()){
            abort(403);
        }
        foreach($product->images as $image){
            Storage::disk('public')->delete($image->image);
            $image->delete();
        }
        $product->orderitems()->delete();
        $product->delete();
        return back()->with('success','Product deleted successfully');
    }
}
