<x-app-layout>
    <x-slot name="slot">
        <center>
            <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
                <div class="card-header py-3">
                    <h4 class="m-2 font-weight-bold text-primary">Modifier une formule</h4>
                </div><a  type="button" class="btn btn-primary bg-gradient-primary btn-block" href="{{route('modifier')}}"> <i class="fas fa-flip-horizontal fa-fw fa-share"></i> Retour </a>
                <div class="card-body">


                    <form role="form" method="post" action="{{route('update.formule',$datas->id_formule)}}">
                      @csrf

                      <div class="form-group">
                        Nom formule<br><input class="form-control" placeholder="{{ $datas->nom_formule }}" name="nom_formule" required>
                      </div>
                      <div class="form-group">
                        Prix formule<br><input class="form-control" placeholder="{{ $datas->prix_formule }}" name="prix_formule" required>
                      </div>
                      <hr>


                        <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-edit fa-fw"></i>Modifier</button>
                </form>
            </div>
            </div>
        </center>
    </x-slot>
  </x-app-layout>
