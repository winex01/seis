<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.user');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'username' => 'required|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => ucwords($request->name),
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'user_type_id' => 2 //2 means not manager
        ]);

        flash(ucwords($request->name).' is added to user successfully!')->success();
        return back();

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
    public function update(User $user, Request $request)
    {

        $user->name = ucwords($request->name);

        $user->save();

        return response()->json(['title' => 'User Name']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $deleted = $user->username;

        User::destroy($user->id);

        return response()->json(['title' => $deleted]);
    }

    public function all()
    {
        
        $users = User::select(['id', 'name', 'username', 'created_at'])->where('user_type_id', 2);
        return DataTables::of($users)->addColumn('action', function ($user) {
                return '
                    <div align="center">
                            <button onclick="editUser('.htmlentities($user).')" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</button>
                            <button onclick="deleteUser('.htmlentities($user).')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</button>
                    </div>
                ';
            })
             ->rawColumns(['action'])
            ->make(true);
    }
}
