<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\DesignRequest;
use App\Models\Category;
use App\Models\Design;
use App\Models\DesignImages;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DesignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.customize',[
            'designs'=>Auth::user()->designs,
            'materials'=>Material::all(),
            'categories'=>Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DesignRequest $request)
    {
        $design = Auth::user()->designs()->create([
            'product_name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category,
            'material_id' => $request->material,
            'dimentions' => $request->dimentions,
            'estimated_price' => $request->price,
        ]);

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $path = $file->store('designs', 'public');
                $design->images()->create([
                    'image' => $path,
                ]);
            }
        }

        return redirect()->back();
    }
    



    /**
     * Display the specified resource.
     */
    public function show(Design $design)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Design $design)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DesignRequest $request, Design $design)
    {
        $design->update([
            'product_name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category,
            'material_id' => $request->material,
            'dimentions' => $request->dimentions,
            'estimated_price' => $request->price,
     ]);
     if($request->deleted_images){
        $ids=explode(',',$request->deleted_images);
        foreach($ids as $id){
            $image=DesignImages::find($id);
            if($image && $image->design_id === $design->id){
                Storage::disk('public')->delete($image->image);
                $image->delete();
            }
        }
     }
     if($request->hasFile('image')){
        foreach($request->file('image') as $images){
            $path=$images->store('designs','public');
            $design->images()->create([
                'image'=>$path,
            ]);
        }
     }
     return back()->with('success','Design updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Design $design)
    {
        
        if($design->user_id !== Auth::id())
    {
        abort(403);
    }
        $design->delete();
        return redirect()->back();

    }
}
