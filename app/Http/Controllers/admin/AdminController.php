<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProduct;
use App\Models\Category;
use App\Models\Design;
use App\Models\Home;
use App\Models\Material;
use App\Models\Order;
use App\Models\OrderItem;
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
   $categories = Category::all();
$materials = Material::all();

$orders = Order::orderByRaw("
    CASE
        WHEN status = 'Pending' THEN 1
        WHEN status = 'Paid' THEN 2
        ELSE 3
    END
")->get();

$designs = Design::all();

$total = OrderItem::whereHas('order', function ($query) {

    $query->whereIn('status', ['Received']);

})->sum("price_at_purchase");

return view('pages/admin/admin', compact(
    'total',
    'categories',
    'materials',
    'orders',
    'designs'
));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function customize()
    {
        return view('pages/admin/customize',[
            'designs'=>Design::all(),
            'categories'=>Category::all(),
            'materials'=>Material::all(),
        ]);
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
        return response()->json([
            'success'=>true,
            'message'=>'Product created successfully',
            'data'=>$product->load('images')
        ]);
    }

    /**
     * Display the specified resource.
     */


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
          'estimated_price'=>'required|numeric|min:5'
        ]);
            $product=Product::create([
            'name'=>$design->product_name,
            'description'=>$design->description,
            'material_id'=>$design->material_id,
            'category_id'=>$design->category_id,
            'price'=>$request->estimated_price,
            'stock'=>$request->stock,
            'dimentions'=>$design->dimentions
        ]);
        foreach ($design->images as $image) {

    $product->images()->create([
        'image' => $image->image
    ]);
    }
      $design->update([
        'estimated_price'=>$request->estimated_price,
        'status'=>$request->status,
      ]);
      return back()->with('success','Design is accepted');
    }
    public function reject(Request $request, string $id)
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
            'category_id'=>$request->category,
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
     public function destroy(Product $product, Request $request)
    {
        $product->update([
        'soft_delete'=>$request->soft_delete,
      ]);
        return back()->with('success','Product deleted successfully');
    }

    public function createCategory(Request $request){
        $request->validate([
        'categories'=>['required']
        ]);
       $category= Category::create(
        [
            'name'=>$request->categories,
        ]
       );
        return response()->json([
            'success'=>true,
            'message'=>'Category created successfully',
            'data'=>$category
        ]);
    }
    public function createMaterial(Request $request){
        $request->validate([
            'materials'=>['required']
        ]);
        $material=Material::create([
            'type'=>$request->materials,
        ]);
        
      return response()->json([
                'success' => true,
                'message' => 'Material created successfully',
                'data' => $material
            ]);
        }
        
    }

