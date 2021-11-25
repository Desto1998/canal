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

