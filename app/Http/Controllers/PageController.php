<?php

namespace App\Http\Controllers;

use App\Models\Home;
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
    ]);

    Home::updateOrCreate(
        ['attribute' => 'website_name'],
        ['value' => $request->website_name]
    );

    Home::updateOrCreate(
        ['attribute' => 'featured_products'],
        ['value' => json_encode($request->featured_products)]
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
    public function about(){
    return view('pages.about');
    }
}
