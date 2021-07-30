<x-app-layout>
    <x-slot name="slot">
        <div class="card shadow mb-4">
            <div class="card-header py-3 ">
                <h4 class="m-2 font-weight-bold text-primary float-left">{{isset($user)? 'Modifier un utilisateur':'Ajouter un utilisateur'}}</h4>

            </div>
            @include('layouts/flash-message')
            <div class="card-body">
                <div class="table-responsive">
                    <form role="form" method="post" action="{{ route('user.add') }}" >
                        @csrf
                        <input type="hidden" name="id" value="{{isset($user) ? $user->id : ''}}">
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
                        <div class="form-group">
                            Mot de passe<span class="text-danger">*</span><br>
                            <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password"  value="{{isset($user) ? $user->password : ''}}"/>
                        </div>
                        <div class="form-group">
                            Confirmer le mot de passe<span class="text-danger">*</span><br>
                            <x-jet-input id="confirm_password" class="block mt-1 w-full" type="password" name="confirm_password" required autocomplete="current-password" value="{{isset($user) ? $user->password : ''}}"/>
                        </div>
                        <div class="form-group">
                            <label for="role">Role<span class="text-danger">*</span></label>
                            <select id="role" name="role" class="form-control">

                                <option value="admin" @if(isset($user) and $user->role =='admin') {{__('selected')}} @endif> Administrateur</option>
                                <option value="user" @if(isset($user) and $user->role =='user') {{__('selected')}} @endif>Utilisateur</option>
                            </select>
                        </div>

                        <hr>
                        <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>{{isset($user)? 'Modifier':'Enregistrer'}}</button>
                        <button href="{{route('compte')}}" class="btn btn-danger"><i class="fa fa-times fa-fw" ></i>Retour</button>
                        <button class="btn btn-secondary" type="reset" data-dismiss="modal">Annuler</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </x-slot>
</x-app-layout>
