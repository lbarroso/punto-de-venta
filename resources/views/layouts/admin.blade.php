<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AdminWeb') }}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @yield('styles')
</head>

<body onkeyup="teclaPresionada(event);" class="hold-transition sidebar-mini layout-fixed" >
    <div class="wrapper">

        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="{{ asset('admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo"
                height="60" width="60">
        </div>

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ url('/home') }}" class="nav-link">Home</a>
                </li>

            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">

                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <li class="nav-item dropdown">
					&nbsp;
				</li>
				
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
					&nbsp;
                </li>
				@php
					$imagePath = Auth::user()->profile_image ? 'images/' . Auth::user()->profile_image : 'admin/dist/img/almacen.jpg';
				@endphp
                <li class="dropdown user user-menu">
                    <a href="#" class="nav-link" data-toggle="dropdown">
                        <img src="{{ asset('admin/dist/img/almacen.jpg') }}" class="user-image" alt="User Image">
                        &nbsp;
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="{{ asset($imagePath) }}" class="img-circle" alt="User Image">
                            <p>
                                {{ Auth::user()->name }}
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="float-left">
                                <a href="{{ route('profile.edit') }}" class="btn btn-default btn-flat">Perfil</a>
                            </div>
                            <div class="float-right">
							
								<a class="btn btn-default btn-flat" href="{{ route('logout') }}"
								   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
									Salir
								</a>
								
								<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
									@csrf
								</form>								
									
                            </div>
                        </li>
                    </ul>
                </li>


            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ url('/home') }}" class="brand-link">
                <img src="{{ asset('admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset($imagePath) }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    
						<li class="nav-item ">
							<a href="{{ route('home') }}" class="nav-link {{ active_menu(route('home')) }}">
								<i class="nav-icon fas fa-tachometer-alt"></i>
								<p>
									Dashboard
								</p>
							</a>
						</li>	
	
						@if(Auth::user()->role > 0)
							
						<li class="nav-item ">
							<a href="{{ route('products.index') }}" class="nav-link {{ active_menu(route('products.index')) }}">
								<i class="nav-icon fas fa-box"></i>
								<p>
									Productos 
								</p>
							</a>
						</li>						

						<li class="nav-item ">
							<a href="{{ route('categories.index') }}" class="nav-link {{ active_menu(route('categories.index')) }}">
								<i class="nav-icon fas fa-tags"></i>
								<p>
									Categorias 
								</p>
							</a>
						</li>	
						
						<li class="nav-item ">
							<a href="{{ route('clientes.index') }}" class="nav-link {{ request()->path() == 'clientes' ? 'active' : ''; }}">
								<i class="nav-icon fas fa-users"></i>
								<p>
									Clientes 
								</p>
							</a>
						</li>	
									
						<li class="nav-item ">
							<a href="{{ route('proveedores.index') }}" class="nav-link {{ active_menu(route('proveedores.index')) }}">
								<i class="nav-icon fas fa-truck"></i>
								<p>
									Proveedores
								</p>
							</a>
						</li>	
						
						<li class="nav-item ">
							<a href="{{ route('empresas.index') }}" class="nav-link {{ active_menu(route('empresas.index')) }}">
								<i class="nav-icon fas fa-building"></i>
								<p>
									Empresas
								</p>
							</a>
						</li>	


						<!--Inventario-->
                        <li class="nav-item {{ menu_open('inventario/*',1) }}">
                            <a href="#" class="nav-link {{ menu_open('inventario/*',2) }}">
                              <i class="fas fa-boxes nav-icon"></i>
                              <p>
                                Inventario
                                <i class="fas fa-angle-left right"></i>
                              </p>
                            </a>
							
                            <ul class="nav nav-treeview">
                              <li class="nav-item">
                                <a href="{{ route('compras.index') }}" class="nav-link {{ active_menu(route('compras.index')) }}" >
                                  <i class="fas fa-plus-square nav-icon"></i>
                                  <p>Compras</p>
                                </a>	
                              </li>
                            </ul>							
                            <ul class="nav nav-treeview">
                              <li class="nav-item">							  
                                <a href="{{ route('salidas.index') }}"  class="nav-link {{ active_menu(route('salidas.index')) }}">
                                  <i class="fas fa-minus-square nav-icon"></i>
                                  <p>Salidas</p>
                                </a>        								
                              </li>
                            </ul>

                           <ul class="nav nav-treeview">
                              <li class="nav-item">							  
                                <a target="_mov" href="{{ route('inventory.report') }}"  class="nav-link {{ active_menu(route('inventory.report')) }}">
                                  <i class="fas fa-truck"></i>
                                  <p>Movimientos por clave</p>
                                </a>        								
                              </li>
                            </ul>							
							
                        </li>		

						
						<!--reportes-->
                        <li class="nav-item {{ menu_open('reports/*',1) }}">
                            <a href="#" class="nav-link {{ menu_open('reports/*',2) }}">
                              <i class="nav-icon fas fa-chart-bar"></i>
                              <p>
                                Reportes
                                <i class="fas fa-angle-left right"></i>
                              </p>
                            </a>
                            <ul class="nav nav-treeview">
                              <li class="nav-item">
                                <a href="{{ route('daily.days') }}" class="nav-link {{ active_menu(route('daily.days')) }}">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Diarios</p>
                                </a>
                              </li>
                            </ul>
                            <ul class="nav nav-treeview">
                              <li class="nav-item">
                                <a href="{{ route('descendente') }}" class="nav-link {{ active_menu(route('descendente')) }}">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Descendente</p>
                                </a>
                              </li>
                            </ul>
                            <ul class="nav nav-treeview">
                              <li class="nav-item">
                                <a href="{{ route('ventas') }}" class="nav-link {{ active_menu(route('ventas')) }}">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Ventas</p>
                                </a>
                              </li>
                            </ul>								
                        </li>					
						
						@endif
					</ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                @yield('content-header')
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 m-auto">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-check"></i> Alert!</h5>
                                    {{ session('success') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 m-auto">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-uncheck"></i> Alert!</h5>
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    @yield('content')
                </div>
            </section>
        
        </div>


        <footer class="main-footer">
            <strong> Administraci&oacute;n de Inventarios {{ config('app.name', 'Laravel') }} </strong>                
            <div class="float-right d-none d-sm-inline-block">
                <b>Versi&oacute;n</b> 2.0
            </div>
        </footer>

    </div>

    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('admin/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('js/ajaxSetup.js') }}"></script>
    <script src="{{ asset('admin/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/app/notify/notify.min.js') }}"></script>

    @yield('scripts')
    @yield('modal')

</body>

<!--interactuar con el teclado-->
<script>
    function teclaPresionada(event)
    {
        var tecla = event.keyCode;

        switch(tecla)
        {
            // tecla funcion F2
            case 113: 
				// Cambiar la URL por la que desees cargar
				window.location.href = "{{ route('product.create') }}";
	
			break;
			
            default:  ; break;
        }        
    }
	
	
</script>

</html>
