<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <style type="text/css">
        #overlay {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 2;
            cursor: pointer;
        }

        #text {
            position: absolute;
            top: 50%;
            left: 50%;
            font-size: 50px;
            color: white;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
        }
    </style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @livewireStyles

    <!-- Scripts -->

    <link rel="icon" href="https://www.freeiconspng.com/uploads/sales-icon-7.png">

    <!-- Custom fonts for this template-->
    <link href={{ asset('vendor/fontawesome-free/css/all.min.css') }} rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href={{ asset('css/sb-admin-2.min.css') }} rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href={{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }} rel="stylesheet">
    {{--Datatables css--}}
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    {{--Datatables js--}}
    <script src="http://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
</head>
<body>
@if(Auth::user()->is_active == 0)
    <div class="card shadow mb-4">
        <div class="card-header py-3 ">
            <h1 class="m-2 font-weight-bold text-primary float-left uppercase">Compte blocké</h1>

                    <a class="btn btn-primary d-flex float-right text-center" href="{{ route('logout') }}">Déconnexion</a>

        </div>
<hr>
        <div class="alert  alert-danger alert-block text-center" id="error">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong style="font-size: 20px">Désolé vous ne pouvez acceder à ce compte, <br>il est blocké contactez l'adminitrateur pour
                l'aide.</strong><br><br>
            <span class="warning">L'application est en maintenance veillez patienter un peu. j'en ai pour 2h max. DESTO</span>
            <p>
                J'ai blocké vos compte pour le faire. Super ADMIN.
            </p>
        </div>

    </div>
@endif
</body>
</html>

