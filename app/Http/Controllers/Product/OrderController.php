<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Order;
use App\Models\OrderItem;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages/order',[
            'orders' => Auth::user()
                ->orders()
                ->orderByRaw("CASE WHEN status = 'Pending' THEN 0 ELSE 1 END")
                ->orderByDesc('created_at')
                ->get(),
                'materials'=>Material::all(),
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
        
    }

    /**
     * Display the specified resource.
     */
    public function delivery(Order $order)
    {
        $order->status=Status::DELIVERY;
        $order->save();

        return response()->json(
            [
                'success'=>true,
                'status'=>$order->status
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, Order $order)
{
    $request->validate([
        'items' => 'required|array',
        'items.*.quantity' => 'nullable|integer|min:1',
        'items.*.material' => 'nullable|exists:materials,id',
    ]);

    foreach ($request->items as $itemId => $data) {

        $item = $order->items()
            ->where('id', $itemId)
            ->firstOrFail();

        $updateData = [];

        // update quantity only if provided
        if (isset($data['quantity'])) {
            $updateData['quantity'] = $data['quantity'];
        }

        // update material only if provided
        if (isset($data['material'])) {
            $updateData['material_id'] = $data['material'];
        }

        // only run update if something changed
        if (!empty($updateData)) {
            $item->update($updateData);
        }
    }

    $order->update([
        'status' => Status::PAID,
    ]);

    return redirect()->back();
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderItem $order,Request $request)
    {
        $order->update([
            'soft_delete'=>$request->soft_delete,
        ]);
       
        return redirect()->back()->with('success','Product removed from cart successfully');
    }
}
