  <center>
    <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
      <div class="card-header py-3">
        <h4 class="m-2 font-weight-bold text-primary">Ajouter client</h4>
      </div>
      <a href="{{route('view.abonner')}}" type="button" class="btn btn-primary bg-gradient-primary">Retour</a>
      <div class="card-body">
                  <div class="table-responsive">
                  <form role="form" method="post" action="{{ route('store.client') }}" enctype="multipart/form-data">
                    @csrf
                    
                      <div class="form-group">
                        Nom client<br><input class="form-control" placeholder="Nom" name="nom_client" required>
                      </div>
                      <div class="form-group">
                        Prenom client<br><input class="form-control" placeholder="Prenom" name="prenom_client" required>
                      </div>
                      <div class="form-group">
                        N° téléphone client<br><input class="form-control" placeholder="Numéro de téléphone" name="telephone_client" required>
                      </div>
                      <div class="form-group">
                        Adresse client<br><input class="form-control" placeholder="Adresse" name="adresse_client" required>
                      </div>
                      <div class="form-group">
                        Formule: <select  name="element" required>
                                    @foreach($allFormules as $element)
                                    <option >{{$element->nom_formule}} </option>
                                    @endforeach
                                  </select>
                      </div>
                      <div class="form-group">
                        Date abonnement<br><input class="form-control" placeholder="Date d'abonnement" value="Date d'abonnement" name="date_abonnement" type="date" required>
                      </div>
                      <div class="form-group">
                        Date reabonnement<br><input class="form-control" placeholder="Date de reabonnement" value="Date de reabonnement" name="date_reabonnement" type="date" required>
                      </div>
                      <hr>

                      <button type="submit" class="btn btn-success btn-block"><i class="fa fa-check fa-fw"></i>Enregistrer</button>
                      <button type="reset" class="btn btn-danger btn-block"><i class="fa fa-times fa-fw"></i>Annuler</button>
                      
                  </form>  
                </div>
      </div>
    </div>
  </center>

  <div class="col-lg-12">
    <script type="text/javascript">
      window.location = "{{ route('view.abonner') }}";
    </script>
  </div>

  <?php
