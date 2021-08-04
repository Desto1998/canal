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
                <form role="form" id="abonneForm" method="post" action="{{ route('store.client') }}">
                    @csrf
                    <div class="form-group">
                        Nom client<br><input class="form-control" type="text"  placeholder="Nom" name="nom_client" required>
                    </div>
                    <div class="form-group">
                        Prenom client<br><input class="form-control" type="text" placeholder="Prenom" name="prenom_client" required>
                    </div>
                    <div class="form-group">
                        Numero d'abonné<br><input type="number" class="form-control" maxlength="8" minlength="8" type="text" onblur="controlNumero1(this)" placeholder="numero abonne" name="num_abonne" id="num_abonne" required>
                        <span class="text-danger hidden ereur-numeroa " style=""> Mauvaise saisie Longeur minimale 8</span>
                        @error('num_decodeur')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        N° téléphone client<br><input class="form-control" type="tel" placeholder="Numéro de téléphone" name="telephone_client" required>
                    </div>
                    <div class="form-group">
                        Adresse client<br><input class="form-control" type="text" placeholder="Adresse" name="adresse_client" required>
                    </div>
                    <div class="form-group">
                        Numero décodeur<br><input type="number" class="form-control" maxlength="14" minlength="14" type="number" onblur="controlNumero(this)" placeholder="Numero decodeur" name="num_decodeur" id="num_decodeur" required>
                        <span class="text-danger hidden ereur-numerod " style=""> Mauvaise saisie Longeur minimale 14</span>
                        @error('num_decodeur')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        Formule: <select  name="formule" required>
                            <option value="ACCESS" selected> ACCESS </option>
                            <option value="ACCESS +"> ACCESS + </option>
                            <option value="EVASION"> EVASION </option>
                            <option value="EVASION +"> EVASION + </option>
                            <option value="ESSENTIEL"> ESSENTIEL </option>
                            <option value="ESSENTIEL +"> ESSENTIEL + </option>
                            <option value="TOUT CANAL"> TOUT CANAL </option>
                        </select>
                        Durée:  <select  name="duree" required>
                            <option value=1 selected> 1 mois </option>
                            <option value=2> 2 mois </option>
                            <option value=3> 3 mois </option>
                            <option value=6> 6 mois </option>
                            <option value=9> 9 mois </option>
                            <option value=12> 12 mois </option>
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
                <h5 class="modal-title" id="exampleModalLabel">Ajouter un accessoire</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="{{route('store.materiel')}}">
                    @csrf
                    <div class="form-group">
                        Nom accessoire<br><input class="form-control" placeholder="nom accessoire" class="form-control  @error('nom_materiel') is-invalid @enderror" name="nom_materiel" id="nom_materiel" required>
                        @error('nom_materiel')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        Quantité<br><input class="form-control" placeholder="Quantite" class="form-control  @error('quantite') is-invalid @enderror" name="quantite" id="quantite" required>
                        @error('quantite')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        Prix<br><input class="form-control" placeholder="Prix" class="form-control  @error('prix_materiel') is-invalid @enderror" name="prix_materiel" id="prix_materiel" required>
                        @error('prix_materiel')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        Date livraison<br><input class="form-control" type="date" class="form-control  @error('date_livraison') is-invalid @enderror" name="date_livraison" id="date_livraison" required>
                        @error('date_livraison')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
<!-- Decodeur Modal-->
<div class="modal fade" id="materielModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter un décodeur</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" id="decodeurForm" method="post" action="{{route('store.decodeur')}}">
                    @csrf
                    <div class="form-group">
                        Numero décodeur<br><input type="number" class="form-control"  maxlength="14" minlength="14" placeholder="numero decodeur" onblur="controlNumero(this)" class="form-control  @error('num_decodeur') is-invalid @enderror" name="num_decodeur" id="num_decodeur1"  required>
                        <span class="text-danger hidden ereur-numerodd " style=""> Mauvaise saisie Longeur minimale 14</span>
                        @error('num_decodeur')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        Prix<br><input class="form-control" placeholder="Prix" class="form-control  @error('prix_decodeur') is-invalid @enderror" name="prix_decodeur" id="prix_decodeur"  required>
                        @error('prix_decodeur')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        Date livraison<br><input class="form-control" type="date" class="form-control  @error('date_livraison') is-invalid @enderror" name="date_livraison" id="date_livraison"  required>
                        @error('date_livraison')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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

