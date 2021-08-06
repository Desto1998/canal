<x-app-layout>
    <x-slot name="slot">
        <center>
            <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
                <div class="card-header py-3">
                    <h4 class="m-2 font-weight-bold text-primary">Réabonner client</h4>
                </div><a  type="button" class="btn btn-primary bg-gradient-primary btn-block" href="{{route('review.reabonner')}}"> <i class="fas fa-flip-horizontal fa-fw fa-share"></i> Retour </a>
                <div class="card-body">


                    <form role="form" method="post" action="{{route('updateR.client',$datas->id_client)}}">
                      @csrf

                      <div class="form-group">
                        Nom client<br><input class="form-control" placeholder="{{ $datas->nom_client }}"  disabled>
                        <input class="form-control" type="hidden" value="{{ $datas->nom_client }}" name="nom_client" >
                      </div>
                      <div class="form-group">
                        Prenom client<br><input class="form-control" placeholder="{{ $datas->prenom_client }}" name="prenom_client" disabled>
                      </div>
                      <div class="form-group">
                        N° téléphone client<br><input class="form-control" placeholder="{{ $datas->telephone_client }}" disabled>
                       <input class="form-control" type="hidden" value="{{ $datas->telephone_client }}" name="telephone_client" >
                      </div>
                      <div class="form-group">
                        Adresse client<br><input class="form-control" placeholder="{{ $datas->adresse_client }}" name="adresse_client" disabled>
                      </div>
                      <div class="form-group">
                          Décodeurs: <select name="id_decodeur">
                              @foreach($decos as $key => $val)
                                  <option value="{{$val->id_decodeur}}">{{$val->num_decodeur}}</option>
                                  @endforeach
                          </select>
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
                        <label><input type="radio" required name="type" value="1">&nbsp;Payé content</label>
                        <label class="ml-4"><input required type="radio" value="0" name="type">&nbsp; A crédit</label>
                      </div>
                        <div class="form-group">
                        Date reabonnement<br><input class="form-control" placeholder="{{ $datas->data_reabonnement }}" value="Date de reabonnement" name="date_reabonnement" type="date" required>
                      </div>
                      <hr>


                        <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-edit fa-fw"></i>Réabonner</button>
                </form>
            </div>
            </div>
        </center>
    </x-slot>
</x-app-layout>
