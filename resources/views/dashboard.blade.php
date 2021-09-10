<x-app-layout>
    <x-slot name="slot">
        <div class="show-grid">
{{--            <!-- Clients -->--}}
            <div class="row">
{{--                <!-- Nombre Clients -->--}}
                <div class="col-md-3 mb-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        <a href="{{ route('clients') }}">Clients</a>
                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        {{ count($clients) }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        <a href="{{ route('user.client.nouveau') }}"> Abonnés nouveaux </a>
                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                         {{ count($clientnouveaux) }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Abonnés
                                        bientot à terme
                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        {{ count($bientotaterme) }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        <a href="{{ route('user.client.perdu') }}">Abonnés échus</a>
                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        {{ count($clientperdu) }}
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
            <div class="row">

                {{--                <!-- Stock -->--}}
                <div class="col-md-3 mb-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        <a href="{{ route('stock') }}">Décodeurs</a>
                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">

                                        {{ count($decodeurs)}}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Décodeurs disponible</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">

                                        {{ count($decodeurs) - count($decodeuroccupe) }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Décodeurs occupés</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">

                                        {{ count($decodeuroccupe) }}
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

            <div class="row">

                <div class="col-md-3 mb-3">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        <a href="{{ route('caisse') }}"> Total caisse </a>

                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                         {{ $totalCaisse }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1"> Cosommé

                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        {{ $consommeCaisse }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1"> Reste en caisse

                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        {{ $statutcaisse }}
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
            <div class="row">

                <div class="col-md-3 mb-3">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Formules

                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        {{ count($allFormules) }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        <a href="{{ route('compte') }}">      Utilisateurs </a>

                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                       {{ count($users) }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Matériel

                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        {{ count($materiels) }}
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
    </x-slot>
</x-app-layout>
