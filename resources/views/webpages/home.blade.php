<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Font & Icon -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">    

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('mimity-retail/img/favicon/favicon.ico') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('mimity-retail/img/favicon/favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('mimity-retail/img/favicon/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('mimity-retail/img/favicon/touch-icon-iphone.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('mimity-retail/img/favicon/touch-icon-ipad.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('mimity-retail/img/favicon/touch-icon-iphone-retina.png') }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('mimity-retail/img/favicon/touch-icon-ipad-retina.png') }}">    
        
    <!-- Plugins -->
    <link rel="stylesheet" href="{{ asset('mimity-retail/plugins/swiper/swiper.min.css') }}">

    <!-- Main style -->
    <link rel="stylesheet" href="{{ asset('mimity-retail/dist/css/style.min.css') }}">

</head>
<body>

    <!-- TOP BAR -->
    <div class="topbar">
        <div class="container-fluid d-flex align-items-center">

        <nav class="nav mr-1 d-none d-md-flex">
            <a class="nav-link nav-link-sm has-icon bg-white pl-0" href="#"><i class="material-icons mr-1">phone</i> {{ $empresa->regtel }} </a>
            <a class="nav-link nav-link-sm has-icon bg-white" href="#"><i class="material-icons mr-1">mail_outline</i> {{ $empresa->regemail }} </a>
        </nav>

        <nav class="nav nav-circle d-none d-sm-flex">
            <a class="nav-link nav-link-sm nav-icon p-0" href="{{ $empresa->facebook }}"><i class="custom-icon" data-icon="facebook" data-size="17x17"></i></a>

            <a class="nav-link nav-link-sm nav-icon p-0" href="{{ $empresa->instagram }}"><i class="custom-icon" data-icon="instagram" data-size="17x17"></i></a>
        </nav>

        <div class="btn-group btn-group-toggle btn-group-sm ml-auto mr-1" data-toggle="buttons" hidden>
			&nbsp;
        </div>

        <nav class="nav nav-gap-x-1 ml-auto mr-1">
			&nbsp;
        </nav>

        </div>
    </div>
    <!-- /TOP BAR -->

    <!-- HEADER -->
    <header>
        <div class="container-fluid">
        <nav class="nav nav-circle d-flex d-lg-none">
            <a href="#menuModal" data-toggle="modal" class="nav-link nav-icon"><i class="material-icons">menu</i></a>
        </nav>
        <nav class="nav ml-3 ml-lg-0">
            <a href="index.html" class="nav-link has-icon p-0 bg-white">
            <img src="{{ asset('mimity-retail/img/logo.png') }}" alt="Logo" height="40">
            </a>
        </nav>

        <nav class="nav nav-main nav-gap-x-1 nav-pills ml-3 d-none d-lg-flex">
            <div class="nav-item dropdown dropdown-hover">
            <a class="nav-link dropdown-toggle no-caret forwardable active" href="index.html" id="homeDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Home
            </a>
            <div class="dropdown-menu" aria-labelledby="homeDropdown">
                <a class="dropdown-item" href="index.html">Layout 1</a>
                <a class="dropdown-item active" href="index2.html">Layout 2</a>
                <a class="dropdown-item" href="index3.html">Electronics Store</a>
            </div>
            </div>


			

            <div class="nav-item dropdown dropdown-hover">
				<a class="nav-link dropdown-toggle no-caret forwardable" href="blog-grid.html" id="blogDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Categorias
				</a>
				<div class="dropdown-menu" aria-labelledby="blogDropdown">
					@foreach ($categories as $category)
						<a class="dropdown-item" href="#">{{ $category->name }}</a>
					@endforeach
				</div>
            </div>

            <a class="nav-item nav-link" href="components.html">
				Acerca de nosotros
            </a>
            <a class="nav-item nav-link" href="components.html">
				Contacto
            </a>
        </nav>
        <nav class="nav nav-circle nav-gap-x-1 ml-auto">
            <a class="nav-link nav-icon" data-toggle="modal" href="#searchModal">
            <i class="material-icons">search</i>
            </a>
        </nav>

        </div>
    </header>
    <!-- /HEADER -->

    <div class="container-fluid mt-3">
        <div class="d-grid grid-template-col-2 grid-template-col-lg-3 grid-gap-1 grid-gap-sm-3">
    
          <!-- HOME SLIDER -->
          <div class="swiper-container grid-column-start-1 grid-column-end-3 grid-row-start-1 grid-row-end-3" id="homeSlider">
            <div class="swiper-wrapper">
              <div class="swiper-slide" data-cover="{{ asset('mimity-retail/img/slider/1.jpg') }}" data-height="220px 320px 350px 470px 420px">
                <div class="overlay-content overlay-show align-items-end text-white">
                  <div class="text-center">
                    <h1 class="animated font-weight-bold" data-animate="fadeDown">Productos<br/>Rehabilitación Ortopédica</h1>
                 
                  </div>
                </div>
              </div>
              <div class="swiper-slide" data-cover="{{ asset('mimity-retail/img/slider/2.jpg') }}" data-height="220px 320px 350px 470px 420px">
                <div class="overlay-content overlay-show align-items-start text-white">
                  <div class="text-center">
                    <h2 class="bg-white text-dark d-inline-block p-1 animated" data-animate="fadeDown">marcas </h2>
                    <h1 class="animated font-weight-bold" data-animate="fadeDown">líderes en el mercado</h1>
                    
                  </div>
                </div>
              </div>
              <div class="swiper-slide" data-cover="{{ asset('mimity-retail/img/slider/3.jpg') }}" data-height="220px 320px 350px 470px 420px">
                <div class="overlay-content overlay-show align-items-end text-white">
                  <div class="text-center">
                    <h2 class="bg-white text-dark d-inline-block p-1 animated" data-animate="fadeDown"> TheraFlex Pro</h2>
                    <h1 class="animated font-weight-bold" data-animate="fadeDown">Mejora tu calidad</h1>
                    
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev autohide"><i class="material-icons">chevron_left</i></div>
            <div class="swiper-button-next autohide"><i class="material-icons">chevron_right</i></div>
          </div>
          <!-- /HOME SLIDER -->
    
          <!-- TOP CATEGORIES 1 -->
          <div class="card card-style1 overflow-hidden">
            <div class="d-grid grid-template-row-2 grid-template-row-md-none grid-template-col-md-2">
              <div data-cover="{{ asset('mimity-retail/img/categories/ortesis.jpg') }}" class="order-md-2"></div>
              <div class="text-center p-3 order-md-1">
                <h3>Soportes y Ortesis</h3>
                <p class="text-center d-none d-md-block">Rodilleras, Tobilleras, Fajas lumbares.</p>
                <a href="shop-grid.html" class="btn btn-outline-primary rounded-pill stretched-link">Comprar</a>
              </div>
            </div>
          </div>
          <div class="card card-style1 overflow-hidden">
            <div class="d-grid grid-template-row-2 grid-template-row-md-none grid-template-col-md-2">
              <div data-cover="{{ asset('mimity-retail/img/categories/soporte.jpg') }}" class="order-md-2"></div>
              <div class="text-center p-3 order-md-1">
                <h3>Equipos de Ejercicio</h3>
                <p class="text-center d-none d-md-block">Bandas de resistencia, Pelotas de ejercicio.</p>
                <a href="shop-grid.html" class="btn btn-outline-danger rounded-pill stretched-link">Comprar</a>
              </div>
            </div>
          </div>
          <!-- /TOP CATEGORIES 1 -->
    
        </div>
    
        <!-- SERVICES BLOCK -->
        <div class="d-grid grid-template-col-sm-2 grid-template-col-xl-4 column-gap-3 row-gap-4 mt-5 mb-5">
          <div class="media">
            <button class="btn btn-icon btn-lg rounded-circle btn-faded-primary active" type="button">
              <i class="material-icons">local_shipping</i>
            </button>
            <div class="media-body ml-3">
              <h6>FREE SHIPPING &amp; RETURN</h6>
              <span class="text-secondary font-condensed">Get free shipping for all orders $99 or more</span>
            </div>
          </div>
          <div class="media">
            <button class="btn btn-icon btn-lg rounded-circle btn-faded-primary active" type="button">
              <i class="material-icons">refresh</i>
            </button>
            <div class="media-body ml-3">
              <h6>MONEY BACK GUARANTEE</h6>
              <span class="text-secondary font-condensed">Get the item you ordered, or your money back</span>
            </div>
          </div>
          <div class="media">
            <button class="btn btn-icon btn-lg rounded-circle btn-faded-primary active" type="button">
              <i class="material-icons">security</i>
            </button>
            <div class="media-body ml-3">
              <h6>100% SECURE PAYMENT</h6>
              <span class="text-secondary font-condensed">Your transaction are secure with SSL Encryption</span>
            </div>
          </div>
          <div class="media">
            <button class="btn btn-icon btn-lg rounded-circle btn-faded-primary active" type="button">
              <i class="material-icons">phone</i>
            </button>
            <div class="media-body ml-3">
              <h6>ONLINE SUPPORT 24/7</h6>
              <span class="text-secondary font-condensed">Chat with experts or have us call you right away</span>
            </div>
          </div>
        </div>
        <!-- /SERVICES BLOCK -->
    
        <!-- DISCOVER -->
        <h4 class="mt-4 text-center">Discover</h4>
        <div class="d-grid grid-template-col-2 grid-template-col-lg-4 grid-gap-1 grid-gap-sm-3 mt-3">
          <div class="img img-zoom-in">
            <div data-cover="{{ asset('mimity-retail/img/discover/2.jpeg') }}" data-height="125px 130px 150px 120px 150px"></div>
            <div class="overlay overlay-show bg-dark"></div>
            <div class="overlay-content overlay-show">
              <a href="shop-grid.html" class="card-link h3 text-white font-condensed stretched-link text-center px-3">Crossbody Bag</a>
            </div>
          </div>
          <div class="img img-zoom-in">
            <div data-cover="{{ asset('mimity-retail/img/discover/3.jpeg') }}" data-height="125px 130px 150px 120px 150px"></div>
            <div class="overlay overlay-show bg-dark"></div>
            <div class="overlay-content overlay-show">
              <a href="shop-grid.html" class="card-link h3 text-white font-condensed stretched-link text-center px-3">Winter Collection</a>
            </div>
          </div>
          <div class="img img-zoom-in">
            <div data-cover="{{ asset('mimity-retail/img/discover/4.jpeg') }}" data-height="125px 130px 150px 120px 150px"></div>
            <div class="overlay overlay-show bg-dark"></div>
            <div class="overlay-content overlay-show">
              <a href="shop-grid.html" class="card-link h3 text-white font-condensed stretched-link text-center px-3">Accessories</a>
            </div>
          </div>
          <div class="img img-zoom-in">
            <div data-cover="{{ asset('mimity-retail/img/discover/5.jpeg') }}" data-height="125px 130px 150px 120px 150px"></div>
            <div class="overlay overlay-show bg-dark"></div>
            <div class="overlay-content overlay-show">
              <a href="shop-grid.html" class="card-link h3 text-white font-condensed stretched-link text-center px-3">Hats</a>
            </div>
          </div>
        </div>
        <div class="text-right mt-3">
          <a href="shop-categories.html" class="btn btn-light rounded-pill has-icon">Explore <i class="material-icons">arrow_right</i></a>
        </div>
        <!-- /DISCOVER -->
    
        <!-- FLASH DEALS -->
        <div class="card card-style1 mt-5">
          <div class="card-body">
            <h5 class="card-title">
              <i class="material-icons align-bottom text-warning">flash_on</i>
              FLASH DEALS
              <span class="text-danger" id="flash-deals-countdown"></span>
            </h5>
            <div class="swiper-container" id="dealSlider2">
              <div class="swiper-wrapper">
                <div class="swiper-slide card card-product">
                  <div class="card-body">
                    <button class="btn btn-icon btn-text-danger rounded-circle btn-wishlist atw-demo" data-toggle="button" title="Add to wishlist"></button>
                    <a href="shop-single.html"><img class="card-img-top" src="{{ asset('mimity-retail/img/products/flash_deals_1.jpg') }} " alt="Card image cap"></a>
                    <a href="shop-single.html" class="card-title card-link">Legendary Whitetails Hoodie</a>
                    <span class="badge badge-warning">25% OFF</span>
                    <div class="price">
                      <span class="h4">$44.99</span>
                      <span class="h5 del">$59.99</span>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button class="btn btn-sm rounded-pill btn-faded-primary btn-block atc-demo">Add to Cart</button>
                  </div>
                </div>
                <div class="swiper-slide card card-product">
                  <div class="card-body">
                    <button class="btn btn-icon btn-text-danger rounded-circle btn-wishlist atw-demo" data-toggle="button" title="Add to wishlist"></button>
                    <a href="shop-single.html"><img class="card-img-top" src="{{ asset('mimity-retail/img/products/flash_deals_2.jpg') }} " alt="Card image cap"></a>
                    <a href="shop-single.html" class="card-title card-link">Casual Floral Print 3/4 Sleeve Shirt</a>
                    <span class="badge badge-success">15% OFF</span>
                    <div class="price">
                      <span class="h4">$18.69</span>
                      <span class="h5 del">$21.99</span>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button class="btn btn-sm rounded-pill btn-faded-primary btn-block atc-demo">Add to Cart</button>
                  </div>
                </div>
                <div class="swiper-slide card card-product">
                  <div class="card-body">
                    <button class="btn btn-icon btn-text-danger rounded-circle btn-wishlist atw-demo" data-toggle="button" title="Add to wishlist"></button>
                    <a href="shop-single.html"><img class="card-img-top" src="{{ asset('mimity-retail/img/products/flash_deals_1.jpg') }} " alt="Card image cap"></a>
                    <a href="shop-single.html" class="card-title card-link">Legendary Whitetails Hoodie</a>
                    <span class="badge badge-warning">25% OFF</span>
                    <div class="price">
                      <span class="h4">$44.99</span>
                      <span class="h5 del">$59.99</span>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button class="btn btn-sm rounded-pill btn-faded-primary btn-block atc-demo">Add to Cart</button>
                  </div>
                </div>
                <div class="swiper-slide card card-product">
                  <div class="card-body">
                    <button class="btn btn-icon btn-text-danger rounded-circle btn-wishlist atw-demo" data-toggle="button" title="Add to wishlist"></button>
                    <a href="shop-single.html"><img class="card-img-top" src="{{ asset('mimity-retail/img/products/flash_deals_2.jpg') }} " alt="Card image cap"></a>
                    <a href="shop-single.html" class="card-title card-link">Casual Floral Print 3/4 Sleeve Shirt</a>
                    <span class="badge badge-success">15% OFF</span>
                    <div class="price">
                      <span class="h4">$18.69</span>
                      <span class="h5 del">$21.99</span>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button class="btn btn-sm rounded-pill btn-faded-primary btn-block atc-demo">Add to Cart</button>
                  </div>
                </div>
                <div class="swiper-slide card card-product">
                  <div class="card-body">
                    <button class="btn btn-icon btn-text-danger rounded-circle btn-wishlist atw-demo" data-toggle="button" title="Add to wishlist"></button>
                    <a href="shop-single.html"><img class="card-img-top" src="{{ asset('mimity-retail/img/products/flash_deals_1.jpg') }} " alt="Card image cap"></a>
                    <a href="shop-single.html" class="card-title card-link">Legendary Whitetails Hoodie</a>
                    <span class="badge badge-warning">25% OFF</span>
                    <div class="price">
                      <span class="h4">$44.99</span>
                      <span class="h5 del">$59.99</span>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button class="btn btn-sm rounded-pill btn-faded-primary btn-block atc-demo">Add to Cart</button>
                  </div>
                </div>
              </div>
              <div class="swiper-button-prev"><i class="material-icons">chevron_left</i></div>
              <div class="swiper-button-next"><i class="material-icons">chevron_right</i></div>
            </div>
          </div>
        </div>
        <!-- /FLASH DEALS -->
    
        <!-- BRANDS SLIDER -->
        <h4 class="mt-4 text-center">Top Brands You'll Love</h4>
        <div class="card mt-3 border-0">
          <div class="card-body pb-0">
            <div class="swiper-container" id="brandSlider">
              <div class="swiper-wrapper pb-5">
                <div class="swiper-slide card p-3">
                  <a href="shop-grid.html" class="stretched-link">
                    <img src="{{ asset('mimity-retail/img/brands/brand1.svg') }}" alt="brand1" class="card-img-top">
                  </a>
                </div>
                <div class="swiper-slide card p-3">
                  <a href="shop-grid.html" class="stretched-link">
                    <img src="{{ asset('mimity-retail/img/brands/brand2.svg') }}" alt="brand2" class="card-img-top">
                  </a>
                </div>
                <div class="swiper-slide card p-3">
                  <a href="shop-grid.html" class="stretched-link">
                    <img src="{{ asset('mimity-retail/img/brands/brand3.svg') }}" alt="brand3" class="card-img-top">
                  </a>
                </div>
                <div class="swiper-slide card p-3">
                  <a href="shop-grid.html" class="stretched-link">
                    <img src="{{ asset('mimity-retail/img/brands/brand4.svg') }}" alt="brand4" class="card-img-top">
                  </a>
                </div>
                <div class="swiper-slide card p-3">
                  <a href="shop-grid.html" class="stretched-link">
                    <img src="{{ asset('mimity-retail/img/brands/brand5.svg') }}" alt="brand5" class="card-img-top">
                  </a>
                </div>
                <div class="swiper-slide card p-3">
                  <a href="shop-grid.html" class="stretched-link">
                    <img src="{{ asset('mimity-retail/img/brands/brand1.svg') }}" alt="brand1" class="card-img-top">
                  </a>
                </div>
              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>
        </div>
        <!-- /BRANDS SLIDER -->
    
        <!-- BEST SELLERS & TOP CATEGORIES 2 -->
        <div class="d-grid grid-template-col-2 grid-template-col-lg-5 grid-template-col-xl-4 grid-gap-2 grid-gap-xl-3 mt-4 mb-3">
          <div class="card card-style1 grid-column-start-1 grid-column-end-3 grid-column-end-sm-2 grid-column-end-lg-3 grid-column-end-xl-2">
            <div class="card-body">
              <h5 class="card-title">Best Sellers</h5>
              <ul class="list-group list-group-flush list-group-sms">
                <li class="list-group-item px-0">
                  <div class="media">
                    <a href="shop-single.html">
                      <img src="{{ asset('mimity-retail/img/products/1_small.jpg') }} " width="75" alt="product">
                    </a>
                    <div class="media-body ml-3">
                      <a href="shop-single.html" class="card-link text-secondary">Hanes Hooded Sweatshirt</a>
                      <div class="price"><span>$18.56</span></div>
                    </div>
                  </div>
                </li>
                <li class="list-group-item px-0">
                  <div class="media">
                    <a href="shop-single.html">
                      <img src="{{ asset('mimity-retail/img/products/2_small.jpg') }} " width="75" alt="product">
                    </a>
                    <div class="media-body ml-3">
                      <a href="shop-single.html" class="card-link text-secondary">The Flash Logo T-Shirt</a>
                      <div class="price"><span>$16.64</span></div>
                    </div>
                  </div>
                </li>
                <li class="list-group-item px-0">
                  <div class="media">
                    <a href="shop-single.html">
                      <img src="{{ asset('mimity-retail/img/products/3_small.jpg') }} " width="75" alt="product">
                    </a>
                    <div class="media-body ml-3">
                      <a href="shop-single.html" class="card-link text-secondary">Open Front Cropped Cardigans</a>
                      <div class="price">
                        <span>$15.20</span>
                        <span class="del">$19.00</span>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="list-group-item px-0">
                  <div class="media">
                    <a href="shop-single.html">
                      <img src="{{ asset('mimity-retail/img/products/4_small.jpg') }} " width="75" alt="product">
                    </a>
                    <div class="media-body ml-3">
                      <a href="shop-single.html" class="card-link text-secondary">Cotton Fleece Long Hoodie</a>
                      <div class="price">
                        <span>$85.00</span>
                        <span class="del">$98.90</span>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <div class="card card-style1">
            <a href="shop-grid.html" class="card-link">
              <img class="card-img-top" src="{{ asset('mimity-retail/img/categories/men2.jpg') }} " alt="Men">
              <div class="card-body bg-primary-faded text-primary">
                <h5 class="mb-0">MEN</h5>
              </div>
            </a>
            <div class="list-group list-group-sms list-group-no-border list-group-flush">
              <a href="shop-grid.html" class="list-group-item list-group-item-action">Clothing</a>
              <a href="shop-grid.html" class="list-group-item list-group-item-action">Shoes</a>
              <a href="shop-grid.html" class="list-group-item list-group-item-action">Watches</a>
              <a href="shop-grid.html" class="list-group-item list-group-item-action">Accessories</a>
              <a href="shop-grid.html" class="list-group-item list-group-item-action">More &raquo;</a>
            </div>
          </div>
          <div class="card card-style1">
            <a href="shop-grid.html" class="card-link">
              <img class="card-img-top" src="{{ asset('mimity-retail/img/categories/women2.jpg') }} " alt="Women">
              <div class="card-body bg-danger-faded text-danger">
                <h5 class="mb-0">WOMEN</h5>
              </div>
            </a>
            <div class="list-group list-group-sms list-group-no-border list-group-flush">
              <a href="shop-grid.html" class="list-group-item list-group-item-action">Clothing</a>
              <a href="shop-grid.html" class="list-group-item list-group-item-action">Shoes</a>
              <a href="shop-grid.html" class="list-group-item list-group-item-action">Jewelry</a>
              <a href="shop-grid.html" class="list-group-item list-group-item-action">Accessories</a>
              <a href="shop-grid.html" class="list-group-item list-group-item-action">More &raquo;</a>
            </div>
          </div>
          <div class="card card-style1 grid-column-start-1 grid-column-end-3 grid-column-start-sm-2 grid-column-end-sm-3
          grid-column-start-lg-5 grid-column-end-lg-6 grid-column-start-xl-4 grid-column-end-xl-5">
            <a href="shop-grid.html" class="card-link">
              <img class="card-img-top" src="{{ asset('mimity-retail/img/categories/kids.jpg') }} " alt="Kids">
              <div class="card-body bg-success-faded text-success">
                <h5 class="mb-0">KIDS</h5>
              </div>
            </a>
            <div class="list-group list-group-sms list-group-no-border list-group-flush">
              <a href="shop-grid.html" class="list-group-item list-group-item-action">Boys Clothing</a>
              <a href="shop-grid.html" class="list-group-item list-group-item-action">Girls Clothing</a>
              <a href="shop-grid.html" class="list-group-item list-group-item-action">Toys</a>
              <a href="shop-grid.html" class="list-group-item list-group-item-action">Accessories</a>
              <a href="shop-grid.html" class="list-group-item list-group-item-action">More &raquo;</a>
            </div>
          </div>
        </div>
        <!-- /BEST SELLERS & TOP CATEGORIES 2 -->
    
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <div class="container-fluid">
        <div class="d-grid grid-template-col-sm-2 grid-template-col-lg-4">
            <div class="px-3 text-center">
            <h5>Subscribe</h5>
            <p>and get <strong class="text-primary">10% discount</strong></p>
            <form>
                <div class="form-group">
                <input type="email" class="form-control rounded-pill text-center" placeholder="Enter your email">
                </div>
                <button type="button" class="btn btn-primary btn-block rounded-pill">SUBSCRIBE</button>
            </form>
            </div>
            <div>
            <h5>Customer Service</h5>
            <div class="list-group list-group-flush list-group-no-border list-group-sm">
                <a href="javascript:void(0)" class="list-group-item list-group-item-action">Help Center</a>
                <a href="javascript:void(0)" class="list-group-item list-group-item-action">How to buy</a>
                <a href="javascript:void(0)" class="list-group-item list-group-item-action">Delivery</a>
                <a href="javascript:void(0)" class="list-group-item list-group-item-action">How to return</a>
                <a href="javascript:void(0)" class="list-group-item list-group-item-action">Payment Method</a>
                <a href="javascript:void(0)" class="list-group-item list-group-item-action">Shipping Method</a>
            </div>
            </div>
            <div>
            <h5>Mimity</h5>
            <div class="list-group list-group-flush list-group-no-border list-group-sm">
                <a href="about.html" class="list-group-item list-group-item-action">About Us</a>
                <a href="javascript:void(0)" class="list-group-item list-group-item-action">Terms and Conditions</a>
                <a href="javascript:void(0)" class="list-group-item list-group-item-action">Privacy Policy</a>
                <a href="faq.html" class="list-group-item list-group-item-action">FAQs</a>
                <a href="javascript:void(0)" class="list-group-item list-group-item-action">Our Story</a>
                <a href="javascript:void(0)" class="list-group-item list-group-item-action">Services</a>
            </div>
            </div>
            <div>
            <h5>Download The App</h5>
            <a href="javascript:void(0)" class="download-app">
                <div class="media">
                <img src="{{ asset('mimity-retail/img/app/google-play.svg') }}" alt="Google Play Logo" height="30">
                <div class="media-body">
                    <small>Get it on</small>
                    <h5>Google Play</h5>
                </div>
                </div>
            </a>
            <a href="javascript:void(0)" class="download-app">
                <div class="media">
                <img src="{{ asset('mimity-retail/img/app/apple.svg') }}" alt="Apple Logo" height="30">
                <div class="media-body">
                    <small>Download on the</small>
                    <h5>App Store</h5>
                </div>
                </div>
            </a>
            <a href="javascript:void(0)" class="download-app">
                <div class="media">
                <img src="{{ asset('mimity-retail/img/app/windows.svg') }}" alt="Windows Logo" height="30">
                <div class="media-body">
                    <small>Get it from</small>
                    <h5>Microsoft Store</h5>
                </div>
                </div>
            </a>
            </div>
        </div>
        </div>
    </div>

    <div class="copyright">Copyright © 2019 Mimity All right reserved</div>
    <!-- /FOOTER -->


    <!-- MENU MODAL -->
    <div class="modal fade modal-content-left" id="menuModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header align-items-center border-bottom shadow-sm z-index-1">
            <a href="#"><img src="{{ asset('mimity-retail/img/logo.png') }}" alt="Logo" height="40"></a>
            <button class="btn btn-icon btn-sm btn-text-secondary rounded-circle" type="button" data-dismiss="modal">
                <i class="material-icons">close</i>
            </button>
            </div>
            <div class="modal-body px-0 scrollbar-width-thin">
            <ul class="menu" id="menu">
                <li class="no-sub"><a href="index.html"><i class="material-icons">home</i> Home</a></li>
                <li class="no-sub mm-active"><a href="index2.html"><i class="material-icons">home_work</i> Home layout 2</a></li>
                <li class="no-sub"><a href="index3.html"><i class="material-icons">phonelink</i> Electronics Store</a></li>
                <li>
                <a href="#" class="has-arrow"><i class="material-icons">shopping_cart</i> Shop</a>
                <ul>
                    <li><a href="shop-categories.html">Shop Categories</a></li>
                    <li><a href="shop-grid.html">Shop Grid</a></li>
                    <li><a href="shop-list.html">Shop List</a></li>
                    <li><a href="cart.html">Cart</a></li>
                    <li>
                    <a href="#" class="has-arrow">Checkout</a>
                    <ul>
                        <li><a href="checkout-shipping.html">Checkout Shipping</a></li>
                        <li><a href="checkout-payment.html">Checkout Payment</a></li>
                        <li><a href="checkout-review.html">Checkout Review</a></li>
                        <li><a href="checkout-complete.html">Checkout Complete</a></li>
                    </ul>
                    </li>
                    <li><a href="shop-single.html">Single Product</a></li>
                </ul>
                </li>
                <li>
                <a href="#" class="has-arrow"><i class="material-icons">person</i> Account</a>
                <ul>
                    <li><a href="account-signin.html">Sign In / Sign Up</a></li>
                    <li><a href="account-profile.html">Profile Page</a></li>
                    <li><a href="account-orders.html">Orders List</a></li>
                    <li><a href="account-order-detail.html">Order Detail</a></li>
                    <li><a href="account-wishlist.html" class="has-badge">Wishlist <span class="badge badge-primary badge-pill">3</span></a></li>
                    <li><a href="account-address.html">Address</a></li>
                </ul>
                </li>
                <li>
                <a href="#" class="has-arrow"><i class="material-icons">rss_feed</i> Blog</a>
                <ul>
                    <li><a href="blog-grid.html">Post Grid</a></li>
                    <li><a href="blog-list.html">Post List</a></li>
                    <li><a href="blog-single.html">Single Post</a></li>
                </ul>
                </li>
                <li>
                <a href="#" class="has-arrow"><i class="material-icons">file_copy</i> Pages</a>
                <ul>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                    <li><a href="compare.html">Compare</a></li>
                    <li><a href="faq.html">Help / FAQ</a></li>
                    <li><a href="404.html">404 Not Found</a></li>
                </ul>
                </li>
                <li class="no-sub"><a href="components.html"><i class="material-icons">check_box_outline_blank</i> Components</a></li>
            </ul>
            </div>
        </div>
        </div>
    </div>
    <!-- /MENU MODAL -->

    <!-- SEARCH MODAL -->
    <div class="modal fade" id="searchModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-1 p-lg-3">
            <form>
                <div class="input-group input-group-lg input-group-search">
                <div class="input-group-prepend">
                    <button class="btn btn-text-secondary btn-icon btn-lg rounded-circle" type="button" data-dismiss="modal">
                    <i class="material-icons">chevron_left</i>
                    </button>
                </div>
                <input type="search" class="form-control form-control-lg border-0 shadow-none mx-1 px-0 px-lg-3" id="searchInput" placeholder="Search..." required>
                <div class="input-group-append">
                    <button class="btn btn-text-secondary btn-icon btn-lg rounded-circle" type="submit">
                    <i class="material-icons">search</i>
                    </button>
                </div>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>
    <!-- /SEARCH MODAL -->

    <!-- Main script -->
    <script src="{{ asset('mimity-retail/dist/js/script.min.js') }}"></script>

    <!-- Plugins -->
    <script src="{{ asset('mimity-retail/plugins/swiper/swiper.min.js') }}"></script>
    <script src="{{ asset('mimity-retail/plugins/jquery-countdown/jquery.countdown.min.js') }}"></script>
    
    <!-- Application script -->
    <script src="{{ asset('mimity-retail/dist/js/app.min.js') }}"></script>
    <script>
      $(() => {
  
        App.atcDemo() // Add to Cart Demo
        App.atwDemo() // Add to Wishlist Demo
        App.homeSlider('#homeSlider')
        App.dealSlider2('#dealSlider2')
        App.brandSlider('#brandSlider')
        App.colorOption()
  
        // example countdown, 6 hours from now for flash deals
        var countdown = new Date()
        countdown.setHours(countdown.getHours() + 6)
        $('#flash-deals-countdown').countdown(countdown, function (e) {
          $(this).text(e.strftime('%H:%M:%S'))
        })
  
      })
    </script>

</body>
</html>

