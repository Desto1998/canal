<x-app-layout>
    <x-slot name="slot">
        <div class="container">
          <div class="row" style="margin-top: 120px;">
            
            <div class="col-md-6 col-md-offset-3">
               <form method="POST" action="{{ route('sms') }}">
                 @csrf
                  <div class="mb-3">
                    <label for="mobile" class="form-label">Numero téléphone</label>
                    <input type="text" name="telephone" class="form-control" id="mobile" aria-describedby="Mobile">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                  </div>
                  <div class="mb-3">
                    <label for="sms" class="form-label">Message</label>
                    <input type="text" name="message" class="form-control" id="sms">
                  </div>
                  <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                  </div>
                  <button type="submit" class="btn btn-primary">Envoyer</button>
               </form>
              
            </div>
           </div>
        </div>
            
          
        </div>
    </x-slot>
</x-app-layout>
