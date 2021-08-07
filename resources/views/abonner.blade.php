<x-app-layout>
    <x-slot name="slot">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h4 class="m-2 font-weight-bold text-primary">Nouvel abonnement&nbsp;<a  href="{{ route('add.client')}}" data-toggle="modal"  data-target="#clientModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i class="fas fa-fw fa-plus"></i></a></h4>
            <label class="mr-5"><a class="btn btn-primary" href="{{route('user.abonnement.jour')}}"> Abonnements du jour</a></label>
            <label class="ml-4"><a class="btn btn-success"  href="{{route('user.abonnement')}}"> Tous mes abonnements</a></label>
        </div>
          @include('layouts/flash-message')

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
                    <td align="right">
                        <div class="btn_group">
                            <a class="button is-primary" href="{{ route('clients.show', $client->id_client) }}"><i class="fas fa-fw fa-list-alt"></i> Details</a>
                            <div class="btn-group">
                                <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow" data-toggle="dropdown" style="color:white;">
                                ... <span class="caret"></span></a>
                                <ul class="dropdown-menu text-center" role="menu">
                                    <li>
                                        <a type="button" class="btn btn-warning bg-gradient-warning btn-block" style="border-radius: 0px;" href="{{route('edit.client',$client->id_client)}}">
                                        <i class="fas fa-fw fa-edit"></i> Modifier
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
