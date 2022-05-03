<x-app-layout>
    <x-slot name="slot">
        <div class="card shadow mb-4">
            <div class="card-header py-3 ">
                <h4 class="m-2 font-weight-bold text-primary float-left">{{ 'Mon compte' }}</h4>

            </div>
            @include('layouts/flash-message')
            <div class="card-body mt-2">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#infos" role="tab"><span
                                class="hidden-sm-up"></span> <span class="hidden-xs-down">A propos de moi</span></a>
                    </li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#password" role="tab"><span
                                class="hidden-sm-up"></span> <span
                                class="hidden-xs-down">Mettre à jour mon mot de passe</span></a></li>
                    {{--                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#versement" role="tab"><span--}}
                    {{--                            class="hidden-sm-up"></span> <span class="hidden-xs-down">Versements</span></a></li>--}}
                </ul>
                <div class="tab-content mt-5 tabcontent-border">
                    <div class="tab-pane active pt-2" id="infos" role="tabpanel">
                        <div class="p-20">
                            <label class="h4">Mes informations</label>
                            <button type="button" style="float: right;" class="btn btn-light" id="edit-btn" title="Modifier mes informations">
                                <i class="fa fa-edit"></i>
                            </button>
                            <form role="form" method="post" action="{{ route('user.edit.infos') }}">
                                @csrf
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input type="hidden" name="userid" value="{{ $user->id }}">
                                    <div class="form-group">
                                        Nom<span class="text-danger">*</span> <br><input
                                            class="form-control edit-info" type="text" placeholder="Nom" name="name"
                                            value="{{isset($user) ? $user->name : ''}}" disabled required>
                                    </div>
                                    <div class="form-group">
                                        Email<span class="text-danger">*</span> <br><input
                                            class="form-control edit-info" type="email" disabled
                                            value="{{isset($user) ? $user->email : ''}}" placeholder="Email"
                                            name="email" required>
                                    </div>

                                    <div class="form-group">
                                        N° téléphone <br><input class="form-control edit-info" type="tel"
                                                                placeholder="Numéro de téléphone"
                                                                name="telephone" disabled
                                                                value="{{isset($user) ? $user->telephone : ''}}">
                                    </div>
                                    <div class="form-group">
                                        Adresse<br><input class="form-control edit-info" type="text"
                                                          placeholder="Adresse" name="adresse" disabled
                                                          value="{{isset($user) ? $user->adresse : ''}}">
                                    </div>

                                </div>

                                <input type="hidden" name="id" value="{{isset($user) ? $user->id : ''}}">

                                <hr>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <button type="submit" class="btn btn-success edit-info" disabled><i
                                            class="fa fa-check fa-fw"></i>{{'Enregistrer'}}
                                    </button>

                                    <button class="btn btn-secondary" type="reset" data-dismiss="modal">Annuler
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>

                    <div class="tab-pane pt-2" id="password" role="tabpanel">
                        <div class="p-20">
                            <label class="h4">Réinitialiser mon mot de passe</label>
                            <form role="form" method="post" action="{{ route('user.edit.password') }}">
                                @csrf
                                <input type="hidden" name="userid" value="{{ $user->id }}">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        Ancien mot de passe<span class="text-danger">*</span><br>
                                        <input id="password" class="form-control" type="password"
                                               name="oldpassword" autocomplete="current-password">
                                    </div>
                                    <div class="form-group">
                                        Mot de passe<span class="text-danger">*</span><br>
                                        <input id="password" class="form-control" type="password"
                                               name="password" required autocomplete="current-password"/>
                                    </div>
                                    <div class="form-group">

                                        Confirmer le mot de passe<span class="text-danger">*</span><br>
                                        <input id="confirm_password" class="form-control" type="password"
                                               name="confirm_password" required
                                               autocomplete="current-password"/>
                                    </div>

                                </div>

                                <input type="hidden" name="id" value="{{isset($user) ? $user->id : ''}}">

                                <hr>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <button type="submit" class="btn btn-success"><i
                                            class="fa fa-check fa-fw"></i>{{ 'Enregistrer'}}
                                    </button>

                                    <button class="btn btn-secondary" type="reset" data-dismiss="modal">Annuler
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
<script>
    $('#edit-btn').click(function (e){
        $('.edit-info').removeAttr('disabled');
        // $('.btn-primary').removeAttr('disabled');
    });
</script>
