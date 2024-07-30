<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\PromotionNotification;
use App\Models\Slider;
use App\Models\News;
use App\Models\Banner;
use App\Models\Promotionmessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slides = Slider::join('users', 'sliders.user_id', '=', 'users.id')
                ->select('sliders.*', 'users.name as user_name')
                ->where('sliders.user_id', auth()->user()->id)
                ->get();
        return view('admin.slider.create', ['slides' => $slides]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $slides = Slider::join('users', 'sliders.user_id', '=', 'users.id')
                ->select('sliders.*', 'users.name as user_name')
                ->where('sliders.user_id', auth()->user()->id)
                ->get();
        return view('admin.slider.create', ['slides' => $slides]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,gif,svg',
            'promotext' => 'required',
            'slug' => 'required'
        ]);

        if ($files = $request->file('image')) {
            // Define upload path
            $destinationPath = public_path('/assets/slider'); // upload path
            // Upload Original Image
            $image = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $image);
        }

        $slug = trim(preg_replace('/-+/', '-', preg_replace('/[^a-z0-9\-]/', '', str_replace(' ', '-', strtolower($request->slug)))),'-');

        $slider = new Slider();
        $slider->user_id = auth()->user()->id;
        $slider->image = $image;
        $slider->promotext = $request->promotext;
        $slider->slug = $slug;
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
        $slider = Slider::find($id);
        $slider->delete();

        return back()->with('success', 'Slider is deleted successfully');
    }

    /**
     * Fetch the specified promotion form.
     */
    public function promotions(string $slug)
    {
        $promos = Slider::where('slug',$slug)->first();
        return ['promos' => $promos];
    }

    /**
     * Insert user information against the specified promotion.
     */
    public function savePromotionsInfo(Request $request)
    {
        $request->validate([
            'promo_id' => 'required|numeric',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required'
        ]);

        $promo = new Promotionmessage();
        $promo->promo_id = $request->promo_id;
        $promo->name = $request->name;
        $promo->email = $request->email;
        $promo->phone = $request->phone;
        $promo->message = $request->message;
        $promo->save();
        Mail::to($promo->email)->send(new PromotionNotification($promo));
        Mail::to('travelgondal@gmail.com')->send(new PromotionNotification($promo));
        return redirect()->route('index')->with('success', 'Thank you for your reservation. We will contact you shortly'); 
    }

    public function savePopInfo(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required'
        ]);

        $promo = new Promotionmessage();
        $promo->promo_id = 0;
        $promo->name = $request->name;
        $promo->email = $request->email;
        $promo->phone = $request->phone;
        $promo->message = $request->title.'---'.$request->message;
        $promo->save();
        Mail::to($promo->email)->send(new PromotionNotification($promo));
        Mail::to('travelgondal@gmail.com')->send(new PromotionNotification($promo));
        return redirect()->route('index')->with('success', 'Thank you for your reservation. We will contact you shortly'); 
    }
}
