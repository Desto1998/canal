<meta charset="utf-8">
<x-app-layout>
    <x-slot name="slot">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-2 font-weight-bold text-primary">
                    &nbsp;Ajouter un client
                </h4>
            </div>
            @include('layouts.flash-message')

            <div class="card-body">
                <div class="col-md-12">
                    <form role="form" id="abonneForm" method="post" action="{{ route('client.add') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6" style="border-right: 1px solid #eeeeee">
                                <div class="form-group">
                                    <label>Nom client</label>
                                    <input class="form-control" type="text" placeholder="Nom" name="nom_client" required>
                                </div>

                                <div class="form-group">
                                    <label>Prenom client</label>
                                    <input class="form-control" type="text" placeholder="Prenom" name="prenom_client">
                                </div>

                                <div class="form-group">
                                    <label>N° téléphone client</label>
                                    <input class="form-control" type="tel" maxlength="15" minlength="8" placeholder="Numéro de téléphone" name="telephone_client" required>
                                </div>
                                <div class="form-group">
                                    <label>Adresse client</label>
                                    <input class="form-control" type="text" placeholder="Adresse" name="adresse_client" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-light new-block" id="new-block" title="Ajouter un décodeur"><i class="fa fa-plus"></i></button>
                                <button type="button" class="btn btn-danger remove-block" id="remove-block" title="Effacer tous les décodeurs"><i class="fa fa-trash"></i></button>
                                <div class="add-abonne text-center align-middle justify-content-center mt-4" id="add-abonne">

                                </div>
                            </div>

                        </div>
                        <hr>
                        <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Enregistrer
                        </button>
                        <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Retour</button>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>

<script>
    $('#new-block').click(function (e){

        var addformfield = '<div class="row"><div class="form-group ml-3"><label>Numéro décodeur</label><input type="text" maxlength="14" minlength="10" name="num_decodeur[]" class="form-control" required></div><div class="form-group ml-6"><label>Numéro abonné</label><input type="text" maxlength="8" minlength="8" name="num_abonne[]" class="form-control" required></div></div><hr>'
        $('#add-abonne').append(addformfield);

    });
    $('#remove-block').click(function(e){
        $('#add-abonne').html('');
    });
</script>
