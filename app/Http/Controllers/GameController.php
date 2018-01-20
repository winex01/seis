<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Manager;
use App\Team;
use DataTables;
use Carbon\Carbon;

class GameController extends Controller
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

    public function assignManager(Request $request)
    {
        // dd($request->all());
        $game = Game::find($request->game_id);
        
        if ($request->manager_id == null) {
            $manager = $game->manager->first();
            $game->manager()->detach($manager->id);

            $fn = $manager->firstname;
            $ln = $manager->lastname;

            flash($fn.' '.$ln.' is removed as ' .$game->game. ' sport\'s manager.')->success();
        }else {
            $manager = Manager::find($request->manager_id);
            $hasManager = $game->manager()->exists();

            // if naa has manager update lng
            if($hasManager) {
                 $game->manager()->detach($game->manager->pluck('id')->first());
            }
            $game->manager()->save($manager);
            
            $fn = $manager->firstname;
            $ln = $manager->lastname;
        
            flash($fn.' '.$ln.' is assigned as ' .$game->game. ' sport\'s manager.')->success();
        }

        

        return  back();
    }

    public function matches(Game $game)
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
}
