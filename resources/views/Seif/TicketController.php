<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\event;
use App\Events\ReservedTickets;
use Illuminate\Support\Facades\Storage;
use App\ticket;
use App\Http\Controllers\array_flatten;
use App\hall;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isCustomer')) {
            $reservations = ticket::where('customer_id', Auth::user()->id)->get();
            $data = array();
            foreach ($reservations as $reservation) {
                $event = event::find($reservation->Event_id);
                array_push($data, array($reservation->Seat_numbers, $event->name, $event->event_Date, $event->event_duration, $event->hall_id, $reservation->id));
            }
            return view('pages.ticketsView')->with('data', $data);
        }
        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::allows('isCustomer')) {
            $this->validate($request, [
                'chairs' => ['required', 'string'],
            ]);
            // return  array_column($array, null);
            $arr = json_decode(ticket::where('Event_id', $request->input('eventID'))->get('Seat_numbers'), true);
            $array = array_column($arr, 'Seat_numbers');
            if (count($array)  != 0) {
                $a1 = explode(' ', $array[0]);
                for ($i = 0; $i < count($array) - 1; $i++) {
                    $a1 = array_merge($a1, explode(' ', $array[$i + 1]));
                }
            }

            $common_seats = array_intersect(explode(' ', $request->input('chairs')), $a1);
            if (count($common_seats) != 0) {
                return redirect('/ticket/' . $request->input('eventID'))->with('success', "Sorry, Seats You Have Chosen has Been Reserved, Choose Again.");
            } else {
                try {
                    $ticket = new ticket();
                    $ticket->customer_id = $request->input('userID');
                    $ticket->Event_id = $request->input('eventID');
                    $ticket->Seat_numbers = $request->input('chairs');

                    $ticket->save();
                    broadcast(new ReservedTickets($request->input('eventID') . " " . $request->input('chairs')))->toOthers();
                    return redirect('/event/' . $request->input('eventID'))->with('success', "Tickets Reserved Successfully, Check Them in 'Reserved Tickets' Tab");
                } catch (\Exception $e) {
                    return redirect('/ticket/' . $request->input('eventID'))->with('success', "Sorry, Seats You Have Chosen has Been Reserved, Choose Again.");
                }
            }
        }
        return abort(404);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::allows('isCustomer')) {
            $event = event::find($id);
            if (isset($event)) {
                $hall = hall::find($event->hall_id);
                $arr = json_decode(ticket::where('Event_id', $id)->get('Seat_numbers'), true);
                $array = array_column($arr, 'Seat_numbers');
                $a1 = array();
                if (count($array)  != 0) {
                    $a1 = explode(' ', $array[0]);
                    for ($i = 0; $i < count($array) - 1; $i++) {
                        $a1 = array_merge($a1, explode(' ', $array[$i + 1]));
                    }
                }

                $hall_rows =  $hall->no_rows;
                $hall_seats = $hall->no_Seats;
                $data = [
                    'hall_rows'  => $hall_rows,
                    'hall_seats'   => $hall_seats,
                    'eventID' => $id, //** TODO: Set Already Reserved Seats*/
                ];
                return view('pages.seats')->with('a1', $a1)->with($data);
            } else {
                return abort(404);
            }
        }
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::allows('isCustomer')) {
            $ticket = ticket::find($id);
            if (isset($ticket)) {
                $event = event::find($ticket->Event_id);
                $TimeNow = Carbon::now();
                $eventDate = Carbon::parse($event->event_Date);

                if ($TimeNow->addDays(3) < $eventDate) {
                    $ticket->delete();
                    return redirect('/ticket')->with('success', 'The Reservation Was Cancelled Successfully');
                } else {
                    return redirect('/ticket')->with('success', "Sorry, We Can't Cancel The Reservation, it's too late.");
                }
            } else {
                return abort(404);
            }
        }
        return abort(404);
    }
}
