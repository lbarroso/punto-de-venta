<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">  
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">
   
   <style>
   
		body {
			font-family: 'Arial', sans-serif;
			margin: 0;
			padding: 0;
			background-color: #f2f2f2;
		}

		#container {
			display: flex;
			justify-content: space-between;
			padding: 2px;
		}

		#product-list {
			width: 75%;
			background-color: #fff;
			padding: 7px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		}

		#barcode-section {
			margin-bottom: 20px;
		}

		#codigos {
			width: 100%;
			padding: 10px;
			box-sizing: border-box;
			margin-bottom: 10px;
		}

		#total-section {
			width: 25%;
			background-color: #fff;
			padding: 20px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			text-align: center;
		}

		#total {
			font-size: 50px;
			font-weight: bold;
			color:#002040;
			margin-bottom: 20px;
		}

		#ad-container {
			max-width: 100%;
		}

		.ad {
			width: 100%;
			height: auto;
			margin-top: 20px;
			border-radius: 10px;
		}

		#logo {
			max-width: 100%;
			height: auto;
			margin-top: 20px;
			border-radius: 10px;
		}   
   </style>
   
   @yield('styles')
   
</head>

<body  class="hold-transition sidebar-mini sidebar-collapse layout-footer-fixed">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url('/pvproducts') }}" class="nav-link"> <i class="fa fa-home"></i> </a>
      </li>
	  
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" onClick="openModalConfirm()" class="nav-link"> [F2] Confirmar venta</a>
      </li>	  
	  
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" onClick="openModalFindProduct()" class="nav-link"> [F9] Buscar producto</a>
      </li>	  	  

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-lightblue elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/pvproducts') }}" class="brand-link">
      <img src="{{ asset('admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
		@php
			$imagePath = Auth::user()->profile_image ? 'images/' . Auth::user()->profile_image : 'admin/dist/img/almacen.jpg';
		@endphp
          <img src="{{ asset($imagePath) }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-cash-register"></i>
              <p>
                Caja
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
			
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('cash.index') }}" class="nav-link">
                  <i class="fas fa-exchange-alt"></i>
                  <p>Movimientos de caja</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('cierre.index') }}" class="nav-link">
                  <i class="fas fa-wallet"></i>
                  <p>Cierres de caja</p>
                </a>
              </li>			  
            </ul>
			
          </li>
		  
		  <li class="nav-item">
            <a href="{{ route('daily.sales') }}" class="nav-link">
              <i class="fas fa-shopping-cart"></i>
              <p>
                Ventas diarias
              </p>
            </a>
		  </li>
		  
		  <li class="nav-item">
		  
            <a href="{{ route('password.change') }}" class="nav-link">
              <i class="fas fa-key"></i>
              <p>
                Cambiar contraseña
              </p>
            </a>
						
          </li>				  
		  
		  <li class="nav-item">
		  
            <a href="{{ route('logout') }}" class="nav-link"
				onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt"></i>
              <p>
                Cerrar sesi&oacute;n
              </p>
            </a>
			
			<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
				@csrf
			</form>					
			
          </li>
		   
		  
        </ul>		
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<div> &nbsp; </div>
	
    <!-- Main content -->
		@yield('content')
	<!-- /.content -->
  
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 2.0
    </div>
    <strong> Punto de venta {{ config('app.name', 'Laravel') }} </strong> 
  </footer>
  
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->  
  
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin/dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('js/ajaxSetup.js') }}"></script>
<script src="{{ asset('admin/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/app/notify/notify.min.js') }}"></script>

@yield('scripts')

@yield('modal')


</body>


</html>
