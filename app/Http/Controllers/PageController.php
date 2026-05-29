<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Home;
use App\Models\Material;
use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
public function home()
{
    $name = Home::where('attribute', 'website_name')->value('value');

    $logo = Home::where('attribute', 'logo')->value('value');

    $productIds = json_decode(
        Home::where('attribute', 'featured_products')->value('value'),true
    )?? [];

    $products = Product::whereIn('id', $productIds)->get();

    return view('pages.home', compact(
        'name',
        'logo',
        'products'
    ));
}
public function create()
{
    $products = Product::all();

    $featuredProducts = json_decode(
        Home::where('attribute', 'featured_products')->value('value'),
        true
    ) ?? [];

    $name = Home::where('attribute', 'website_name')->value('value');
    $logo = Home::where('attribute', 'logo')->value('value');

    return view('pages.home', compact(
        'products',
        'featuredProducts',
        'name',
        'logo'
    ));
}

public function store(Request $request)
{

    $request->validate([
        'website_name' => 'required',
        'logo' => 'nullable|image',
        'featured_products' => 'required|array',
        'intro'=>'required|string',
        'description'=>'required|string'
    ]);

    Home::updateOrCreate(
        ['attribute' => 'website_name'],
        ['value' => $request->website_name]
    );

    Home::updateOrCreate(
        ['attribute' => 'featured_products'],
        ['value' => json_encode($request->featured_products)]
    );
    Home::updateOrCreate(
        ['attribute' => 'intro'],
        ['value' => $request->intro]
    );
    Home::updateOrCreate(
        ['attribute' => 'description'],
        ['value' => $request->description]
    );

    if ($request->hasFile('logo')) {

        $path = $request->file('logo')->store('logos', 'public');

        Home::updateOrCreate(
            ['attribute' => 'logo'],
            ['value' => $path]
        );
    }

    return back();
}

    public function storeAbout(Request $request){
        $request->validate([
        'story' => 'required',
        'info' => 'required',
        'mission' => 'required',
        'vision' => 'required',
        'values' => 'required',
    ]);

    Home::updateOrCreate(
        ['attribute' => 'story'],
        ['value' => $request->story]
    );
    Home::updateOrCreate(
        ['attribute' => 'info'],
        ['value' => $request->info]
    );
    Home::updateOrCreate(
        ['attribute' => 'mission'],
        ['value' => $request->mission]
    );
    Home::updateOrCreate(
        ['attribute' => 'vision'],
        ['value' => $request->vision]
    );
    Home::updateOrCreate(
        ['attribute' => 'values'],
        ['value' => $request->values]
    );

    return back();
    }

    public function about(){
    return view('pages.about');
    }
    public function setting(){
            $products = Product::all();

    $featuredProducts = json_decode(
        Home::where('attribute', 'featured_products')->value('value'),
        true
    ) ?? [];
        $name = Home::where('attribute', 'website_name')->value('value');
    $intro = Home::where('attribute', 'intro')->value('value');
    $story = Home::where('attribute', 'story')->value('value');
    $info = Home::where('attribute', 'info')->value('value');
    $mission = Home::where('attribute', 'mission')->value('value');
    $vision = Home::where('attribute', 'vision')->value('value');
    $values = Home::where('attribute', 'values')->value('value');
    $des = Home::where('attribute', 'description')->value('value');
    $logo = Home::where('attribute', 'logo')->value('value');
    return view('pages/admin/home_settings',compact(
        'name',
        'logo',
        'mission',
        'vision',
        'values',
        'info',
        'story',
        'featuredProducts',
        'products',
        'des',
        'intro',
    ));
    }
    public function addP(){
        return view('pages/admin/products',[
            'categories'=>Category::all(),
            'materials'=>Material::all(),
        ]);
}
}