<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;

class AssignMedalsController extends Controller
{
    //
    public function __invoke(Request $request)
    {

    	$this->validate($request, [
    		'game_id' => 'required|not_in:-1',
    	]);


        // gold and silver
        if ($request->gold_team_id != '' && $request->silver_team_id != '') {
            if ($request->gold_team_id == $request->silver_team_id) {
                flash('Duplicate team medals!')->error();
                return back();
            }
        }

        // gold and bronze
        if ($request->gold_team_id != '' && $request->bronze_team_id != '') {
            if ($request->gold_team_id == $request->bronze_team_id) {
                flash('Duplicate team medals!')->error();
                return back();
            }
        }

        // silver and bronze
        if ($request->silver_team_id != '' && $request->bronze_team_id != '') {
            if ($request->silver_team_id == $request->bronze_team_id) {
                flash('Duplicate team medals!')->error();
                return back();
            }
        }


        $game = Game::findOrFail($request->game_id);

        $game->gold_team_id = $request->gold_team_id;
        $game->silver_team_id = $request->silver_team_id;
        $game->bronze_team_id = $request->bronze_team_id;

        
        
        $game->save();

    	flash('Overall winner assigned successfully!')->success();

    	return back();

    }
}
