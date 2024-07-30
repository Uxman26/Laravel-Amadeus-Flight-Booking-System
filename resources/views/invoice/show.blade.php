<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $booking->pnr }}</title>
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
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <img style="filter: grayscale(100%);" src="{{ asset('assets/img/logo.png') }}" width="200"
                    alt="Logo">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td>
                                <h3>GUR ELEC (GONDAL ) </h3>
                                <p>89 Avenue du Groupe Manouchian</p>
                                <p>94400 Vitry - sur- Seine</p>
                                <p>Telephone: +33 187653786</p>
                                <p>Email: hello@gondaltravel.com</p>
                            </td>
                            <td>
                                <h3>Adresse de facturation</h3>
                                <p>{{ $booking->passengers[0]->firstname }} {{ $booking->passengers[0]->lastname }}</p>
                                <p>Email: {{ $booking->email }}</p>
                                <p>Telephone: {{ $booking->phone }}</p>
                                <p>Country: {{ $booking->passengers[0]->nationality }}</p>
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
                                        <b> FACTURE : </b> {{ $booking->pnr }}
                                    </li>
                                    <li>
                                        <b>Commande : </b> GT10{{ $booking->id }}G
                                    </li>
                                    <li>
                                        <b>Vendeur Conseil : </b> {{ $booking->user->name }}
                                    </li>
                                    <li>
                                        <b>Modes de paiement : </b> {{ $booking->payment_method }}
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li>
                                        <b> Date de depart : </b>
                                        {{ getFullDate(json_decode($booking->routes)->itineraries[0]->segments[0]->departure->at) }}
                                    </li>
                                    <li>
                                        <b> Date de Retour : </b>
                                        @if($booking->trip_type == 'oneway') ----- @else
                                        {{ getFullDate(json_decode($booking->routes)->itineraries[1]->segments[0]->departure->at) }}  @endif
                                    </li>
                                    <li>

                                        <b> Pays : </b>
                                        {{ findCountryName(json_decode($booking->routes)->itineraries[0]->segments[0]->departure->iataCode) }}
                                    </li>
                                    <li>
                                        <b> Devise : </b> {{ json_decode($booking->routes)->price->currency }}
                                    </li>
                                    <li>
                                        <b> PNR : </b> {{ $booking->pnr }}
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
                        <tr>
                            <td style="width:20%;">
                                <ul>
                                    <li>{{ findAirlineName(json_decode($booking->routes)->validatingAirlineCodes[0]) }}
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li>Passager: {{ $booking->passengers[0]->firstname }}
                                        {{ $booking->passengers[0]->lastname }}</li>
                                    <li>billet: </b> {{ $booking->pnr }} - </li>
                                    <li>
                                        @foreach (json_decode($booking->routes)->itineraries as $segments)
                                            {{ findCityName($segments->segments[0]->departure->iataCode) }}
                                        @endforeach
                                        -
                                        @foreach (json_decode($booking->routes)->itineraries as $segments)
                                            {{ findCityName(end($segments->segments)->arrival->iataCode) }}
                                        @endforeach
                                    </li>
                                    <li>TICKET {{ $booking->passengers[0]->etkt }}</li>
                                    <li>Taxes(*) aeriennes et surcharge carburant : 0000 EUR</li>
                                </ul>
                            </td>
                            <td>
                                {{ $booking->agent_margin }} €
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-end p-1">total des prestations:</th>
                            <td class="p-1">{{ $booking->agent_margin }} €</td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-end p-1">Solde a payer: </th>
                            <td class="p-1">{{ number_format($booking->received, 2) }} €</td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-end p-1">Le montant restant: </th>
                            <td class="p-1">{{ $booking->agent_margin - $booking->received }} €</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-end text-right">
                <p>Solde a regler pour le = {{ now()->parse($booking->created_at)->format('d-M-y') }}</p>
            </div>
        </div>
        <div class="row justify-content-end">
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
                            <td>{{ number_format($booking->received, 2) }} €</td>
                            <td>0.00</td>
                            <td>{{ number_format($booking->received, 2) }} €</td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
</body>

</html>
