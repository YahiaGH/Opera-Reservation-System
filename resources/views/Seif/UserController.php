<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        // $user = User::find($id);
        // return view('user.show')->with('user', $user);
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
        $user = User::find($id);
        if (isset($user)) {
            return view('pages.editUser')->with('user', $user);
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
        $this->validate($request, [
            'Password' => ['required', 'string', 'min:8', 'confirmed'],
            'FirstName' => ['required', 'string', 'regex:/^[a-zA-Z]+$/', 'max:50'],
            'LastName' => ['required', 'string', 'regex:/^[a-zA-Z]+$/', 'max:50'],
            'Gender' => ['required', 'string'],
            'City' => ['required', 'string', 'max:100'],
            'Address' => ['string', 'max:100'],
            'BirthDate' => ['required', 'date', 'before: -13 years'],
        ]);

        $user = User::find($id);
        if (isset($user)) {

            $user->password = Hash::make($request->input('Password'));
            $user->fname = $request->input('FirstName');
            $user->lname = $request->input('LastName');
            $user->gender = $request->input('Gender')[0];
            $user->city = $request->input('City');
            $user->address = $request->input('Address');
            $user->Bdate = $request->input('BirthDate');

            $user->save(); //!!!
            return redirect('/home')->with('edited', 'Your Settings Was Edited Successfully');
        } else {
            return abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return abort(404);
    }
}
