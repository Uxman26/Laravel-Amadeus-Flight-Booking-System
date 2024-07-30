<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Slider;
use App\Models\Banner;
use App\Models\Option;
use App\Models\Package;
use Illuminate\Support\Facades\DB;

class FooterController extends Controller
{
     
    public function aboutus(){
        $news = News::all(); 
        $slides = Slider::all();
        $banner = Banner::where('ishidden' , '=', 0)->first();
        $settings = DB::table('footer_settings')->first();
        $color = Option::where('key','themecolor')->first()->value;
        $packages = Package::where('status', 1)->get();

        return view("footer.aboutus", ['color'=>$color,'packages'=>$packages,'news' => $news, 'slides' => $slides, 'banner' => $banner, 'settings' => $settings]);
    }

    public function privacy(){
        $news = News::all();
        $slides = Slider::all();
        $banner = Banner::where('ishidden' , '=', 0)->first();
        $settings = DB::table('footer_settings')->first();
        $color = Option::where('key','themecolor')->first()->value;
        $packages = Package::where('status', 1)->get();

        return view("footer.privacy", ['color'=>$color,'packages'=>$packages,'news' => $news, 'slides' => $slides, 'banner' => $banner, 'settings' => $settings]);
    }

}
