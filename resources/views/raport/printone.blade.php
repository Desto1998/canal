<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport canal GETEL SARL</title>
{{--    <link rel="stylesheet" href="{{ asset('css/app.css') }}">--}}
{{--    <link href={{ asset('css/sb-admin-2.min.css') }} rel="stylesheet">--}}
</head>
<body>
<div class="card shadow mb-4">

    <div class="card-body">
        <table cellspacing="2"  bgcolor="#000000" width="100%" id="table">
            <tr style="text-transform: uppercase; text-align: center">
                <td colspan="7" bgcolor="#ffffff">
                    <strong>
                        <h3>
                            Rapport hedomadaires canal<span class="h2">+</span> de: {{ $user->name }}
                        </h3>
                    </strong>
                </td>
            </tr>
            <tr style="font-size: 10px;font-weight: bold" class="-bold">
                <th bgcolor="#ffffff" style="padding: 3px">DATE</th>
                <th bgcolor="#ffffff" style="padding: 3px">ACTIVATION CASH</th>
                <th bgcolor="#ffffff" style="padding: 3px">ACTIVATION A CREDIT</th>
                <th bgcolor="#ffffff" style="padding: 3px">RECOUVREMENTS</th>
                <th bgcolor="#ffffff" style="padding: 3px">VENTE KITS</th>
                <th bgcolor="#ffffff" style="padding: 3px">VERSEMENTS</th>
                <th bgcolor="#ffffff" style="padding: 3px">ACHAT DES KITS</th>
                {{--                            <th>TOTAL JOUR</th>--}}
                {{--                            <th>CAISSE</th>--}}
            </tr>
            @php
                $TOTALJ = 0; $totatV=0; $TOTAL = 0; $totalactivCash=0; $totalactivCredit = 0; $totalRecou=0; $totalVkit = 0; $totalver = 0; $totalAkit=0;
                $Dejapasse = [];
            @endphp
            @foreach($TDATES as $date)
                @php
                    $activCash=0; $activCredit = 0; $Recou=0; $Vkit = 0; $ver = 0; $Akit=0;
                    $Dejapasse = [];
                @endphp
                @foreach($achatkit as $key=>$item)
                    @if($date==date("Y-m-d", strtotime($item->created_at)))
                        @php
                            $Akit += $item->montant_achat;
                            $TOTALJ+=$Akit;

                        @endphp
                    @endif
                @endforeach
                @php
                    $totalAkit += $Akit;
                @endphp
                @foreach($versement as $key=>$item)
                    @if($date==date("Y-m-d", strtotime($item->created_at)))
                        @php
                            $ver += $item->montant_versement;
                            $TOTALJ+=$ver;

                        @endphp
                    @endif
                @endforeach
                @php
                    $totalver += $ver;
                @endphp
                @foreach($recouvrement as $key=>$item)
                    @if($date==$item->date_ajout)
                        @php
                            $Recou += $item->montant;
                            $TOTALJ+=$Recou;

                        @endphp
                    @endif
                @endforeach
                @php
                    $totalRecou += $Recou;
                @endphp
                @foreach($upgrade as $key=>$item)

                    @if($date==$item->date_upgrade)
                        @if($item->statut_upgrade==1)
                            @php
                                $activCash += $item->montant_upgrade;
                                $TOTALJ+=$activCash;
                            @endphp
                        @endif
                        @if($item->statut_upgrade==0)
                            @php
                                $activCredit += $item->montant_upgrade;
                                $TOTALJ+=$activCredit;
                            @endphp
                        @endif
                    @endif
                @endforeach
                {{--                            @php--}}
                {{--                                $totalactivCash += $activCash;--}}
                {{--                                $totalactivCredit += $activCredit;--}}
                {{--                            @endphp--}}
                @foreach($abonnement as $key=>$item)
                    @if($date==date("Y-m-d", strtotime($item->date)))
                        @if($item->statut_abo==1)
                            @php
                                $activCash += $item->duree*$item->prix_formule;
                                $Vkit +=  $item->prix_decodeur;
                                $TOTALJ+=$activCash;
                            @endphp
                        @endif
                        @if($item->statut_abo==0)
                            @php
                                $activCredit += $item->duree*$item->prix_formule;
                                $Vkit +=  $item->prix_decodeur;
                                $TOTALJ+=$activCredit;
                            @endphp
                        @endif
                    @endif
                @endforeach
                @php
                    $totalVkit += $Vkit;
                @endphp
                {{--                            @php--}}
                {{--                                $totalactivCash += $activCash;--}}
                {{--                                $totalactivCredit += $activCredit;--}}
                {{--                            @endphp--}}
                @foreach($reabonnement as $key=>$item)
                    @if($date==date("Y-m-d", strtotime($item->date)))
                        @if($item->statut_reabo==1)
                            @php
                                $activCash += $item->duree*$item->prix_formule;
                                $TOTALJ+=$activCash;
                            @endphp
                        @endif
                        @if($item->statut_reabo==0)
                            @php
                                $activCredit += $item->duree*$item->prix_formule;
                                $TOTALJ+=$activCredit;
                            @endphp
                        @endif
                    @endif
                @endforeach
                @php
                    $totalactivCash += $activCash;
                    $totalactivCredit += $activCredit;
                @endphp
                <tr>
                    <td bgcolor="#ffffff" style="padding: 3px">{{ $date }}</td>
                    <td bgcolor="#ffffff" style="padding: 3px">{{ $activCash }}</td>
                    <td bgcolor="#ffffff" style="padding: 3px">{{ $activCredit }}</td>
                    <td bgcolor="#ffffff" style="padding: 3px">{{ $Recou }}</td>
                    <td bgcolor="#ffffff" style="padding: 3px">{{ $Vkit }}</td>
                    <td bgcolor="#ffffff" style="padding: 3px">{{ $ver }}</td>
                    <td bgcolor="#ffffff" style="padding: 3px">{{ $Akit }}</td>
                    {{--                                <td>{{ $TOTALJ }}</td>--}}
                </tr>
            @endforeach
            <tr>
                <td class="" bgcolor="#ffffff" style="padding: 3px"><strong>TOTAL</strong></td>
                <td class="" bgcolor="#ffffff" style="padding: 3px"><strong>{{ $totalactivCash }}</strong></td>
                <td class="" bgcolor="#ffffff" style="padding: 3px"><strong>{{ $totalactivCredit }}</strong></td>
                <td class="" bgcolor="#ffffff" style="padding: 3px"><strong>{{ $totalRecou }}</strong></td>
                <td class="" bgcolor="#ffffff" style="padding: 3px"><strong>{{ $totalVkit }}</strong></td>
                <td class="" bgcolor="#ffffff" style="padding: 3px"><strong>{{ $totalver }}</strong></td>
                <td class="" bgcolor="#ffffff" style="padding: 3px"><strong>{{ $totalAkit }}</strong></td>
            </tr>
        </table>
        <div class="row">

            <strong>
                <h3>
                    TOTAL : <span class="h2"> {{ $totalactivCash+$totalactivCredit}}</span>
                </h3>
            </strong>
        </div>
    </div>
</div>

</body>
</html>
