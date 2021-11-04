<x-app-layout>
  <x-slot name="slot">
      <center>
          <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
              <div class="card-header py-3">
                  <h4 class="m-2 font-weight-bold text-primary">Modifier client</h4>
              </div><a  type="button" class="btn btn-primary bg-gradient-primary btn-block" href="{{route('clients')}}"> <i class="fas fa-flip-horizontal fa-fw fa-share"></i> Retour </a>
              <div class="card-body">


                  <form role="form" method="post" action="{{route('updateM.client')}}">
                    @csrf
                    <input type="hidden" name="id_client" value="{{ $datas->id_client }}" required>
                    <div class="form-group">
                      Nom client<br><input class="form-control" value="{{ $datas->nom_client }}" name="nom_client" required>
                    </div>
                    <div class="form-group">
                      Prenom client<br><input class="form-control" value="{{ $datas->prenom_client }}" name="prenom_client" required>
                    </div>
                    <div class="form-group">
                      N° téléphone client<br><input class="form-control" value="{{ $datas->telephone_client }}" name="telephone_client" required>
                    </div>
{{--                    <div class="form-group">--}}
{{--                      N° decodeur<br><input class="form-control" value="{{ $datas->num_decodeur }}" name="num_decodeur" disabled>--}}
{{--                    </div>--}}
                    <div class="form-group">
                      Adresse client<br><input class="form-control" value="{{ $datas->adresse_client }}" name="adresse_client" required>
                    </div>
                      <hr>
                      Décodeurs
                      @foreach( $decodeurs as $key =>$item)
                          <div class="form-group">
                              <label>Déco N°{{ $key+1 }}</label>
                              <input type="text"  maxlength="14" minlength="14" class="form-control" value="{{ $item->num_decodeur }}" name="num_decodeur[]" required>
                              <input type="hidden"   value="{{ $item->id }}" name="id[]" required>
                              <input type="hidden"   value="{{ $item->id_decodeur }}" name="id_decodeur[]" required>
                          </div>
                      @endforeach
                      <hr>
                      <label>Numéro d'abonné</label>
                      @foreach( $decodeurs as $key =>$item)
                          <div class="form-group">
                              <label>Num abo N°{{ $key+1 }}</label>
                              <input type="text"  maxlength="8" minlength="8" class="form-control" value="{{ $item->num_abonne }}" name="num_abonne[]" required>
                          </div>
                      @endforeach
                    <hr>


                      <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-edit fa-fw"></i>Modifier</button>
              </form>
          </div>
          </div>
      </center>
  </x-slot>
</x-app-layout>
