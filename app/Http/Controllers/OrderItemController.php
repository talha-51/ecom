<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $orderItem = DB::table('order_items')->where('id', $id)->first();

        DB::table('order_items')->where('id', $id)->update([
            'quantity' => $request->quantity,
            'total_price' => $request->quantity * $orderItem->unit_price,
            'updated_at' => now()
        ]);

        $newSubTotal = DB::table('order_items')->where('order_id', $orderItem->order_id)->sum('total_price');

        $order = DB::table('orders')->where('id', $orderItem->order_id)->first();

        DB::table('orders')->where('id', $orderItem->order_id)->update([
            'sub_total' => $newSubTotal,
            'grand_total' => $newSubTotal + $order->delivery_fee,
        ]);

        return back()->with('success', 'Product quantity changed!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $orderItem = DB::table('order_items')->where('id', $id)->first();

        DB::table('order_items')->where('id', $id)->delete();

        $newSubTotal = DB::table('order_items')->where('order_id', $orderItem->order_id)->sum('total_price');

        $order = DB::table('orders')->where('id', $orderItem->order_id)->first();

        DB::table('orders')->where('id', $orderItem->order_id)->update([
            'sub_total' => $newSubTotal,
            'grand_total' => $newSubTotal + $order->delivery_fee,
        ]);

        return back()->with('success', 'Product removed!');
    }
}
