<x-app-layout>
    <x-slot name="slot">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h4 class="m-2 font-weight-bold text-primary">Nouveau abonnement&nbsp;<a  href="{{ route('add.client')}}" data-toggle="modal"  data-target="#clientModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i class="fas fa-fw fa-plus"></i></a></h4>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                  <tr>
                    <th>#</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Numéro de téléphone</th>
                    <th>Formule</th>
                    <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                @foreach($allClients as $key => $client)
                <tr>
                    <td>{{ $client->id_client }}</td>
                    <td><strong>{{ $client->prenom_client }}</strong></td>
                    <td><strong>{{ $client->nom_client }}</strong></td>
                    <td><strong>{{ $client->telephone_client }}</strong></td>
                    @foreach($allFormules as $key =>$fm)
                      @if($fm->id_formule==$client->id_formule)
                        <td><strong>{{ $fm->nom_formule }}</strong></td>
                      @endif
                    @endforeach
                    <td align="right"><div class="btn_group">
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
