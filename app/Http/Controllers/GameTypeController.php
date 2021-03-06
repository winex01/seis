<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\GameType;
use App\Game;

class GameTypeController extends Controller
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
        return view('admin.gametype');
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
        $request->validate([
            'description' => 'required',
            'medal_points' => 'required',
        ]);

        //validation success
        $event = GameType::create([
            'description' => ucwords($request->description),
            'medal_points' => ucwords($request->medal_points)
        ]);

        flash('New game added successfully!')->success();
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
    public function update(GameType $gametype, Request $request)
    {

        $gametype->description = ucwords($request->description);
        $gametype->medal_points = $request->medal_points;
        $gametype->save();

        return response()->json(['title' => 'Game Type']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(GameType $gametype)
    {
        //
        $deleted = $gametype->description;

        Game::where('game_type_id', $gametype->id)->delete();
        GameType::destroy($gametype->id);

        return response()->json(['title' => $deleted]);
    }

    public function all()
    {
        
        $gametypes = GameType::select(['id', 'description', 'medal_points', 'created_at']);
        return DataTables::of($gametypes)->addColumn('action', function ($gametype) {
                return '
                    <div align="center">
                            <button onclick="editGametype('.htmlentities($gametype).')" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</button>
                            <button onclick="deleteGametype('.$gametype->id.', \'' .$gametype->description. '\')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</button>
                    </div>
                ';
            })
             ->rawColumns(['action'])
            ->make(true);
    }
}
