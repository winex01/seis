<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Match;
use DataTables;
use Carbon\Carbon;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        // dd($request->all());

        $game_id = $request->game_id;

        $game = Game::findOrFail($game_id);

        // new match
        $match = new Match([
            'team1_id' => $request->team1_id,
            'team2_id' => $request->team2_id,
            'schedule' => $request->schedule,
        ]);


        $game->matches()->save($match);

        flash('Added new match & schedule!')->success();

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

    public function all(Game $game)
    {

        $matches = $game->matches;
        return DataTables::of($matches)->addColumn('action', function ($match) {
                return '
                    <div align="center">
                        <button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Select Winner</button>
                        <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Remove</button>
                    </div>
                ';
            })
            ->rawColumns(['action'])
            ->removeColumn('game_id', 'created_at', 'updated_at')
            ->editColumn('team1_id', function ($match) {
                return $match->team1->pluck('description')->first();
            })
            ->editColumn('team2_id', function ($match) {
                return $match->team2->pluck('description')->first();
            })
            ->editColumn('schedule', function ($match) {
                return Carbon::parse($match->schedule)->toDayDateTimeString();
            })
            ->make(true);

        return response()->json(['title' => $matches]);
    }
}
