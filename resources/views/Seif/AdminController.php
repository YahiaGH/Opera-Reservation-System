<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\ticket;
use App\hall;

use Illuminate\Validation\Rule;

class AdminController extends Controller
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
        if (Gate::allows('isAdmin')) {
            $users = User::all()->filter(function ($user) {
                if ($user->privilage == 'pending') {
                    return $user;
                }
            });
            return view('pages.adminPending')->with('users', $users); // ??? Dummpy Page.
        }
        return abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {

        if (Gate::allows('isAdmin')) {
            $users = User::all()->filter(function ($user) {
                if ($user->privilage != 'pending') {
                    return $user;
                }
            });
            return view('pages.adminAccounts')->with('users', $users); // ??? Dummpy Page.
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
        //
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
        //
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
        // //return view('Admin.show')->with('user',$user);
        // return $user;
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
        // $user = User::find($id);
        // return $user;
        //return view('Admin.edit')->with('user',$user);
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
        if (Gate::allows('isAdmin')) {
            $this->validate($request, [
                'Privilage' => ['required']
            ]);
            $user = User::find($id);
            if (isset($user)) {
                $user->privilage = $request->input('Privilage');
                $user->save();
                return redirect('/Admin')->with('success', 'User Edited Successfully');
            }
            return redirect('/Admin')->with('success', 'User Not Found');
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
    public function manage(Request $request, $id)
    {
        if (Gate::allows('isAdmin')) {
            $this->validate($request, [
                'Privilage' => ['required']
            ]);
            $user = User::find($id);
            if (isset($user)) {
                if ($request->input('action') == 'confirm') {
                    $user->privilage = $request->input('Privilage');
                    $user->save();
                    return redirect('/Admin/showAll')->with('success', 'User Edited Successfully');
                } else {
                    $user->delete();
                    return redirect('/Admin/showAll')->with('success', 'User Removed Successfully');
                }
            }
            return redirect('/Admin/showAll')->with('success', 'User Not Found');
        }
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
        // $user = User::find($id);
        // $user->delete();
        // return redirect('/Admin.index')->with('success', 'User Removed Successfully');
        return abort(404);
    }
}
