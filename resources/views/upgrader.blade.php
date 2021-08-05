<x-app-layout>
  <x-slot name="slot">
    <div class="row show-grid">
      <!-- Clients -->
      <div class="col-md-6">
        <!-- Nombre Clients -->
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h4 class="m-2 font-weight-bold text-primary">Upgrader un client</h4>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable_1" width="100%" cellspacing="0">
                <thead>
                    <tr>
                      <th>Prénom</th>
                      <th>Nom</th>
                      <th>Numéro de téléphone</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($allClients as $key => $client)
                  <tr>
                      <td><strong>{{ $client->prenom_client }}</strong></td>
                      <td><strong>{{ $client->nom_client }}</strong></td>
                      <td><strong>{{ $client->telephone_client }}</strong></td>
                      <td align="right"><div class="btn_group">
                        <a type="button" class="btn btn-warning bg-gradient-warning btn-block" style="border-radius: 0px;" href="{{route('up.client',$client->id_client)}}">
                          <i class="fas fa-fw fa-edit"></i> Upgrader
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
        <!-- Abonnés bientot à terme -->
        <div class="col-md-6">
          <!-- Nombre Clients -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h4 class="m-2 font-weight-bold text-primary">Modifier une formule</h4>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable_2" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th>Nom formule</th>
                        <th>Prix</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($allFormules as $key => $formule)
                    <tr>
                        <td><strong>{{ $formule->nom_formule }}</strong></td>
                        <td><strong>{{ $formule->prix_formule }}</strong></td>
                        <td align="right"><div class="btn_group">
                          <a type="button" class="btn btn-info bg-gradient-info btn-block" style="border-radius: 0px;" href="{{route('edit.formule',$formule->id_formule)}}">
                            <i class="fas fa-fw fa-edit"></i> Modifier
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

    <div class="row show-grid">
      <!-- Clients -->
      <div class="col-md-6">
        <!-- Nombre Clients -->
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h4 class="m-2 font-weight-bold text-primary">Modifier le prix d'un materiel</h4>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable_3" width="100%" cellspacing="0">
                <thead>
                    <tr>
                      <th>Nom matériel</th>
                      <th>Prix</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  <tr>
                      <td><strong>Accessoires</strong></td>
                      @foreach($allMateriels as $key => $mat)
                      <td><strong>{{ $mat->prix_materiel }}</strong></td>
                      <td align="right"><div class="btn_group">
                        <a type="button" class="btn btn-success bg-gradient-success btn-block" style="border-radius: 0px;" href="{{route('edit.materiel',$mat->id_materiel)}}">
                          <i class="fas fa-fw fa-edit"></i> Modifier
                        </a>
                      </td>
                  </tr>
                 @endforeach
                  <tr>
                      <td><strong>Decodeur</strong></td>
                      @foreach($allDecodeurs as $key => $dec)
                        <td><strong>{{ $dec->prix_decodeur }}</strong></td>
                      <td align="right"><div class="btn_group">
                        <a type="button" class="btn btn-success bg-gradient-success btn-block" style="border-radius: 0px;" href="{{route('edit.materiel',$dec->id_decodeur)}}">
                          <i class="fas fa-fw fa-edit"></i> Modifier
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
        <!-- Abonnés bientot à terme -->
        <div class="col-md-6">
          <!-- Nombre Clients -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h4 class="m-2 font-weight-bold text-primary">Modifier un utilisateur</h4>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable_4" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th>Nom complet</th>
                        <th>email</th>
                        <th>Numéro de téléphone</th>
                        <th>Role</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($allUsers as $key => $user)
                    <tr>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td><strong>{{ $user->email }}</strong></td>
                        <td><strong>{{ $user->telephone }}</strong></td>
                        <td><strong>{{ $user->role }}</strong></td>
                        <td align="right"><div class="btn_group">
                          <a type="button" class="btn btn-secondary bg-gradient-secondary btn-block" style="border-radius: 0px;" href="{{route('edit.client',$user->id)}}">
                            <i class="fas fa-fw fa-edit"></i> Modifier
                          </a>
                    </tr>
                @endforeach

                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
    </div>




    </div>
  </x-slot>
</x-app-layout>