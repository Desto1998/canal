<x-app-layout>
    <x-slot name="slot">
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
                            <th>Numéro Décodeur</th>
                            <th>Formule prec</th>
                            <th>Formule Suiv</th>
                            <th>Montant</th>
                            <th>Type</th>
                            <th width="150px">Le</th>
                            <th width="150px">Par</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $key => $value)
                            @php
                           // dd($reabonnements,$abonnements,$data);
                            $num_decodeur = '';
                            $nom_client = '';
                            @endphp
                            @foreach($reabonnements as $k=>$item)
                                @if($value->id_reabonnement==$item->id_reabonnement)
                                    @php
                                        $nom_client = $item->nom_client .' '.$item->prenom_client;
                                        $num_decodeur = $item->num_decodeur;
                                    @endphp
                                @endif
                            @endforeach
                            @foreach($abonnements as $k=>$item)
                                @if($value->id_abonnement==$item->id_abonnement)
                                    @php
                                        $nom_client = $item->nom_client .' '.$item->prenom_client;
                                        $num_decodeur = $item->num_decodeur;
                                    @endphp
                                @endif
                            @endforeach
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{ $nom_client }}</td>
                                <td>{{ $num_decodeur }}</td>
                                <td>
                                    @foreach( $formules as $f => $form )
                                        @if( $value->id_oldformule==$form->id_formule )
                                            {{ $form->nom_formule }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($formules as $f => $form)
                                        @if($value->id_newformule==$form->id_formule)
                                            {{ $form->nom_formule }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $value->montant_upgrade }}</td>
                                <td>
                                    @if($value->type_upgrade==1)
                                        <span class="text-info">Payé </span>
                                    @else
                                        <span class="text-danger">A crédit </span>
                                    @endif
                                </td>
                                <td>{{ $value->date_upgrade }}</td>
                                <td>{{ $value->name }}</td>
                                <td class="text-center d-flex">
                                    {{--                                    <div class="row">--}}
                                    <a id="upgrade" title="Supprimer"
                                       href="javascript:void(0);" onclick="deleteFunc({{$value->id_upgrade}})"
                                       class="btn btn-danger btn-supp">
                                        <i class="fas fa-fw fa-trash"></i>
                                    </a>
                                    @if($value->type_upgrade==0)
                                        <a title="Recouvrir le crédit" href="javascript:void(0);"
                                                class="btn btn-success btn-supp ml-1"
                                                onclick="recouvrirFunc({{$value->id_upgrade}})">
                                            <i class="fas fa-fw fa-check"></i>
                                        </a>
                                    @endif

                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </x-slot>
</x-app-layout>
<script>
    function deleteFunc(id) {
        // $('#success').addClass('hidden');
        // $('#error').addClass('hidden');
        if (confirm("voulez vraiment Supprimer?") == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('upgrade.delete') }}",
                data: {id: id},
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

    function recouvrirFunc(id) {
        // $('#success').addClass('hidden');
        // $('#error').addClass('hidden');
        if (confirm("Recouvrir ce Réabonnement?") == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('upgrade.recover') }}",
                data: {id: id},
                dataType: 'json',
                success: function (res) {
                    if (res) {
                        alert("Effectué avec succès!");
                        window.location.reload( 100);

                    } else {
                        alert("Une erreur s'est produite!");
                    }

                }
            });
        }
    }
</script>
