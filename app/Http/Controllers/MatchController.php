<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Match;
use App\Team;
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
        $request->validate([
            'schedule' => 'required',
        ]);

        if ($request->team1_id == $request->team2_id) {
            flash('Cannot add schedule with same team!')->error();
            return back();
        }

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
    public function destroy(Match $match)
    {
        //
        //
        Match::destroy($match->id);

        return response()->json(['title' => 'Match']);
    }

    public function all(Game $game)
    {

        $matches = $game->matches;
        return DataTables::of($matches)->addColumn('action', function ($match) {
                $team1 = Team::findOrFail($match->team1_id);    
                $team2 = Team::findOrFail($match->team2_id);    
                return '
                    <div align="center">
                        <button onclick="setResult('.htmlentities($team1).', '.htmlentities($team2).', '.htmlentities($match).')" class="btn btn-xs btn-success"><i class="fa fa-check"></i> Set Result</button>
                        <button onclick="removeMatch('.htmlentities($match).')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Remove</button>
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
            ->editColumn('winner_team_id', function ($match) {
                return $match->winner->pluck('description')->first();
            })
            ->editColumn('schedule', function ($match) {
                return Carbon::parse($match->schedule)->toDayDateTimeString();
            })
            ->make(true);

        return response()->json(['title' => $matches]);
    }

    public function setWinner(Request $request)
    {
        
        $match = Match::findOrFail($request->match_id);
        $match->winner_team_id = $request->team_winner_id;
        $match->save();

        return response()->json(['title' => 'Result']);
    }
}
