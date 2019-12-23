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
<link rel="icon" href="{{asset('img/core-img/favicon.ico')}}">
    <link rel="stylesheet" href="{{asset('style.css')}}">
	
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

    <!-- ##### Breadcumb Area Start ##### -->
    <section class="breadcumb-area bg-img bg-overlay" style="background-image: url({{asset('img/bg-img/breadcumb3.jpg')}});">
        <div class="bradcumbContent">
            <h2>Account Settings</h2>
        </div>
    </section>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### Contact Area Start ##### -->
    <section class="contact-area section-padding-100-0">
        <div class="container">
            <div class="row">

                <div class="col-12 col-lg-3">
                    <div class="contact-content mb-100">
                        <!-- Title -->
                        <div class="contact-title mb-50">
                            <h5>Account Info</h5>
                        </div>

                        <!-- Single Contact Info -->
                        <div class="single-contact-info d-flex align-items-center">
                            <div class="icon mr-30">
                                <span class="icon-users"></span>
                            </div>
                        <p>Username: {{$user->username}}</p>
                        </div>
                        <!-- Single Contact Info -->
                        <div class="single-contact-info d-flex align-items-center">
                            <div class="icon mr-30">
                                <span class="icon-mail"></span>
                            </div>
                            <p>E-mail: {{$user->email}}</p>
                        </div>

                        <div class="single-contact-info d-flex align-items-center">
                            <div class="icon mr-30">
                                <span class="icon-padlock-1"></span>
                            </div>
                            <p>Status: {{$user->privilage}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
		
    </section>
    <!-- ##### Contact Area End ##### -->
	<section class="login-area section-padding-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="login-content">
                        <h3>Edit Settings</h3>
                        <!-- Login Form -->
                        <div class="login-form">
                            <form action="{{ route("user.update", $user->id) }}" method="post">
                                @csrf
                                {{ method_field('PUT') }}
							<div class="form-group">
							<label for="FirstName">First Name</label>
                            <input value="{{$user->fname}}" required type="text" class="form-control" id="FirstName" placeholder="First Name"  @error('FirstName') is-invalid @enderror name="FirstName" value="{{ old('FirstName') }}" required autocomplete="FirstName" autofocus>
                                
                                @if(Session::has('errors'))  
                                @if(Session::get('errors')->has('FirstName'))  
                                       <div class="alert alert-danger"> {{ Session::get('errors')->first('FirstName') }}</div>
                                @endif
                                @endif

                        </div>
						  <div class="form-group">
							<label for="LastName">Last Name</label>
							<input value="{{$user->lname}}" required type="text" class="form-control" id="LastName" placeholder="Last Name" @error('LastName') is-invalid @enderror name="LastName" value="{{ old('LastName') }}" required autocomplete="LastName" autofocus>
                        
                                @if(Session::has('errors'))   
                                  @if(Session::get('errors')->has('LastName'))   
                                       <div class="alert alert-danger"> {{ Session::get('errors')->first('LastName') }}</div>
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
                                <input value="{{$user->address}}" type="text" class="form-control" id="Address" placeholder="Address" @error('Address') is-invalid @enderror name="Address" value="{{ old('Address') }}" required autocomplete="Address" autofocus>
                                
                               @if(Session::has('errors'))
                                    @if(Session::get('errors')->has('Address'))   
                
                                                <div class="alert alert-danger"> {{ Session::get('errors')->first('Address') }}</div>
                                    @endif
                                    @endif
							  </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                    <label for="City">City</label>
                                    <input value="{{$user->city}}" type="text" class="form-control" id="City" placeholder="City" @error('City') is-invalid @enderror name="City" value="{{ old('City') }}" required autocomplete="City" autofocus>
                                     @if(Session::has('errors'))
                                    @if(Session::get('errors')->has('City'))   
                                                <div class="alert alert-danger"> {{ Session::get('errors')->first('City') }}</div>
                                    @endif
                                    @endif
                                </div>
                                <div class="form-group"> <!-- Date input -->
                                        <label class="control-label" for="BirthDate">BirthDate</label>
                                        <input value="{{$user->Bdate}}" required type="date"class="form-control" id="BirthDate" name="BirthDate" placeholder="MM/DD/YYY" @error('BirthDate') is-invalid @enderror name="BirthDate" value="{{ old('BirthDate') }}" required autocomplete="BirthDate" autofocus>
                                         @if(Session::has('errors'))
                                    @if(Session::get('errors')->has('BirthDate'))   
                
                                                <div class="alert alert-danger"> {{ Session::get('errors')->first('BirthDate') }}</div>
                                    @endif
                                    @endif
                                    </div>
                                    
                                    <div class="form-group col-md-2">
                                    <label for="Gender" required>Gender</label>
                                    
                                    <select value ="{{$user->Gender}}" id="Gender" class="form-control" @error('Gender') is-invalid @enderror name="Gender" value="{{ old('Gender') }}" required autocomplete="Gender" autofocus>
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

                                <button type="submit" class="btn oneMusic-btn mt-30">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
	
    <!-- ##### Contact Area Start ##### -->
    

    <!-- ##### Footer Area Start ##### -->
     <footer class="footer-area">
        <div class="container">
            <div class="row d-flex flex-wrap align-items-center">
                <div class="col-12 col-md-6">
                     <b>Opera</b>
                    <p class="copywrite-text"><a href="#"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved by Opera.</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                </div>
            </div>
        </div>
    </footer>
    <!-- ##### Footer Area Start ##### -->

   
    <script src="{{asset('js/jquery/jquery-2.2.4.min.js')}}"></script>
    <!-- Popper js -->
    <script src="{{asset('js/bootstrap/popper.min.js')}}"></script>
    <!-- Bootstrap js -->
    <script src="{{asset('js/bootstrap/bootstrap.min.js')}}"></script>
    <!-- All Plugins js -->
    <script src="{{asset('js/plugins/plugins.js')}}"></script>
    <!-- Active js -->
    <script src="{{asset('js/active.js')}}"></script>

</body>
</html>