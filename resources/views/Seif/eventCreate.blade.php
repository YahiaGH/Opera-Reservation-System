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
            <h2>Create an Event</h2>
        </div>
    </section>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### Login Area Start ##### -->
 <section class="login-area section-padding-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="login-content">
                        <h3>Event</h3>
                        <!-- Login Form -->
                        <div class="login-form">
                            
                            <form action="{{ route('event.store') }}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="form-group">
							<label for="EventName">Event Name</label>
							<input required type="text" class="form-control" id="EventName" placeholder="Event Name" @error('EventName') is-invalid @enderror name="EventName" value="{{ old('EventName') }}" required autocomplete="EventName" autofocus>
                           
                                @if(Session::has('errors'))  
                                @if(Session::get('errors')->has('EventName'))  
                                       <div class="alert alert-danger"> {{ Session::get('errors')->first('EventName') }}</div>
                                @endif
                                @endif
                        </div>
						 <div class="form-group">
							<label for="EventDescription">Event Description</label>
							<textarea class="form-control" style = "height:150px;" id="EventDescription" rows="20"  @error('EventDescription') is-invalid @enderror name="EventDescription" value="{{ old('EventDescription') }}" required autocomplete="EventDescription" autofocus></textarea>
                                @if(Session::has('errors'))  
                                @if(Session::get('errors')->has('EventDescription'))  
                                       <div class="alert alert-danger"> {{ Session::get('errors')->first('EventDescription') }}</div>
                                @endif
                                @endif
                        </div>
						 <div class="form-row">    
                            <div class="form-group col-md-3"> <!-- Date input -->
                                        <label class="control-label" for="EventDate">Event Date</label>
                                        <input required type="date"class="form-control" id="EventDate" name="EventDate" placeholder="YYY/MM/DD" @error('EventDate') is-invalid @enderror name="EventDate" value="{{ old('EventDate') }}" required autocomplete="EventDate" autofocus>
                                         @if(Session::has('errors'))
                                    @if(Session::get('errors')->has('EventDate'))   
                                                <div class="alert alert-danger"> {{ Session::get('errors')->first('EventDate') }}</div>
                                    @endif
                                    @endif
                            </div>

                            <div class="form-group col-md-4"> <!-- Date input -->
                                        <label class="control-label" for="EventStartTime">Event Start Time (Hours)</label>
                                        <input required type="time"class="form-control" id="EventStartTime" name="EventStartTime" @error('EventStartTime') is-invalid @enderror name="EventStartTime" value="{{ old('EventStartTime') }}" required autocomplete="EventStartTime" autofocus>
                                         @if(Session::has('errors'))
                                    @if(Session::get('errors')->has('EventStartTime'))   
                                                <div class="alert alert-danger"> {{ Session::get('errors')->first('EventStartTime') }}</div>
                                    @endif
                                    @endif
                            </div>

                            <div class="form-group col-md-3"> <!-- Date input -->
                                        <label class="control-label" for="EventDuration">Event Duration (Hours)</label>
                                        <input required type="time"class="form-control" id="EventDuration" name="EventDuration" @error('EventDuration') is-invalid @enderror name="EventDuration" value="{{ old('EventDuration') }}" required autocomplete="EventDuration" autofocus>
                                         @if(Session::has('errors'))
                                    @if(Session::get('errors')->has('EventDuration'))   
                                                <div class="alert alert-danger"> {{ Session::get('errors')->first('EventDuration') }}</div>
                                    @endif
                                    @endif
                            </div>

                            <div class="form-group col-md-2">
                                <div class="hide">
                                    <label for="Hall">Hall Number</label>
                                    <select id="Hall" class="form-control" @error('hall_id') is-invalid @enderror name="hall_id" value="{{ old('hall_id') }}" required autocomplete="hall_id" autofocus>
                                        <option value=""></option>
                                    </select>
                                      @if(Session::has('errors'))
                                    @if(Session::get('errors')->has('hall_id'))   
                
                                                <div class="alert alert-danger"> {{ Session::get('errors')->first('hall_id') }}</div>
                                    @endif
                                    @endif
                                </div>
                                    </div>
                                </div>
                            </div>    
                        
                           
                            
                            <div class="form-group">
                                     <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile01"
                                        aria-describedby="inputGroupFileAddon01" @error('CoverImage') is-invalid @enderror name="CoverImage" value="{{ old('CoverImage') }}" required autocomplete="CoverImage" autofocus>
                                        <label class="custom-file-label" for="inputGroupFile01">Choose Event Cover Image</label>
                                    </div>
                                     @if(Session::has('errors'))
                                    @if(Session::get('errors')->has('CoverImage'))   
                
                                                <div class="alert alert-danger"> {{ Session::get('errors')->first('CoverImage') }}</div>
                                    @endif
                                    @endif
                                </div>
                                
                            
                                <button type="submit" class="btn oneMusic-btn mt-30 hide">Create</button>
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
                     <b>Opera</b>
                    <p class="copywrite-text"><a href="#"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved by Opera.</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                </div>
            </div>
        </div>
    </footer>
    <!-- ##### Footer Area Start ##### -->

    <!-- ##### All Javascript Script ##### --
    <!-- jQuery-2.2.4 js -->
    <script src="{{asset('js/jquery/jquery-2.2.4.min.js')}}"></script>
    <!-- Popper js -->
    <script src="{{asset('js/bootstrap/popper.min.js')}}"></script>
    <!-- Bootstrap js -->
    <script src="{{asset('js/bootstrap/bootstrap.min.js')}}"></script>
    <!-- All Plugins js -->
    <script src="{{asset('js/plugins/plugins.js')}}"></script>
    <!-- Active js -->
    <script src="{{asset('js/active.js')}}"></script>
		 <script>
                                        $(document).on('change', '.custom-file-input', function (event) {
    $(this).next('.custom-file-label').html(event.target.files[0].name);
})
                                    </script>


<script type="text/javascript">

        $(document).on('change','#EventDuration ,#EventStartTime ,#EventDate',function(){
            console.log("{{ route('event.getAvailableHalls') }}?event_date=" + $('#EventDate').val() + "%20" + $('#EventStartTime').val() + "&event_duration=" + $('#EventDuration').val());
              $('.hide').css('visibility', 'hidden');
              $.ajax({
                url: "{{ route('event.getAvailableHalls') }}?event_date=" + $('#EventDate').val() + "%20" + $('#EventStartTime').val() + "&event_duration=" + $('#EventDuration').val(),
                method: 'GET',
                success: function(data) {
                    $('#Hall').html(data.html);
                    $('.hide').css('visibility', 'visible');

                }
            });
        });
    </script>
</body>

</html>