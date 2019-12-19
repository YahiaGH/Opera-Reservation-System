<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\event;
use App\Http\Controllers\Storage;
use App\ticket;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // ** view all events to all users privliegs.
        //** after current date check needed. */
        $events = event::all()->filter(function ($event) {
            if ($event->event_Date > Carbon::now()) {
                return $event;
            }
        });
        return $events;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //** redirect to page of creation of an event if you are auth: as manager*/

        //* create Ajax Request whenever the event date changes to get the avalible halls
        if (Gate::allows('isManager')) {
            return view('pages.eventCreate'); // ??? Dummpy Page.
        }
        return abort(404);
    }

    /**
     * Returns Available Halls for AJAX Listen.
     *
     * @return \Illuminate\Http\Response
     */

    public function getAvailableHalls()
    {
        if (Gate::allows('isManager')) {
            $eventDate = Carbon::parse('2019-12-30 14:30:00')->addHours(2); // * got from create event form.
            $eventDuration = Carbon::parse('05:00:00');
            $eventDateEnd = $eventDate->copy();

            $eventDateEnd->addHours($eventDuration->hour);
            $eventDateEnd->addMinutes($eventDuration->minute);
            $eventDateEnd->addSeconds($eventDuration->second);

            $halls = (event::all($columns = ['event_Date', 'event_duration', 'hall_id'])->filter(function ($event) use ($eventDate, $eventDateEnd) {

                $endDate = Carbon::createFromDate($event->event_Date)->addHours(2);
                $startDate = $endDate->copy();
                $duration  = Carbon::createFromTimeString($event->event_duration, 'Europe/London');
                $endDate->addHours($duration->hour);
                $endDate->addMinutes($duration->minute);
                $endDate->addSeconds($duration->second);


                if (!$eventDate->between($startDate, $endDate) and !$eventDateEnd->between($startDate, $endDate)) {
                    return $event;
                }
            }));
            return response()->json($halls->unique('hall_id'));
        }

        return abort(404);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showVacantSeats()
    {
        $id = 2;
        $tickets = ticket::all($columns = ['Seat_numbers'])->filter(function ($ticket) use ($id) {
            if($ticket->Event_id != "2"){
                return $ticket;
            }
        });

        return $tickets;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::allows('isManager')) {

            $this->validate($request, [
                'cover_image' => ['required', 'image', 'max:1999'],
                'name' => ['required', 'string', 'max:50'],
                'descrition' => ['required', 'string', 'max:100'],
                'event_Date' => ['required', 'Date', 'after:today', 'unique:event,event_Date,NULL,id,hall_id'],
                'hall_id' => ['required', 'Integer', 'unique:event,hall_id,NULL,id,event_Date'],
                'event_duration' => ['required', 'Timezone'],
            ]);

            // Handle File Upload
            if ($request->hasFile('cover_image')) {
                // Get filename with the extension
                $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('cover_image')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                // Upload Image
                $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
            }
            // Create event
            $event = new event();
            $event->name = $request->input('name');
            $event->descrition = $request->input('descrition');
            $event->image = $fileNameToStore;
            $event->hall_id = $request->input('hall_id');
            $event->event_Date = $request->input('event_Date');
            $event->event_duration = $request->input('event_duration');

            $event->save();
            return redirect('/event')->with('success', 'Event Created Successfully');
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
        $event = event::find($id);
        return view('pages.showEvent')->with('event', $event); //* Dummy page.
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::allows('isManager')) {

            $event = event::find($id);

            if (!isset($event)) {
                return redirect('/events')->with('error', 'No Event Found'); //** Dummy Erorr Content Page */
            }

            return view('pages.editEvent')->with('event', $event); //** Dummy Page */
        }

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::allows('isManager')) {
            $event = event::find($id);

            if (!isset($event)) {
                return redirect('/event')->with('error', 'No Event Found'); //** Dummy Erorr Content Page */
            }

            if ($event->cover_image != 'noimage.jpg') {
                Storage::delete('public/cover_images/' . $event->cover_image);
            }

            $event->delete();

            return redirect('/events')->with('success', 'Event Removed'); //** Dummy Erorr Content Page */
        }
        return abort(404);
    }
}
