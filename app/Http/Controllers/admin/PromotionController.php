<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Promotionmessage;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promos = Promotionmessage::join('sliders', 'promotionmessages.promo_id', '=', 'sliders.id')
        ->select('promotionmessages.*', 'sliders.promotext as promotext', 'sliders.slug')
        ->get();
        $guests = Promotionmessage::where('promo_id', 0)->get();
        return view('admin.promostions.index', ['promos' => $promos, 'guests' => $guests]);
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
        $promo = Promotionmessage::find($id);
        $promo->delete();

        return back()->with('success', 'Promotion Message is deleted successfully');
    }

}
