<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Manager;
use DataTables;


class ManagerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        //
        return view('admin.manager');
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
            'firstname' => 'required|min:2|max:50',
            'middlename' => 'required|min:1|max:50',
            'lastname' => 'required|min:2|max:50',
            'username' => 'required|unique:managers',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $mngr = Manager::create([
            'firstname' => ucwords($request->firstname),
            'middlename' => ucwords($request->middlename),
            'lastname' => ucwords($request->lastname),
            'suffix' => ucfirst($request->suffix),
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        flash(ucwords($mngr->firstname.' '.ucwords($mngr->lastname)).' is added to user successfully!')->success();
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
    public function update(Manager $manager, Request $request)
    {

        $manager->firstname = ucwords($request->firstname);
        $manager->middlename = ucwords($request->middlename);
        $manager->lastname = ucwords($request->lastname);
        $manager->suffix = ucfirst($request->suffix);
        $manager->username = $request->username;

        $manager->save();

        return response()->json(['title' => 'Sports Manager']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manager $manager)
    {
        //
        $manager->active = false;
        $manager->save();

        return response()->json(['title' => $manager->firstname.' '.$manager->lastname]);
    }

    public function all()
    {
        
        $mngers = Manager::select(['id', 'firstname', 'middlename', 'lastname', 'suffix', 'username', 'created_at'])->where('active', true);
        return DataTables::of($mngers)->addColumn('action', function ($mngr) {
                return '
                    <div align="center">
                            <button onclick="editMngr('.htmlentities($mngr).')" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</button>
                            <button onclick="deleteMngr('.htmlentities($mngr).')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</button>
                    </div>
                ';
            })
             ->rawColumns(['action'])
            ->make(true);
    }
}
