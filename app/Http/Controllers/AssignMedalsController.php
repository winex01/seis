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

    	$game = Game::findOrFail($request->game_id);

		$game->gold_team_id = $request->gold_team_id;
		$game->silver_team_id = $request->silver_team_id;
		$game->bronze_team_id = $request->bronze_team_id;

		
		
		$game->save();

    	flash('Overall winner assigned successfully!')->success();

    	return back();

    }
}
