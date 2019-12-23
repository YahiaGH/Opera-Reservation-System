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

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/1.4.1/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<style>
	.edittable {
  padding: 2rem 0rem;
}

h4 {
  margin: 2rem 0rem 1rem;
}

.table-image {
  td, th {
    vertical-align: middle;
  }
}
	</style>
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
            <h2>Pending Accounts</h2>
            @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
            @endif
        </div>
    </section>
    <!-- ##### Breadcumb Area End ##### -->
    <!-- ##### Contact Area End ##### -->
	<section class="login-area section-padding-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="login-content">
                        <h3>Accounts</h3>
                        <!-- Login Form -->
                        <div class="login-form">
                           <div class="container edittable">
  <div class="row">
    <div class="col-12">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">Username</th>
            <th scope="col">E-mail</th>
            <th scope="col">Current Status</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                      <tr>
                      <th scope="row">{{$user->username}}</th>
                        <td>{{$user->email}}</td>
                        <td>{{$user->privilage}}</td>
                        <td>
                    <form action="{{ route('Admin.update',$user->id) }}" method="post">
                    @csrf
                {{ method_field('PUT') }}
                        <div class="form-group">
                    <select class="form-control" id="sel1" @error('Privilage') is-invalid @enderror name="Privilage" value="{{ old('Privilage') }}" required autocomplete="Privilage" autofocus>
                        <option>customer</option>
                        <option>manager</option>
                        <option>admin</option>
                    </select>
                    </div> 
                    
                    <button type="submit" class="btn btn-success">Confirm</button>
                </form>
                        
                     </td>
                      </tr>
            @endforeach


                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
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