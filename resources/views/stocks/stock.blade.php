<x-app-layout>
    <x-slot name="slot">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <!-- Nav tabs -->
                <h6 class="text-primary">Gestion des stocks</h6>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#EtatStock" role="tab"><span
                                class="hidden-sm-up"></span> <span class="hidden-xs-down">Etat des stocks</span></a>
                    </li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#EtatVente" role="tab"><span
                                class="hidden-sm-up"></span> <span class="hidden-xs-down">Vente de matériel</span></a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                @include('layouts.flash-message')
                <div class="tab-content tabcontent-border">
                    <div class="tab-pane active pt-2" id="EtatStock" role="tabpanel">
                        <div class="p-20">
                            <div class="col-md-12">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h4 class="m-2 font-weight-bold text-primary">Ajouter un décodeur&nbsp;<a
                                                href="{{ route('add.client')}}" data-toggle="modal"
                                                data-target="#materielModal1" type="button"
                                                class="btn btn-primary"><i
                                                    class="fas fa-fw fa-plus"></i></a></h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                   cellspacing="0">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Numero décodeur</th>
                                                    <th>Prix</th>
                                                    <th>Crée le</th>
                                                    <th>Ajouté par</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($allDecodeurs as $key => $dec)
                                                    <tr>
                                                        <td>{{ $key+1     }}</td>
                                                        <td>{{ $dec->code_stock }}</td>
                                                        <td>{{ $dec->prix_unit }}</td>
                                                        <td>{{ $dec->date_ajout }}</td>
                                                        <td>{{ $dec->name }}</td>
                                                        <td align="center">
                                                            {{--                                                            <a type="button" class="btn btn-warning" title="Modifier"--}}
                                                            {{--                                                               href="">--}}
                                                            {{--                                                                <i class="fas fa-fw fa-edit"></i>--}}
                                                            {{--                                                            </a>--}}
                                                            <button type="button"
                                                                    {{ Auth::user()->is_admin==1?'':'disabled' }} onclick="deleteFunc({{ $dec->id_stock }})"
                                                                    class="btn btn-danger" title="Supprimer"
                                                                    href="javascript:void(0)">
                                                                <i class="fas fa-fw fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="accessoire" class="mt-5">
                                    <div class="card">
                                        <div class="card-header py-3">
                                            <h4 class="m-2 font-weight-bold text-primary">Ajouter un accessoire&nbsp;<a
                                                    href="{{ route('add.client')}}" data-toggle="modal"
                                                    data-target="#materielModal" type="button"
                                                    class="btn btn-primary bg-gradient-primary"
                                                    style="border-radius: 0px;"><i
                                                        class="fas fa-fw fa-plus"></i></a></h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="dataTable" width="100%"
                                                       cellspacing="0">
                                                    <thead>
                                                    <tr>
                                                        <th>Nom assessoire</th>
                                                        <th>Prix</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($allMateriels as $key => $mat)
                                                        <tr>
                                                            <td>{{ $mat->nom_materiel }}</td>
                                                            <td>{{ $mat->prix_materiel }}</td>
                                                            <td align="right">
                                                                {{--                                                                <a type="button" class="btn btn-warning" title="Modifier"--}}
                                                                {{--                                                                   href="">--}}
                                                                {{--                                                                    <i class="fas fa-fw fa-edit"></i>--}}
                                                                {{--                                                                </a>--}}
                                                                <a type="button" class="btn btn-danger"
                                                                   title="Supprimer"
                                                                   href="">
                                                                    <i class="fas fa-fw fa-edit"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane active pt-2" id="EtatVente" role="tabpanel">
                        <div class="p-20">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="text-primary">Liste des ventes</h6>
                                        <div class="">
                                            <h4 class="m-2 font-weight-bold text-primary pull-right -align-right float-right">
                                                Effectuer une vente&nbsp;<a
                                                    href="#" data-toggle="modal"
                                                    data-target="#upgradeModal" type="button"
                                                    class="btn btn-primary"><i
                                                        class="fas fa-fw fa-plus"></i></a></h4>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                   cellspacing="0">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nom du client</th>
                                                    <th>Numéro Dec</th>
                                                    <th>Montant</th>
                                                    <th>Date</th>
                                                    <th>Effectué par</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($allVentes as $key => $item)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{ $item->nom_client }}</td>
                                                        <td>{{ $item->code_stock }}</td>
                                                        <td>{{ $item->montant_vente }}</td>
                                                        <td>{{ $item->date_vente }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td class="text-center">
                                                            {{--                                                                <a type="button" class="btn btn-warning" title="Modifier"--}}
                                                            {{--                                                                   href="">--}}
                                                            {{--                                                                    <i class="fas fa-fw fa-edit"></i>--}}
                                                            {{--                                                                </a>--}}
                                                            <button type="button"
                                                                    {{ Auth::user()->is_admin==1?'':'disabled' }} onclick="deleteVente({{ $item->id_vente }})"
                                                                    class="btn btn-danger"
                                                                    title="Supprimer cette vente">
                                                                <i class="fas fa-fw fa-trash"></i>
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
                        </div>
                    </div>
                </div>

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
                        <form role="form" id="abonneForm" method="post" action="{{ route('stock.sale.add') }}">
                            @csrf
                            <div class="row pl-6">
                                <label class="ml-6"><input type="checkbox" value="1" class="checkbox" id="check"
                                                           name="check">
                                    Le client existe dejà dans le systéme
                                </label>
                            </div>
                            <div class="row select-client hidden" hidden id="select-client">
                                <div class="form-group">
                                    <label class="pl-4 mr-4">Sélectioner un client</label>
                                    <select class="selectpicker  show-tick" name="id_client" id="selectclient"
                                            data-live-search="true">
                                        <option disabled="disabled" selected>Sélectioner un client</option>
                                        @foreach($clients as $c=>$client)
                                            <option data-tokens="{{ $client->id_client }}"
                                                    value="{{ $client->id_client }}"
                                                    data-subtext="{{ $client->telephone_client }}">{{ $client->nom_client.' '.$client->prenom_client }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mainblock" id="infosblock0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            Nom client<br><input class="form-control" type="text" placeholder="Nom"
                                                                 name="nom_client">
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
                                            N° téléphone client<br><input class="form-control" type="tel"
                                                                          placeholder="Numéro de téléphone"
                                                                          name="telephone_client">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            Adresse client<br><input class="form-control" type="text"
                                                                     placeholder="Adresse" name="adresse_client">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @foreach($clients as $c=>$client)
                                <div class="hidden infos-block" id="infos-block{{ $client->id_client }}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                Nom client<br>
                                                <input class="form-control" type="text"
                                                       value="{{ $client->nom_client }}" name="nom_clientv" readonly
                                                       disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                Prenom client<br>
                                                <input class="form-control" type="text"
                                                       value="{{ $client->prenom_client }}"
                                                       name="prenom_clientv" readonly disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                N° téléphone client<br>
                                                <input class="form-control" type="tel" readonly disabled
                                                       value="{{ $client->telephone_client }}"
                                                       name="telephone_clientv">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                Adresse client<br>
                                                <input class="form-control" type="text"
                                                       value="{{ $client->adresse_client }}"
                                                       name="adresse_clientv" readonly disabled>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                                <div class="form-group">
                                    <label>Numero d'abonné</label>
                                    <br><input type="text" class="form-control" maxlength="8"
                                                              minlength="8" type="text"
                                                              placeholder="numero abonne" name="num_abonne" required
                                                              id="num_abonne">

                                </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Sélectioner un matériel</label>
                                        <select class="form-control selectpicker show-tick" data-live-search="true"
                                                name="id_stock" required>
                                            <option disabled="disabled" selected>Sélectionne un numéro
                                            </option>
                                            @foreach($allDecodeurs as $dc => $item)
                                                <option
                                                    value="{{ $item->id_stock }}">{{ $item->code_stock }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group text-center col-md-6">
                                    <label>Prix du matériel
                                        <input type="number" name="prix_vente" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <label><input type="checkbox" name="printpdf" value="1">&nbsp;Imprimer la
                                    facture?</label>
                                {{--                                <label class="ml-4"><input  type="checkbox" value="1" name="sendsms">&nbsp; Envoyer un SMS au client?</label>--}}
                            </div>

                            {{--                            <div class="row">--}}
                            {{--                                <div class="col-md-6">--}}
                            {{--                                    <div class="form-group">--}}
                            {{--                                        <label>Formule Actuelle: </label>--}}
                            {{--                                        <select class="form-control" name="oldformule" required>--}}
                            {{--                                            @foreach($formules as $f=>$item)--}}
                            {{--                                                <option--}}
                            {{--                                                    value="{{ $item->id_formule }}"> {{ $item->nom_formule }}</option>--}}
                            {{--                                            @endforeach--}}
                            {{--                                        </select>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="col-md-6">--}}
                            {{--                                    <div class="form-group">--}}
                            {{--                                        <label>Nouvelle Formule: </label>--}}
                            {{--                                        <select class="form-control" name="newformule" required>--}}

                            {{--                                            @foreach($formules as $f=>$item)--}}
                            {{--                                                <option--}}
                            {{--                                                    value="{{ $item->id_formule }}"> {{ $item->nom_formule }}</option>--}}
                            {{--                                            @endforeach--}}

                            {{--                                        </select>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="row">--}}
                            {{--                                <div class="col-md-6">--}}
                            {{--                                    Durée:  <select class="form-control"  name="duree" required>--}}
                            {{--                                        <option value=1 selected> 1 mois </option>--}}
                            {{--                                        <option value=2> 2 mois </option>--}}
                            {{--                                        <option value=3> 3 mois </option>--}}
                            {{--                                        <option value=6> 6 mois </option>--}}
                            {{--                                        <option value=9> 9 mois </option>--}}
                            {{--                                        <option value=12> 12 mois </option>--}}
                            {{--                                    </select>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="col-md-6">--}}
                            {{--                                    <label>Date de reabonnement</label>--}}
                            {{--                                    <input type="date" name="date_reabonnement" class="form-control" required>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="form-group text-center">--}}
                            {{--                                <label><input type="radio" required name="type" value="1">&nbsp;Payé content</label>--}}
                            {{--                                <label class="ml-4"><input required type="radio" value="0" name="type">&nbsp; A crédit</label>--}}
                            {{--                            </div>--}}

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

    </x-slot>
</x-app-layout>
<script>

    function deleteFunc(id) {
        // $('#success').addClass('hidden');
        // $('#error').addClass('hidden');
        if (confirm("Supprimer ce matériel du stock?") == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('stock.delete.decodeur') }}",
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
    function deleteVente(id) {
        // $('#success').addClass('hidden');
        // $('#error').addClass('hidden');
        if (confirm("Supprimer ce matériel du stock?") == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('stock.sale.delete') }}",
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

    $('#prix_unitaire').change(function (e) {
        var qte = $('#qte').val();
        var pu = $('#prix_unitaire').val();
        var total = 0;
        if ($.isNumeric(qte) && $.isNumeric(pu)) {
            total = pu * qte;
            $('#total').val(total);
        } else {
            $('#total').val(total);
            e.preventDefault();
        }
    });
    $('#qte').change(function (e) {
        var qte = $('#qte').val();
        var pu = $('#prix_unitaire').val();
        var total = 0;
        if ($.isNumeric(qte) && $.isNumeric(pu)) {
            total = pu * qte;
            $('#total').val(total);
        } else {
            $('#total').val(total);
            e.preventDefault();
        }
    });

    $('#check').click(function (e) {
        if ($("input[name=check]").is(":checked")) {
            $('.mainblock').addClass('hidden')
            $('#select-client').removeAttr('hidden')
            $('#select-client').show(100)
            var id_client = $('#selectclient').val();
            if (id_client) {
                $('.mainblock').addClass('hidden');
                $('#infos-block' + id_client).removeClass('hidden');
            }
            $('#selectclient').change(function (e) {
                var id_client = $('#selectclient').val();
                var is_check = $('#check').val();
                $('.infos-block').addClass('hidden');
                if (id_client) {
                    $('.mainblock').addClass('hidden');
                    $('#infos-block' + id_client).removeClass('hidden');
                } else {
                    $('.mainblock').removeClass('hidden');
                    $('.infos-block').addClass('hidden');
                }
            })
        } else {
            $('.mainblock').removeClass('hidden')
            $('#select-client').hide(100)
            $('.infos-block').addClass('hidden')

        }

    })
    // function controlNumero(val) {
    //     // alert("test");
    //     var long = $('#num_decodeur1').val();
    //     if (long.length != 14) {
    //         $('.ereur-numerodd').removeClass('hidden');
    //     } else {
    //         $('.ereur-numerodd').addClass('hidden');
    //     }
    //     // if ($.isNumeric(value) == '') {
    //     //     alert('Veillez entrer un nombre compris entre 0 et 20. Merci!');
    //     //     return false;
    //     // }
    // }
    //
    // $("#decodeurForm").submit(function (event) {
    //
    //     var numdeco = $('#num_decodeur1').val();
    //     if (numdeco.length == 14) {
    //         $('.ereur-numerodd').addClass('hidden');
    //         return;
    //     } else {
    //         $('.ereur-numerodd').removeClass('hidden');
    //         event.preventDefault();
    //     }
    //
    // });

</script>
