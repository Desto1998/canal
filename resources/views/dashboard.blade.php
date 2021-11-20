<x-app-layout>
    <x-slot name="slot">
        <div class="show-grid">
            @include('layouts.flash-message')
            {{--            <!-- Clients -->--}}

            <div class="row">
                {{--                <!-- Nombre Clients -->--}}

                <div class="col-md-3 mb-3">
                    <a href="{{ route('clients') }}" class="text-primary">
                        <div class="card border-left-primary shadow h-100 py-2 card-hover">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-0">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Parc Clients
                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                                            {{ count($clients) }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas  fa-users-cog fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="{{ route('user.client.nouveau') }}" class="text-success">
                        <div class="card border-left-success shadow h-100 py-2 card-hover">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-0">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Entrée en parc
                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                                            {{ count($clientnouveaux) }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 mb-3">
                    <a href="{{ route('user.client.terme') }}" class="text-warning">
                        <div class="card border-left-warning shadow h-100 py-2 card-hover">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-0">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Abonnés Bientôt à terme
                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                                            {{ count($bientotaterme) }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-alt fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 mb-3">
                    <a href="{{ route('user.client.perdu') }}" class="text-danger">
                        <div class="card border-left-danger shadow h-100 py-2 card-hover">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-0">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            Abonnés échus
                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                                            {{ count($clientperdu) }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-lock fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
            <div class="row">

                {{--                <!-- Stock -->--}}
                <div class="col-md-3 mb-3">
                    <a href="{{ route('stock') }}" class="text-primary">
                        <div class="card border-left-primary shadow h-100 py-2 card-hover">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-0">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Décodeurs
                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">

                                            {{ count($decodeurs)}}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-boxes fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                {{--                <div class="col-md-3 mb-3">--}}
                {{--                    <div class="card border-left-info shadow h-100 py-2 card-hover">--}}
                {{--                        <div class="card-body">--}}
                {{--                            <div class="row no-gutters align-items-center">--}}
                {{--                                <div class="col mr-0">--}}
                {{--                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Décodeurs--}}
                {{--                                        disponible--}}
                {{--                                    </div>--}}
                {{--                                    <div class="h6 mb-0 font-weight-bold text-gray-800">--}}

                {{--                                        {{ count($decodeurs) - count($decodeuroccupe) }}--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                                <div class="col-auto">--}}
                {{--                                    <i class="fas fa-check fa-2x text-gray-300"></i>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--                <div class="col-md-3 mb-3">--}}
                {{--                    <div class="card border-left-success shadow h-100 py-2 card-hover">--}}
                {{--                        <div class="card-body">--}}
                {{--                            <div class="row no-gutters align-items-center">--}}
                {{--                                <div class="col mr-0">--}}
                {{--                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Décodeurs--}}
                {{--                                        occupés--}}
                {{--                                    </div>--}}
                {{--                                    <div class="h6 mb-0 font-weight-bold text-gray-800">--}}

                {{--                                        {{ count($decodeuroccupe) }}--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                                <div class="col-auto">--}}
                {{--                                    <i class="fas fa-lock fa-2x text-gray-300"></i>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                {{--            <div class="row">--}}
                {{--                <div class="col-md-3 mb-3">--}}
                {{--                    <a href="{{ route('settings') }}" class="text-info" >--}}
                {{--                        <div class="card border-left-info shadow h-100 py-2 card-hover">--}}
                {{--                            <div class="card-body">--}}
                {{--                                <div class="row no-gutters align-items-center">--}}
                {{--                                    <div class="col mr-0">--}}
                {{--                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">--}}
                {{--                                            Total Versement--}}

                {{--                                        </div>--}}
                {{--                                        <div class="h6 mb-0 font-weight-bold text-gray-800">--}}
                {{--                                            {{ $totalVersement }}--}}
                {{--                                        </div>--}}
                {{--                                    </div>--}}
                {{--                                    <div class="col-auto">--}}
                {{--                                        <i class="fas fa-balance-scale fa-2x text-gray-300"></i>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </a>--}}
                {{--                </div>--}}
                {{--                <div class="col-md-3 mb-3">--}}
                {{--                    <div class="card border-left-success shadow h-100 py-2 card-hover card-hover">--}}
                {{--                        <div class="card-body">--}}
                {{--                            <div class="row no-gutters align-items-center">--}}
                {{--                                <div class="col mr-0">--}}
                {{--                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">--}}
                {{--                                        CGA utilisé--}}

                {{--                                    </div>--}}
                {{--                                    <div class="h6 mb-0 font-weight-bold text-gray-800">--}}
                {{--                                        {{ $consommeVersement }}--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                                <div class="col-auto">--}}
                {{--                                    <i class="fas fa-money-bill-alt fa-2x text-gray-300"></i>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                <div class="col-md-3 mb-3">
                    <div class="card border-left-danger shadow h-100 py-2 card-hover card-hover">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Solde CGA

                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        {{ $statutVersement }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-check fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="{{ route('caisse') }}" class="text-info">
                        <div class="card border-left-info shadow h-100 py-2 card-hover">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-0">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Solde caisse

                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                                            {{ $totalCaisse }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-left-success shadow h-100 py-2 card-hover card-hover">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Solde SMS

                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        {{ $balance }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-envelope fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                {{--                <!-- Stock -->--}}
                <div class="col-md-3 mb-3">
                    <a href="{{ route('today.all') }}" class="text-primary">
                        <div class="card border-left-primary shadow h-100 py-2 card-hover">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-0">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Opérations du jour
                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">
{{--                                            'upgradestody','reabonnementstoday','abonnementstoday'--}}
                                            {{ count($upgradestody)  + count($reabonnementstoday) + count($abonnementstoday)}}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-caret-up fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="{{ route('credit.all') }}" class="text-info">
                        <div class="card border-left-info shadow h-100 py-2 card-hover">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-0">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Opération à crédit

                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                                            {{ $totalCredit }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>

