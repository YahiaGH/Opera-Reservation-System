<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>OPERA</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/core-img/favicon.ico') }}">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('style.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
	
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
                    <a href="{{url('/')}}" class="nav-brand"><img src="{{ asset('img/core-img/logo.png') }}" alt=""></a>

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

    <!-- ##### Breadcumb Area Start ##### -->
    <section class="breadcumb-area bg-img bg-overlay" style="background-image:  url({{ asset('img/bg-img/breadcumb3.jpg') }});">
        <div class="bradcumbContent">
            <h2>Hello</h2>
        </div>
    </section>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### Login Area Start ##### -->
	 <section class="login-area section-padding-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="login-content">
                        <h3>Register</h3>
                        <!-- Login Form -->
                        <div class="login-form">
                            <form action="{{ route('register') }}" method="post">
                                @csrf
							
							<div class="form-group">
							<label for="FirstName">First Name</label>
							<input required type="text" class="form-control" id="FirstName" placeholder="First Name"  @error('FirstName') is-invalid @enderror name="FirstName" value="{{ old('FirstName') }}" required autocomplete="FirstName" autofocus>
                                
                                @if(Session::has('errors'))  
                                @if(Session::get('errors')->has('FirstName'))  
                                       <div class="alert alert-danger"> {{ Session::get('errors')->first('FirstName') }}</div>
                                @endif
                                @endif

                        </div>
						  <div class="form-group">
							<label for="LastName">Last Name</label>
							<input required type="text" class="form-control" id="LastName" placeholder="Last Name" @error('LastName') is-invalid @enderror name="LastName" value="{{ old('LastName') }}" required autocomplete="LastName" autofocus>
                        
                                @if(Session::has('errors'))   
                                  @if(Session::get('errors')->has('LastName'))   
                                       <div class="alert alert-danger"> {{ Session::get('errors')->first('LastName') }}</div>
                                @endif
                                @endif
                        </div>
						  
						  <div class="form-group">
							<label for="Username">Username</label>
							<input required type="text" class="form-control" id="Username" placeholder="Username" @error('Username') is-invalid @enderror name="Username" value="{{ old('Username') }}" required autocomplete="Username" autofocus>
                        @if(Session::has('errors'))
                         @if(Session::get('errors')->has('Username'))   
    
                                       <div class="alert alert-danger"> {{ Session::get('errors')->first('Username') }}</div>
                        @endif
                        @endif

                        </div>
                                <div class="form-group">
                                    <label for="Email" >E-mail Address</label>
                                    <input required type="email" class="form-control" id="Email" aria-describedby="emailHelp" placeholder="E-mail address"  @error('Email') is-invalid @enderror name="Email" value="{{ old('Email') }}" required autocomplete="Email" autofocus>
                                            @if(Session::has('errors'))
                                    @if(Session::get('errors')->has('Email'))   
                
                                                <div class="alert alert-danger"> {{ Session::get('errors')->first('Email') }}</div>
                                    @endif
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="Password" >Password</label>
                                    <input required type="password" class="form-control" id="Password" placeholder="Password" @error('Password') is-invalid @enderror name="Password" value="{{ old('Password') }}" required autocomplete="Password" autofocus>
                                            @if(Session::has('errors'))
                                    @if(Session::get('errors')->has('Password'))   
                
                                                <div class="alert alert-danger"> {{ Session::get('errors')->first('Password') }}</div>
                                    @endif
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="Password_confirmation" >Confirm Password</label>
                                    <input required type="password" class="form-control" id="Password_confirmation" placeholder="Confirm Password" name="Password_confirmation" autocomplete="Password" autofocus>
                                
                                </div>
								 <div class="form-group">
								<label for="Address">Address</label>
                                <input type="text" class="form-control" id="Address" placeholder="Address" @error('Address') is-invalid @enderror name="Address" value="{{ old('Address') }}" required autocomplete="Address" autofocus>
                                
                               @if(Session::has('errors'))
                                    @if(Session::get('errors')->has('Address'))   
                
                                                <div class="alert alert-danger"> {{ Session::get('errors')->first('Address') }}</div>
                                    @endif
                                    @endif
							  </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                    <label for="City">City</label>
                                    <input type="text" class="form-control" id="City" placeholder="City" @error('City') is-invalid @enderror name="City" value="{{ old('City') }}" required autocomplete="City" autofocus>
                                     @if(Session::has('errors'))
                                    @if(Session::get('errors')->has('City'))   
                
                                                <div class="alert alert-danger"> {{ Session::get('errors')->first('City') }}</div>
                                    @endif
                                    @endif
                                </div>
                                <div class="form-group"> <!-- Date input -->
                                        <label class="control-label" for="BirthDate">BirthDate</label>
                                        <input required type="date"class="form-control" id="BirthDate" name="BirthDate" placeholder="MM/DD/YYY" @error('BirthDate') is-invalid @enderror name="BirthDate" value="{{ old('BirthDate') }}" required autocomplete="BirthDate" autofocus>
                                         @if(Session::has('errors'))
                                    @if(Session::get('errors')->has('BirthDate'))   
                
                                                <div class="alert alert-danger"> {{ Session::get('errors')->first('BirthDate') }}</div>
                                    @endif
                                    @endif
                                    </div>
                                    
                                    <div class="form-group col-md-2">
                                    <label for="Gender" required>Gender</label>
                                    <select id="Gender" class="form-control" @error('Gender') is-invalid @enderror name="Gender" value="{{ old('Gender') }}" required autocomplete="Gender" autofocus>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                      @if(Session::has('errors'))
                                    @if(Session::get('errors')->has('Gender'))   
                
                                                <div class="alert alert-danger"> {{ Session::get('errors')->first('Gender') }}</div>
                                    @endif
                                    @endif
                                    </div>
                                </div>

                                <button type="submit" class="btn oneMusic-btn mt-30">Register</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Login Area End ##### -->

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
    
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
	<script>
    // $(document).ready(function(){
    //   var date_input=$('input[name="date"]'); //our date input has the name "date"
    //   var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    //   var options={
    //     format: 'mm/dd/yyyy',
    //     container: container,
    //     todayHighlight: true,
    //     autoclose: true,
    //   };
    //   date_input.datepicker(options);
    // })
</script>

</body>

</html>