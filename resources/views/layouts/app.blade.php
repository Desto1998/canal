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
  background-color: rgba(0,0,0,0.5);
  z-index: 2;
  cursor: pointer;
}
#text{
  position: absolute;
  top: 50%;
  left: 50%;
  font-size: 50px;
  color: white;
  transform: translate(-50%,-50%);
  -ms-transform: translate(-50%,-50%);
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
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href={{ asset('css/sb-admin-2.min.css') }} rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href={{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }} rel="stylesheet">
  {{--Datatables css--}}
  <link rel="stylesheet" href="http://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
  {{--Datatables js--}}
  <script src="http://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready( function () {<font></font>
    $('#myTable').DataTable();<font></font>
    } );<font></font>
  </script>

  {{--toaster--}}
  <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

  <script src="{{ asset('js/app.js') }}" defer></script>
  <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
  <script>
    @if(Session::has('message'))
      var type = "{{ Session::get('alert-type', 'info') }}";
      switch(type){
        case 'info':
          toastr.info("{{ Session::get('message') }}");
          break;

        case 'warning':
          toastr.warning("{{ Session::get('message') }}");
          break;

        case 'success':
          toastr.success("{{ Session::get('message') }}");
          break;

        case 'error':
          toastr.error("{{ Session::get('message') }}");
          break;
      }
    @endif
  </script>


</head>

<body id="page-top">
@if(Auth::user()->is_active!=0)
  <div class="min-h-screen bg-gray-100">
    {{--@livewire('navigation-menu')--}}

    <main>
    <div id="wrapper">
      @php
        $prefix = Request::route()->getPrefix();
        $route = Route::current()->getName();

      @endphp

    <!-- Sidebar -->

    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">CANAL +</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link {{ ($route=='dashboard')?'active':'' }}" href="{{ route('dashboard') }}">
          <i class="fas fa-fw fa-home"></i>
          <span>DASHBOARD</span></a>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Tables
      </div>
      <!-- Tables Buttons -->
      <li class="nav-item">
        <a class="nav-link {{ ($route=='view.abonner')?'active':'' }}" href="{{ route('view.abonner') }}">
          <i class="fas fa-fw fa-user-friends"></i>
          <span>Abonnement</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ ($route=='reabonner')?'active':'' }}" href="{{ route('review.reabonner') }}">
          <i class="fas fa-fw fa-redo"></i>
          <span>Reabonnement</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ ($route=='upgrader')?'active':'' }}" href="{{ route('upgrader') }}">
          <i class="fas fa-fw fa-edit"></i>
          <span>Upgrader un client</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ ($route=='historiques')?'active':'' }}" href="{{ route('historiques') }}">
          <i class="fas fa-fw fa-history"></i>
          <span>Historiques</span></a>
      </li>

     <li class="nav-item">
        <a class="nav-link {{ ($route=='clients')?'active':'' }}" href="{{ route('clients') }}">
          <i class="fas fa-fw fa-user-check"></i>
          <span>Clients</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ ($route=='stock')?'active':'' }}" href="{{ route('stock') }}">
          <i class="fas fa-fw fa-database"></i>
          <span>Stocks</span></a>
      </li>

{{--      <li class="nav-item">--}}
{{--        <a class="nav-link {{ ($route=='messagerie')?'active':'' }}" href="{{ route('messagerie') }}">--}}
{{--          <i class="fas fa-fw fa-mail-bulk"></i>--}}
{{--          <span>Messagerie</span></a>--}}
{{--      </li>--}}
        @if(Auth::user()->is_admin==1)
            <li class="nav-item">
                <a class="nav-link {{ ($route=='caisse')?'active':'' }}" href="{{ route('caisse') }}">
                    <i class="far fa-money-bill-alt"></i>
                    <span>Caisse</span></a>
            </li>
        @endif
        @if(Auth::user()->is_admin==1)
            <li class="nav-item">
                <a class="nav-link {{ ($route=='compte')?'active':'' }}" href="{{ route('compte') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Comptes</span></a>
            </li>
        @endif

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

      <!-- Topbar -->
      <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
          <i class="fa fa-bars"></i>
        </button>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">

          <li class="nav-item dropdown no-arrow">
            <a class="nav-link" href="pos.php" role="button">
              <span class="mr-2 d-none d-lg-inline text-gray-600 small">POS</span>
            </a>
          </li>

          <div class="topbar-divider d-none d-sm-block"></div>

          <!-- Nav Item - User Information -->
          <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
              <img class="img-profile rounded-circle">
              {{--session--}}

            </a>

            {{--session--}}

            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
              <button class="dropdown-item" onclick="on()">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                Profil
              </button>
              <a class="dropdown-item" href="{{route('user.editForm',Auth::user()->id)}}">
                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                Paramètres
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Déconnexion
              </a>
            </div>
          </li>

        </ul>

      </nav>
      <!-- End of Topbar -->
      <!-- Begin Page Content -->
      <div class="container-fluid">
      {{ $slot }}
    </main>
</div>

@else
    @php
        header("Location: {{route('compte/blocke')}}");
    @endphp
    @include('layouts.compte-block')
@endif
@stack('modals')

@livewireScripts

  <!-- Page Wrapper -->

  <div class="container">
    @include('layouts.modal')
    @include('layouts.footer')
</div>
