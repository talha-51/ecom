<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = DB::table('brands')->get();
        $users = DB::table('users')->select('id', 'name')->get();

        return view('admin.brand.index', compact('brands', 'users'));
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
            'image' => 'required|mimes:png,jpg,webp|max:2048|dimensions:min_width=1920,min_height=1080,max_width=1920,max_height=1080',
            ], [
                'image.dimensions' => 'Image resolution must be 1920*1080'
        ]);

        $img = time() . '.' . $request->image->getClientOriginalExtension();
        $path = 'images/brands/';

        DB::table('brands')->insert([
            'name' => $request->name,
            'image' => $path . $img,
            'added_by_id' => Auth::user()->id
        ]);

        $request->image->move(public_path($path), $img);

        return redirect()->back()->with('success', 'Brand Added successfully.');
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
        $brand = DB::table('brands')->where('id', $id)->first();

        return view('admin.brand.edit')->with('brand', $brand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:20',
            'image' => 'nullable|mimes:png,jpg,webp|max:2048|dimensions:min_width=1920,min_height=1080,max_width=1920,max_height=1080',
            ], [
                'image.dimensions' => 'Image resolution must be 1920*1080'
        ]);

        if ($request->hasFile('image')) {
        // delete old image and upload new one
            $oldImg = DB::table('brands')->where('id', $id)->first();

            if ($oldImg) {
                // Build the full path to the image
                $imagePath = public_path($oldImg->image);

                // Check if the file exists before deleting
                if (!empty($oldImg->image) && File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            $img = time() . '.' . $request->image->getClientOriginalExtension();
            $path = 'images/brands/';

            DB::table('brands')->where('id', $id)->update([
                'name' => $request->name,
                'image' => $path . $img,
                'updated_by_id' => Auth::user()->id
            ]);

            $request->image->move(public_path($path), $img);
        }
        else
        {
            DB::table('brands')->where('id', $id)->update([
                'name' => $request->name,
                'updated_by_id' => Auth::user()->id
            ]);
        }

        return redirect()->route('brand.index')->with('success', 'Brand Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Fetch the image path from DB first
        $brand = DB::table('brands')->where('id', $id)->first();


        if ($brand) {
            // Build the full path to the image
            $imagePath = public_path($brand->image);

            // Check if the file exists before deleting
            if (!empty($brand->image) && File::exists($imagePath)) {
                File::delete($imagePath);
            }

            // Delete the record from database
            DB::table('brands')->where('id', $id)->delete();

            return redirect()->back()->with('success', 'Brand deleted successfully.');
        }

        return redirect()->back()->with('error', 'Brand not found.');
    }
}
