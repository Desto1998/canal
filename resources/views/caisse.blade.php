<x-app-layout>
    <x-slot name="slot">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-2 font-weight-bold text-primary">Caisse</h4>
            </div>
            @include('layouts/flash-message')

            <div class="card-body">
                <div class="row col-md-12 d-flex mb-6">
                    <div class="col-md-6">
                        <h3>Total en caisse: <span class="text-secondary">{{$totalcaisse}} </span> FCFA</h3>
                        <h3 class="mt-4">Déja  consommé: <span class="text-success">{{$dejeconsomme}}</span> FCFA</h3>
                        <h3 class="mt-4"> Reste en caisse: <span class="text-warning">{{$restecaisse}}</span> FCFA</h3>

                    </div>
                    <div class="col-md-6">
                        <h4>Ajouter</h4> &nbsp;&nbsp;&nbsp;
                        <form action="{{isset($datas)?route('caisse.update'):route('caisse.ajouter')}}" method="post">
                            {{--                        <div class="form-group">--}}
                            @csrf
                            @isset($datas)
                                <input type="hidden" name="id_caisse" value="{{isset($datas)?$datas[0]->id_caisse:''}}">
                            @endisset
                            <div class="row d-flex">
                                <div class="col-md-8 ml-4">
                                    Montant <input type="number" name="montant" required="Le montant ne peut pas etre vide" class="form-control" value="{{isset($datas)?$datas[0]->montant:''}}">

                                </div>
                                <div class="col-md-8 ml-4 mt-4">
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    <button type="reset" class="btn btn-light">Annuler</button>

                                </div>
                            </div>
                            {{--                        </div>--}}

                        </form>
                    </div>


                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="text-center">
                        @php
                        $comp = 0;
                        @endphp
                        <tr>
                            <th>#</th>
                            <th>Utilisateur</th>
                            <th>Montant</th>
                            <th>Date d'ajout</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        @foreach($Caisse as $key => $value)
                            <tr>
                                <td>{{$comp+1}}</td>
                                <td>{{$value->name}}</td>
                                <td>{{$value->montant}}</td>
                                <td>{{$value->date_ajout}}</td>
                                <td>
                                        <a  href="{{$value->id == Auth::user()->id? route('caisse.get',$value->id_caisse ):'#'}}"   class="btn btn-warning" type="Modifier"><i class="fa fa-edit"></i></a>
                                        <a href="{{$value->id == Auth::user()->id? route('caisse.delete',$value->id_caisse ):'#'}}"  class="btn btn-danger" title="Supprimer"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @php
                                $comp ++;
                            @endphp
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        </div>
    </x-slot>
</x-app-layout>
