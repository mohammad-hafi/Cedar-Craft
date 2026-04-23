<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProduct;
use App\Models\Category;
use App\Models\Design;
use App\Models\Material;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('pages/admin/admin',[
            'designs'=>Design::all(),
            'materials'=>Material::all(),
            'categories'=>Category::all(),
            'orders'=>Order::all(),
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
    public function store(ProductRequest $request)
    {
      $product=Product::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'material_id'=>$request->material,
            'category_id'=>$request->category,
            'price'=>$request->price,
            'stock'=>$request->stock,
            'dimentions'=>$request->dimentions
        ]);
        if($request->hasFile('image')){
            foreach($request->file('image') as $image){
                $path=$image->store('products','public');
                $product->images()->create([
                    'image'=>$path,
                ]);
            }
        }
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('pages.admin.show',[
            'design'=>Design::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $design=Design::findOrFail($id);
      $request->validate([
        'status'=>'required|in:In Progress,Accepted,Rejected',
      ]);
      $design->update([
        'status'=>$request->status,
      ]);
      return back();
    }

    //updateing the product in the shop
    public function updateShop(UpdateProduct $request, Product $product)
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
