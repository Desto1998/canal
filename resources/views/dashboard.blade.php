<x-app-layout>
    <x-slot name="slot">
        <div class="row show-grid">
            <!-- Clients -->
            <div class="col-md-3">
            <!-- Nombre Clients -->
            <div class="col-md-12 mb-3">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-0">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Clients</div>
                      <div class="h6 mb-0 font-weight-bold text-gray-800">
                        {{--compte--}}Record(s)
                      </div>
                    </div>
                      <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                      </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Stock -->
            <div class="col-md-12 mb-3">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-0">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Stock</div>
                      <div class="h6 mb-0 font-weight-bold text-gray-800">
                        {{--compte--}} Record(s)
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
            <!-- Abonnés bientot à terme -->
          <div class="col-md-3">
            <!-- Nombre Abonnés bientot à terme -->
            <div class="col-md-12 mb-3">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-0">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Abonnés bientot à terme</div>
                      <div class="h6 mb-0 font-weight-bold text-gray-800">
                        {{--compte--}} Record(s)
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--Abonnés échus -->
            <div class="col-md-12 mb-3">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-0">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Abonnés échus</div>
                      <div class="h6 mb-0 font-weight-bold text-gray-800">
                        {{--compte--}} Record(s)
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>


            </div>




          </div>
    </x-slot>
</x-app-layout>
