<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = DB::table('sliders')->get();
        $users = DB::table('users')->select('id', 'name')->get();

        return view('admin.slider.index', compact('sliders', 'users'));
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
        $validator = Validator::make($request->all(), [
        'title' => 'required|max:20',
        'image' => 'required|mimes:png,jpg|max:2048|dimensions:min_width=1920,min_height=1080,max_width=1920,max_height=1080',
        ], [
            'image.dimensions' => 'Image resolution must be 1920*1080'
        ]);

        // If validation fails — redirect back with slider ID
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('form', 'create');
        }


        $img = time() . '.' . $request->image->getClientOriginalExtension();
        $path = 'images/sliders/';

        DB::table('sliders')->insert([
            'title' => $request->title,
            'image' => $path . $img,
            'added_by_id' => Auth::user()->id
        ]);

        $request->image->move(public_path($path), $img);

        return redirect()->back()->with('success', 'Slider Added successfully.');
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
        $validator = Validator::make($request->all(), [
        'title' => 'required|max:20',
        'image' => 'required|mimes:png,jpg|max:2048|dimensions:min_width=1920,min_height=1080,max_width=1920,max_height=1080',
        ], [
            'image.dimensions' => 'Image resolution must be 1920*1080'
        ]);

        // If validation fails — redirect back with slider ID
        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->with('edit_slider_id', $id);
        }

        // delete existing image file

        $oldImg = DB::table('sliders')->where('id', $id)->first();

        if ($oldImg) {
            // Build the full path to the image
            $imagePath = public_path($oldImg->image);

            // Check if the file exists before deleting
            if (!empty($oldImg->image) && File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $img = time() . '.' . $request->image->getClientOriginalExtension();
        $path = 'images/sliders/';

        DB::table('sliders')->where('id', $id)->update([
            'title' => $request->title,
            'image' => $path . $img,
            'updated_by_id' => Auth::user()->id
        ]);

        $request->image->move(public_path($path), $img);

        return redirect()->back()->with('success', 'Slider Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Fetch the image path from DB first
        $slider = DB::table('sliders')->where('id', $id)->first();


        if ($slider) {
            // Build the full path to the image
            $imagePath = public_path($slider->image);

            // Check if the file exists before deleting
            if (!empty($slider->image) && File::exists($imagePath)) {
                File::delete($imagePath);
            }

            // Delete the record from database
            DB::table('sliders')->where('id', $id)->delete();

            return redirect()->back()->with('success', 'Slider deleted successfully.');
        }

        return redirect()->back()->with('error', 'Slider not found.');
    }
}
