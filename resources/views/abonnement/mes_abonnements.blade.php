<x-app-layout>
    <x-slot name="slot">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="mb-1 text-success"> Mes abonnements</h6>
                <label class="mr-5"><a class="btn btn-primary" href="{{route('user.abonnement.jour')}}"> Abonnements du
                        jour</a></label>
                <label class="ml-4"><a class="btn btn-success" href="{{route('user.abonnement')}}"> Tous mes
                        abonnements</a></label>
                <label class="ml-6"><a class="btn btn-danger" href="{{route('user.reabonnement.credit')}}">
                        Reabonnements à crédit</a></label>
            </div>
            @include('layouts.flash-message')

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom et Prénom</th>
                            <th>Numéro de téléphone</th>
                            <th>Numéro client</th>
                            <th>Numéro Décodeur</th>
                            <th>prix Décodeur</th>
                            <th>Formule</th>
                            <th>Durée</th>
                            <th>Montant de la formule(FCFA)</th>
                            <th>Montant total</th>
                            <th>Action</th>
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
                                <td>{{ $value->prix_decodeur }}</td>
                                <td>{{ $value->nom_formule }}</td>
                                <td>{{ $value->duree }} mois</td>
                                <td>{{ $value->prix_formule }}</td>
                                <td>{{ ($value->prix_formule * $value->duree) + $value->prix_decodeur }}</td>
                                @php
                                    $canDelete =0;
                                              $created = new DateTime($value->created_at);
                                            $created =  date("Y-m-d H:i:s", strtotime($value->created_at));

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
                                @endphp
                                <td class="text-center d-flex">
                                    <button {{ $canDelete == 1? '' : "disabled" }} id="supprimer" title="Supprimer"
                                            href="javascript:void(0);"
                                            class="btn btn-danger btn-supp"
                                            onclick="deleteFunc({{ $value->id_abonnement }},{{ $value->id_client }})">
                                        <i class="fas fa-fw fa-trash"></i>
                                    </button>

                                </td>
                            </tr>
                            </tr>
                            @php
                                $chiffre += ($value->prix_formule * $value->duree) + $value->prix_decodeur ;
                                    $compt ++;
                            @endphp
                        @endforeach

                        </tbody>
                    </table>

                </div>
                <div class="mt-6">
                    <h2>Total du Général : <span class="text-info">{{$chiffre}} FCFA</span></h2>
                </div>
            </div>
        </div>

    </x-slot>
</x-app-layout>
<script>
    function deleteFunc(id, id_client) {
        // $('#success').addClass('hidden');
        // $('#error').addClass('hidden');
        if (confirm("Supprimer cet abonnement?") == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('abonnement.delete') }}",
                data: {id: id_client, id_abonnement: id},
                dataType: 'json',
                success: function (res) {
                    if (res) {
                        alert("Supprimé avec succès!");
                        window.location.reload(200);

                    } else {
                        alert("Une erreur s'est produite!");
                    }

                }
            });
        }
    }

</script>
