<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FooterController extends Controller
{
    public function settings(){
        $settings = DB::table('footer_settings')->first();
        return view("admin.footer.settings", ['settings' => $settings]);
    }

    public function saveSettings(Request $request){
        $request->validate([
            'facebook' => 'required',
            'twitter' => 'required',
            'whatsapp' => 'required',
            'instagram' => 'required',
            'policy' => 'required',
            'aboutus' => 'required'
        ]);

        DB::table('footer_settings')
            ->where('id', 1)
            ->update([
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'whatsapp' => $request->whatsapp,
                'instagram' => $request->instagram,
                'policy' => $request->policy,
                'aboutus' => $request->aboutus
            ]);

        return back()->with('success', 'Footer settings are saved successfully');
    }
}
