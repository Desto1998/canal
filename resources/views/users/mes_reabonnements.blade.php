<x-app-layout>
    <x-slot name="slot">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <label class="mr-5"><a class="btn btn-primary" href="{{route('user.reabonnement.jour')}}"> Reabonnements du jour</a></label>
                <label class="ml-4"><a class="btn btn-success"  href="{{route('user.reabonnement')}}"> Tous mes reabonnements</a></label>
            </div>
            @include('layouts/flash-message')

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom et Prénom </th>
                            <th>Numéro de téléphone</th>
                            <th>Numéro client</th>
                            <th>Numéro Décodeur</th>
                            <th>Formule</th>
                            <th>Durée</th>
                            <th>Montant de la formule(FCFA)</th>
                            <th>Montant total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $compt = 1;
                            $chiffre = 0;
                        @endphp
                        @foreach($data as $key => $value)

                            <tr>
                                <td>{{$compt}}</td>
                                <td><strong>{{ $value->nom_client }} {{$value->prenom_client }}</strong></td>
                                <td><strong>{{ $value->telephone_client }}</strong></td>
                                <td>{{ $value->num_abonne }}</td>
                                <td>{{ $value->num_decodeur }}</td>
                                <td>{{ $value->nom_formule }}</td>
                                <td>{{ $value->duree }} mois</td>
                                <td>{{ $value->prix_formule }}</td>
                                <td>{{ ($value->prix_formule * $value->duree) }}</td>
                            </tr>
                            @php
                                $chiffre += ($value->prix_formule * $value->duree) ;
                                    $compt ++;
                            @endphp
                        @endforeach

                        </tbody>
                    </table>

                </div>
                <div class="mt-6">
                    <h2>Total Général : <span class="text-info">{{$chiffre}} FCFA</span></h2>
                </div>
            </div>
        </div>


        </div>
    </x-slot>
</x-app-layout>