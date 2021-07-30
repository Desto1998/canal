<x-app-layout>
  <x-slot name="slot">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
          <style>
            .marge {
            margin-left: 5em;
            }
          </style>
        <h4 class="m-2 font-weight-bold text-primary">Stock&nbsp;
            <span class="marge">
                <a  href="{{ route('add.client')}}" data-toggle="modal"  data-target="#materielModal1" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 50px;">
                    <i class="fas fa-fw fa-plus"></i>Ajouter un décodeur
                </a>
            </span>
            <span class="marge">
            <a  href="{{ route('add.client')}}" data-toggle="modal"  data-target="#materielModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 50px;">
                <i class="fas fa-fw fa-plus"></i>Ajouter un accessoire
            </a>
            </span>
        </h4>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                  <th>Type</th>
                  <th>Quantité en stock</th>
                  <th>Quantité livré</th>
                  <th>Date de livraison</th>
                  <th>Prix</th>
                </tr>
            </thead>
            <tbody>
            <td><strong>Accessoires</strong></td>
                      @foreach($allMateriels as $key => $mat)
                      <td><strong>{{ $mat->prix_materiel }}</strong></td>
                      <td><strong>{{ $mat->quantite }}</strong></td>
                      <td><strong>{{ $mat->quantite_stock }}</strong></td>
                      <td><strong>{{ $mat->date_livaison }}</strong></td>
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
                        <td><strong>{{ $dec->quantite }}</strong></td>
                        <td><strong>{{ $dec->quantite_stock }}</strong></td>
                        <td><strong>{{ $dec->date_livaison }}</strong></td>
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
  </x-slot>
</x-app-layout>
