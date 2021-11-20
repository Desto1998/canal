<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport CANAL GETEL SARL</title>
{{--    <link href={{ asset('css/sb-admin-2.min.css') }} rel="stylesheet">--}}
</head>
<body>
<table class="table table-bordered text-center" width="100%" cellspacing="2" bgcolor="#000000">
    <thead>
    <tr style="text-transform: uppercase">
        <td colspan="9" bgcolor="#ffffff">
            <strong>
                <h3>
                    Rapport canal<span class="h2">+</span> {{ $request->date1 }} au {{ $request->date2 }} GETEL SARL
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
        <th bgcolor="#ffffff" style="padding: 3px">SOLDE CGA</th>
        <th bgcolor="#ffffff" style="padding: 3px">CAISSE</th>
    </tr>
    </thead>
    <tbody>
    @php
        $TOTALJ = 0; $totatV=0; $TOTAL = 0; $totalactivCash=0; $totalactivCredit = 0; $totalRecou=0; $totalVkit = 0; $totalver = 0; $totalAkit=0;
        $Dejapasse = [];
        $TCREANCE=[];

    @endphp
    @foreach($TDATES as $date)
        @php
            $activCash=0; $activCredit = 0; $Recou=0; $Vkit = 0; $ver = 0; $Akit=0;
            $Dejapasse = []; $statutcaisse = 0;$i=0; $CGAutilise = 0;$soldeCGA=0;$r=0;$a=0;$u=0;$v=0;
        @endphp
        @while($v<count($versement) && $date<=date("Y-m-d", strtotime($versement[$v]->created_at)))
            @php
                $soldeCGA += ($versement[$v]->montant_versement);
                $v++;
            @endphp
        @endwhile
        @while($r<count($allReabonnement) && $date<=date("Y-m-d", strtotime($allReabonnement[$r]->created_at)))
            @php
                $CGAutilise += ($allReabonnement[$r]->duree*$allReabonnement[$r]->pix_formule);
                $r++;
            @endphp
        @endwhile
        @while($a<count($allAbonnement) && $date<=date("Y-m-d", strtotime($allAbonnement[$a]->created_at)))
            @php
                $CGAutilise += ($allAbonnement[$a]->duree*$allAbonnement[$a]->pix_formule);
                $a++;
            @endphp
        @endwhile
        @while($u<count($allUpgrade) && $date<=date("Y-m-d", strtotime($allUpgrade[$u]->created_at)))
            @php
                $CGAutilise += ($allUpgrade[$u]->montant_upgrade);
                $u++;
            @endphp
        @endwhile
        @while($i<count($caisse) && $date<=date("Y-m-d", strtotime($caisse[$i]->created_at)))
            @php
                $statutcaisse += ($caisse[$i]->montant);
                $i++;
            @endphp
        @endwhile
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
            $totalRecou  += $Recou;
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
                        foreach ($users as $u =>$user)
                        {
                            if ($user->id==$item->id_user){
                                if (!in_array($user->id,$Dejapasse)){
                                    $Dejapasse[$user->id]=$user->id;
                                    $TCREANCE[$user->id] =$item->montant_upgrade;
                                }else{
                                    $TCREANCE[$user->id] +=$item->montant_upgrade;
                                }
                            }
                        }
                        $activCredit += $item->montant_upgrade;
                        $TOTALJ+=$activCredit;
                    @endphp
                @endif
            @endif
        @endforeach
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
                        foreach ($users as $u =>$user)
                        {
                            if ($user->id==$item->id_user){
                                if (!in_array($user->id,$Dejapasse)){
                                    $Dejapasse[$user->id]=$user->id;
                                    $TCREANCE[$user->id] =$item->duree*$item->prix_formule;
                                }else{
                                    $TCREANCE[$user->id] +=$item->duree*$item->prix_formule;
                                }
                            }
                        }
                    @endphp
                @endif
            @endif
        @endforeach
        @php
            $totalVkit += $Vkit;
        @endphp

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
                         foreach ($users as $u =>$user)
                        {
                            if ($user->id==$item->id_user){
                                if (!in_array($user->id,$Dejapasse)){
                                    $Dejapasse[$user->id]=$user->id;
                                    $TCREANCE[$user->id] =$item->duree*$item->prix_formule;
                                }else{
                                    $TCREANCE[$user->id] +=$item->duree*$item->prix_formule;
                                }
                            }
                        }
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
            <td bgcolor="#ffffff" style="padding: 3px">{{ $soldeCGA - $CGAutilise }}</td>
            <td bgcolor="#ffffff" style="padding: 3px">{{ $statutcaisse }}</td>
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
        <td class="" bgcolor="#ffffff" style="padding: 3px"><strong>{{  $soldeCGA - $CGAutilise }}</strong></td>
        <td class="" bgcolor="#ffffff" style="padding: 3px"><strong>{{ $statutcaisse }}</strong></td>
    </tr>
    </tbody>
</table>
</div>
<hr>
<div class="table-responsive mt-2">
    <table class="table table-bordered text-center" bgcolor="#000000" width="100%" cellspacing="2">
        <thead>
        <tr style="text-transform: uppercase">
            <th colspan="{{ count($TID)+1 }}" bgcolor="#ffffff">
                <strong>
                    <h3>
                        ETAT DES CREANCES CANAL
                    </h3>
                </strong>
            </th>
        </tr>
        <tr>
            <th bgcolor="#ffffff" style="padding: 3px"></th>

            {{--                                {{ dd($TCREANCE,$TID) }}--}}
            @foreach ($users as $u =>$user)
                @if (in_array($user->id,$TID))
                    <th bgcolor="#ffffff" style="padding: 3px">   {{ $user->name }} </th>
                @endif
            @endforeach

        </tr>
        </thead>
        <tbody>
        <tr>
            <td bgcolor="#ffffff" style="padding: 3px"></td>

            @foreach ($users as $u =>$user)
                @if (in_array($user->id,$TID))
                    @if(isset($TCREANCE[$user->id]))
                        <td bgcolor="#ffffff" style="padding: 3px">{{ $TCREANCE[$user->id] }}</td>
                    @else
                        <td bgcolor="#ffffff" style="padding: 3px">0</td>
                    @endif
                @endif
            @endforeach

        </tr>
        <tr>
            <td bgcolor="#ffffff" style="padding: 3px">TOTAL</td>
            <td colspan="{{ count($TID)+1 }}" bgcolor="#ffffff" style="padding: 3px">
                @php
                    $total =0;
                @endphp
                @foreach($TCREANCE as $creance)
                    @php
                        $total += $creance;
                    @endphp

                @endforeach
                {{ $total }}
            </td>
        </tr>
        </tbody>
    </table>
</div>
<hr>
<div class="table-responsive mt-2">
    <table class="table table-bordered text-center" width="100%" cellspacing="2" bgcolor="black">
        <thead>
        <tr style="text-transform: uppercase">
            <td colspan="2" bgcolor="#ffffff" style="padding: 3px">
                <strong>
                    <h3>
                        ETAT DE STOCK
                    </h3>
                </strong>
            </td>
        </tr>
        <tr>
            <th bgcolor="#ffffff" style="padding: 3px">DECODEURS</th>
            <th bgcolor="#ffffff" style="padding: 3px">KITS ACCESSOIRES</th>
        </tr>
        </thead>
        <td bgcolor="#ffffff" style="padding: 3px">{{ count($decodeur) }}</td>
        <td bgcolor="#ffffff" style="padding: 3px">0</td>
    </table>
</body>
</html>
