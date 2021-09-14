<meta charset="utf-8">
<x-app-layout>
    <x-slot name="slot">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h4 class="m-2 font-weight-bold text-primary">Nouvel abonnement&nbsp;<a  href="{{ route('add.client')}}" data-toggle="modal"  data-target="#clientModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i class="fas fa-fw fa-plus"></i></a></h4>
            <label class="mr-5"><a class="btn btn-primary" href="{{route('user.abonnement.jour')}}"> Abonnements du jour</a></label>
            <label class="ml-4"><a class="btn btn-success"  href="{{route('user.abonnement')}}"> Tous mes abonnements</a></label>
        </div>
          @include('layouts/flash-message')


          <div class="modal fade " id="clientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          Nom client<br><input class="form-control" type="text"  placeholder="Nom" name="nom_client" required>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          Prenom client<br><input class="form-control" type="text" placeholder="Prenom" name="prenom_client" required>
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          Numero d'abonné<br><input type="number" class="form-control" maxlength="8" minlength="8" type="text" onblur="controlNumero1(this)" placeholder="numero abonne" name="num_abonne" id="num_abonne" required>
                                          <span class="text-danger hidden ereur-numeroa " style=""> Mauvaise saisie Longeur requise 8</span>
                                          @error('num_decodeur')
                                          <div class="invalid-feedback">{{ $message }}</div>
                                          @enderror
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          N° téléphone client<br><input class="form-control" type="tel" placeholder="Numéro de téléphone" name="telephone_client" required>
                                      </div>
                                  </div>
                              </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            Adresse client<br><input class="form-control" type="text" placeholder="Adresse" name="adresse_client" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            Numero décodeur<br>
                                            @if(isset($decodeur))

                                                <select class="form-control" required="Sélectionnez un decodeur SVP." name="num_decodeur" id="num_decodeur">
                                                    <option>Sélectionner un decodeur</option>
                                                    @foreach($decodeur as $key =>$deco)
                                                        @php
                                                            $comp = 0;
                                                        @endphp
                                                        @foreach($clientdecodeur as $k =>$clientdeco)
                                                            @if($deco->id_decodeur == $clientdeco->id_decodeur)

                                                                @php
                                                                    $comp++;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        @if($comp==0)
                                                            <option value="{{$deco->num_decodeur}}">{{$deco->num_decodeur}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                {{--                            <input type="number" class="form-control" maxlength="14" minlength="14" type="number" onblur="controlNumero(this)" placeholder="Numero decodeur" name="num_decodeur" id="num_decodeur" required>--}}
                                                {{--                            <span class="text-danger hidden ereur-numerod " style=""> Mauvaise saisie Longeur requise 14</span>--}}
                                                {{--                            @error('num_decodeur')--}}
                                                {{--                            <div class="invalid-feedback">{{ $message }}</div>--}}
                                                {{--                            @enderror--}}

                                            @else
                                                <span class="text-danger">Aucun décodeur n'est disponible veiller enregistrer un décodeur.</span>
                                            @endif

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



        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                  <tr>

                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Numéro de téléphone</th>
                    <th>Numero d'abonné</th>
                    <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                @foreach($allClients as $key => $client)
                <tr>

                    <td><strong>{{ $client->prenom_client }}</strong></td>
                    <td><strong>{{ $client->nom_client }}</strong></td>
                    <td><strong>{{ $client->telephone_client }}</strong></td>
                    <td><strong>{{ $client->num_abonne }}</strong></td>
                    <td class="text-center">
                        <div class="btn_group">
                            <div class="btn-group">
                                <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow" data-toggle="dropdown" >
                                ... <span class="caret"></span></a>
                                <ul class="dropdown-menu text-center" role="menu">
                                    <li>
                                        <a class="btn btn-info" href="{{ route('clients.show', $client->id_client) }}" title="Details sur le client"><i class="fas fa-fw fa-list-alt"></i> </a>

                                        <a type="button" class="btn btn-warning" title="Modifier les infos du client"  href="{{route('edit.client',$client->id_client)}}">
                                        <i class="fas fa-fw fa-edit"></i>
                                        </a>

                                    </li>
                                </ul>
                            </div>
                        </div>
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
<script>
    function controlNumero1(){


      var long = $('#num_abonne').val();

      if(long.length != 8){
         $('.ereur-numeroa').removeClass('hidden');
      }else{
        $('.ereur-numeroa').addClass('hidden');
      }

    }
    function controlNumero(val){
        // alert("test");
        var long = $('#num_decodeur').val();
        if(long.length != 14){
            $('.ereur-numerod').removeClass('hidden');
        }else{
            $('.ereur-numerod').addClass('hidden');
        }

    }
    $( "#abonneForm" ).submit(function( event ) {

        var numdeco = $('#num_decodeur').val();
        var numabonne = $('#num_abonne').val();
        if(numdeco.length == 14){
            $('.ereur-numerod').addClass('hidden');
            return;
        }else{
            $('.ereur-numerod').removeClass('hidden');
            event.preventDefault();
        }
        if(numabonne.length == 8){
            $('.ereur-numeroa').addClass('hidden');
            return;
        }else{
            $('.ereur-numeroa').removeClass('hidden');
            event.preventDefault();
        }
        // $( "span" ).text( "Not valid!" ).show().fadeOut( 1000 );
        // event.preventDefault();
    });

</script>
