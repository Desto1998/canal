<x-app-layout>
    <x-slot name="slot">
        <center>
            <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
                <div class="card-header py-3">
                    <h4 class="m-2 font-weight-bold text-primary">Upgrader client</h4>
                </div><a  type="button" class="btn btn-primary bg-gradient-primary btn-block" href="{{route('upgrader')}}"> <i class="fas fa-flip-horizontal fa-fw fa-share"></i> Retour </a>
                <div class="card-body">


                    <form role="form" method="post" action="{{route('upgrade.client',$datas->id_client)}}">
                      @csrf

                      <div class="form-group">
                        Nom client<br><input class="form-control" placeholder="{{ $datas->nom_client }}" name="nom_client" disabled>
                      </div>
                      <div class="form-group">
                        Prenom client<br><input class="form-control" placeholder="{{ $datas->prenom_client }}" name="prenom_client" disabled>
                      </div>
                      <div class="form-group">
                        N° téléphone client<br><input class="form-control" placeholder="{{ $datas->telephone_client }}" name="telephone_client" disabled>
                      </div>
                      <div class="form-group">
                        N° decodeur<br><input class="form-control" placeholder="{{ $decodeur->num_decodeur }}" name="num_decodeur" disabled>
                      </div>
                      <div class="form-group">
                        Adresse client<br><input class="form-control" placeholder="{{ $datas->adresse_client }}" name="adresse_client" disabled>
                      </div>
                      <div class="form-group">
                        Formule précedent :<br><input class="form-control" placeholder="{{ $formule->nom_formule }}" name="adresse_client" disabled>
                      </div>
                      <div class="form-group">
                        Formule nouvelle : <select  name="formule" required>
                          <option value="ACCESS" selected> ACCESS </option>
                          <option value="ACCESS +"> ACCESS + </option>
                          <option value="EVASION"> EVASION </option>
                          <option value="EVASION +"> EVASION + </option>
                          <option value="EVASION"> Essentiel </option>
                          <option value="EVASION +"> Essentiel + </option>
                          <option value="EVASION +"> Tout canal </option>
                         </select>
                      </div>
                      <hr>


                        <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-edit fa-fw"></i>Upgrader</button>
                </form>
            </div>
            </div>
        </center>
    </x-slot>
  </x-app-layout>
