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
                                                            <a type="button" class="btn btn-warning" title="Modifier"
                                                               href="">
                                                                <i class="fas fa-fw fa-edit"></i>
                                                            </a>
                                                            <a type="button" class="btn btn-danger" title="Supprimer"
                                                               href="">
                                                                <i class="fas fa-fw fa-trash"></i>
                                                            </a>
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
                                                    class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i
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
                                                                <a type="button" class="btn btn-warning" title="Modifier"
                                                                   href="">
                                                                    <i class="fas fa-fw fa-edit"></i>
                                                                </a>
                                                                <a type="button" class="btn btn-danger" title="Supprimer"
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

                                    </div>
                                    <div class="card-body">
                                        esdflfwffweklklejrewrjwelkjrwekrjeklrjekrjeklwrjekwrjwekrj
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </x-slot>
</x-app-layout>
<script>
    $('#prix_unitaire').change(function (e){
        var qte = $('#qte').val();
        var pu = $('#prix_unitaire').val();
        var total = 0;
        if ($.isNumeric(qte) && $.isNumeric(pu)){
            total = pu * qte;
            $('#total').val(total);
        }else {
            $('#total').val(total);
            e.preventDefault();
        }
    });
    $('#qte').change(function (e){
        var qte = $('#qte').val();
        var pu = $('#prix_unitaire').val();
        var total = 0;
        if ($.isNumeric(qte) && $.isNumeric(pu)){
            total = pu * qte;
            $('#total').val(total);
        }else {
            $('#total').val(total);
            e.preventDefault();
        }
    });
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
