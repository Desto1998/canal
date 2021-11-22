<x-app-layout>
    <x-slot name="slot">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="text-info">Upgrade un reabonnement</h6>
                <div class="row">
                    <a href="{{ route('upgrader.all') }}" class="btn btn-success">Tous les upgrades</a>
                </div>
                <div class="">
                    <h4 class="m-2 font-weight-bold text-primary pull-right -align-right float-right">Ajouter un upgrade&nbsp;<a
                            href="#" data-toggle="modal"
                            data-target="#upgradeModal" type="button"
                            class="btn btn-primary"><i
                                class="fas fa-fw fa-plus"></i></a></h4>
                </div>
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
                            <th>Formule</th>
                            <th>Durée</th>
                            <th width="150px">Expire le</th>
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
                                <td>{{ $value->duree }} mois</td>
                                <td width="150px">{{ $value->date_reabonnement }}</td>
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
                                <td class="text-center d-flex">
                                    <a id="upgrade" title="Upgrade ce reabonnement"
                                            href="{{ route('up.client',[$value->id_client,$value->id_reabonnement]) }}"
                                            class="btn btn-warning btn-supp">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </a>
{{--                                    <a {{ $value->type_reabonement == 0? '' : "disabled" }} id="Recouvrement" title="Recouvrir le crédit"--}}
{{--                                            href="javascript:void(0);"--}}
{{--                                            class="btn btn-success btn-supp ml-1"--}}
{{--                                            onclick="recouvrirFunc({{ $value->id_reabonnement }},{{ $value->id_client }})">--}}
{{--                                        <i class="fas fa-fw fa-check"></i>--}}
{{--                                    </a>--}}
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
            <div class="modal fade " id="upgradeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ajouter un client</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form role="form" id="abonneForm" method="post" action="{{ route('store.client') }}">
                                @csrf
                                <div class="row">
                                    <label>Le client existe dejà dans le systéme</label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            Nom client<br><input class="form-control" type="text" placeholder="Nom"
                                                                 name="nom_client" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            Prenom client<br><input class="form-control" type="text"
                                                                    placeholder="Prenom" name="prenom_client">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            Numero d'abonné<br><input type="text" class="form-control" maxlength="8"
                                                                      minlength="8" type="text"
                                                                      onblur="controlNumero1(this)"
                                                                      placeholder="numero abonne" name="num_abonne"
                                                                      id="num_abonne" required>
                                            <span class="text-danger hidden ereur-numeroa " style=""> Mauvaise saisie Longeur requise 8</span>
                                            @error('num_decodeur')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            N° téléphone client<br><input class="form-control" type="tel"
                                                                          placeholder="Numéro de téléphone"
                                                                          name="telephone_client" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            Adresse client<br><input class="form-control" type="text"
                                                                     placeholder="Adresse" name="adresse_client"
                                                                     required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            Numero décodeur<br>
                                            @if(isset($decodeur))

                                                <select class="form-control" required="Sélectionnez un decodeur SVP."
                                                        name="num_decodeur" id="num_decodeur">
                                                    <option disabled selected hidden>Sélectionner un decodeur</option>
                                                    @foreach($decodeur as $key =>$deco)

                                                        <option
                                                            value="{{$deco->num_decodeur}}">{{$deco->num_decodeur}}</option>
                                                    @endforeach
                                                </select>

                                            @else
                                                <span class="text-danger">Aucun décodeur n'est disponible veiller enregistrer un décodeur.</span>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            Formule: <select class="form-control" name="formule" required>
                                                <option value="ACCESS" selected> ACCESS</option>
                                                <option value="ACCESS +"> ACCESS +</option>
                                                <option value="EVASION"> EVASION</option>
                                                <option value="EVASION +"> EVASION +</option>
                                                <option value="PRESTIGE"> PRESTIGE</option>
                                                <option value="ESSENTIEL +"> ESSENTIEL +</option>
                                                <option value="TOUT CANAL"> TOUT CANAL</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            Formule: <select class="form-control" name="formule" required>
                                                <option value="ACCESS" selected> ACCESS</option>
                                                <option value="ACCESS +"> ACCESS +</option>
                                                <option value="EVASION"> EVASION</option>
                                                <option value="EVASION +"> EVASION +</option>
                                                <option value="PRESTIGE"> PRESTIGE</option>
                                                <option value="ESSENTIEL +"> ESSENTIEL +</option>
                                                <option value="TOUT CANAL"> TOUT CANAL</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Enregistrer
                                </button>
                                <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Retour
                                </button>
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                            </form>
                        </div>
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
    function recouvrirFunc(id, id_client) {
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
                url: "{{ route('reabonnement.recover') }}",
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
