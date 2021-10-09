<x-app-layout>
    <x-slot name="slot">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="text-info">Rapport</h6>
                <form action="{{ route('report.print') }}" method="get">
                    <input type="hidden" name="date1" value="{{ $request->date1 }}">
                    <input type="hidden" name="date2" value="{{ $request->date2 }}">
                    <input type="hidden" name="action" value="{{ $request->action }}">
                    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-print">Imprimer</i></button>
                </form>
            </div>
            @include('layouts.flash-message')
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" id="dataTable1" width="100%" cellspacing="0">
                        <thead>
                        <tr style="text-transform: uppercase">
                            <td colspan="9">
                                <strong>
                                    <h3>
                                        Rapport hedomadaires canal<span class="h2">+</span> de: {{ $user->name }}
                                    </h3>
                                </strong>
                            </td>
                        </tr>
                        <tr style="font-size: 10px;font-weight: bold" class="-bold">
                            <th>DATE</th>
                            <th>ACTIVATION CASH</th>
                            <th>ACTIVATION A CREDIT</th>
                            <th>RECOUVREMENTS</th>
                            <th>VENTE KITS</th>
                            <th>VERSEMENTS</th>
                            <th>ACHAT DES KITS</th>
                            {{--                            <th>TOTAL JOUR</th>--}}
                            {{--                            <th>CAISSE</th>--}}
                        </tr>
                        </thead>
                        <tbody>
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
                                <td>{{ $date }}</td>
                                <td>{{ $activCash }}</td>
                                <td>{{ $activCredit }}</td>
                                <td>{{ $Recou }}</td>
                                <td>{{ $Vkit }}</td>
                                <td>{{ $ver }}</td>
                                <td>{{ $Akit }}</td>
                                {{--                                <td>{{ $TOTALJ }}</td>--}}
                            </tr>
                        @endforeach
                        <tr>
                            <td class=""><strong>TOTAL</strong></td>
                            <td class=""><strong>{{ $totalactivCash }}</strong></td>
                            <td class=""><strong>{{ $totalactivCredit }}</strong></td>
                            <td class=""><strong>{{ $totalRecou }}</strong></td>
                            <td class=""><strong>{{ $totalVkit }}</strong></td>
                            <td class=""><strong>{{ $totalver }}</strong></td>
                            <td class=""><strong>{{ $totalAkit }}</strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">

                    <strong>
                        <h3>
                            TOTAL : <span class="h2"> {{ $totalactivCash+$totalactivCredit}}</span>
                        </h3>
                    </strong>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>

