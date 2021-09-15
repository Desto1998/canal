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
                                            Clients
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
                                            Abonnés nouveaux
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
                                            Abonnés bientot à terme
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
                <div class="col-md-3 mb-3">
                    <div class="card border-left-info shadow h-100 py-2 card-hover">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Décodeurs
                                        disponible
                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">

                                        {{ count($decodeurs) - count($decodeuroccupe) }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-left-success shadow h-100 py-2 card-hover">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Décodeurs
                                        occupés
                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">

                                        {{ count($decodeuroccupe) }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-lock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="row">

                <div class="col-md-3 mb-3">
                    <a href="{{ route('caisse') }}" class="text-info" >
                        <div class="card border-left-info shadow h-100 py-2 card-hover">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-0">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Total caisse

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
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1"> Cosommé

                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        {{ $consommeCaisse }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-bill-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-left-danger shadow h-100 py-2 card-hover card-hover">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1"> Reste en
                                        caisse

                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        {{ $statutcaisse }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-check fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-3 mb-3">
                    <div class="card border-left-info shadow h-100 py-2 card-hover">
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
                                    <i class="fas fa-fax fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <a href="{{ route('compte') }}" class="text-info">
                        <div class="card border-left-info shadow h-100 py-2 card-hover">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-0">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Utilisateurs

                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                                            {{ count($users) }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card border-left-info shadow h-100 py-2 card-hover">
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
                                    <i class="fas fa-object-group fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
{{--<div class="bs-example">--}}
{{--    <div class="accordion" id="accordionExample">--}}
{{--        <div class="card">--}}
{{--            <div class="card-header" id="headingOne">--}}
{{--                <h2 class="mb-0">--}}
{{--                    <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseOne">1. What--}}
{{--                        is HTML?--}}
{{--                    </button>--}}
{{--                </h2>--}}
{{--            </div>--}}
{{--            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">--}}
{{--                <div class="card-body">--}}
{{--                    <p>HTML stands for HyperText Markup Language. HTML is the standard markup language for describing--}}
{{--                        the structure of web pages. <a href="https://www.tutorialrepublic.com/html-tutorial/"--}}
{{--                                                       target="_blank">Learn more.</a></p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="card">--}}
{{--            <div class="card-header" id="headingTwo">--}}
{{--                <h2 class="mb-0">--}}
{{--                    <button type="button" class="btn btn-link collapsed" data-toggle="collapse"--}}
{{--                            data-target="#collapseTwo">2. What is Bootstrap?--}}
{{--                    </button>--}}
{{--                </h2>--}}
{{--            </div>--}}
{{--            <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">--}}
{{--                <div class="card-body">--}}
{{--                    <p>Bootstrap is a sleek, intuitive, and powerful front-end framework for faster and easier web--}}
{{--                        development. It is a collection of CSS and HTML conventions. <a--}}
{{--                            href="https://www.tutorialrepublic.com/twitter-bootstrap-tutorial/" target="_blank">Learn--}}
{{--                            more.</a></p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="card">--}}
{{--            <div class="card-header" id="headingThree">--}}
{{--                <h2 class="mb-0">--}}
{{--                    <button type="button" class="btn btn-link collapsed" data-toggle="collapse"--}}
{{--                            data-target="#collapseThree">3. What is CSS?--}}
{{--                    </button>--}}
{{--                </h2>--}}
{{--            </div>--}}
{{--            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">--}}
{{--                <div class="card-body">--}}
{{--                    <p>CSS stands for Cascading Style Sheet. CSS allows you to specify various style properties for a--}}
{{--                        given HTML element such as colors, backgrounds, fonts etc. <a--}}
{{--                            href="https://www.tutorialrepublic.com/css-tutorial/" target="_blank">Learn more.</a></p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}


{{--<!-- Tabs -->--}}
{{--<div class="card">--}}
{{--    <!-- Nav tabs -->--}}
{{--    <ul class="nav nav-tabs" role="tablist">--}}
{{--        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span--}}
{{--                    class="hidden-sm-up"></span> <span class="hidden-xs-down">Tab1</span></a></li>--}}
{{--        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile" role="tab"><span--}}
{{--                    class="hidden-sm-up"></span> <span class="hidden-xs-down">Tab2</span></a></li>--}}
{{--        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#messages" role="tab"><span--}}
{{--                    class="hidden-sm-up"></span> <span class="hidden-xs-down">Tab3</span></a></li>--}}
{{--    </ul>--}}
{{--    <!-- Tab panes -->--}}
{{--    <div class="tab-content tabcontent-border">--}}
{{--        <div class="tab-pane active" id="home" role="tabpanel">--}}
{{--            <div class="p-20">--}}
{{--                <p>And is full of waffle to It has multiple paragraphs and is full of waffle to pad out the comment.--}}
{{--                    Usually, you just wish these sorts of comments would come to an end.multiple paragraphs and is full--}}
{{--                    of waffle to pad out the comment..</p>--}}
{{--                <img src="assets/images/background/img4.jpg" class="img-fluid">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="tab-pane  p-20" id="profile" role="tabpanel">--}}
{{--            <div class="p-20">--}}
{{--                <img src="assets/images/background/img4.jpg" class="img-fluid">--}}
{{--                <p class="m-t-10">And is full of waffle to It has multiple paragraphs and is full of waffle to pad out--}}
{{--                    the comment. Usually, you just wish these sorts of comments would come to an end.multiple paragraphs--}}
{{--                    and is full of waffle to pad out the comment..</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="tab-pane p-20" id="messages" role="tabpanel">--}}
{{--            <div class="p-20">--}}
{{--                <p>And is full of waffle to It has multiple paragraphs and is full of waffle to pad out the comment.--}}
{{--                    Usually, you just wish these sorts of comments would come to an end.multiple paragraphs and is full--}}
{{--                    of waffle to pad out the comment..</p>--}}
{{--                <img src="assets/images/background/img4.jpg" class="img-fluid">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
