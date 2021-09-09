<x-app-layout>
    <x-slot name="slot">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <label class="mr-5"><a class="btn btn-primary" href="{{route('user.reabonnement.jour')}}"> Reabonnements
                        du jour</a></label>
                <label class="ml-4"><a class="btn btn-success" href="{{route('user.reabonnement')}}"> Tous mes
                        reabonnements</a></label>
            </div>
            @include('layouts/flash-message')

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
                            <th>Formule</th>
                            <th>Durée</th>
                            <th>Montant formule(FCFA)</th>

                            <th>Montant total</th>
                            <th>Type</th>
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
                                @php
                                    // $new_time = date("$value->created_at", strtotime('+24 hours'));
                                     // $new_time = date("2021-09-09 01:00:00", strtotime('+24 hours'));
                                        $canDelete =0;

                                         foreach ($reabonnement as $r =>$item){
                                             if ($item->id_reabonnement==$value->id_reabonnement){
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
                <div class="mt-6">
                    <h4>Total Crédit : <span class="text-danger">{{$credit}} FCFA</span></h4>
                </div>
                <div class="mt-6">
                    <h4>Total payé : <span class="text-success">{{$paye}} FCFA</span></h4>
                </div>
                <div class="mt-6">
                    <h4>Total Général : <span class="text-info">{{$chiffre}} FCFA</span></h4>
                </div>

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
                url: "{{ route('reabonnement.delete') }}",
                data: {id: id, id_client: id_client},
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
