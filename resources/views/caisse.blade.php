<x-app-layout>
    <x-slot name="slot">
        <div class="row col-md-12">
            <div class="col-md-6">
                <label class="text-uppercase h6 ml-6"> Paramétres de la caisse </label>
                <label class="align-content-center text-center pull-right h6 ml-6"> Total caisse: <span class="text-info">{{ $totalcaisse }}</span> </label>
            </div>

            <div class="float-right mb-4 pull-right">
                <form action="{{ route('caisse.sort') }}" method="post">
                    @csrf
                    <div class="row">
                        <input type="date" name="date1" class="form-control col-md-5">
                        <input type="date" name="date2" class="form-control col-md-5">
                        <button type="submit" class="btn btn-primary float-right"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    {{--        <a href="{{ route('test.message') }}" > Testmessage</a>--}}
    {{--        <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">--}}
    {{--            <div class="card-header py-3">--}}
    {{--                <h4 class="m-2 font-weight-bold text-primary">Upgrader client</h4>--}}
    {{--            </div>--}}
    {{--            <a type="button" class="btn btn-primary bg-gradient-primary btn-block" href="{{route('upgrader')}}"> <i--}}
    {{--                    class="fas fa-flip-horizontal fa-fw fa-share"></i> Retour </a>--}}
    {{--            <div class="card-body">--}}

    {{--            </div>--}}
    {{--        </div>--}}
    @include('layouts.flash-message')
    <!-- Tabs -->
        <div class="card">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#message" role="tab"><span
                            class="hidden-sm-up"></span> <span class="hidden-xs-down">Caisse</span></a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#messagestantdard" role="tab"><span
                            class="hidden-sm-up"></span> <span class="hidden-xs-down">Achat matériel</span></a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#versement" role="tab"><span
                            class="hidden-sm-up"></span> <span class="hidden-xs-down">Versements</span></a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#recouvrement" role="tab"><span
                            class="hidden-sm-up"></span> <span class="hidden-xs-down">Recouvrement</span></a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content tabcontent-border">
                <div class="tab-pane active pt-2" id="message" role="tabpanel">
                    <div class="p-20">
                        <div class="col-md-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-2 font-weight-bold text-primary">Liste des operations de caisse</h6>
                                </div>
{{--                                @include('layouts/flash-message')--}}

                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead class="text-center">
                                            @php
                                                $comp = 0;
                                            @endphp
                                            <tr>
                                                <th>#</th>
                                                <th>Montant</th>
                                                <th>Opération</th>
                                                <th>Par</th>
                                                <th>Date d'ajout</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody class="text-center">
                                            @foreach($Caisse as $key => $value)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$value->montant}}</td>
                                                    <td>{{$value->raison}}</td>
                                                    <td>
                                                        @foreach($users as $k => $item)
                                                            @if($value->id_user === $item->id)
                                                                {{$item->name}}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>{{$value->date_ajout}}</td>
                                                    <td>
                                                        {{--                                        <a  href="{{$value->id == Auth::user()->id? route('caisse.get',$value->id_caisse ):'#'}}"   class="btn btn-warning" type="Modifier"><i class="fa fa-edit"></i></a>--}}
                                                        <a href="{{$value->id_user == Auth::user()->id? route('caisse.delete',$value->id_caisse ):'#'}}"  class="btn btn-danger" title="Supprimer"><i class="fa fa-trash"></i></a>
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
                </div>
                <div class="tab-pane  p-20 pt-2" id="messagestantdard" role="tabpanel">
                    <div class="p-20">
                        <div class="card shadow mb-4 col-xs-12 col-md-18 border-bottom-primary">
                            <div class="card-header py-3">
                                <h6 class="m-2 font-weight-bold text-primary">Achat Matériel</h6>
                            </div>
                            <div class="col-md-2 mt-2 pull-right -align-right">
                                <a type="button" class="btn btn-primary pull-right -align-right" href="#"
                                   data-toggle="modal"
                                   data-target="#messageModal"> <i
                                        class="fas fa-plus"></i> Ajouter </a>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable">
                                        <thead class="text-center">
                                        <tr>
                                            <th>#</th>
                                            <th> Montant</th>
                                            <th width="400px">Description</th>
                                            <th width="400px">Par</th>
                                            <th width="400px">Date</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-center">
                                        @foreach($achats as $key => $value)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$value->montant_achat}}</td>
                                                    <td width="300px">{{$value->description_achat}}</td>
                                                    <td>
                                                        @foreach($users as $k => $item)
                                                            @if($value->id_user === $item->id)
                                                                {{$item->name}}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>{{$value->created_at}}</td>


                                                    <td class="d-flex  text-center">
                                                        <a href="#" data-toggle="modal"
                                                           data-target="#messageModal{{ $value->id_achat }}"
                                                           class="btn btn-warning" type="Modifier"><i
                                                                class="fa fa-edit"></i></a>
                                                        <a href="{{$value->id_user == Auth::user()->id? route('achat.delete',$value->id_achat ):'#'}}"
                                                           class="btn btn-danger ml-1" title="Supprimer"><i
                                                                class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                                {{--                                                Edit messages modal--}}
                                                <div class="modal fade justify-center justify-content-center"
                                                     id="messageModal{{ $value->id_achat }}" tabindex="-1"
                                                     role="dialog"
                                                     aria-labelledby="exampleModalLabel"
                                                     aria-hidden="true">
                                                    <div class="modal-dialog text-center" role="document">
                                                        <div class="modal-content text-center">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Modifier
                                                                    l'achat: {{$value->montant_achat}}</h5>
                                                                <button class="close" type="button" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div
                                                                class="modal-body text-center justify-content-center align-content-center">
                                                                <form role="form" id="abonneForm" method="post"
                                                                      action="{{ route('achat.update') }}">
                                                                    @csrf
                                                                    <input type="hidden"
                                                                           value="{{ $value->id_achat }}"
                                                                           name="id_achat">
                                                                    <div class="form-group">
                                                                        <label>Montant</label>
                                                                        <input class="form-control"
                                                                               type="number" min="0"
                                                                               value="{{$value->montant_achat}}"
                                                                               name="montant_achat" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Description</label>
                                                                        <input type="text" class="form-control" name="description_achat" value="{{$value->description_achat}}">
                                                                    </div>
                                                                    <hr>
                                                                    <button type="submit" class="btn btn-success"><i
                                                                            class="fa fa-check fa-fw"></i>Enregistrer
                                                                    </button>
                                                                    <button type="reset" class="btn btn-danger"><i
                                                                            class="fa fa-times fa-fw"></i>Retour
                                                                    </button>
                                                                    <button class="btn btn-secondary" type="button"
                                                                            data-dismiss="modal">Annuler
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="tab-pane p-20 pt-2" id="versement" role="tabpanel">
                    <div class="p-20">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-2 font-weight-bold text-primary">Liste des Opérations de Versements
                                    Canal</h6>
                            </div>
{{--                            @include('layouts/flash-message')--}}

                            <div class="card-body">
                                <div class="row col-md-12 d-flex mb-6">
                                    <div class="col-md-6">
                                        <h3>Total versement: <span class="text-secondary">{{ $totalVersement }} </span>
                                            FCFA</h3>
                                        <h3 class="mt-4">Total des activations: <span
                                                class="text-success">{{ $dejaUTilise }}</span> FCFA</h3>
                                        <h3 class="mt-4"> Solde CGA : <span
                                                class="text-warning">{{ $resteVersement }}</span> FCFA</h3>

                                    </div>
                                    <div class="col-md-6 pull-right text-right">
                                        <a type="button" class="btn btn-primary pull-right -align-right" href="#"
                                           data-toggle="modal"
                                           data-target="#versementModal"> <i
                                                class="fas fa-plus"></i> Ajouter </a>
                                    </div>
                                </div>
                                <div class="table-responsive col-md-12">
                                    <table class="table table-bordered col-md-12" width="100%" id="dataTable">
                                        <thead class="text-center">
                                        @php
                                            $comp = 0;
                                        @endphp
                                        <tr>
                                            <th>#</th>
                                            <th>Montant</th>
                                            <th>Description</th>
                                            <th>Par</th>
                                            <td>Le</td>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-center">
                                        @foreach($versements as $key => $value)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$value->montant_versement}}</td>
                                                <td> {{$value->description}} </td>
                                                <td>
                                                    @foreach($users as $k => $item)
                                                        @if($value->id_user === $item->id)
                                                            {{$item->name}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>{{$value->created_at}}</td>
                                                <td class="d-flex">
                                                    <a href="#" data-toggle="modal"
                                                       data-target="#versementModal{{ $value->id_versement }}"
                                                       {{$value->id_user == Auth::user()->id? '':'disabled'}}
                                                       class="btn btn-warning mr-1" type="Modifier"><i
                                                            class="fa fa-edit"></i></a>
                                                    <a href="{{$value->id_user == Auth::user()->id? route('versement.delete',$value->id_versement ):'#'}}"
                                                       class="btn btn-danger" title="Supprimer"><i
                                                            class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            <div class="modal fade"
                                                 id="versementModal{{ $value->id_versement }}" tabindex="-1"
                                                 role="dialog"
                                                 aria-labelledby="exampleModalLabel"
                                                 aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Modifier
                                                                versement</h5>
                                                            <button class="close" type="button" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div
                                                            class="modal-body">
                                                            <form role="form"
                                                                  id="versementForm{{ $value->id_versement }}"
                                                                  method="post"
                                                                  action="{{ route('versement.update') }}">
                                                                @csrf
                                                                <input type="hidden" name="id_versement"
                                                                       value="{{ $value->id_versement }}" required>
                                                                <div class="form-group">
                                                                    <label>Montant</label>
                                                                    <input class="form-control text-uppercase"
                                                                           type="number" min="5000"
                                                                           name="montant_versement"
                                                                           value="{{$value->montant_versement}}"
                                                                           required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Description(facultatif)</label>
                                                                    <textarea class="form-control"
                                                                              name="description">{{$value->description}}</textarea>
                                                                </div>
                                                                <hr>
                                                                <button type="submit" class="btn btn-success"><i
                                                                        class="fa fa-check fa-fw"></i>Enregistrer
                                                                </button>
                                                                <button type="reset" class="btn btn-danger"><i
                                                                        class="fa fa-times fa-fw"></i>Retour
                                                                </button>
                                                                <button class="btn btn-secondary" type="button"
                                                                        data-dismiss="modal">Annuler
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recouvrement tab -->
                <div class="tab-pane p-20 pt-2" id="recouvrement" role="tabpanel">
                    <div class="p-20">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-2 font-weight-bold text-primary">Liste des recouvrements
                                    Canal</h6>
                            </div>
                            <div class="col-md-12 pull-right text-right">
                                <a type="button" class="btn btn-primary pull-right -align-right" href="#"
                                   data-toggle="modal"
                                   data-target="#recouvrementModal"> <i
                                        class="fas fa-plus"></i> Ajouter </a>
                            </div>
{{--                            @include('layouts/flash-message')--}}

                            <div class="card-body">

                                <div class="table-responsive col-md-12">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="text-center">
                                        @php
                                            $comp = 0;
                                        @endphp
                                        <tr>
                                            <th>#</th>
                                            <th>Montant</th>
                                            <th>Raison</th>
                                            <th>Par</th>
                                            <th>Date d'ajout</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-center">
                                        @foreach($Recouvrements as $key => $value)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$value->montant}}</td>
                                                <td>{{$value->raison}}</td>
                                                <td>
                                                    @foreach($users as $k => $item)
                                                        @if($value->id_user === $item->id)
                                                            {{$item->name}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>{{$value->date_ajout}}</td>
                                                <td>
                                                    {{--                                        <a  href="{{$value->id == Auth::user()->id? route('caisse.get',$value->id_caisse ):'#'}}"   class="btn btn-warning" type="Modifier"><i class="fa fa-edit"></i></a>--}}
                                                    <a href="{{$value->id_user == Auth::user()->id? route('caisse.delete',$value->id_caisse ):'#'}}"  class="btn btn-danger" title="Supprimer"><i class="fa fa-trash"></i></a>
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
            </div>
        </div>

        {{--        // modal section--}}
        {{--        message modal--}}
        <div class="modal fade " id="messageModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter un achat</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="abonneForm" method="post"
                              action="{{ route('caisse.store.achat') }}">
                            @csrf
                            <div class="form-group">
                                <label>Montant</label>
                                <input class="form-control" type="number" min="0"
                                       name="montant_achat" required>
                            </div>
                            <div class="form-group">
                                <label>Description(facultatif)</label>
                                <input type="text" class="form-control" name="description_achat">
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Enregistrer
                            </button>
                            <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Retour</button>
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{--        Versement modal--}}
        <div class="modal fade" id="versementModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter un versement</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="versementForm" method="post"
                              action="{{ route('settings.store.versement') }}">
                            @csrf
                            <div class="form-group">
                                <label>Montant</label>
                                <input class="form-control text-uppercase" type="number" min="0"
                                       name="montant_versement" required>
                            </div>
                            <div class="form-group">
                                <label>Description(facultatif)</label>
                                <textarea class="form-control" name="description"
                                          placeholder="Description ..."></textarea>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Enregistrer
                            </button>
                            <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Retour</button>
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal recouvrement -->
        <div class="modal fade " id="recouvrementModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="recouvrementModaleModalLabel">Ajouter un recouvrement</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="abonneForm" method="post"
                              action="{{ route('caisse.store.recouvrement') }}">
                            @csrf
                            <div class="form-group">
                                <label>Montant</label>
                                <input class="form-control" type="number" min="0"
                                       name="montant" required>
                            </div>
                            <div class="form-group">
                                <label>Raison</label>
                                <input type="text" class="form-control" name="raison" required>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Enregistrer
                            </button>
                            <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Retour</button>
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
