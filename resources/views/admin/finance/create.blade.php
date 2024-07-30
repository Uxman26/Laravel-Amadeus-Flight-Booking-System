@extends('layouts.app')
@section('head')
@livewireStyles
@livewireStyles
@powerGridStyles
@endsection
@section('content')
@include('inc.admin.nav')
<section class="dashboard-area">
    <div class="dashboard-content-wrap">

        <div class="dashboard-bread">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="breadcrumb-content">
                            <div class="section-heading">
                                <h2 class="sec__title font-size-30 text-white mb-4">Finance Section</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 responsive-column--m">
                        <div class="form-box dashboard-card">
                            <div class="form-title-wrap">
                                <div class="">
                                    <h3 class="title">Finance Management</h3>
                                </div>
                            </div>
                            <div class="form-content p-2">
                                <div class="list-group drop-reveal-list">
                                    <div class="col-md-6 mx-auto">
                                        <form action="{{ route('admin.finance.store') }}" method="POST">
                                            @csrf
                                            <div class="form-group mb-2">
                                                <label for="user_id">Select Account</label>
                                                <select name="user_id" id="user_id" class="form-control">
                                                    @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mb-2 d-none" id="iataFranchise">
                                                <label for="iata">Iata Franchise</label>
                                                <select name="iata" id="iata" class="form-control">
                                                    <option value="">Select Franchise</option>
                                                    <option value="FR">FR</option>
                                                    <option value="CA">CA</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="sum">Payment Type</label>
                                                <select name="sum" id="sum" class="form-control">
                                                    <option value="0">Debit</option>
                                                    <option value="1" selected>Credit</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="amount">Amount</label>
                                                <input type="text" name="amount" class="form-control" placeholder="Amount">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="type">Payment Type</label>
                                                <select name="type" id="type" class="form-control">
                                                    <option value="Payment" selected>Payment</option>
                                                    <option value="Refund">Refund</option>
                                                    <option value="Paid">Paid</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="pnr">PNR #</label>
                                                <input type="text" name="pnr" class="form-control" placeholder="PNR Number">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
                                            </div>
                                            <div class="form-group mb-2">
                                                <button type="submit" class="btn btn-primary btn-large">Add Transaction</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="border-top mt-4"></div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('footer')
@livewireScripts
@powerGridScripts
<script>
    var user_id = document.getElementById('user_id');
    var iataFranchise = document.getElementById('iataFranchise');

    user_id.addEventListener('change', function() {
        if (user_id.value == 4) {
            iataFranchise.classList.remove('d-none');
        } else {
            iataFranchise.classList.add('d-none');
        }
    });
</script>
@endsection