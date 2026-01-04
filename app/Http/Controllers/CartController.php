<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartProducts = DB::table('carts')->where('user_id', Auth::id())->get();
        $products = DB::table('products')->select('id', 'name', 'image')->get();
        $cartCount = DB::table('carts')->where('user_id', Auth::id())->count();

        $categories = DB::table('categories')->get();

        return view('home.cart.index', compact('cartProducts', 'products', 'cartCount','categories'));
    }

    // Add to Cart
    public function addToCart($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        $cartItem = DB::table('carts')->where('user_id', Auth::id())->where('product_id', $id)->first();

        if(!$cartItem)
        {
            DB::table('carts')->insert([
                'user_id' => Auth::user()->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'unit_price' => $product->price,
                'total_price' => $product->price,
                'created_at' => now(),
            ]);
        }
        else
        {
            DB::table('carts')->update([
                'quantity' => $cartItem->quantity + 1,
                'total_price' => ($cartItem->quantity + 1) * $cartItem->unit_price,
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    // change product quantity
    public function updateCart(Request $request, $id)
    {
        $cart = DB::table('carts')->where('id', $id)->first();

        DB::table('carts')->where('id', $id)->update([
            'quantity' => $request->quantity,
            'total_price' => $request->quantity * $cart->unit_price
        ]);

        return back()->with('success', 'Product quantity Changed!');
    }

    // delete cart-item
    public function deleteItem($id)
    {
        DB::table('carts')->where('id', $id)->delete();

        return back()->with('success', 'Item removed from the cart!');
    }

    public function checkout()
    {
        $cartProducts = DB::table('carts')->where('user_id', Auth::id())->get();
        $products = DB::table('products')->select('id', 'name', 'image')->get();
        $categories = DB::table('categories')->get();

        $cartCount = DB::table('carts')->where('user_id', Auth::id())->count();

        return view('home.cart.checkout', compact('cartProducts', 'products','categories', 'cartCount'));
    }

    // one-page-checkout
    public function onepagecheckout($id)
    {
        // add-to-cart
        $product = DB::table('products')->where('id', $id)->first();

        DB::table('carts')->insert([
            'user_id' => Auth::user()->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'unit_price' => $product->price,
            'total_price' => $product->price,
            'created_at' => now(),
        ]);

        return redirect()->route('cart.checkout');
    }

    public function confirmOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|max:20',
            'email' => 'required|max:50',
            'phone_number' => 'required|min:11',
            'address' => 'required|max:100',
            'delivery_fee' => 'required|max:5',
            'sub_total' => 'required',
            'grand_total' => 'required',
        ]);

        // STEP 1: Insert main order row
        $orderId = DB::table('orders')->insertGetId([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'delivery_fee' => $request->delivery_fee,
            'sub_total' => $request->sub_total,
            'grand_total' => $request->grand_total,
            'status' => 'pending',
            'created_at' => now(),
        ]);

        // STEP 2: Insert each product into order_items
        foreach ($request->product_id as $index => $productId) {
            DB::table('order_items')->insert([
                'order_id' => $orderId,
                'product_id' => $productId,
                'quantity' => $request->quantity[$index],
                'unit_price' => $request->unit_price[$index],
                'total_price' => $request->total_price[$index],
                'created_at' => now(),
            ]);
        }

        DB::table('carts')->where('user_id', Auth::user()->id)->delete();

        return redirect()->route('home.index')->with('success', 'Order Complete!');
    }
}
