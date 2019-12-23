<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\ticket;
use App\hall;

use Illuminate\Validation\Rule;

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
        return view('pages.event')->with('events', $events);
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

    public function getAvailableHalls(Request $request)
    {
        if (Gate::allows('isManager')) {
            $eventDate =  Carbon::parse($request->input('event_date')); //* got from create event form.
            $eventDuration = Carbon::createFromTimeString($request->input('event_duration'), 'Europe/London');
            $eventDateEnd = $eventDate->copy();

            $eventDateEnd->addHours($eventDuration->hour);
            $eventDateEnd->addMinutes($eventDuration->minute);
            $eventDateEnd->addSeconds($eventDuration->second);


            $halls = (event::all($columns = ['event_Date', 'event_duration', 'hall_id'])->filter(function ($event) use ($eventDate, $eventDateEnd) {

                $endDate = Carbon::parse($event->event_Date);
                $startDate = $endDate->copy();
                $duration  =  Carbon::createFromTimeString($event->event_duration, 'Europe/London');
                $endDate->addHours($duration->hour);
                $endDate->addMinutes($duration->minute);
                $endDate->addSeconds($duration->second);


                if (
                    $startDate->between($eventDate, $eventDateEnd) or $endDate->between($eventDate, $eventDateEnd) or
                    $eventDate->between($startDate, $endDate)
                ) {
                    return $event;
                }
            }));
            $hall_ids = json_decode($halls->unique('hall_id'), true);
            $hall_id_array = array_column($hall_ids, 'hall_id');
            $allHalls = hall::all()->whereNotIn('id', $hall_id_array);

            ///! event/getAvailableHalls/?event_date=2021-02-22 16:00:00&event_duration=03:00:00
            if (!$request->event_date or !$request->event_duration) {
                $html = '<option value=""></option>';
            } else {
                $html = '';
                foreach ($allHalls as $hall) {
                    $html .= '<option value=' . "'" . $hall->id . "'" . '>' . $hall->id . '</option>';
                }
            }
            return response()->json(['html' => $html]);
        }

        return abort(404);
    }


    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showVacantSeats($id)
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
        if (Gate::allows('isManager')) {

            $this->validate($request, [
                'CoverImage' => ['required', 'max:1999'],
                'EventName' => ['required', 'string', 'max:50'],
                'EventDescription' => ['required', 'string', 'max:100'],
                'EventDate' => ['required', 'Date', 'after:today'],
                'EventStartTime' => ['required'],
                'hall_id' => ['required', 'Integer'],
                'EventDuration' => ['required'], //** 'between:20,22'
            ]);


            $duplicate = event::where(
                'event_Date',
                $request->input('EventDate') . " " . $request->input('EventStartTime')
            )->where('hall_id', $request->input('hall_id'))->first();

            if (($duplicate) != null) {
                return redirect('/event')->with('success', 'Event Already Exist');
            }
            // Handle File Upload
            if ($request->hasFile('CoverImage')) {
                // Get filename with the extension

                $filenameWithExt = $request->file('CoverImage')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('CoverImage')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                // Storage::disk('public/cover_images')->put($fileNameToStore, $request->file('CoverImage'));
                // Upload Image
                $path = $request->file('CoverImage')->storeAs('public/cover_images', $fileNameToStore);
            }
            // Create event
            $event = new event();
            $event->name = $request->input('EventName');
            $event->descrition = $request->input('EventDescription');
            $event->image = 'cover_images/' . $fileNameToStore;
            $event->hall_id = $request->input('hall_id');
            $event->event_Date = $request->input('EventDate') . " " . $request->input('EventStartTime');
            $event->event_duration = $request->input('EventDuration');

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
        if (!isset($event)) {
            return redirect('/event')->with('success', 'No Event Found'); //** Dummy Erorr Content Page */
        }

        $reserved_tickets = 0;
        $total = 0;

        if (Gate::allows('isManager')) {

            $tickets = ticket::all($columns = ['Event_id', 'Seat_numbers'])->filter(function ($ticket) use ($id) {
                if ($ticket->Event_id == $id) {
                    return $ticket;
                }
            });
            $hall = hall::find($event->hall_id);
            $total = $hall->no_rows * $hall->no_Seats;
            foreach ($tickets as $ticket) {
                $reserved_tickets += count(explode(' ', $ticket->Seat_numbers));
            }
        }

        $data = [
            'reserved_tickets'  => $reserved_tickets,
            'event'   => $event,
            'total' => $total,
        ];
        return view('pages.eventDetails')->with($data); //* Dummy page.
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
                return redirect('/event')->with('success', 'No Event Found'); //** Dummy Erorr Content Page */
            }

            return view('pages.contact')->with('event', $event); //** Dummy Page */
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
        if (Gate::allows('isManager')) {
            $event = event::find($id);

            if (!isset($event)) {
                return redirect('/event')->with('success', 'No Event Found'); //** Dummy Erorr Content Page */
            }

            if ($event->cover_image != 'cover_images/no_image.jpg') {
                // File::delete(public_path('storage/' . $event->image));
                Storage::disk('public')->delete("storage/" . $event->image);
            }

            $event->delete();

            return redirect('/event')->with('success', 'Event Removed Successfully'); //** Dummy Erorr Content Page */
        }
        return abort(404);
    }
}
