<x-app-layout>
    <x-slot name="slot">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-2 font-weight-bold text-primary">Liste des clients</h4>
                <label class=""><a class="btn btn-success" href="{{route('user.client.nouveau')}}"> Parc courant</a></label>
                <label class="ml-4"><a class="btn btn-warning"  href="{{route('user.client.terme')}}"> Bientôt à terme</a></label>
                <label class="ml-4"><a class="btn btn-danger"  href="{{route('user.client.perdu')}}"> Clients échus</a></label>
                <label class="ml-4"><a class="btn btn-primary"  href="{{route('clients')}}"> Tous les clients</a></label>
            </div>
            @include('layouts.flash-message')

            <div class="modal fade" id="sendtoallModal" tabindex="-1" role="dialog"
                 aria-labelledby="sendtoallModal"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel2">Envoyer un message</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form role="form" id="sendtoallModal" method="post"
                                  action="{{ route('send.message.to.selected') }}">
                                @csrf
                                <input class="form-control text-uppercase selectphone" type="hidden" value=""
                                       id="selectphonehidden"
                                       name="phone">
                                <div class="form-group">
                                    <label><span><i class="fas fa-phone"></i> </span> Téléphone</label>
                                    <input class="form-control text-uppercase selectphone" type="text" value=""
                                           id="selectphone"
                                           name="phone" disabled>
                                </div>
                                <div class="for-group">
                                    <select name="id_message" id="showselectmessage" onchange="showselectedSMSArea()"
                                            class="form-control showarea">
                                        <option value="0">Message Standart</option>
                                        @foreach($messages as $sms => $value)
                                            <option value="{{ $value->id_message }}"> {{ $value->titre_sms }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group selectmessagearea" id="message0">
                                    <label><span><i class="fas fa-pen"></i></span>Message</label>
                                    <textarea class="form-control" name="message"
                                              placeholder="Saisisser un message ici..."></textarea>
                                </div>
                                @foreach($messages as $sms => $value)
                                    <div class="form-group hidden selectmessagearea"
                                         id="message{{ $value->id_message }}">
                                        <label><span><i class="fas fa-pen"></i></span>Message</label>
                                        <textarea class="form-control" name="message">{{ $value->message }}</textarea>
                                    </div>
                                @endforeach

                                <hr>
                                <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Enregistrer
                                </button>
                                <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Retour
                                </button>
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <label class="float-right">
                    <a class="btn btn-info" id="sendmessage" title="Envoyer un SMS aux sélectionés" href="#"
                       data-toggle="modal" onclick="getNumber()" data-target="#sendtoallModal">
                        <i class="fas fa-sms"></i>
                    </a>
                </label>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable_1" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" style="border-radius: 3px" name="selectall" value="-1"
                                       class="selectall" id="selectall">
                            </th>
                            <th>#</th>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Numéro de téléphone</th>
                            <th>Numéro abonné</th>
                            <th>Décodeurs</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($allClients as $key => $client)
                            <tr>
                                <td>
                                    <input type="checkbox" style="border-radius: 3px" name="tel[]"
                                           value="{{ $client->telephone_client }}" class="selectid"
                                           id="select{{ $client->telephone_client }}">
                                </td>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $client->prenom_client }}</td>
                                <td>{{ $client->nom_client }}</td>
                                <td>{{ $client->telephone_client }}</td>
                                <td>
                                    @foreach( $decodeurs as $k => $item)
                                        @if( $item->id_client === $client->id_client)
                                            <h6 style="font-size: 11px!important;"
                                                class="bg-gradient-info p-1 w-16 text-white text-center">{{ $item->num_abonne }}</h6>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach( $decodeurs as $k => $item)
                                        @if( $item->id_client === $client->id_client)
                                            <h6 style="font-size: 11px!important;"
                                                class="bg-gradient-info p-1 w-100 text-white text-center">{{ $item->num_decodeur }}</h6>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <div class="btn_group">
                                        <div class="btn-group">
                                            <a type="button"
                                               class="btn btn-primary bg-gradient-primary dropdown no-arrow"
                                               data-toggle="dropdown" style="color:white;">
                                                <i class="fas fa-fw fa-list-alt"></i> <span class="caret"></span></a>
                                            <ul class="dropdown-menu text-center" role="menu">
                                                <li>
                                                    <a class="btn btn-info m-1"
                                                       href="{{ route('clients.show', $client->id_client) }}"
                                                       title="Details sur le client"><i class="fas fa-fw fa-eye"></i>
                                                    </a>

                                                    <a type="button" class="btn btn-primary m-1"
                                                       title="Ajouter un décodeur" href="#" data-toggle="modal"
                                                       data-target="#materielClientModal1{{ $client->id_client }}">
                                                        <i class="fas fa-fw fa-plus"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a type="button" class="btn btn-warning m-1" title="Modifier"
                                                       href="{{ route('edit.client',$client->id_client)}}">
                                                        <i class="fas fa-fw fa-edit"></i>
                                                    </a>

                                                    <a type="button" class="btn btn-danger m-1" title="Supprimer"
                                                       href="javascript:void(0);"
                                                       onclick="deleteFunc({{ $client->id_client }})">
                                                        <i class="fas fa-fw fa-trash"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a type="button" class="btn btn-info" title="Envoyer un message"
                                                       href="#" data-toggle="modal"
                                                       data-target="#messageModal{{ $client->id_client }}">
                                                        <i class="fas fa-fw fa-envelope"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="materielClientModal1{{ $client->id_client }}" tabindex="-1"
                                 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel{{ $client->id_client }}">
                                                Ajouter un décodeur</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form"
                                                  id="decodeurForm{{ $client->id_client }}{{ $client->id_client }}"
                                                  method="post"
                                                  action="{{ route('clients.new_decodeur') }}">
                                                @csrf
                                                <input type="hidden" name="id_client" value="{{ $client->id_client }}">
                                                <div class="form-group">
                                                    <label> Numéro d'abonné</label>
                                                    <input type="text" name="num_abonne" minlength="8" maxlength="8"
                                                           class="form-control">
                                                </div>
                                                <div
                                                    class="form-group align-content-center justify-content-center text-center">
                                                    <label><input type="radio" required name="operation" value="1"
                                                                  class="operation">&nbsp; Abonnement</label>
                                                    <label class="ml-4"><input required type="radio" value="0"
                                                                               name="operation" class="operation">&nbsp;
                                                        Réabonnement</label>
                                                </div>
                                                <div class="selectdecodeur">
                                                    <div class="form-group">
                                                        Numero décodeur<br>
                                                        @if(isset($decodeur))

                                                            <select class="form-control" name="num_decodeurs">
                                                                <option disabled selected hidden>Sélectionner un
                                                                    decodeur
                                                                </option>
                                                                @foreach($decodeur as $key =>$deco)

                                                                    <option
                                                                        value="{{$deco->num_decodeur}}">{{$deco->num_decodeur}}</option>
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            <span class="text-danger">Aucun décodeur n'est disponible veiller enregistrer un décodeur.</span>
                                                        @endif

                                                    </div>
                                                </div>
                                                <div class="form-group hidden enternum">
                                                    Numero décodeur<br><input type="text" class="form-control"
                                                                              maxlength="14" minlength="10"
                                                                              placeholder="Entrez le numero decodeur"
                                                                              onblur="controlNumero(this)"
                                                                              name="num_decodeur" id="num_decodeur1">
                                                    <span class="text-danger hidden ereur-numerodd " style=""> Mauvaise saisie Longeur minimale 14</span>
                                                    @error('num_decodeur')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    Formule: <select name="formule" required>
                                                        <option value="ACCESS" selected> ACCESS</option>
                                                        <option value="ACCESS +"> ACCESS +</option>
                                                        <option value="EVASION"> EVASION</option>
                                                        <option value="EVASION +"> EVASION +</option>
                                                        <option value="PRESTIGE"> PRESTIGE</option>
                                                        <option value="ESSENTIEL +"> ESSENTIEL +</option>
                                                        <option value="TOUT CANAL"> TOUT CANAL</option>
                                                    </select>
                                                    Durée: <select name="duree" required>
                                                        <option value=1 selected> 1 mois</option>
                                                        <option value=2> 2 mois</option>
                                                        <option value=3> 3 mois</option>
                                                        <option value=6> 6 mois</option>
                                                        <option value=9> 9 mois</option>
                                                        <option value=12> 12 mois</option>
                                                    </select>
                                                </div>
                                                <div
                                                    class="form-group align-content-center justify-content-center text-center">
                                                    <label><input type="radio" required name="type" value="1">&nbsp;
                                                        Payé content</label>
                                                    <label class="ml-4"><input required type="radio" value="0"
                                                                               name="type">&nbsp;A crédit</label>
                                                </div>
                                                <div class="form-group">
                                                    Date abonnement<br><input class="form-control"
                                                                              name="date_abonnement" type="date"
                                                                              required>
                                                </div>
                                                <hr>
                                                <button type="submit" class="btn btn-success"><i
                                                        class="fa fa-check fa-fw"></i>Enregistrer
                                                </button>
                                                <button type="reset" class="btn btn-danger"><i
                                                        class="fa fa-times fa-fw"></i>Retour
                                                </button>
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">
                                                    Annuler
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade justify-center justify-content-center"
                                 id="messageModal{{ $client->id_client }}" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel{{ $client->id_client }}"
                                 aria-hidden="true">
                                <div class="modal-dialog text-center" role="document">
                                    <div class="modal-content text-center">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel{{ $client->id_client }}">
                                                Envoyer un message</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center justify-content-center align-content-center">
                                            <form role="form" id="abonneForm{{ $client->id_client }}" method="post"
                                                  action="{{ route('send.message') }}">
                                                @csrf
                                                <input type="hidden" name="id_client" value="{{ $client->id_client }}">
                                                <input type="hidden" name="phone"
                                                       value="{{ $client->telephone_client }}">
                                                <input type="hidden" name="nom_client"
                                                       value="{{ $client->nom_client }}">
                                                <div class="form-group">
                                                    <label><span><i class="fas fa-address-book"></i> </span> Nom client</label>
                                                    <input class="form-control text-uppercase" type="text"
                                                           value="{{ $client->nom_client }}"
                                                           name="nom" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label><span><i class="fas fa-phone"></i> </span> Numéro du
                                                        client</label>
                                                    <input class="form-control text-uppercase" type="text"
                                                           value="{{ $client->telephone_client }}"
                                                           name="tel" disabled>
                                                </div>
                                                <div class="for-group">
                                                    <select name="id_message" id="showmessage{{ $client->id_client }}"
                                                            onchange="showSMSArea({{$client->id_client}})"
                                                            class="form-control showarea">
                                                        <option value="0">Message Standart</option>
                                                        @foreach($messages as $sms => $value)
                                                            <option
                                                                value="{{ $value->id_message }}"> {{ $value->titre_sms }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group messagearea"
                                                     id="message0{{ $client->id_client }}">
                                                    <label><span><i class="fas fa-pen"></i></span>Message</label>
                                                    <textarea class="form-control" name="message"
                                                              placeholder="Saisisser un message ici..."></textarea>
                                                </div>
                                                @foreach($messages as $sms => $value)
                                                    <div class="form-group hidden messagearea"
                                                         id="message{{ $value->id_message }}{{ $client->id_client }}">
                                                        <label><span><i class="fas fa-pen"></i></span>Message</label>
                                                        <textarea class="form-control"
                                                                  name="message">{{ $value->message }}</textarea>
                                                    </div>
                                                @endforeach

                                                <hr>
                                                <button type="submit" class="btn btn-success"><i
                                                        class="fa fa-check fa-fw"></i>Enregistrer
                                                </button>
                                                <button type="reset" class="btn btn-danger"><i
                                                        class="fa fa-times fa-fw"></i>Retour
                                                </button>
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">
                                                    Annuler
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
    </x-slot>
</x-app-layout>
<script>

    $('input[name="operation"]').change(function () {
        var operation = $('input[name="operation"]:checked').val();
        if (operation == 1) {
            $('.selectdecodeur').removeClass('hidden');
            $('.enternum').addClass('hidden');
            $('.enternumprise').addClass('hidden');
        } else {
            $('.selectdecodeur').addClass('hidden');
            $('.enternum').removeClass('hidden');
            // $('#enternumprise').removeClass('hidden');
        }
        // alert(operation);
    });

    function showSMSArea(id) {
        $('.messagearea').addClass('hidden');
        var value = $('#showmessage' + id).val();
        $('#message' + value + id).removeClass('hidden');

    }

    function showModal(id) {

    }

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

    $('#selectall').click(function () {

        if ($('#selectall').is(':checked')) {
            $('.selectid').prop('checked', true);
            console.log(id);
        } else {
            $('.selectid').prop('checked', false);
        }
    });

    function showselectedSMSArea() {
        $('.selectmessagearea').addClass('hidden');
        var value = $('#showselectmessage').val();
        $('#message' + value).removeClass('hidden');

    }

    function getNumber() {
        var values = '';
        $('input[name="tel[]"]:checked').each(function () {
            values += (this.checked ? $(this).val() : "") + ',';

        });
        $('.selectphone').val(values);
    }
</script>
