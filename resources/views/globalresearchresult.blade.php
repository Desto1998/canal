<x-app-layout>
    <x-slot name="slot">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-2 font-weight-bold text-primary">Resultats de la recherche ({{ count($data) }} résultats trouvés)</h4>

            </div>
            @include('layouts/flash-message')

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable_1" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Numéro de téléphone</th>
                            <th>Numéro abonné</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($data as $key => $client)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td><strong>{{ $client->prenom_client }}</strong></td>
                                <td><strong>{{ $client->nom_client }}</strong></td>
                                <td><strong>{{ $client->telephone_client }}</strong></td>
                                <td><strong>{{ $client->num_abonne }}</strong></td>

                                <td class="text-center"><div class="btn_group">
                                        <div class="btn-group">
                                            <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow" data-toggle="dropdown" style="color:white;">
                                                <i class="fas fa-fw fa-list-alt"></i> <span class="caret"></span></a>
                                            <ul class="dropdown-menu text-center" role="menu">
                                                <li>
                                                    <a class="btn btn-info m-1" href="{{ route('clients.show', $client->id_client) }}" title="Details"><i class="fas fa-fw fa-list-alt"></i> </a>

                                                    <a type="button" class="btn btn-primary m-1 text-white" title="Ajouter un décodeur" href="#"  data-toggle="modal"  data-target="#materielClientModal1{{ $client->id_client }}">
                                                        <i class="fas fa-fw fa-plus"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a type="button" class="btn btn-warning m-1" title="Modifier"  href="{{ route('edit.client',$client->id_client)}}">
                                                        <i class="fas fa-fw fa-edit"></i>
                                                    </a>

                                                    <a type="button"  class="btn btn-danger m-1" title="Supprimer" href="javascript:void(0);"
                                                       onclick="deleteFunc({{ $client->id_client }})">
                                                        <i class="fas fa-fw fa-trash"></i>
                                                    </a>
                                                    <a type="button" class="btn btn-success m-1" title="Réabonner"  href="{{ route('reabonne.client',$client->id_client)}}">
                                                        <i class="fas fa-fw fa-check"></i>
                                                    </a>
                                                </li>
                                                <li>

                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="materielClientModal1{{ $client->id_client }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel{{ $client->id_client }}">Ajouter un décodeur</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" id="decodeurForm{{ $client->id_client }}" method="post" action="{{ route('clients.new_decodeur') }}">
                                                @csrf
                                                <input type="hidden" name="id_client" value="{{ $client->id_client }}">
                                                <div class="form-group">
                                                    Numero décodeur<br><input type="number" class="form-control"  maxlength="14" minlength="14" placeholder="numero decodeur" onblur="controlNumero(this)" class="form-control  @error('num_decodeur') is-invalid @enderror" name="num_decodeur" id="num_decodeur1"  required>
                                                    <span class="text-danger hidden ereur-numerodd " style=""> Mauvaise saisie Longeur minimale 14</span>
                                                    @error('num_decodeur')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label > Prix du décodeur </label>
                                                    <input type="number" name="prix_decodeur" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    Formule: <select  name="formule" required>
                                                        <option value="ACCESS" selected> ACCESS </option>
                                                        <option value="ACCESS +"> ACCESS + </option>
                                                        <option value="EVASION"> EVASION </option>
                                                        <option value="EVASION +"> EVASION + </option>
                                                        <option value="PRESTIGE"> PRESTIGE </option>
                                                        <option value="ESSENTIEL +"> ESSENTIEL + </option>
                                                        <option value="TOUT CANAL"> TOUT CANAL </option>
                                                    </select>
                                                    Durée:  <select  name="duree" required>
                                                        <option value=1 selected> 1 mois </option>
                                                        <option value=2> 2 mois </option>
                                                        <option value=3> 3 mois </option>
                                                        <option value=6> 6 mois </option>
                                                        <option value=9> 9 mois </option>
                                                        <option value=12> 12 mois </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    Date abonnement<br><input class="form-control" name="date_abonnement" type="date" required>
                                                </div>
                                                <hr>
                                                <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Enregistrer</button>
                                                <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Retour</button>
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        </div>
    </x-slot>
</x-app-layout>
<script>
    function deleteFunc(id_client) {
        // $('#success').addClass('hidden');
        // $('#error').addClass('hidden');
        if (confirm("Supprimer ce Client?") == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('client.delete') }}",
                data: {id_client: id_client},
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
