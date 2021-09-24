<x-app-layout>
    <x-slot name="slot">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="text-primary">Clients bientàt à terme</h4>
                        <label class=""><a class="btn btn-success" href="{{route('user.client.nouveau')}}"> Client nouveau</a></label>
                        <label class="ml-4"><a class="btn btn-warning"  href="{{route('user.client.terme')}}"> Bientot a terme</a></label>
                        <label class="ml-4">
                            <a class="btn btn-danger"  href="{{route('user.client.perdu')}}">
                                Clients échus
                            </a>
                        </label>
                    </div>
                    <div class="col-md-4">
{{--                        <label class="ml-4"><a class="btn btn-primary"  href="#"><i class="fas fa-fw fa-envelope" id="sentoall" title="Envoyer un sms  à toute la liste"></i></a></label>--}}

                    </div>
                </div>
            </div>
            @include('layouts/flash-message')

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
                                <input class="form-control text-uppercase selectphone" type="hidden" value="" id="selectphonehidden"
                                       name="phone" >
                                <div class="form-group">
                                    <label><span><i class="fas fa-phone"></i> </span> Téléphone</label>
                                    <input class="form-control text-uppercase selectphone" type="text" value="" id="selectphone"
                                           name="phone" disabled>
                                </div>
                                <div class="for-group">
                                    <select name="id_message" id="showselectmessage" onchange="showselectedSMSArea()"  class="form-control showarea">
                                        <option value="0">Message Standart</option>
                                        @foreach($messages as $sms => $value)
                                            <option value="{{ $value->id_message }}"> {{ $value->titre_sms }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group selectmessagearea" id="message0">
                                    <label><span><i class="fas fa-pen"></i></span>Message</label>
                                    <textarea class="form-control" name="message" placeholder="Saisisser un message ici..."></textarea>
                                </div>
                                @foreach($messages as $sms => $value)
                                    <div class="form-group hidden selectmessagearea" id="message{{ $value->id_message }}">
                                        <label><span><i class="fas fa-pen"></i></span>Message</label>
                                        <textarea class="form-control" name="message" >{{ $value->message }}</textarea>
                                    </div>
                                @endforeach

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

            <div class="card-body">
                <label class="float-right">
                    <a  class="btn btn-info" id="sendmessage" title="Envoyer un SMS aux sélectionés" href="#"
                        data-toggle="modal" onclick="getNumber()" data-target="#sendtoallModal">
                        <i class="fas fa-sms" ></i>
                    </a>
                </label>
                <div class="table-responsive">
                    <div class="form-group">
{{--                        <label>--}}
{{--                            <input type="checkbox" name="selectall" class="form-control" id="selectall">--}}
{{--                            Tout cocher--}}
{{--                        </label>--}}
                    </div>
                    <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" style="border-radius: 3px" name="selectall" value="-1" class="selectall" id="selectall" >
                            </th>
                            <th>#</th>
                            <th>Nom et Prénom </th>
                            <th>Numéro de téléphone</th>
                            <th>Numéro client</th>
                            <th>Numéro Décodeur</th>
                            <th>Formule actuelle</th>
                            <th>Durée</th>
                            <th>Date d'expiration</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($data as $key => $client)

                            <tr>
                                <td>
                                    <input type="checkbox" style="border-radius: 3px" name="tel[]" value="{{ $client->telephone_client }}" class="selectid" id="select{{ $client->telephone_client }}" >
                                </td>
                                <td>{{ $key+1 }}</td>
                                <td><strong>{{ $client->nom_client }} {{$client->prenom_client }}</strong></td>
                                <td><strong>{{ $client->telephone_client }}</strong></td>
                                <td>{{ $client->num_abonne }}</td>
                                <td>{{ $client->num_decodeur }}</td>
                                <td>{{ $client->nom_formule }} ( {{ $client->prix_formule  }} )</td>
                                <td>{{ $client->duree }} mois</td>
                                <td>{{ $client->date_reabonnement }} </td>
                                <td>
                                    <a type="button" class="btn btn-info" title="Envoyer un message"  href="#" data-toggle="modal" data-target="#messageModal{{ $client->id_client }}">
                                        <i class="fas fa-fw fa-envelope"></i>
                                    </a>
                                </td>
                            </tr>
                            <div class="modal fade justify-center justify-content-center" id="messageModal{{ $client->id_client }}" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel{{ $client->id_client }}"
                                 aria-hidden="true">
                                <div class="modal-dialog text-center" role="document">
                                    <div class="modal-content text-center">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel{{ $client->id_client }}">Envoyer un message</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center justify-content-center align-content-center">
                                            <form role="form" id="abonneForm{{ $client->id_client }}" method="post"
                                                  action="{{ route('send.message') }}">
                                                @csrf
                                                <input type="hidden" name="id_client" value="{{ $client->id_client }}">
                                                <input type="hidden" name="phone" value="{{ $client->telephone_client }}">
                                                <input type="hidden" name="nom_client" value="{{ $client->nom_client }}">
                                                <div class="form-group">
                                                    <label><span><i class="fas fa-address-book"></i> </span> Nom client</label>
                                                    <input class="form-control text-uppercase" type="text" value="{{ $client->nom_client }}"
                                                           name="nom" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label><span><i class="fas fa-phone"></i> </span> Numéro du client</label>
                                                    <input class="form-control text-uppercase" type="text" value="{{ $client->telephone_client }}"
                                                           name="tel" disabled>
                                                </div>
                                                <div class="for-group">
                                                    <select name="id_message" id="showmessage{{ $client->id_client }}" onchange="showSMSArea({{$client->id_client}})"  class="form-control showarea">
                                                        <option value="0">Message Standart</option>
                                                        @foreach($messages as $sms => $value)
                                                            <option value="{{ $value->id_message }}"> {{ $value->titre_sms }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group messagearea" id="message0{{ $client->id_client }}">
                                                    <label><span><i class="fas fa-pen"></i></span>Message</label>
                                                    <textarea class="form-control" name="message" placeholder="Saisisser un message ici..."></textarea>
                                                </div>
                                                @foreach($messages as $sms => $value)
                                                    <div class="form-group hidden messagearea" id="message{{ $value->id_message }}{{ $client->id_client }}">
                                                        <label><span><i class="fas fa-pen"></i></span>Message</label>
                                                        <textarea class="form-control" name="message" >{{ $value->message }}</textarea>
                                                    </div>
                                                @endforeach

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
    function showSMSArea(id)
    {
        $('.messagearea').addClass('hidden');
        var value = $('#showmessage'+id).val();
        $('#message'+value+id).removeClass('hidden');

    }

    $('#selectall').click(function (){

        if($('#selectall').is(':checked')){
            $('.selectid').prop('checked', true);
            console.log(id);
        }else {
            $('.selectid').prop('checked', false);
        }
    });
    function showselectedSMSArea()
    {
        $('.selectmessagearea').addClass('hidden');
        var value = $('#showselectmessage').val();
        $('#message'+value).removeClass('hidden');

    }

    function getNumber(){
        var values='';
        $('input[name="tel[]"]:checked').each(function () {
            values += (this.checked ? $(this).val() : "")+',';

        });
        $('.selectphone').val(values);
    }
</script>
