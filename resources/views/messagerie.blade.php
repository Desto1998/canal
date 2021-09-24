<x-app-layout>
    <x-slot name="slot">
        @include('layouts.flash-message')
          <div class="row col-md-8  d-flex align-content-center justify-content-center" style="margin-top: 20px; border-radius: 10px">

            <div class="col-md-12 bg-white  p-4" style="border-radius: 10px">
                <div class="card shadow">
                    <div class="card-body">
                        <form method="POST" action="{{ route('send.message.manual') }}">
                            @csrf
                            <div class="form-group">
                                <label for="sender" class="form-label"><i class="fas fa-user mr-1"></i>Nom de l'émetteur</label>
                                <input type="text" name="sender" required placeholder="Identifiant de l'emetteur" class="form-control" id="sender">
                            </div>
                            <div class="form-group">
                                <label for="mobile" class="form-label"><i class="fas fa-phone mr-1"></i>Numero téléphone(séparé par des virgules: ",")</label>
                                <input type="text" name="phone" required placeholder="Séparé par des virgules(,) Ex: 670xxxxxx,69xxxxxxx" class="form-control" id="mobile">
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label"><i class="fas fa-envelope-open-text mr-1"></i>Message</label>
                                <textarea cols="3" rows="3" placeholder="Saisir le message ici..." class="form-control" id="message" name="message"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary float-left">Envoyer</button>
                            <button type="reset" class="btn btn-secondary float-right">Annuler</button>
                        </form>
                    </div>
                </div>
            </div>
           </div>
        </div>
    </x-slot>
</x-app-layout>
