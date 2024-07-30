<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banner = Banner::join('users', 'banners.user_id', '=', 'users.id')
                ->select('banners.*', 'users.name as user_name')
                ->where('banners.user_id', auth()->user()->id)
                ->get();
        return view('admin.banner.index', ['banner' => $banner]);
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
            'image' => 'image|mimes:jpeg,png,gif,svg',
			'logo_image' => 'image|mimes:jpeg,png,gif,svg'
        ]);

        if ($banner = $request->file('image')) {
            // Define upload path
            $destinationPath = public_path('/assets/banner'); // upload path
            // Upload Original Image
            $image = date('YmdHis') . "." . $banner->getClientOriginalExtension();
            $banner->move($destinationPath, $image);
        }
		
		if ($logo = $request->file('logo_image')) {
            // Define upload path
            $destinationPath = public_path('/assets/logo'); // upload path
            // Upload Original Image
            $logo_image = date('YmdHis') . "." . $logo->getClientOriginalExtension();
            $logo->move($destinationPath, $logo_image);
        }

        $slider = new Banner();
        $slider->user_id = auth()->user()->id;
        if($request->hasFile('image')){
            $slider->image = $image;
        }
        if($request->hasFile('logo_image')){
            $slider->logo_image = $logo_image;
        }
        $slider->ishidden = 0;
        $slider->save();

        return back()->with('success', 'Slider Image Added Successfully');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::find($id);
        $banner->delete();

        return back()->with('success', 'Banner is deleted successfully');
    }
}
