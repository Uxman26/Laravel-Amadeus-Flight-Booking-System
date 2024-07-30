<?php

namespace App\Http\Controllers\agent;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $to_date = Option::where('key', 'to_date')->first();
        if (!isset($to_date)) {
            $option = new Option;
            $option->key = 'to_date';
            $option->value = Carbon::now()->endOfMonth()->format('Y-m-d');
            $option->save();
            $option1 = new Option;
            $option1->key = 'from_date';
            $option1->value = Carbon::now()->startOfMonth()->format('Y-m-d');
            $option1->save();
        }
        if(isset($request->to) && isset($request->from)){
            Option::where('key', 'to_date')->update(['value'=> $request->to]);
            Option::where('key', 'from_date')->update(['value'=> $request->from]);
        } else {
            Option::where('key', 'to_date')->update(['value'=> Carbon::now()->endOfMonth()->format('Y-m-d')]);
            Option::where('key', 'from_date')->update(['value'=> Carbon::now()->startOfMonth()->format('Y-m-d')]);
        }

        return view('agent.dashboard.index', get_defined_vars());
    }
public function goto_nego(){
        return view('agent.dashboard.goto_nego');
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
