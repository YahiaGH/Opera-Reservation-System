<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\event;
use App\hall;

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
            return $event->event_Date > Carbon::now();
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
        if (Gate::allows('isAdmin')) {
            $halls = hall::all();
            return view('pages.eventCreate')->with('hall', $halls); // ??? Dummpy Page.
        }
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
