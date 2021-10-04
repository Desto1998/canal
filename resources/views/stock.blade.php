<x-app-layout>
  <x-slot name="slot">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
          @if (session()->has('message'))
                <div class="bd-teal-100 border-t-4 border-teal-500 rounded-b px-4 py-3 shadow-md my-3 text-teal-900" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{session('message')}}</p>
                        </div>
                    </div>
                </div>

          @endif
      </div>
        <div class="col-md-9">
            <div class="card-header py-3">
                <h4 class="m-2 font-weight-bold text-primary">Ajouter un décodeur&nbsp;<a  href="{{ route('add.client')}}" data-toggle="modal"  data-target="#materielModal1" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i class="fas fa-fw fa-plus"></i></a></h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Numero décodeur</th>
                            <th>Prix</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allDecodeurs as $key => $dec)
                        <tr>
                            <td>{{ $dec->num_decodeur }}</td>
                            <td>{{ $dec->prix_decodeur }}</td>
                            <td align="center">
                            <a type="button" class="btn btn-warning" title="Modifier" href="">
                              <i class="fas fa-fw fa-edit"></i>
                            </a>
                            <a type="button" class="btn btn-danger" title="Supprimer" href="">
                              <i class="fas fa-fw fa-trash"></i>
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
        <div class="col-md-6">
            <div class="card-header py-3">
                <h4 class="m-2 font-weight-bold text-primary">Ajouter un accessoire&nbsp;<a  href="{{ route('add.client')}}" data-toggle="modal"  data-target="#materielModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i class="fas fa-fw fa-plus"></i></a></h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nom assessoire</th>
                            <th>Prix</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allMateriels as $key => $mat)
                        <tr>
                            <td>{{ $mat->nom_materiel }}</td>
                            <td>{{ $mat->prix_materiel }}</td>
                            <td align="right">
                            <a type="button" class="btn btn-warning" title="Modifier" href="">
                              <i class="fas fa-fw fa-edit"></i>
                            </a>
                            <a type="button" class="btn btn-danger" title="Supprimer"  href="">
                              <i class="fas fa-fw fa-edit"></i>
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




      </div>
  </x-slot>
</x-app-layout>
<script>
    function controlNumero(val){
        // alert("test");
        var long = $('#num_decodeur1').val();
        if(long.length != 14){
            $('.ereur-numerodd').removeClass('hidden');
        }else{
            $('.ereur-numerodd').addClass('hidden');
        }
        // if ($.isNumeric(value) == '') {
        //     alert('Veillez entrer un nombre compris entre 0 et 20. Merci!');
        //     return false;
        // }
    }
    $( "#decodeurForm" ).submit(function( event ) {

        var numdeco = $('#num_decodeur1').val();
        if(numdeco.length == 14){
            $('.ereur-numerodd').addClass('hidden');
            return;
        }else{
            $('.ereur-numerodd').removeClass('hidden');
            event.preventDefault();
        }

    });

</script>
