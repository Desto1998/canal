<x-app-layout>
    <x-slot name="slot">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h4 class="m-2 font-weight-bold text-primary">Liste des clients</h4>
            <label class=""><a class="btn btn-success" href="{{route('user.client.nouveau')}}"> Client nouveau</a></label>
            <label class="ml-4"><a class="btn btn-warning"  href="{{route('user.client.terme')}}"> Bientot a terme</a></label>
            <label class="ml-4"><a class="btn btn-danger"  href="{{route('user.client.perdu')}}"> Clients échus</a></label>
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
                @foreach($allClients as $key => $client)
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

                              <a type="button" class="btn btn-primary m-1" title="Ajouter un décodeur" href="{{route('clients',$client->id_client)}}" data-toggle="modal"  data-target="#materielClientModal1">
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
