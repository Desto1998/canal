<meta charset="utf-8">
<x-app-layout>
    <x-slot name="slot">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-2 font-weight-bold text-primary">Liste des messages envoyés&nbsp;</h6>
            </div>
            @include('layouts/flash-message')
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" >
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Téléphone</th>
                            <th width="200">Message</th>
                            <th>Qté</th>
                            <th>Envoyé Par</th>
                            <th>Envoyé le</th>
                            <th>Status</th>
{{--                            <th>Action</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($messages as $key => $item)
                            <tr>
                                <td>{{ $item->nom_client }}</td>
                                <td>{{ $item->telephone_client }}</td>
                                <td>{{ $item->message }}</td>
                                <td>{{ $item->quantite }}</td>
                                <td>{{ $item->name }}
                                    @foreach($users as $u=>$user)
                                        @if($user->id === $item->id_user)
                                            {{ $user->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $item->created_at }}</td>
                                <td class="text-center">
                                    @if($item->statut==1)
                                        <span class="bg-success p-1"> Succès </span>
                                    @else
                                        <span class="bg-danger p-1"> Echec </span>
                                    @endif
                                </td>
{{--                                <td></td>--}}
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
