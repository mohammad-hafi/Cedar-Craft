<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Design;
use App\Models\Material;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('pages/admin',[
            'designs'=>Design::all(),
            'materials'=>Material::all(),
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
        //
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
