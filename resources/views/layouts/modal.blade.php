<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Vous partez ?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">{{ Auth::user()->name }} Etes-vous sur de vouloir vous déconnectez ?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="{{ route('logout') }}">Déconnexion</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Client Modal-->
  <div class="modal fade" id="clientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ajouter un client</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" method="post" action="{{ route('store.client') }}">
            @csrf
            <div class="form-group">
              Nom client<br><input class="form-control" type="text"  placeholder="Nom" name="nom_client" required>
            </div>
            <div class="form-group">
              Prenom client<br><input class="form-control" type="text" placeholder="Prenom" name="prenom_client" required>
            </div>
            <div class="form-group">
              Numero d'abonné<br><input class="form-control" type="text" placeholder="numero abonne" name="num_abonne" required>
            </div>
            <div class="form-group">
              N° téléphone client<br><input class="form-control" type="tel" placeholder="Numéro de téléphone" name="telephone_client" required>
            </div>
            <div class="form-group">
              Adresse client<br><input class="form-control" type="text" placeholder="Adresse" name="adresse_client" required>
            </div>
            <div class="form-group">
              Numero décodeur<br><input class="form-control" type="number" placeholder="Numero decodeur" name="num_decodeur" required>
            </div>
            <div class="form-group">
              Formule: <select  name="formule" required>
                            <option value="ACCESS" selected> ACCESS </option>
                            <option value="ACCESS +"> ACCESS + </option>
                            <option value="EVASION"> EVASION </option>
                            <option value="EVASION +"> EVASION + </option>
                            <option value="EVASION"> Essentiel </option>
                            <option value="EVASION +"> Essentiel + </option>
                            <option value="EVASION +"> Tout canal </option>
                           </select>
            </div>
            <div class="form-group">
              Date abonnement<br><input class="form-control" name="date_abonnement" type="date" required>
            </div>
            <hr>
            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Enregistrer</button>
            <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Retour</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
          </form>
        </div>
      </div>
    </div>
  </div>

<!-- Employee Modal-->
<div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ajouter un utilisateurs</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" method="post" action="emp_transac.php?action=add">
              <div class="form-group">
                <input class="form-control" placeholder="Prénom" name="firstname" required>
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Nom" name="lastname" required>
              </div>
              <div class="form-group">
                  <select class='form-control' name='gender' required>
                    <option value="" disabled selected hidden>Sexe</option>
                    <option value="Male">Homme</option>
                    <option value="Female">Femme</option>
                  </select>
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Email" name="email" required>
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Numéro de téléphone" name="phonenumber" required>
              </div>
              <div class="form-group">
                Job:
              </div>
              <div class="form-group">
                <input placeholder="Date d'embauche" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="FromDate" name="hireddate" class="form-control" />
              </div>
              <hr>
            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Enregistrer</button>
            <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Retour</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
          </form>
        </div>
      </div>
    </div>
  </div>



  <!-- Delete Modal-->
  <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="DeleteModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Suppression</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Voulez-vous vraiment supprimer ?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
          <a class="btn btn-danger btn-ok">Delete</a>
        </div>
      </div>
    </div>
  </div>

   <!-- Accessoires Modal-->
   <div class="modal fade" id="materielModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ajouter un materiel</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" method="post" action="{{route('store.materiel')}}">
            @csrf
            <div class="form-group">
              Type: <select  name="type_materiel" onChange="afficherAutre()" required>
                            <option>--Choississez--</option>
                            <option value="Accessoires"> Accessoires </option>
                            <option value="Decodeur"> Decodeur </option>
                           </select>
            </div>
            <div class="form-group">
                <span id=autre style="display: none"> Autre :</span>
                <input type="text" id="mots" name="mots" style="display: none">
            </div>
            <div class="form-group">
              Quantité<br><input class="form-control" placeholder="Quantite" name="quantite" required>
            </div>
            <div class="form-group">
              Prix<br><input class="form-control" placeholder="Prix" name="prix" required>
            </div>
            <div class="form-group">
              Date livraison<br><input class="form-control" type="date" name="date_livraison" required>
            </div>
            <hr>
            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Enregistrer</button>
            <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Retour</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
          </form>
        </div>
      </div>
    </div>
  </div>


</div>
