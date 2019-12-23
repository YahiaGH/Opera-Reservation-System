
<!DOCTYPE html>
<html>
<head>
<title>Opera Ticket Reservation</title>
<!-- //for-mobile-apps -->

<meta name="csrf-token" content="{{ csrf_token() }}">


<link href='{{asset('css/google_fonts.css')}}' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery.seat-charts.css')}}">
<link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css" media="all" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">

<script>
		window.addEventListener( "pageshow", function ( event ) {
		var historyTraversal = event.persisted || 
								( typeof window.performance != "undefined" && 
									window.performance.navigation.type === 2 );
		if ( historyTraversal ) {
			// Handle page restore.
			window.location.reload();
		}
		});
		var eventID = {{$eventID}};
	function initInputs(){
		var Query = $('#app .content .main .wrapper .booking-details #selected-seats');
		allChairs = Query.find('li');
		var chairs = "";
		for(var i = 0; i< allChairs.length; i++){
			var chair = $(allChairs[i]);
			chairs += chair.attr('id').split('-')[2] + " "; 
		}
		$("#hiddenChairs").val(chairs);
		console.log(chairs);
		return true;
	};
</script>

</head>
<body>
<div id='app'>
<div class="content">
	<h1>Opera Ticket Reservation</h1>
	<div class="main">
		<h2>Book Your Seat Now?</h2>
		<div class="wrapper">
			<div id="seat-map">
				<div class="front-indicator"><h3>Opera</h3></div>
			</div>
			<div class="booking-details">
						<div id="legend"></div>
						<h3> Selected Seats (<span id="counter">0</span>):</h3>
						<ul id="selected-seats" class="scrollbar scrollbar1"></ul>
						
						Total: <b>$<span id="total">0</span></b>
						{{-- <button onclick="initInputs();" class="checkout-button">CheckOut Seats</button> --}}

						<form action="{{ route('ticket.store') }}" method="post" onsubmit="return initInputs();">
							@csrf
							<br>
						   <div class="form-group">
   							 <label for="exampleFormControlInput1">Credit (Master Card) Number</label>
							<input class="form-control" type="text" title="Enter a Valid Credit Card Number" required pattern= "^(5[1-5][0-9]{14}|2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12}))$" placeholder="ex: 1234 5678 9123 4567">	
						</div>
							  
							<div class="form-group">
   							 <label for="exampleFormControlInput1">Credit Card PIN</label>
							<input class="form-control" type="text" title="Enter a Valid Credit Card PIN Number" pattern= "^[0-9]{3,4}$" placeholder="ex: 123 or 1234" required>	
						</div>

						<div class="form-group">
							<input class="form-control" value="{{$eventID}}" type="hidden" @error('eventID') is-invalid @enderror name="eventID" value="{{ old('eventID') }}" required autocomplete="eventID" autofocus>	
						</div>

						<div class="form-group">
							<input class="form-control" value="{{Auth::user()->id}}" type="hidden" @error('userID') is-invalid @enderror name="userID" value="{{ old('userID') }}" required autocomplete="userID" autofocus>	
						</div>

						<div class="form-group">
							<input id="hiddenChairs" class="form-control" type="hidden" @error('chairs') is-invalid @enderror name="chairs" value="{{ old('chairs') }}" required autocomplete="chairs" autofocus>	
							 @if(Session::has('errors'))
                                    @if(Session::get('errors')->has('chairs'))   
                
                                                <div class="alert alert-danger"> {{ Session::get('errors')->first('chairs') }}</div>
                                    @endif
                                    @endif
						</div>
						<button type="submit" class="checkout-button">CheckOut</button>

						</form>
						
			</div>
			<div class="clear"></div>
		</div>
		<script>
				var firstSeatLabel = 1;
			
				var test = []
				var rows={{$hall_rows}};
				var cols={{$hall_seats}};
				var i = 0 ;
				var j = 0 ;
				var dash = 40-cols;
				for( i = 0 ; i < rows; i++)
				{
					var s = '';
					for (j=0;j<40;j++)
					{	
						if (cols<40)
						{
							if(cols%2==0)
							{
								if(j<dash/2)
								{
									s+='_'
								}
								else if (j>dash/2 && j<dash/2+cols+1)
								{
									s+='f'
								}
								else {
									s+='_'
								}
							}else{
								if(j<dash/2)
								{
									s+='_'
								}
								else if (j>dash/2 && j<dash/2+cols)
								{
									s+='f'
								}
								else {
									s+='_'
								}
							}
							
						}
						else
						{
							s += 'f';
						}
						
					}
					test.push(s);
					
				}
						
				$(document).ready(function() {
					var $cart = $('#selected-seats'),
						$counter = $('#counter'),
						$total = $('#total'),
						sc = $('#seat-map').seatCharts({
						map: test,
						seats: {
							f: {
								price   : 100,
								classes : 'first-class', //your custom CSS class
								category: 'First Class'
							},			
						},
						naming : {
							top : false,
							getLabel : function (character, row, column) {
								return firstSeatLabel++;
							},
						},
						legend : {
							node : $('#legend'),
							items : [
								[ 'f', 'available',   'First Class' ],
								[ 'f', 'unavailable', 'Already Booked']
							]					
						},
						click: function () {
							if (this.status() == 'available') {
								//let's create a new <li> which we'll add to the cart items
								$('<li>'+this.data().category+' : Seat no '+this.settings.label+': <b>$'+this.data().price+'</b> <a href="#" class="cancel-cart-item">[cancel]</a></li>')
									.attr('id', 'cart-item-'+this.settings.id)
									.data('seatId', this.settings.id)
									.appendTo($cart);
								
								/*
								 * Lets update the counter and total
								 *
								 * .find function will not find the current seat, because it will change its stauts only after return
								 * 'selected'. This is why we have to add 1 to the length and the current seat price to the total.
								 */
								$counter.text(sc.find('selected').length+1);
								$total.text(recalculateTotal(sc)+this.data().price);
								
								return 'selected';
							} else if (this.status() == 'selected') {
								//update the counter
								$counter.text(sc.find('selected').length-1);
								//and total
								$total.text(recalculateTotal(sc)-this.data().price);
							
								//remove the item from our cart
								$('#cart-item-'+this.settings.id).remove();
							
								//seat has been vacated
								return 'available';
							} else if (this.status() == 'unavailable') {
								//seat has been already booked
								return 'unavailable';
							} else {
								return this.style();
							}
						}
					});

					//this will handle "[cancel]" link clicks
					$('#selected-seats').on('click', '.cancel-cart-item', function () {
						//let's just trigger Click event on the appropriate seat, so we don't have to repeat the logic here
						sc.get($(this).parents('li:first').data('seatId')).click();
					});

					//let's pretend some seats have already been booked
					@foreach($a1 as $seat)
					sc.get(['{{$seat}}']).status('unavailable');
					@endforeach
			});

			function recalculateTotal(sc) {
				var total = 0;
			
				//basically find every selected seat and sum its price
				sc.find('selected').each(function () {
					total += this.data().price;
				});
				
				return total;
			}
		</script>
	</div>
<p class="copy_rights">Copy Rights&copy; 2019 All rights reserved By Opera.</p>
</div>
</div>

<script src="{{asset('js/jquery-1.11.0.min.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/jquery.seat-charts.js')}}"></script>
<script src="{{asset('js/jquery.nicescroll.js')}}"></script>
<script src="{{asset('js/scripts.js')}}"></script>

</body>
</html>
