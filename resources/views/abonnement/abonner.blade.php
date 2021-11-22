<meta charset="utf-8">
<x-app-layout>
    <x-slot name="slot">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-2 font-weight-bold text-primary">Nouvel abonnement&nbsp;
                    <a href="{{ route('add.client')}}"
                       data-toggle="modal" data-target="#clientModal" type="button"
                       class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;">
                        <i class="fas fa-fw fa-plus"></i>
                    </a>
                </h4>
                <label class="mr-5"><a class="btn btn-primary" href="{{route('user.abonnement.jour')}}"> Abonnements du
                        jour</a></label>
                <label class="ml-4"><a class="btn btn-success" href="{{route('user.abonnement')}}"> Tous mes
                        abonnements</a></label>
                <div class="float-right mb-1 pull-right col-md-12">
                    <form action="{{ route('abonnement.sort') }}" method="get">
                        @csrf
                        <div class="row pull-right float-right col-md-12">
                            <select class="form-control col-md-2" name="byUser">
                                <option value="ALL">Tous les statuts</option>
                                <option value="BYME">Reabonné par moi</option>
                                <option value="BYORTHERS">Reabonné par autre</option>
                            </select>
                            <select class="form-control col-md-2" name="byDate">
                                <option value="CREATE">Date creation</option>
                                <option value="START">Date reabo</option>
                                <option value="STOP">Date échéance</option>
                            </select>
                            <input type="date" name="date1" class="form-control col-md-3">
                            <input type="date" name="date2" class="form-control col-md-3">
                            <button type="submit" class="btn btn-primary float-right"><i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @include('layouts.flash-message')





            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom et Prénom</th>
                            <th>Téléphone</th>
                            <th>Num abonné</th>
                            <th>Num Décodeur</th>
                            <th>Formule</th>
                            <th>Date reabo</th>
                            <th>Durée</th>
                            <th>Date échéance</th>
                            <th>Montant</th>
                            <th>Par</th>
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
                                <td>{{$key+1}}</td>
                                <td>{{ $value->nom_client }} {{$value->prenom_client }}</td>
                                <td>{{ $value->telephone_client }}</td>
                                <td>{{ $value->num_abonne }}</td>
                                <td>{{ $value->num_decodeur }}</td>
                                <td>{{ $value->nom_formule }}</td>
                                <td>{{ $value->date_debut }}</td>
                                <td>{{ $value->duree }} mois</td>
                                <td>{{ $value->date_echeance }}</td>
                                <td>{{ ($value->prix_formule * $value->duree)+$value->prix_decodeur }}</td>
                                <td>
                                    @foreach($users as $u=>$user)
                                        @if($user->id === $value->id_user)
                                            {{ $user->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @if($value->type_abonement ===0)
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
                                             if ($item->id_abonnement==$value->id_abonnement){
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
                                <td class="text-center d-flex">
                                    {{--                                    <div class="row">--}}
                                    <button {{ $canDelete == 1? '' : "disabled" }} id="supprimer" title="Supprimer"
                                            href="javascript:void(0);"
                                            class="btn btn-danger btn-supp"
                                            onclick="deleteFunc({{ $value->id_abonnement }},{{ $value->id_client }})">
                                        <i class="fas fa-fw fa-trash"></i>
                                    </button>
                                    <a id="upgrade" title="Upgrade l'abonnement"
                                       href="{{ route('abonnement.upgrade',[ $value->id_client,$value->id_abonnement]) }}"
                                       class="btn btn-warning btn-supp ml-1">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </a>
                                    <a target="_blank" title="Imprimer la facture"
                                       href="{{ route('printpdf', $value->id_abonnement ) }}" class="btn btn-info ml-1">
                                        <i class="fas fa-fw fa-print"></i>
                                    </a>
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

    function controlNumero1() {


        var long = $('#num_abonne').val();

        if (long.length != 8) {
            $('.ereur-numeroa').removeClass('hidden');
        } else {
            $('.ereur-numeroa').addClass('hidden');
        }

    }

    function controlNumero(val) {
        // alert("test");
        var long = $('#num_decodeur').val();
        if (long.length != 14) {
            $('.ereur-numerod').removeClass('hidden');
        } else {
            $('.ereur-numerod').addClass('hidden');
        }

    }

    $("#abonneForm").submit(function (event) {

        var numdeco = $('#num_decodeur').val();
        var numabonne = $('#num_abonne').val();
        if (numdeco.length == 14) {
            $('.ereur-numerod').addClass('hidden');
            return;
        } else {
            $('.ereur-numerod').removeClass('hidden');
            event.preventDefault();
        }
        if (numabonne.length == 8) {
            $('.ereur-numeroa').addClass('hidden');
            return;
        } else {
            $('.ereur-numeroa').removeClass('hidden');
            event.preventDefault();
        }
        // $( "span" ).text( "Not valid!" ).show().fadeOut( 1000 );
        // event.preventDefault();
    });

</script>
