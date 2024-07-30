<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;

class ApiConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.api.index');
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
        $validatedData = $request->validate([
            'ApiLiveMode' => 'nullable',
            'ApiLiveBooking' => 'nullable',
            'ApiEnterpiseMode' => 'nullable',
            'paginate_50' => 'nullable',
        ]);

        $option = Option::where('key', 'enterprise_api')->first();
        $option->value = (isset($validatedData['ApiEnterpiseMode']) == "on") ? true : false;
        $option->save();
        
        $option = Option::where('key', 'live_api')->first();
        $option->value = (isset($validatedData['ApiLiveMode']) == "on") ? true : false;
        $option->save();

        $option = Option::where('key', 'live_booking')->first();
        $option->value = (isset($validatedData['ApiLiveBooking']) == "on") ? true : false;
        $option->save();

        $option = Option::where('key', 'paginate_50')->first();
        $option->value = (isset($validatedData['paginate_50']) == "on") ? true : false;
        $option->save();


        return back()->with('success', 'Api Status Updated Successfully');
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
