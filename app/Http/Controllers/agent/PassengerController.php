<?php

namespace App\Http\Controllers\agent;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class PassengerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('agent.passenger.index');
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
    public function show($id)
    {
        $booking = Booking::find($id);
        return view('agent.passenger.show', compact('booking'));
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
