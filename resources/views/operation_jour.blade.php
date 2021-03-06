@php
    $compt = 1;
    $chiffre = 0;
     $credit = 0;
    $paye = 0;
@endphp
<x-app-layout>
    <x-slot name="slot">
        <div class="card">
            <div class="card-body">
                <h4 class="uppercase">Liste des opérations du jours</h4>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="mb-1 text-primary">Liste des abonnements</h6>
            </div>
            @include('layouts.flash-message')

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom et Prénom </th>
                            <th>Num Abo</th>
                            <th>Num Dec</th>
                            <th>prix Décodeur</th>
                            <th>Formule</th>
                            <th>Durée</th>
                            <th>Montant formule</th>
                            <th>Montant total</th>
                            <th>Par</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($abonnements as $key => $value)

                            <tr>
                                <td>{{$key+1}}</td>
                                <td><strong>{{ $value->nom_client }} {{$value->prenom_client }}</strong></td>
                                <td>{{ $value->num_abonne }}</td>
                                <td>{{ $value->num_decodeur }}</td>
                                <td>{{ $value->prix_decodeur }}</td>
                                <td>{{ $value->nom_formule }}</td>
                                <td>{{ $value->dureeabo }} mois</td>
                                <td>{{ $value->prix_formule }}</td>
                                <td>{{ ($value->prix_formule * $value->dureeabo) + $value->prix_decodeur }}</td>
                                <td>{{ $value->name }} </td>
                            </tr>
                            @php
                                $chiffre += ($value->prix_formule * $value->duree) + $value->prix_decodeur ;
                                    $compt ++;
                            @endphp
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <hr>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="mb-1 text-primary">Liste des reabonnements du jour</h6>
            </div>
            @include('layouts.flash-message')

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom et Prénom</th>
                            <th>Numéro client</th>
                            <th>Numéro Décodeur</th>
                            <th>Formule</th>
                            <th>Durée</th>
                            <th>Montant formule</th>
                            <th>Montant total</th>
                            <th>Type</th>
                            <th>Par</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($reabonnements as $key => $value)

                            <tr>
                                <td>{{$compt}}</td>
                                <td>{{ $value->nom_client }} {{$value->prenom_client }}</td>
                                <td>{{ $value->num_abonne }}</td>
                                <td>{{ $value->num_decodeur }}</td>
                                <td>{{ $value->nom_formule }}</td>
                                <td>{{ $value->duree }} mois</td>
                                <td>{{ $value->prix_formule }}</td>
                                <td>{{ ($value->prix_formule * $value->duree)  }}</td>
                                <td>
                                    @if($value->type_reabonement ===0)
                                        <span class="bg-gradient-danger text-white p-1">Crédit</span>
                                        @php
                                            $credit += ($value->prix_formule * $value->duree) ;
                                        @endphp
                                    @else
                                        <span class="bg-gradient-success text-white p-1">Payé</span>
                                        @php
                                            $paye += ($value->prix_formule * $value->duree) ;
                                        @endphp
                                    @endif

                                </td>
                                <td>{{ $value->name }} </td>
                            </tr>
                            @php
                                $chiffre += ($value->prix_formule * $value->duree) ;
                                    $compt ++;
                            @endphp
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="text-info">Liste des upgrades</h6>

            </div>
            @include('layouts.flash-message')

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom et Prénom</th>
{{--                            <th>Numéro client</th>--}}
                            <th>Numéro Décodeur</th>
                            <th>Formule</th>
                            <th>Durée</th>
                            <th width="150px">Expire le</th>
                            <th>Type</th>
                            <th>Par</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($upgrades as $key => $value)
                                @php
                                    // dd($reabonnements,$abonnements,$data);
                                     $num_decodeur = '';
                                     $nom_client = '';
                                     $num_abonne = '';
                                     $date_fin = '';

                                @endphp
                                @foreach($reabonnement as $k=>$item)
                                    @if($value->id_reabonnement==$item->id_reabonnement)
                                        @php
                                            $nom_client = $item->nom_client .' '.$item->prenom_client;
                                            $num_decodeur = $item->num_decodeur;
                                            $num_abonne = $item->num_abonne;
                                            $date_fin = $item->date_echeance;
                                        @endphp
                                    @endif
                                @endforeach
                                @foreach($abonnement as $k=>$item)
                                    @if($value->id_abonnement==$item->id_abonnement)
                                        @php
                                            $nom_client = $item->nom_client .' '.$item->prenom_client;
                                            $num_decodeur = $item->num_decodeur;
                                            $num_abonne = $item->num_abonne;
                                             $date_fin = $item->date_echeance;
                                        @endphp
                                    @endif
                                @endforeach
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{ $nom_client }}</td>
{{--                                <td>{{ $num_abonne }}</td>--}}
                                <td>{{ $num_decodeur }}</td>
                                <td>
                                    @foreach($formules as $f => $form)
                                        @if($form->id_formule==$value->id_newformule)
                                            {{ $value->nom_formule }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $value->duree }} mois</td>
                                <td width="150px">{{ $date_fin }}</td>
                                <td>
                                    @if($value->type_reabonement ===0)
                                        <span class="bg-gradient-danger text-white p-1">Crédit</span>
                                        @php
                                            $credit += ($value->prix_formule * $value->duree) ;
                                        @endphp
                                    @else
                                        <span class="bg-gradient-success text-white p-1">Payé</span>
                                        @php
                                            $paye += ($value->prix_formule * $value->duree) ;
                                        @endphp
                                    @endif
                                </td>
                                <td>{{ $value->name }} </td>
                            </tr>
                            @php
                                $chiffre += ($value->montant_upgrade) ;
                                    $compt ++;
                            @endphp
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-6">
            <h4>Total Crédit : <span class="text-danger">{{$credit}} FCFA</span></h4>
        </div>
        <div class="mt-6">
            <h4>Total payé : <span class="text-success">{{$paye}} FCFA</span></h4>
        </div>
        <div class="mt-6">
            <h4>Total Général : <span class="text-info">{{$chiffre}} FCFA</span></h4>
        </div>
    </x-slot>
</x-app-layout>

