<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\event;
use Illuminate\Support\Facades\Storage;
use App\ticket;
use App\hall;

use Illuminate\Validation\Rule;

class HullController extends Controller
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
        //** view all halls */ table
        if (Gate::allows('isManager')) {
            $halls = hall::all();
            return view('pages.hallView')->with('halls', $halls); //** TODO: Do this Page */
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
        if (Gate::allows('isManager')) {
            return view('pages.hallCreate'); // ??? Dummpy Page.
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
                'Rows' => ['required', 'Integer'],
                'Columns' => ['required', 'Integer'],
            ]);


            // Create hall
            $hall = new hall();
            $hall->no_rows = $request->input('Rows');
            $hall->no_Seats = $request->input('Columns');

            $hall->save();
            return redirect('/hall')->with('success', 'Hall Was Successfully Added');
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
        //
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
        //
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
        //
        return abort(404);
    }
}
