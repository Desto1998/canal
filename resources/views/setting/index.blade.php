<x-app-layout>
    <x-slot name="slot">
        <div class="row">
            <h4 class="text-uppercase ml-6"> Paramétres </h4>
        </div>
    @include('layouts.flash-message')
    <!-- Tabs -->
        <div class="card">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#message" role="tab"><span
                            class="hidden-sm-up"></span> <span class="hidden-xs-down">Messages</span></a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#messagestantdard" role="tab"><span
                            class="hidden-sm-up"></span> <span class="hidden-xs-down">Messages standart</span></a></li>
{{--                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#versement" role="tab"><span--}}
{{--                            class="hidden-sm-up"></span> <span class="hidden-xs-down">Versements</span></a></li>--}}
            </ul>
            <!-- Tab panes -->
            <div class="tab-content tabcontent-border">
                <div class="tab-pane active pt-2" id="message" role="tabpanel">
                    <div class="p-20">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    <form action="{{ route('settings.store.sms') }}" method="post">
                                        @csrf
                                        <div class="bs-example">
                                            <div class="accordion" id="accordionExample">
                                                <div class="card card-outline card-primary">
                                                    <div class="card-header bg-primary h4 text-white" id="headingOne">
                                                        <h6 class="mb-0">
                                                            <button type="button" class="btn btn-link text-white"
                                                                    data-toggle="collapse" data-target="#collapseOne">
                                                                Message après réabonnement
                                                            </button>
                                                        </h6>
                                                    </div>
                                                    <div id="collapseOne" class="collapse show"
                                                         aria-labelledby="headingOne" data-parent="#accordionExample">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <input type="hidden" value="REABONNEMENT"
                                                                       name="type_sms[]">
                                                                <input type="hidden" value="Message après réabonnement"
                                                                       name="titre_sms[]">
                                                                @php
                                                                    $message='';
                                                                        foreach( $messages as $key => $value ){
                                                                                if( $value->type_sms==='REABONNEMENT' ){
                                                                                    $message = $value->message;
                                                                                }
                                                                        }
                                                                @endphp
                                                                <textarea class="form-control" name="message[]"
                                                                          placeholder="Saisisez le message ici...">{{ $message }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header bg-primary" id="headingTwo">
                                                        <h6 class="mb-0">
                                                            <button type="button"
                                                                    class="btn btn-link text-white collapsed"
                                                                    data-toggle="collapse"
                                                                    data-target="#collapseTwo">Message après récrutement
                                                            </button>
                                                        </h6>
                                                    </div>
                                                    <div id="collapseTwo" class="collapse " aria-labelledby="headingTwo"
                                                         data-parent="#accordionExample">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <input type="hidden" value="ABONNEMENT"
                                                                       name="type_sms[]">
                                                                <input type="hidden" value="Message après récrutement"
                                                                       name="titre_sms[]">
                                                                @php
                                                                    $message='';
                                                                        foreach( $messages as $key => $value ){
                                                                                if( $value->type_sms==='ABONNEMENT' ){
                                                                                    $message = $value->message;
                                                                                }
                                                                            }
                                                                @endphp
                                                                <textarea class="form-control" name="message[]"
                                                                          placeholder="Saisisez le message ici...">{{ $message }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header bg-primary" id="headingThree">
                                                        <h6 class="mb-0">
                                                            <button type="button"
                                                                    class="btn btn-link text-white collapsed"
                                                                    data-toggle="collapse"
                                                                    data-target="#collapseThree">Message après versement
                                                            </button>
                                                        </h6>
                                                    </div>
                                                    <div id="collapseThree" class="collapse"
                                                         aria-labelledby="headingThree" data-parent="#accordionExample">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <input type="hidden" value="VERSEMENT"
                                                                       name="type_sms[]">
                                                                <input type="hidden" value="Message après versement"
                                                                       name="titre_sms[]">
                                                                @php
                                                                    $message='';
                                                                        foreach( $messages as $key => $value ){
                                                                                if( $value->type_sms==='VERSEMENT' ){
                                                                                    $message = $value->message;
                                                                                }
                                                                            }
                                                                @endphp
                                                                <textarea class="form-control"  name="message[]"
                                                                          placeholder="Saisisez le message ici...">{{ $message }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row ml-2">
                                                    <button type="submit" name="save" class="btn btn-primary m-3">Mettre
                                                        à jour
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-md-4">
                                    <div class="card text-center">
                                        <div class="card-header">
                                            <h6>Codes utilisés</h6>
                                        </div>

                                        <div class="card-body text-center">
                                            <p>
                                                Le système de conception automatique de SMS utilisé par l'application se
                                                base sur les codes suivants:
                                            </p>
                                            <ul class="text-center">
                                                <li><span> <</span>NOM<span>></span></li>
                                                <li><span> <</span>PRENOM<span>></span></li>
                                                <li><span> <</span>MONTANT<span>></span></li>
                                                <li><span> <</span>DATEECHEANCE<span>></span></li>
                                                <li><span> <</span>DATEREABO<span>></span></li>
                                            </ul>
                                            <p>
                                               <span class="text-warning"><i class="fas fa-warning"></i> Ils  seront remplacés
                                                 avant l'envoi de chaque message!
                                               </span>
                                            </p>
                                            </p>
                                        </div>
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
                                <h6 class="m-2 font-weight-bold text-primary">Liste des messages standart</h6>
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
                                            <th>Titre</th>
                                            <th width="400px">Message</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-center">
                                        @foreach($messages as $key => $value)
                                            @if($value->type_sms === "STANDART")
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$value->titre_sms}}</td>
                                                    <td width="400px">{{$value->message}}</td>
                                                    <td class="d-flex  text-center">
                                                        <a href="#" data-toggle="modal"
                                                           data-target="#messageModal{{ $value->id_message }}"
                                                           class="btn btn-warning" type="Modifier"><i
                                                                class="fa fa-edit"></i></a>
                                                        <a href="{{route('message.delete',$value->id_message )}}"
                                                           class="btn btn-danger ml-1" title="Supprimer"><i
                                                                class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                                {{--                                                Edit messages modal--}}
                                                <div class="modal fade justify-center justify-content-center"
                                                     id="messageModal{{ $value->id_message }}" tabindex="-1"
                                                     role="dialog"
                                                     aria-labelledby="exampleModalLabel"
                                                     aria-hidden="true">
                                                    <div class="modal-dialog text-center" role="document">
                                                        <div class="modal-content text-center">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Modifier
                                                                    le message: {{$value->titre_sms}}</h5>
                                                                <button class="close" type="button" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div
                                                                class="modal-body text-center justify-content-center align-content-center">
                                                                <form role="form" id="abonneForm" method="post"
                                                                      action="{{ route('message.update') }}">
                                                                    @csrf
                                                                    <input type="hidden"
                                                                           value="{{ $value->id_message }}"
                                                                           name="id_message">
                                                                    <div class="form-group">
                                                                        <label>Titre</label>
                                                                        <input class="form-control text-uppercase"
                                                                               type="text" placeholder="Titre"
                                                                               value="{{$value->titre_sms}}"
                                                                               name="titre_sms" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Message</label>
                                                                        <textarea class="form-control" name="message"
                                                                                  required> {{$value->message}}</textarea>
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

                                            @endif
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
{{--                <div class="tab-pane p-20 pt-2" id="versement" role="tabpanel">--}}
{{--                    <div class="p-20">--}}
{{--                        <div class="card shadow mb-4">--}}
{{--                            <div class="card-header py-3">--}}
{{--                                <h6 class="m-2 font-weight-bold text-primary">Liste des Opérations de Versements--}}
{{--                                    Canal</h6>--}}
{{--                            </div>--}}
{{--                            @include('layouts/flash-message')--}}

{{--                            <div class="card-body">--}}
{{--                                <div class="row col-md-12 d-flex mb-6">--}}
{{--                                    <div class="col-md-6">--}}
{{--                                        <h3>Total versement: <span class="text-secondary">{{ $totalVersement }} </span>--}}
{{--                                            FCFA</h3>--}}
{{--                                        <h3 class="mt-4">Déja utilisé: <span--}}
{{--                                                class="text-success">{{ $dejaUTilise }}</span> FCFA</h3>--}}
{{--                                        <h3 class="mt-4"> Disponible : <span--}}
{{--                                                class="text-warning">{{ $resteVersement }}</span> FCFA</h3>--}}

{{--                                    </div>--}}
{{--                                    <div class="col-md-6 pull-right text-right">--}}
{{--                                        <a type="button" class="btn btn-primary pull-right -align-right" href="#"--}}
{{--                                           data-toggle="modal"--}}
{{--                                           data-target="#versementModal"> <i--}}
{{--                                                class="fas fa-plus"></i> Ajouter </a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="table-responsive col-md-12">--}}
{{--                                    <table class="table table-bordered col-md-12" width="100%" id="dataTable">--}}
{{--                                        <thead class="text-center">--}}
{{--                                        @php--}}
{{--                                            $comp = 0;--}}
{{--                                        @endphp--}}
{{--                                        <tr>--}}
{{--                                            <th>#</th>--}}
{{--                                            <th>Montant</th>--}}
{{--                                            <th>Description</th>--}}
{{--                                            <th>Par</th>--}}
{{--                                            <td>Le</td>--}}
{{--                                            <th>Action</th>--}}
{{--                                        </tr>--}}
{{--                                        </thead>--}}
{{--                                        <tbody class="text-center">--}}
{{--                                        @foreach($versements as $key => $value)--}}
{{--                                            <tr>--}}
{{--                                                <td>{{$key+1}}</td>--}}
{{--                                                <td>{{$value->montant_versement}}</td>--}}
{{--                                                <td> {{$value->description}} </td>--}}
{{--                                                <td>--}}
{{--                                                    @foreach($users as $k => $item)--}}
{{--                                                        @if($value->id_user === $item->id)--}}
{{--                                                            {{$item->name}}--}}
{{--                                                        @endif--}}
{{--                                                    @endforeach--}}
{{--                                                </td>--}}
{{--                                                <td>{{$value->created_at}}</td>--}}
{{--                                                <td class="d-flex">--}}
{{--                                                    <a href="#" data-toggle="modal"--}}
{{--                                                       data-target="#versementModal{{ $value->id_versement }}"--}}
{{--                                                       {{$value->id_user == Auth::user()->id? '':'disabled'}}--}}
{{--                                                       class="btn btn-warning mr-1" type="Modifier"><i--}}
{{--                                                            class="fa fa-edit"></i></a>--}}
{{--                                                    <a href="{{$value->id_user == Auth::user()->id? route('versement.delete',$value->id_versement ):'#'}}"--}}
{{--                                                       class="btn btn-danger" title="Supprimer"><i--}}
{{--                                                            class="fa fa-trash"></i></a>--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                            <div class="modal fade justify-center  justify-content-center"--}}
{{--                                                 id="versementModal{{ $value->id_versement }}" tabindex="-1"--}}
{{--                                                 role="dialog"--}}
{{--                                                 aria-labelledby="exampleModalLabel"--}}
{{--                                                 aria-hidden="true">--}}
{{--                                                <div class="modal-dialog" role="document">--}}
{{--                                                    <div class="modal-content">--}}
{{--                                                        <div class="modal-header">--}}
{{--                                                            <h5 class="modal-title" id="exampleModalLabel">Modifier--}}
{{--                                                                versement</h5>--}}
{{--                                                            <button class="close" type="button" data-dismiss="modal"--}}
{{--                                                                    aria-label="Close">--}}
{{--                                                                <span aria-hidden="true">×</span>--}}
{{--                                                            </button>--}}
{{--                                                        </div>--}}
{{--                                                        <div--}}
{{--                                                            class="modal-body justify-content-center align-content-center">--}}
{{--                                                            <form role="form"--}}
{{--                                                                  id="versementForm{{ $value->id_versement }}"--}}
{{--                                                                  method="post"--}}
{{--                                                                  action="{{ route('versement.update') }}">--}}
{{--                                                                @csrf--}}
{{--                                                                <input type="hidden" name="id_versement"--}}
{{--                                                                       value="{{ $value->id_versement }}" required>--}}
{{--                                                                <div class="form-group">--}}
{{--                                                                    <label>Montant</label>--}}
{{--                                                                    <input class="form-control text-uppercase"--}}
{{--                                                                           type="number" min="5000"--}}
{{--                                                                           name="montant_versement"--}}
{{--                                                                           value="{{$value->montant_versement}}"--}}
{{--                                                                           required>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="form-group">--}}
{{--                                                                    <label>Description(facultatif)</label>--}}
{{--                                                                    <textarea class="form-control"--}}
{{--                                                                              name="description">{{$value->description}}</textarea>--}}
{{--                                                                </div>--}}
{{--                                                                <hr>--}}
{{--                                                                <button type="submit" class="btn btn-success"><i--}}
{{--                                                                        class="fa fa-check fa-fw"></i>Enregistrer--}}
{{--                                                                </button>--}}
{{--                                                                <button type="reset" class="btn btn-danger"><i--}}
{{--                                                                        class="fa fa-times fa-fw"></i>Retour--}}
{{--                                                                </button>--}}
{{--                                                                <button class="btn btn-secondary" type="button"--}}
{{--                                                                        data-dismiss="modal">Annuler--}}
{{--                                                                </button>--}}
{{--                                                            </form>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        @endforeach--}}

{{--                                        </tbody>--}}
{{--                                    </table>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>

        {{--        // modal section--}}
        {{--        message modal--}}
        <div class="modal fade justify-center justify-content-center" id="messageModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog text-center" role="document">
                <div class="modal-content text-center">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter un message</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body text-center justify-content-center align-content-center">
                        <form role="form" id="abonneForm" method="post"
                              action="{{ route('settings.store.sms.standart') }}">
                            @csrf
                            <div class="form-group">
                                <label>Titre</label>
                                <input class="form-control text-uppercase" type="text" placeholder="Titre"
                                       name="titre_sms" required>
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea class="form-control" name="message"></textarea>
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
{{--        <div class="modal fade justify-center justify-content-center" id="versementModal" tabindex="-1" role="dialog"--}}
{{--             aria-labelledby="exampleModalLabel"--}}
{{--             aria-hidden="true">--}}
{{--            <div class="modal-dialog" role="document">--}}
{{--                <div class="modal-content">--}}
{{--                    <div class="modal-header">--}}
{{--                        <h5 class="modal-title" id="exampleModalLabel">Ajouter un versement</h5>--}}
{{--                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">--}}
{{--                            <span aria-hidden="true">×</span>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                    <div class="modal-body justify-content-center align-content-center">--}}
{{--                        <form role="form" id="versementForm" method="post"--}}
{{--                              action="{{ route('settings.store.versement') }}">--}}
{{--                            @csrf--}}
{{--                            <div class="form-group">--}}
{{--                                <label>Montant</label>--}}
{{--                                <input class="form-control text-uppercase" type="number" min="5000"--}}
{{--                                       name="montant_versement" required>--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <label>Description(facultatif)</label>--}}
{{--                                <textarea class="form-control" name="description"--}}
{{--                                          placeholder="Description ..."></textarea>--}}
{{--                            </div>--}}
{{--                            <hr>--}}
{{--                            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Enregistrer--}}
{{--                            </button>--}}
{{--                            <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Retour</button>--}}
{{--                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </x-slot>
</x-app-layout>



