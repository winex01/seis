<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Team;

class TeamController extends Controller
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
        return view('admin.team');
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
    public function update(Team $team, Request $request)
    {

        $team->description = ucwords($request->description);

        $team->save();

        return response()->json(['title' => 'Team Name']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        //
        $deleted = $team->description;

        Team::destroy($team->id);

        return response()->json(['title' => $deleted]);
    }

    public function all()
    {
        
        $teams = Team::select(['id', 'description', 'created_at']);
        return DataTables::of($teams)->addColumn('action', function ($team) {
                return '
                    <div align="center">
                            <button onclick="editTeam('.$team->id.', \'' .$team->description. '\')" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</button>
                            <button onclick="deleteTeam('.$team->id.', \'' .$team->description. '\')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</button>
                    </div>
                ';
            })
             ->rawColumns(['action'])
            ->make(true);
    }
}
