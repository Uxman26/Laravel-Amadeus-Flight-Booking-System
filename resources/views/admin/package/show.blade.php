<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $package->pnr }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        ul {
            list-style-type: none;
        }

        p {
            margin-bottom: 0;
        }

        .notice-text {
            font-size: 10px;
        }

        ul {
            padding: 0;
            margin: 0;
        }

        .table12 {
            padding: 10x !important;
            border-bottom-width: 1px !important;
        }

        .th {
            width: 140px !important;
        }

        .top-text {
            margin-top: 0%;
            text-align: right;
            margin-left: -15%;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <h5>{{ $package->name }} - Formule Pas Chere</h5>
            </div>
            <div class="col-md-6">
                <img style="filter: grayscale(100%);" src="{{ asset('assets/img/logo-old1.png') }}" width="300"
                    alt="Logo"> 
            </div>
            <div class="col-md-6 text-center">
                <div style="margin-left: 50%; margin-top: 0px">
                    <h4>Status</h4>
                    <h3>
                        @if ($packageBooking->status == 'confirm')
                            Confirmed
                        @elseif($packageBooking->status == 'cancel')
                            Cancelled
                        @else
                            PreReservation
                        @endif
                    </h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>
                                <h3>GUR ELEC (GONDAL ) </h3>
                                <p>89 Avenue du Groupe Manouchian</p>
                                <p>94400 Vitry - sur- Seine</p>
                                <p>Telephone: +33 187653786</p>
                                <p>Email: hello@gondaltravel.com</p>
                            </td>
                            <td class="border">
                                <h3>Adresse de facturation</h3>
                                <p>Name: {{ $packageBooking->first_name }} {{ $packageBooking->last_name }}</p>
                                <p>Address: {{ $packageBooking->address }}</p>
                                <p>Telephone: {{ $packageBooking->phone_number }}</p>
                                <p>Email: {{ $packageBooking->email }}</p>

                            </td>
                        </tr>
                    </tbody> 
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <tr>
                            <th colspan="2" class="text-center">
                                References
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <ul>
                                    <li>
                                        <b> FACTURE : </b> {{ $packageBooking->invoice_no }}
                                    </li>
                                    <li>
                                        <b>Vendeur Conseil : </b>
                                        @if ($packageBooking->user)
                                            {{ $packageBooking->user->name }}
                                        @endif
                                    </li>
                                    <li>
                                        <b>Modes de paiement : </b> {{ $packageBooking->payment_method }}
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li>
                                        <b> Date de depart :
                                             </b> {{ \Carbon\Carbon::parse($package->departure)->format('d/M/Y') }}
                                    </li>
                                    <li>
                                        <b> Date de Retour :
                                            </b> @if(isset($package->return)) {{ \Carbon\Carbon::parse($package->return)->format('d/M/Y') }} @else --- @endif
                                    </li>
                                    <li>

                                        <b> Pays : </b>FRANCE
                                    <li>
                                        <b> Devise : </b>EUR
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <tr>
                            <th>Organisme</th>
                            <th>Services</th>
                            <th>Montant</th>
                        </tr>
                        @php
                            $text = strtolower($packageBooking->rooms) . '_room_price';
                        @endphp
                        <tr>
                            <td style="width:20%;">
                                <ul>
                                    <li>Mecca Hotel: {{ $package->mecca_hotel }}</li>
                                    <li>Madina Hotel: {{ $package->madina_hotel }}</li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li>Passengers: {{ $packageBooking->adults ?? 0 }} Adult
                                        {{ $packageBooking->childrens ?? 0 }} Childrens
                                        {{ $packageBooking->infants ?? 0 }} Infant</li>
                                    <li>Length of stay:
                                        {{ \Carbon\Carbon::parse($package->departure)->diffInDays(\Carbon\Carbon::parse($package->return)) }}
                                        Days</li>

                                    <li>Taxes(*) aeriennes et surcharge carburant : 0000 EUR</li>
                                </ul>
                            </td>
                            <td>
                                {{ $packageBooking->price ?? 0 }} EUR
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-end p-1">total des prestations: </th>
                            <td class="p-1">{{ $packageBooking->price ?? 0 }} EUR</td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-end p-1">Solde a payer: </th>
                            <td class="p-1">{{ $packageBooking->received ?? 0 }} EUR</td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-end p-1">Le montant restant: </th>
                            <td class="p-1">{{ $packageBooking->remaining ?? 0 }} EUR</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-end text-right">
                <p>Solde a regler pour le = {{ now()->parse($packageBooking->created_at)->format('d-M-y') }}</p>
            </div>
        </div>
        <div class="row justify-content-end me-5">
            <div class="col-md-7">
                <div class="top-text" style="margin-bottom:40px;">
                    <p class="text-start notice-text">(*) en cas d'annulation du transport, une partie des taxes est
                        eligible au remboursement</p>
                    <p class="text-start notice-text">(*)Les conditions de changement de date, annulation ou toute autre
                        demande entrainera des frais supplémentaire. </p>
                </div>
            </div>
            <div class="col-md-4">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th colspan="4" class="text-center">
                                Recapitulatif TVA
                            </th>
                        </tr>

                        <tr>
                            <th px-1 class="th">Taux</th>
                            <th px-1 class="th">Mnt HT</th>
                            <th px-1 class="th">Mnt TVA</th>
                            <th px-1 class="th">Mnt TTC</th>
                        </tr>

                        <tr>
                            <td>0.00%</td>
                            <td>{{ number_format($packageBooking->received, 2) }} EUR</td>
                            <td>0.00</td>
                            <td>{{ number_format($packageBooking->received, 2) }} EUR</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">

                    <h5 class="mb-0">Merci d'avoir choisi GondalTravel.com</h5>
                    <p class="notice-text">SASU GUR ELEC-Siret : 90305898000017 - Email : hello@gondaltravel.com</p>
                    <p class="notice-text"><a href="#">www.gondaltravel.com</a></p>
                    <p class="notice-text">Code Naf : 4778C - TVA Intracommunautair : FR 29 903058980* Adress 89 AV DU
                        GROUPE MANOUCHIAN 94400 VITRY-SUR-SEINE</p>
                </div>
            </div>
        </div>
        </div>
</body>

</html>
