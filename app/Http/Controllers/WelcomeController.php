<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use DataTables;
use App\GameType;
use App\Game;
use App\Team;
use Carbon\Carbon;

class WelcomeController extends Controller
{
    //

    public function all()
    {


    	return view('welcome');
    }


    public function sports(Event $event)
    {
    	return view('sports', compact('event'));
    }

    public function yearSports(Event $event) 
    {
    	$games = $event->games;
        return DataTables::of($games)->addColumn('action', function ($game) {
                $manager_id = $game->manager()->pluck('id')->first();
                return '
                    <div align="center">
                        <button onclick="sportsMatches('.htmlentities($game).')" class="btn btn-xs btn-info"><i class="fa fa-eye" aria-hidden="true"></i> Matches</button>
                    </div>
                ';
            })
            ->addColumn('medal_points', function ($game){
                $q = GameType::findOrFail($game->game_type_id);
                return $q->medal_points;
            })
            ->addColumn('manager', function ($game){
                $fn = $game->manager->pluck('firstname')->first();
                $ln = $game->manager->pluck('lastname')->first();
                return $fn.' '.$ln;
            })
            ->removeColumn('created_at')
            ->rawColumns(['action', 'manager'])
            ->make(true);
    }

    public function scheduleAndMatches(Game $game) {

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

    public function scoreBoard(Event $event)
    {
        $games = $event->games;

        $team_ids = [];
        foreach ($games as $game) {
            $team1_ids = $game->matches->pluck('team1_id');
            $team2_ids = $game->matches->pluck('team2_id');

            foreach ($team1_ids as $team1) {
                if (!in_array($team1, $team_ids)) {
                    $team_ids[] = $team1;
                }
            }

            foreach ($team2_ids as $team2) {
                if (!in_array($team2, $team_ids)) {
                    $team_ids[] = $team2;
                }
            }

        }//end foreach

        $teams = Team::select('id', 'description')->whereIn('id', $team_ids)->get();

        return DataTables::of($teams)
            ->addColumn('gold', function ($team) {
                $games = Game::select('game_type_id')->where('gold_team_id', $team->id)->get();
                $total = 0;
                // loop game wins
                foreach ($games as $game) {
                    $gameType = GameType::findOrFail($game->game_type_id);
                    $total += $gameType->medal_points;
                }

                return $total;
            })
            ->addColumn('silver', function ($team) {
                $games = Game::select('game_type_id')->where('silver_team_id', $team->id)->get();
                $total = 0;
                // loop game wins
                foreach ($games as $game) {
                    $gameType = GameType::findOrFail($game->game_type_id);
                    $total += $gameType->medal_points;
                }

                return $total;
            })
            ->addColumn('bronze', function ($team) {
                $games = Game::select('game_type_id')->where('bronze_team_id', $team->id)->get();
                $total = 0;
                // loop game wins
                foreach ($games as $game) {
                    $gameType = GameType::findOrFail($game->game_type_id);
                    $total += $gameType->medal_points;
                }

                return $total;
            })
            ->addColumn('total', function ($team) {
                
                $total = 0;
                $games = Game::select('game_type_id')->where('gold_team_id', $team->id)->get();
                // loop game wins
                foreach ($games as $game) {
                    $gameType = GameType::findOrFail($game->game_type_id);
                    $total += $gameType->medal_points;
                }

                $games = Game::select('game_type_id')->where('silver_team_id', $team->id)->get();
                // loop game wins
                foreach ($games as $game) {
                    $gameType = GameType::findOrFail($game->game_type_id);
                    $total += $gameType->medal_points;
                }

                $games = Game::select('game_type_id')->where('bronze_team_id', $team->id)->get();
                // loop game wins
                foreach ($games as $game) {
                    $gameType = GameType::findOrFail($game->game_type_id);
                    $total += $gameType->medal_points;
                }


                return $total;

            })
            ->make(true);

        //test
        // return response()->json(['title' => $teams]);
    
    }






}
