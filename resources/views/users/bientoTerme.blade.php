<x-app-layout>
    <x-slot name="slot">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="text-primary">Clients bientàt à terme</h4>
                <label class=""><a class="btn btn-success" href="{{route('user.client.nouveau')}}"> Client nouveau</a></label>
                <label class="ml-4"><a class="btn btn-warning"  href="{{route('user.client.terme')}}"> Bientot a terme</a></label>
                <label class="ml-4"><a class="btn btn-danger"  href="{{route('user.client.perdu')}}"> Clients échus</a></label>
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
                            <th>Formule actuelle</th>
                            <th>Durée</th>
                            <th>Date d'expiration</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($data as $key => $value)

                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td><strong>{{ $value->nom_client }} {{$value->prenom_client }}</strong></td>
                                <td><strong>{{ $value->telephone_client }}</strong></td>
                                <td>{{ $value->num_abonne }}</td>
                                <td>{{ $value->num_decodeur }}</td>
                                <td>{{ $value->nom_formule }} ( {{ $value->prix_formule  }} )</td>
                                <td>{{ $value->duree }} mois</td>
                                <td>{{ $value->date_reabonnement }} </td>
                                <td>
                                    <button class="btn btn-success" title="Envoyer un message de notification">
                                        <i class="fa fa-envelope"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </x-slot>
</x-app-layout>
