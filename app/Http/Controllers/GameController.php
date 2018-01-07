<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Manager;

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

        return  back();
    }
}
