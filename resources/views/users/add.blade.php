<x-app-layout>
    <x-slot name="slot">
        <div class="card shadow mb-4">
            <div class="card-header py-3 ">
                <h4 class="m-2 font-weight-bold text-primary float-left">{{isset($user)? 'Modifier un utilisateur':'Ajouter un utilisateur'}}</h4>

            </div>
            @include('layouts/flash-message')
            <div class="card-body">
                <div class="table-responsive">
                    <form role="form" method="post" action="{{ isset($user)? route('user.update') : route('user.add') }}" >
                        @csrf
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        Nom<span class="text-danger">*</span> <br><input class="form-control" type="text"  placeholder="Nom" name="name" value="{{isset($user) ? $user->name : ''}}" required>
                                    </div>
                                    <div class="form-group">
                                        Email<span class="text-danger">*</span> <br><input class="form-control" type="email" value="{{isset($user) ? $user->email : ''}}"  placeholder="Email" name="email" required>
                                    </div>

                                    <div class="form-group">
                                        N° téléphone <br><input class="form-control" type="tel" placeholder="Numéro de téléphone" name="telephone" value="{{isset($user) ? $user->telephone : ''}}" >
                                    </div>
                                    <div class="form-group">
                                        Adresse<br><input class="form-control" type="text" placeholder="Adresse" name="adresse" value="{{isset($user) ? $user->adresse : ''}}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    @if(isset($user) and Auth::user()->id==$user->id)
                                        <div class="form-group">
                                            Ancien mot de passe<span class="text-danger">*</span><br>
                                            <input id="password" class="form-control" type="password" name="oldpassword"  autocomplete="current-password">
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        Mot de passe<span class="text-danger">*</span><br>
                                        <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
                                    </div>
                                    <div class="form-group">

                                        Confirmer le mot de passe<span class="text-danger">*</span><br>
                                        <input id="confirm_password" class="form-control" type="password" name="confirm_password"  required autocomplete="current-password"/>
                                    </div>
                                        @if( Auth::user()->role=="admin")
                                            <div class="form-group">
                                                Role<span class="text-danger">*</span><br>
                                                <select id="role" name="role" class="form-control">
                                                    <option value="admin" @if(isset($user) and $user->role =='admin') {{__('selected')}} @endif> Administrateur</option>
                                                    <option value="user" @if(isset($user) and $user->role =='user') {{__('selected')}} @endif>Utilisateur</option>
                                                </select>
                                            </div>
                                        @else
                                            <input type="hidden" name="role" value="{{Auth::user()->role}}">
                                        @endif


                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="id" value="{{isset($user) ? $user->id : ''}}">

                        <hr>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>{{isset($user)? 'Modifier':'Enregistrer'}}</button>
                            <button href="{{route('compte')}}" class="btn btn-danger"><i class="fa fa-times fa-fw" ></i>Retour</button>
                            <button class="btn btn-secondary" type="reset" data-dismiss="modal">Annuler</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        </div>
    </x-slot>
</x-app-layout>
