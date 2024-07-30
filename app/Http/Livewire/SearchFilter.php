<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Request;

use Livewire\Component;

class SearchFilter extends Component
{

    function mount(){
        info('Reaced');
    }

    public $includedAirlineCodes;

    function fetch()
    {
        // setting session with this airline code
        session(['includedAirlineCodes' => $this->includedAirlineCodes]);
        redirect(url()->previous());
    }


    function resetFilter()
    {
        // reset the flight code
        session()->forget('includedAirlineCodes');
        redirect(url()->previous());

    }


    public function render()
    {
        return view('livewire.search-filter');
    }
}
