<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = DB::table('products')->get();
        $categories = DB::table('categories')->get();
        $subcategories = DB::table('sub_categories')->get();
        $brands = DB::table('brands')->get();
        $users = DB::table('users')->select('id', 'name')->get();

        return view('admin.product.index', compact('subcategories', 'categories', 'products', 'users', 'brands'));
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
        $request->validate([
            'name' => 'required|max:20',
            'price' => 'required|max:4',
            'quantity' => 'required|max:3',
            'image' => 'required|mimes:png,jpg,webp|max:2048|dimensions:min_width=500,min_height=500,max_width=500,max_height=500',
            ], [
                'image.dimensions' => 'Image resolution must be 500*500'
        ]);

        $img = time() . '.' . $request->image->getClientOriginalExtension();
        $path = 'images/products/';

        DB::table('products')->insert([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'image' => $path . $img,
            'cat_id' => $request->cat_id,
            'sub_id' => $request->sub_id,
            'brand_id' => $request->brand_id,
            'added_by_id' => Auth::user()->id
        ]);

        $request->image->move(public_path($path), $img);

        return redirect()->back()->with('success', 'Product Added successfully.');
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
        $product = DB::table('products')->where('id', $id)->first();
        $categories = DB::table('categories')->get();
        $subcategories = DB::table('sub_categories')->get();
        $brands = DB::table('brands')->get();

        return view('admin.product.edit', compact('categories', 'subcategories', 'product', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:20',
            'price' => 'required|max:4',
            'quantity' => 'required|max:3',
            'image' => 'nullable|mimes:png,jpg,webp|max:2048|dimensions:min_width=500,min_height=500,max_width=500,max_height=500',
            ], [
                'image.dimensions' => 'Image resolution must be 500*500'
        ]);

        if ($request->hasFile('image')) {
        // delete old image and upload new one
            $oldImg = DB::table('products')->where('id', $id)->first();

            if ($oldImg) {
                // Build the full path to the image
                $imagePath = public_path($oldImg->image);

                // Check if the file exists before deleting
                if (!empty($oldImg->image) && File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            $img = time() . '.' . $request->image->getClientOriginalExtension();
            $path = 'images/products/';

            DB::table('products')->where('id', $id)->update([
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'image' => $path . $img,
                'cat_id' => $request->cat_id,
                'sub_id' => $request->sub_id,
                'brand_id' => $request->brand_id,
                'updated_by_id' => Auth::user()->id
            ]);

            $request->image->move(public_path($path), $img);
        }
        else
        {
            DB::table('products')->where('id', $id)->update([
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'cat_id' => $request->cat_id,
                'sub_id' => $request->sub_id,
                'brand_id' => $request->brand_id,
                'updated_by_id' => Auth::user()->id
            ]);
        }

        return redirect()->route('product.index')->with('success', 'Product Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Fetch the image path from DB first
        $product = DB::table('products')->where('id', $id)->first();


        if ($product) {
            // Build the full path to the image
            $imagePath = public_path($product->image);

            // Check if the file exists before deleting
            if (!empty($product->image) && File::exists($imagePath)) {
                File::delete($imagePath);
            }

            // Delete the record from database
            DB::table('products')->where('id', $id)->delete();

            return redirect()->back()->with('success', 'Product deleted successfully.');
        }

        return redirect()->back()->with('error', 'Product not found.');
    }
}
