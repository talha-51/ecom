<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = DB::table('sub_categories')->get();
        $categories = DB::table('categories')->get();
        $users = DB::table('users')->select('id', 'name')->get();

        return view('admin.subcategory.index', compact('subcategories', 'categories', 'users'));
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
            'image' => 'required|mimes:png,jpg,webp|max:2048|dimensions:min_width=500,min_height=500,max_width=500,max_height=500',
            ], [
                'image.dimensions' => 'Image resolution must be 500*500'
        ]);

        $img = time() . '.' . $request->image->getClientOriginalExtension();
        $path = 'images/sub-categories/';

        DB::table('sub_categories')->insert([
            'name' => $request->name,
            'cat_id' => $request->cat_id,
            'image' => $path . $img,
            'added_by_id' => Auth::user()->id
        ]);

        $request->image->move(public_path($path), $img);

        return redirect()->back()->with('success', 'Sub-Category Added successfully.');
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
        $subcategory = DB::table('sub_categories')->where('id', $id)->first();
        $categories = DB::table('categories')->get();

        return view('admin.subcategory.edit', compact('categories', 'subcategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'name' => 'required|max:20',
        'image' => 'nullable|mimes:png,jpg,webp|max:2048|dimensions:min_width=500,min_height=500,max_width=500,max_height=500',
        ], [
            'image.dimensions' => 'Image resolution must be 500*500'
        ]);

        if ($request->hasFile('image')) {
        // delete old image and upload new one
            $oldImg = DB::table('sub_categories')->where('id', $id)->first();

            if ($oldImg) {
                // Build the full path to the image
                $imagePath = public_path($oldImg->image);

                // Check if the file exists before deleting
                if (!empty($oldImg->image) && File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            $img = time() . '.' . $request->image->getClientOriginalExtension();
            $path = 'images/sub-categories/';

            DB::table('sub_categories')->where('id', $id)->update([
                'name' => $request->name,
                'cat_id' => $request->cat_id,
                'image' => $path . $img,
                'updated_by_id' => Auth::user()->id
            ]);

            $request->image->move(public_path($path), $img);
        }
        else
        {
            DB::table('sub_categories')->where('id', $id)->update([
                'name' => $request->name,
                'cat_id' => $request->cat_id,
                'updated_by_id' => Auth::user()->id
            ]);
        }

        return redirect()->route('sub-category.index')->with('success', 'Sub-Category Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Fetch the image path from DB first
        $subcategory = DB::table('sub_categories')->where('id', $id)->first();


        if ($subcategory) {
            // Build the full path to the image
            $imagePath = public_path($subcategory->image);

            // Check if the file exists before deleting
            if (!empty($subcategory->image) && File::exists($imagePath)) {
                File::delete($imagePath);
            }

            // Delete the record from database
            DB::table('sub_categories')->where('id', $id)->delete();

            return redirect()->back()->with('success', 'Sub-Category deleted successfully.');
        }

        return redirect()->back()->with('error', 'Sub-Category not found.');
    }
}
