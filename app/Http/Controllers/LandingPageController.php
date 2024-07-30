<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Slider;
use App\Models\Banner;
use App\Models\Option;
use App\Models\Package;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
	
	
	public function setCookie()
{
    // Create a response
    $response = new Response('Cookie set successfully');

    // Set the cookie with Secure and SameSite=None attributes
    $response->withCookie(cookie('yourCookieName', 'cookieValue', 60)
        ->secure(true) // This ensures the cookie is only sent over HTTPS
        ->samesite('none')); // This allows cross-site sharing

    return $response;
}
    public function index()
    {
        session()->forget('bookingData');
        $news = News::all();
        $packages = Package::where('status', 1)->get();
        $slides = Slider::all();
        $banner = Banner::where('ishidden' , '=', 0)->first();
		$settings = DB::table('footer_settings')->first();
        $color = Option::where('key','themecolor')->first()->value;
        return view("landing.index", ['color'=>$color,'packages'=>$packages,'news' => $news, 'slides' => $slides, 'banner' => $banner, 'settings' => $settings]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
