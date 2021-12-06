<x-app-layout>
    <x-slot name="slot">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="col-md-12">
                    <div class="row">
                        <label class="m-2 font-weight-bold text-uppercase text-2xl text-primary pull-left">Détails du
                            client</label>
                        <label class="ml-2 pull-right float-right">
                            <a class="btn btn-primary pull-right float-right" title="Nouveau réabonnement"
                               href="{{ route('reabonne.client',$client[0]->id_client)}}"> <i class="fa fa-plus"></i>
                                Réabonnement
                            </a>

                        </label>
                        <label class="ml-4 pull-right float-right">
                            <a class="btn btn-warning pull-right float-right" title="Mofier les informations"
                               href="{{ route('edit.client',$client[0]->id_client)}}"> <i class="fa fa-edit"></i>Modifier
                            </a>

                        </label>
                        <a type="button" class="btn btn-primary ml-4"
                           title="Ajouter un décodeur" href="#" data-toggle="modal"
                           data-target="#materielClientModal1{{ $client[0]->id_client }}">
                            <i class="fas fa-fw fa-plus"></i>
                        </a>

                            <a type="button" class="btn btn-info ml-4" title="Envoyer un message"
                               href="#" data-toggle="modal"
                               data-target="#messageModal{{ $client[0]->id_client }}">
                                <i class="fas fa-fw fa-envelope"></i>
                            </a>
                    </div>
                </div>


                <div class="col-m-12">
                    <div class="row text-center">
                        {{--                        <h3 class="text-center">Informations personnelles</h3>--}}
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <span class="">Nom:</span> <span
                                class="mr-2 text-black-50 font-semibold">{{ $client[0]->nom_client }}</span>
                        </div>
                        <div class="col-md-4">
                            <span class="">Prenom:</span> <span
                                class="mr-2 text-black-50 font-semibold">{{ $client[0]->prenom_client }}</span>

                        </div>
                        <div class="col-md-4 mt-2">
                            <span class="mr-2">Téléphone:</span> <span
                                class="mr-2 text-black-50 font-semibold">{{ $client[0]->telephone_client }}</span>

                        </div>
                        <div class="col-md-6 mt-2">
                            <span class="">Adresse:</span> <span
                                class="mr-2 text-black-50 font-semibold">{{ $client[0]->adresse_client }}</span>

                        </div>
                        <div class="col-md-6 mt-2">
                            <span class="">Numéro d'abonné( {{ count($decodeurs) }} ):</span>
                            @foreach($decodeurs as $k => $item)
                                <span class="mr-2 text-black-50 m-2 font-semibold"> {{ $item->num_abonne }} </span>
                            @endforeach
                        </div>
                        <div class="col-md-6 mt-2">
                            <span class="mr-2">Date d'abonnement:</span> <span
                                class="mr-2 text-black-50 font-semibold">{{ $client[0]->date_abonnement }}</span>

                        </div>
                        <div class="col-md-6 mt-2">
                            <span class="">Ajouté le:</span> <span
                                class="mr-2 text-black-50 font-semibold">{{ $client[0]->created_at }}</span>
                            <span class="mr-2">par:</span> <span
                                class="mr-2 text-black-50 font-semibold">{{ $user[0]->name }}</span>

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
            @include('layouts.flash-message')

            <div class="card-body">
                <div class="row mt-4 ml-4">
                    <h6 class="text-primary">Liste des Reabonnements</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable_1" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Date Raébo</th>
                            <th>Décodeur</th>
                            <th>Formule</th>
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
                <div class="mt-6">
                    <h4>Total Crédit : <span class="text-danger">{{$credit}} FCFA</span></h4>
                </div>
                <div class="row mt-4 ml-4">
                    <h6 class="text-primary">Liste des upgrades</h6>
                </div>
                <div class="table-responsive mt-6">
                    <table class="table table-bordered" id="dataTable_1" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Ancienne Form</th>
                            <th>Nouvelle Form</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Vendeur</th>
                            <th>Effectué le</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($upgrades as $key => $value)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    @foreach($formules as $form)
                                        @if($form->id_formule===$value->id_oldformule)
                                            {{ $form->nom_formule }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($formules as $form)
                                        @if($form->id_formule===$value->id_newformule)
                                            {{ $form->nom_formule }}
                                        @endif
                                    @endforeach
                                </td>

                                <td>{{ $value->montant_upgrade }}</td>
                                <td>
                                    @if($value->type_upgrade===1)
                                        <span class="bg-gradient-success p-2 text-white">Payé</span>
                                    @else
                                        <span class="bg-gradient-danger p-2 text-white">A crédit</span>
                                    @endif
                                </td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->date_upgrade }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row mt-4 ml-4">
                    <h6 class="text-primary">Liste des abonnements</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable_1" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Date Raébo</th>
                            <th>Décodeur</th>
                            <th>Formule</th>
                            <th>Prix</th>
                            <th>Durée</th>
                            <th>Total</th>
                            <th>Statut</th>
                            <th>Vendeur</th>
{{--                            <th>Effectué le</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $compt = 1;
                            $chiffre = 0;
                            $credit = 0;
                            $paye = 0;
                        @endphp
                        @foreach($abonnements as $key => $value)

                            <tr>
                                <td>{{$compt}}</td>
                                <td>{{ $value->date_reabonnement }}</td>
                                <td>{{ $value->num_decodeur }}</td>
                                <td>{{ $value->nom_formule }}</td>
                                <td>{{ $value->prix_formule }}</td>
                                <td>{{ $value->duree }} mois</td>

                                <td>{{ ($value->prix_formule * $value->duree) }}</td>

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
                                <td>{{ $value->name }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row mt-4 ml-4">
                    <h6 class="text-primary">Liste des achats effectués</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable_1" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Num decodeur</th>
                            <th>Montant</th>
                            <th>Date</th>
                            <th>Par</th>
                        </tr>
                        <thead>
                        <tbody>
                            @foreach($achats as $a => $item)
                            <tr>
                                <td>{{ $a+1 }}</td>
                                <td>{{ $item->code_stock }}</td>
                                <td>{{ $item->montant_vente }}</td>
                                <td>{{ $item->date_vente }}</td>
                                <td>{{ $item->name }}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="materielClientModal1{{ $client[0]->id_client }}" tabindex="-1"
             role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel{{ $client[0]->id_client }}">
                            Ajouter un décodeur</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form"
                              id="decodeurForm{{ $client[0]->id_client }}{{ $client[0]->id_client }}"
                              method="post"
                              action="{{ route('clients.new_decodeur') }}">
                            @csrf
                            <input type="hidden" name="id_client" value="{{ $client[0]->id_client }}">
                            <div class="form-group">
                                <label> Numéro d'abonné</label>
                                <input type="text" name="num_abonne" minlength="8" maxlength="8"
                                       class="form-control" required>
                            </div>
                            <div
                                class="form-group align-content-center justify-content-center text-center">
                                <label><input type="radio" required name="operation" value="1"
                                              class="operation">&nbsp; Abonnement</label>
                                <label class="ml-4"><input required type="radio" value="0"
                                                           name="operation" class="operation">&nbsp;
                                    Réabonnement</label>
                            </div>
                            <div class="selectdecodeur hidden row col-md-12">
                                <div class="form-group col-md-6">
                                    <label>Numero décodeur</label>
                                    @if(isset($stock))

                                        <select class="form-control show-tick" id="id_decodeur{{$client[0]->id_client}}" name="id_decodeur">
                                            <option disabled selected hidden>Sélectionner un
                                                decodeur
                                            </option>
                                            @foreach($stock as $key =>$deco)

                                                <option data-tokens="{{ $deco->id_stock }}"
                                                        value="{{$deco->id_stock}}">{{$deco->code_stock}}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <span class="text-danger">Aucun décodeur n'est disponible veiller enregistrer un décodeur.</span>
                                    @endif

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Prix du décodeur</label>
                                        <input type="number" name="prix_decodeur" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group hidden enternum">
                                Numero décodeur<br><input type="text" class="form-control"
                                                          maxlength="14" minlength="10"
                                                          placeholder="Entrez le numero decodeur"
                                                          onblur="controlNumero(this)"
                                                          name="num_decodeur" id="num_decodeur1">
                                <span class="text-danger hidden ereur-numerodd " style=""> Mauvaise saisie Longeur minimale 14</span>
                                @error('num_decodeur')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-6">
                                    <label>Formule:</label>
                                    <select name="formule" class="form-control" required>
                                        <option value="ACCESS" selected> ACCESS</option>
                                        <option value="ACCESS +"> ACCESS +</option>
                                        <option value="EVASION"> EVASION</option>
                                        <option value="EVASION +"> EVASION +</option>
                                        <option value="PRESTIGE"> PRESTIGE</option>
                                        <option value="ESSENTIEL +"> ESSENTIEL +</option>
                                        <option value="TOUT CANAL"> TOUT CANAL</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Durée:</label>
                                    <select name="duree"  class="form-control" required>
                                        <option value=1 selected> 1 mois</option>
                                        <option value=2> 2 mois</option>
                                        <option value=3> 3 mois</option>
                                        <option value=6> 6 mois</option>
                                        <option value=9> 9 mois</option>
                                        <option value=12> 12 mois</option>
                                    </select>
                                </div>
                            </div>

                            <div
                                class="form-group align-content-center justify-content-center text-center">
                                <label><input type="radio" required name="type" value="1">&nbsp;
                                    Payé content</label>
                                <label class="ml-4"><input required type="radio" value="0"
                                                           name="type">&nbsp;A crédit</label>
                            </div>
                            <div class="form-group text-center">
                                <label><input type="checkbox"  name="printpdf" value="1">&nbsp;Imprimer la facture?</label>
                                <label class="ml-4"><input  type="checkbox" value="1" name="sendsms">&nbsp; Envoyer un SMS au client?</label>
                            </div>
                            <div class="form-group">
                                Date abonnement<br><input class="form-control"
                                                          name="date_abonnement" type="date"
                                                          required>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-success"><i
                                    class="fa fa-check fa-fw"></i>Enregistrer
                            </button>
                            <button type="reset" class="btn btn-danger"><i
                                    class="fa fa-times fa-fw"></i>Retour
                            </button>
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">
                                Annuler
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade justify-center justify-content-center"
             id="messageModal{{ $client[0]->id_client }}" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel{{ $client[0]->id_client }}"
             aria-hidden="true">
            <div class="modal-dialog text-center" role="document">
                <div class="modal-content text-center">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel{{ $client[0]->id_client }}">
                            Envoyer un message</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body text-center justify-content-center align-content-center">
                        <form role="form" id="abonneForm{{ $client[0]->id_client }}" method="post"
                              action="{{ route('send.message') }}">
                            @csrf
                            <input type="hidden" name="id_client" value="{{ $client[0]->id_client }}">
                            <input type="hidden" name="phone"
                                   value="{{ $client[0]->telephone_client }}">
                            <input type="hidden" name="nom_client"
                                   value="{{ $client[0]->nom_client }}">
                            <div class="form-group">
                                <label><span><i class="fas fa-address-book"></i> </span> Nom client</label>
                                <input class="form-control text-uppercase" type="text"
                                       value="{{ $client[0]->nom_client }}"
                                       name="nom" disabled>
                            </div>
                            <div class="form-group">
                                <label><span><i class="fas fa-phone"></i> </span> Numéro du
                                    client</label>
                                <input class="form-control text-uppercase" type="text"
                                       value="{{ $client[0]->telephone_client }}"
                                       name="tel" disabled>
                            </div>
                            <div class="for-group">
                                <select name="id_message" id="showmessage{{ $client[0]->id_client }}"
                                        onchange="showSMSArea({{$client[0]->id_client}})"
                                        class="form-control showarea">
                                    <option value="0">Message Standart</option>
                                    @foreach($messages as $sms => $value)
                                        <option
                                            value="{{ $value->id_message }}"> {{ $value->titre_sms }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group messagearea"
                                 id="message0{{ $client[0]->id_client }}">
                                <label><span><i class="fas fa-pen"></i></span>Message</label>
                                <textarea class="form-control" name="message"
                                          placeholder="Saisisser un message ici..."></textarea>
                            </div>
                            @foreach($messages as $sms => $value)
                                <div class="form-group hidden messagearea"
                                     id="message{{ $value->id_message }}{{ $client[0]->id_client }}">
                                    <label><span><i class="fas fa-pen"></i></span>Message</label>
                                    <textarea class="form-control"
                                              name="message">{{ $value->message }}</textarea>
                                </div>
                            @endforeach

                            <hr>
                            <button type="submit" class="btn btn-success"><i
                                    class="fa fa-check fa-fw"></i>Envoyer
                            </button>
                            <button type="reset" class="btn btn-danger"><i
                                    class="fa fa-times fa-fw"></i>Retour
                            </button>
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">
                                Annuler
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
<script>
    $('input[name="operation"]').change(function () {
        var operation = $('input[name="operation"]:checked').val();
        if (operation == 1) {
            $('.selectdecodeur').removeClass('hidden');
            $('.selectdecodeur').show(100);
            $('.enternum').addClass('hidden');
            $('.enternumprise').addClass('hidden');
        } else {
            $('.selectdecodeur').hide(100);
            $('.enternum').removeClass('hidden');
            // $('#enternumprise').removeClass('hidden');
        }
        // alert(operation);
    });
    function showSMSArea(id) {
        $('.messagearea').addClass('hidden');
        var value = $('#showmessage' + id).val();
        $('#message' + value + id).removeClass('hidden');

    }
    function showselectedSMSArea() {
        $('.selectmessagearea').addClass('hidden');
        var value = $('#showselectmessage').val();
        $('#message' + value).removeClass('hidden');

    }
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
