<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = DB::table('orders')->get();
        $users = DB::table('users')->select('id', 'name')->get();

        return view('admin.order.index', compact('orders', 'users'));
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
        $orderItems = DB::table('order_items')->where('order_id', $id)->get();
        $products = DB::table('products')->select('id', 'name')->get();

        return view('admin.order.details', compact('orderItems', 'products'));
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
        DB::table('orders')->where('id', $id)->update([
            'status' => $request->status,
            'updated_at' => now()
        ]);

        return back()->with('success', 'Delivery status changed');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('order_items')->where('order_id', $id)->delete();
        DB::table('orders')->where('id', $id)->delete();

        return back()->with('success', 'Order removed.');
    }
}
