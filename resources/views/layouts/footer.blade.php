
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
              <span>Copyright © GETEL SARL</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

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
        <div class="modal-body">{{ Auth::user()->name }} Voulez-vous vraiment vous déconnectez ?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
          <a class="btn btn-primary" href="logout.php">Déconnexion</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

  <!-- Page level plugins -->
  <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

  <!-- Page level custom scripts -->
  <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>

  <!-- User Edit Info Modal-->
  <div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modifier les informations utilisateurs</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" method="post" action="settings_edit.php">
              <input type="hidden" name="id" value="name" />

              <div class="form-group row text-left text-primary">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Nom complet:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Nom" name="lastname" value="{{ Auth::user()->name }}" required>
                </div>
              </div>
              <div class="form-group row text-left text-primary">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Sexe:
                </div>
                <div class="col-sm-9">
                  <select class='form-control' name='Sexe' required>
                    <option value="" disabled selected hidden>Choix sexe</option>
                    <option value="Male">Homme</option>
                    <option value="Female">Femme</option>
                  </select>
                </div>
              </div>
              <div class="form-group row text-left text-primary">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Nom d'utilisateur:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Nom d'utilisateur" name="username" value="user" required>
                </div>
              </div>
              <div class="form-group row text-left text-primary">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Mot de passe:
                </div>
                <div class="col-sm-9">
                  <input type="password" class="form-control" placeholder=" Mot de passe" name="password" value="" required>
                </div>
              </div>
              <div class="form-group row text-left text-primary">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Email:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Email" name="email" value="email" required>
                </div>
              </div>
              <div class="form-group row text-left text-primary">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Contact #:
                </div>
                <div class="col-sm-9">
                   <input class="form-control" placeholder="Contact #" name="phone" value="Contact" required>
                </div>
              </div>
              <div class="form-group row text-left text-primary">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Role:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Role" name="role" value="role" readonly>
                </div>
              </div>
              <div class="form-group row text-left text-primary">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Date d'embauche:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Date d'embauche" name="hireddate" value="embauche" required>
                </div>
              </div>
              <div class="form-group row text-left text-primary">
                <div class="col-sm-3" style="padding-top: 5px;">
                  Type de compte:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Type de compte" name="type" value="compte" readonly>
                </div>
              </div>
              <hr>
            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Enregistrer</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Fermer</button>      
          </form>  
        </div>
      </div>
    </div>
  </div>