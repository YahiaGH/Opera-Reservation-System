<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="descriptOnion" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>OPERA</title>

    <!-- Favicon -->
    <link rel="icon" href="{{asset('img/core-img/favicon.ico')}}">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('img/bg-img/breadcum') }}">

</head>

<body>
    <!-- Preloader -->
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="lds-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <!-- ##### Header Area Start ##### -->
    <header class="header-area">
        <!-- Navbar Area -->
        <div class="oneMusic-main-menu">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <!-- Menu -->
                    <nav class="classy-navbar justify-content-between" id="oneMusicNav">

                        <!-- Nav brand -->
                    <a href="{{url('/')}}" class="nav-brand"><img src="{{asset('img/core-img/logo.png')}}" alt=""></a>

                        <!-- Navbar Toggler -->
                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>

                        <!-- Menu -->
                        <div class="classy-menu">

                            <!-- Close Button -->
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>

                            <!-- Nav Start -->
                            <div class="classynav">
                                <ul>
                                    <li><a href={{ url('/') }}>Home</a></li>
                                    <li><a href="{{ url('event') }}">Events</a></li>

                                    @auth
                                        <li><a href="{{ url('user/' . auth::user()->id . '/edit') }}">Account Settings</a></li>
                                        @if(Gate::allows('isCustomer'))
                                        <li><a href="{{ route('ticket.index') }}">Reserved Tickets</a></li>
                                        @endif
                                    @endauth
                                    
                                    
                                    @auth
                                    @if(Gate::allows('isManager'))
                                    <li><a href="#">Manager</a>
                                        <ul class="dropdown">
                                         	<li><a href="{{ route('event.create') }}">Create Events</a></li>
                                            <li><a href="{{ route('hall.create') }}">Add Halls</a></li>
                                            <li><a href="{{ route('hall.index') }}">View All Halls</a></li>
                                        </ul>
                                    </li>
                                    @endif
                                    @endauth
                                    

                                    @auth
                                    @if(Gate::allows('isAdmin'))
                                    <li><a href="#">Admin</a>
                                        <ul class="dropdown">
                                        <li><a href="{{ route('Admin.index') }}">View Pending</a></li>
											<li><a href="{{ route('Admin.showAll') }}">View All Accounts</a></li>    
                                        </ul>
                                    </li>
                                    @endif
                                    @endauth
									
                                
                                @auth
                                <li><a href="{{ route('logout') }}">Hi, {{auth::user()->fname}}</a></li>
                                @if(Session::has('edited'))
                                        <li style="color:green">{{Session::get('edited')}}</li>
                                @endif
                                @else
                                   <li><a href="{{ route('login') }}">Login</a></li>
                                    <li><a href="{{ route('register') }}">Register</a></li>
                                    @if(Session::has('successRegister'))
                                        <li style="color:green">{{Session::get('successRegister')}}</li>
                                    @endif
                                @endauth
                                </ul>
                           
                            </div>
                            <!-- Nav End -->

                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- ##### Hero Area Start ##### -->
    <section class="hero-area">
        <div class="hero-slides owl-carousel">
            <!-- Single Hero Slide -->
            <div class="single-hero-slide d-flex align-items-center justify-content-center">
                <!-- Slide Img -->
                <div class="slide-img bg-img" style="background-image: url({{ asset('img/bg-img/bg-1.jpg') }});"></div>
                <!-- Slide Content -->
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="hero-slides-content text-center">
                                <h6 data-animation="fadeInUp" data-delay="100ms">EGYPT</h6>
                                <h2 data-animation="fadeInUp" data-delay="300ms"><span></span></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Single Hero Slide -->
            <div class="single-hero-slide d-flex align-items-center justify-content-center">
                <!-- Slide Img -->
                <div class="slide-img bg-img" style="background-image: url({{ asset('img/bg-img/bg-2.jpg') }});"></div>
                <!-- Slide Content -->
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="hero-slides-content text-center">
                                <h2 data-animation="fadeInUp" data-delay="300ms">Above All<span>Above All</span></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Hero Area End ##### -->

    <!-- ##### Featured Artist Area Start ##### -->
    <section class="featured-artist-area section-padding-100 bg-img bg-overlay bg-fixed" style="background-image: url({{asset('img/bg-img/bg-4.jpg')}});">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-12 col-md-7 col-lg-8">
                    <div class="featured-artist-content">
                        <!-- Section Heading -->
                        <div class="section-heading white text-left mb-30">
                            <p>Egypt OPERA House</p>
                            <h2>Listen and Watch Egypt's Most Beautiful Plays</h2>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Featured Artist Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer-area">
        <div class="container">
            <div class="row d-flex flex-wrap align-items-center">
                <div class="col-12 col-md-6">
                    <a href="#">Opera</a>
                    <p class="copywrite-text"><a href="#"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved by Opera.</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                </div>
            </div>
        </div>
    </footer>
    <!-- ##### Footer Area Start ##### -->

    <!-- ##### All Javascript Script ##### -->
    <!-- jQuery-2.2.4 js -->
   <script src="{{ asset('js/jquery/jquery-2.2.4.min.js') }}"></script>
    <!-- Popper js -->
    <script src="{{ asset('js/bootstrap/popper.min.js') }}"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>
    <!-- All Plugins js -->
    <script src="{{ asset('js/plugins/plugins.js') }}"></script>
    <!-- Active js -->
    <script src="{{ asset('js/active.js') }}"></script>
</body>

</html>