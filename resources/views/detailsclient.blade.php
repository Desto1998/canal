<x-app-layout>
    <x-slot name="slot">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="col-md-12">
                    <div class="row">
                        <label class="m-2 font-weight-bold text-uppercase text-2xl text-primary pull-left">Détails du client</label>
                                            <label class="mr-5 pull-right float-right">
                        <a class="btn btn-primary pull-right float-right" title="Nouveau réabonnement" href="{{ route('reabonne.client',$client[0]->id_client)}}"> <i class="fa fa-plus"></i> Réabonnement
                        </a>
                                            </label>
                    </div>
                </div>


                <div class="col-m-12">
                    <div class="row text-center">
{{--                        <h3 class="text-center">Informations personnelles</h3>--}}
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <span class="">Nom:</span> <span class="mr-2 text-black-50 font-semibold">{{ $client[0]->nom_client }}</span>
                        </div>
                        <div class="col-md-4">
                            <span class="">Prenom:</span> <span class="mr-2 text-black-50 font-semibold">{{ $client[0]->prenom_client }}</span>

                        </div>
                        <div class="col-md-4 mt-2">
                            <span class="mr-2">Téléphone:</span> <span class="mr-2 text-black-50 font-semibold">{{ $client[0]->telephone_client }}</span>

                        </div>
                        <div class="col-md-6 mt-2">
                            <span class="">Adresse:</span> <span class="mr-2 text-black-50 font-semibold">{{ $client[0]->adresse_client }}</span>

                        </div>
                        <div class="col-md-6 mt-2">
                            <span class="">Numéro d'abonné:</span> <span class="mr-2 text-black-50 font-semibold">{{ $client[0]->num_abonne }}</span>

                        </div>
                        <div class="col-md-6 mt-2">
                            <span class="mr-2">Date d'abonnement:</span> <span class="mr-2 text-black-50 font-semibold">{{ $client[0]->date_abonnement }}</span>

                        </div>
                        <div class="col-md-6 mt-2">
                            <span class="">Ajouté le:</span> <span class="mr-2 text-black-50 font-semibold">{{ $client[0]->created_at }}</span>
                            <span class="mr-2">par:</span> <span class="mr-2 text-black-50 font-semibold">{{ $user[0]->name }}</span>

                        </div>
                        <div class="col-md-12 mt-2">
                            décodeurs( {{ count($decodeurs) }} ):
                            @foreach($decodeurs as $k => $item)
                                <span class="mr-2 text-black-50 m-2 font-semibold"> {{ $item->num_decodeur }} </span>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">

                    </div>

                </div>
            </div>
            @include('layouts/flash-message')

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable_1" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Date Raébo</th>
                            <th>Décodeur</th>
                            <th>Formul</th>
                            <th>Prix</th>
                            <th>Durée</th>
                            <th>Total</th>
                            <th>Statut</th>
                            <th>Vendeur</th>
                            <th>Effectué le</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $compt = 1;
                            $chiffre = 0;
                            $credit = 0;
                            $paye = 0;
                        @endphp
                        @foreach($reabonnements as $key => $value)

                            <tr>
                                <td>{{$compt}}</td>
                                <td>{{ $value->date_reabonnement }}</td>
                                <td>{{ $value->num_decodeur }}</td>
                                <td>{{ $value->nom_formule }}</td>
                                <td>{{ $value->prix_formule }}</td>
                                <td>{{ $value->duree }} mois</td>

                                <td>{{ ($value->prix_formule * $value->duree) }}</td>

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
                                <td>{{ $value->name }}</td>
                                @php
                                        $canDelete =0;

                                         foreach ($reabonnement as $r =>$item){
                                             if ($item->id_reabonnement==$value->id_reabonnement){
                                                 echo "<td>$item->created_at</td>";
                                                  $created = new DateTime($value->created_at);
                                                $created =  date("Y-m-d H:i:s", strtotime($item->created_at));
                                                $date = new DateTime($created);
                                             $date->add(new DateInterval('P1D'));
                                            $datenow =  date('Y-m-d H:i:s');
                                         //$date->format('');
                                            $date =  date("Y-m-d H:i:s", strtotime($date->format('Y-m-d H:i:s')));
                                            // dd($date);
                                                if ($datenow <= $date){
                                                     $canDelete = 1;
                                                 }else{
                                                     $canDelete = 0;
                                                 }
                                             }
                                         }

                                @endphp
                                <td class="text-center">
                                    <button {{ $canDelete == 1? '' : "disabled" }} id="supprimer" title="Supprimer"
                                            href="javascript:void(0);"
                                            class="btn btn-danger btn-supp"
                                            onclick="deleteFunc({{ $value->id_reabonnement }},{{ $value->id_client }})">
                                        <i class="fas fa-fw fa-trash"></i>
                                    </button>
                                </td>
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
        <div class="mt-6">
            <h4>Total Crédit : <span class="text-danger">{{$credit}} FCFA</span></h4>
        </div>

        </div>
    </x-slot>
</x-app-layout>
