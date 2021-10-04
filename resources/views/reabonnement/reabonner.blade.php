<x-app-layout>
    <x-slot name="slot">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h4 class="m-2 font-weight-bold text-primary">Réabonnement</h4>
            <h4 class="m-2 font-weight-bold text-primary">Nouveau&nbsp;<a  href="{{ route('add.client')}}" data-toggle="modal"  data-target="#clientModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i class="fas fa-fw fa-plus"></i></a></h4>
            <label class=""><a class="btn btn-primary" href="{{route('user.reabonnement.jour')}}"> Reabonnements
                    du jour</a></label>
            <label class="ml-6"><a class="btn btn-success" href="{{route('user.reabonnement')}}"> Tous mes
                    reabonnements</a></label>
            <label class="ml-6"><a class="btn btn-info" href="{{route('user.reabonnement.all')}}"> Tous les
                    reabonnements</a></label>
            <label class="ml-6"><a class="btn btn-danger" href="{{route('user.reabonnement.credit')}}">
                    Reabonnements à crédit</a></label>
        </div>
          <div class="modal fade"  id="clientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog"  role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Ajouter un client</h5>
                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <form role="form" id="abonneForm" method="post" action="{{ route('store.client.reabonnement') }}">
                              @csrf
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          Nom client<br><input class="form-control" type="text"  placeholder="Nom" name="nom_client" required>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          Prenom client<br><input class="form-control" type="text" placeholder="Prenom" name="prenom_client">
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          Numero d'abonné<br><input type="text" class="form-control" maxlength="15" minlength="8" type="text" onblur="controlNumero1(this)" placeholder="numero abonne" name="num_abonne" id="num_abonne" required>
                                          <span class="text-danger hidden ereur-numeroa " style=""> Mauvaise saisie Longeur requise 8</span>
                                          @error('num_decodeur')
                                          <div class="invalid-feedback">{{ $message }}</div>
                                          @enderror
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          N° téléphone client<br>
                                          <input class="form-control" type="tel" placeholder="Numéro de téléphone" name="telephone_client" required>
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          Adresse client<br>
                                          <input class="form-control" type="text" placeholder="Adresse" name="adresse_client" required>
                                      </div>
                                  </div>
                                  <div class="col-md-6 enterdecodeur" id="enterdecodeur">
                                      <div class="form-group">
                                          Numero décodeur<br>
                                          <input type="text" class="form-control" maxlength="20" minlength="10" type="text"  placeholder="numero du decodeur" name="num_decodeur" id="num_decodeur" required>
                                      </div>
                                  </div>

                              </div>
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">

                                          Formule: <select class="form-control"  name="formule" required>
                                              <option value="ACCESS" selected> ACCESS </option>
                                              <option value="ACCESS +"> ACCESS + </option>
                                              <option value="EVASION"> EVASION </option>
                                              <option value="EVASION +"> EVASION + </option>
                                              <option value="PRESTIGE"> PRESTIGE </option>
                                              <option value="ESSENTIEL +"> ESSENTIEL + </option>
                                              <option value="TOUT CANAL"> TOUT CANAL </option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          Durée:  <select class="form-control" name="duree" required>
                                              <option value=1 selected> 1 mois </option>
                                              <option value=2> 2 mois </option>
                                              <option value=3> 3 mois </option>
                                              <option value=6> 6 mois </option>
                                              <option value=9> 9 mois </option>
                                              <option value=12> 12 mois </option>
                                          </select>
                                      </div>
                                  </div>
                              </div>
                              <div class="form-group align-content-center">
                                  <label><input type="radio" required name="type" value="1">&nbsp;Payé content</label>
                                  <label class="ml-4"><input required type="radio" value="0" name="type">&nbsp; A
                                      crédit</label>
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
@include('layouts.flash-message')
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                  <tr>
                    <th>#</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Numéro de téléphone</th>
                    <th>Numero abonné</th>
                    <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                @foreach($allClients as $key => $client)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $client->prenom_client }}</td>
                    <td>{{ $client->nom_client }}</td>
                    <td>{{ $client->telephone_client }}</td>
                    <td>
                        @foreach($clientdecodeur as $d =>$item)
                            @if($item->id_client===$client->id_client)
                                <span class="bg-info p-1 text-center m-1 text-white" >{{ $item->num_abonne }} </span>
                            @endif
                        @endforeach
                    </td>
                    <td class="text-center">
                      <a type="button" class="btn btn-warning" title="Réabonner"  href="{{route('reabonne.client',$client->id_client)}}">
                        <i class="fas fa-fw fa-plus"></i>
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
    </x-slot>
</x-app-layout>
