<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\PackageBookingNotification;
use App\Models\Option;
use App\Models\Package;
use App\Models\PackageBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PackageController extends Controller
{
    public function index()
    {
        return view('admin.package.index');
    }
    public function packageBooking()
    {
        return view('admin.package.packageBooking');
    }
    public function view(Request $request)
    {
        $package = Package::findOrFail($request->id);
        $color = Option::where('key', 'themecolor')->first()->value;
        return view('admin.package.view', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.package.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $from_date = Carbon::parse($request->departure);
        $through_date = Carbon::parse($request->arrival);
        $shift_difference = $from_date->diffInDays($through_date);

        $package = new Package();
        $package->name = $request->name;
        $package->period = $shift_difference;
        $package->single_room_price = $request->single_room_price;
        $package->double_room_price = $request->double_room_price;
        $package->triple_room_price = $request->triple_room_price;
        $package->quadruple_room_price = $request->quadruple_room_price;
        $package->children_price_deduction = $request->children_price_deduction;
        $package->infant_price = $request->infant_price;   
        $package->mecca_hotel = $request->mecca_hotel;
        $package->madina_hotel = $request->madina_hotel;
        $package->departure = $request->departure;
        $package->return = $request->return;
        $package->description = $request->description;
        if (isset($request->image)) {
            $file = request()->file('image');
            $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
            $file->move('assets/images/packages/', $filename);
            $image = 'assets/images/packages/' . $filename;
            $package->image = $image;
        }
        $package->status = 1;
        $package->save();

        return redirect()->route('admin.package.index')->with('success', 'Package is saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function invoice(Request $request, $id, $packageBooking, $number)
    {
        $package = Package::findOrFail($id);
        $packageBooking = PackageBooking::findOrFail($packageBooking);
        $color = Option::where('key', 'themecolor')->first()->value;
        return view('admin.package.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(string $id)
    {
    }
    public function edit($id)
    {
        $package = Package::find($id);
        return view('admin.package.edit', get_defined_vars());
    }
    public function booking(Request $request)
    {
        $package = Package::findOrFail($request->id);
        return view('admin.package.booking', get_defined_vars());
    }
    public function store_booking(Request $request)
    {
        if ($request->checkbox == 'on') { 
        $packageBooking = new PackageBooking();
        $packageBooking->package_id = $request->id;
        $packageBooking->first_name = $request->first_name;
        $packageBooking->last_name = $request->last_name;
        $packageBooking->phone_number = $request->phone_number;
        $packageBooking->email = $request->email;
        $packageBooking->address = $request->address;
        $packageBooking->nationality = $request->nationality;
        $packageBooking->rooms = $request->rooms;
        $packageBooking->adults = $request->adults;
        $packageBooking->childrens = $request->childrens;
        $packageBooking->infants = $request->infants;
        $packageBooking->price = $request->price;
        $packageBooking->remaining = $request->price;
        $packageBooking->invoice_no = strtoupper(substr(sha1(mt_rand()),17,6)); 
        $packageBooking->save();
        if (isset($packageBooking->email)) { 
            Mail::to($packageBooking->email)->send(new PackageBookingNotification($packageBooking));
        }
        Mail::to('travelgondal@gmail.com')->send(new PackageBookingNotification($packageBooking));
        return redirect()->route('admin.package.invoice',['id'=>$packageBooking->package_id, 'packageBooking'=> $packageBooking->id, 'number'=>$packageBooking->invoice_no])->with('success', 'Package Booking is saved successfully');
    } else {
        return redirect()->back()->with('error', 'Please Accept Terms & Conditions');
    }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_package(Request $request)
    {
        $from_date = Carbon::parse($request->departure);
        $through_date = Carbon::parse($request->arrival);
        $shift_difference = $from_date->diffInDays($through_date);

        $package = Package::findOrFail($request->id);
        $package->name = $request->name;
        $package->period = $shift_difference;
        $package->single_room_price = $request->single_room_price;
        $package->double_room_price = $request->double_room_price;
        $package->triple_room_price = $request->triple_room_price;
        $package->quadruple_room_price = $request->quadruple_room_price;
        $package->children_price_deduction = $request->children_price_deduction;
        $package->infant_price = $request->infant_price;
        $package->mecca_hotel = $request->mecca_hotel;
        $package->madina_hotel = $request->madina_hotel;
        $package->departure = $request->departure;
        $package->return = $request->return;
        $package->description = $request->description;
        if (isset($request->image)) {
            $file = request()->file('image');
            $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
            $file->move('assets/images/packages/', $filename);
            $image = 'assets/images/packages/' . $filename;
            $package->image = $image;
        }
        $package->status = 1;
        $package->save();

        return redirect()->route('admin.package.index')->with('success', 'Package is updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return back()->with('success', 'Package is deleted successfully');
    }
}
