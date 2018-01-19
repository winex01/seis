<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Manager;
use Carbon\Carbon;
use App\GameType;
use DataTables;
use App\Event;
use App\Game;

class EventController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('admin.event');
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required',
        ]);

        //validation success
        $event = Event::create([
            'year' => $request->year
        ]);

        flash('Event created successfully!')->success();
        return back();

    }

    public function all()
    {
        
        $events = Event::select(['id', 'year', 'created_at', 'is_open']);
        return DataTables::of($events)->addColumn('action', function ($event) {
            
            $temp = '<button onclick="eventStatus('.htmlentities($event).', 1)" class="btn btn-xs btn-success"><i class="fa fa-check"></i> Open</button>';
            if ($event->is_open) {
                $temp = '<button onclick="eventStatus('.htmlentities($event).', 0)" class="btn btn-xs btn-danger"><i class="fa fa-remove"></i> Close</button>';
            }
                return '
                    <div align="center">
                            '.$temp.'
                            <a href="'.route('event.show', $event->id).'" class="btn btn-xs btn-info"><i class="fa fa-television"></i> Games</a>
                            <button onclick="editEvent('.$event->id.', \'' .$event->year. '\')" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</button>
                            <button onclick="deleteEvent('.$event->id.', \'' .$event->year. '\')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</button>
                    </div>
                ';
            })
            ->editColumn('is_open', '{{ ($is_open) ? \'Open\': \'\' }}')
            ->rawColumns(['action'])
            ->make(true);
    }

    public function destroy(Event $event)
    {
        $deleted = $event->year;

        Event::destroy($event->id);

        return response()->json(['title' => $deleted]);
    }

    public function update(Event $event, Request $request)
    {

        $event->year = $request->year;

        $event->save();

        return response()->json(['title' => 'Year']);
    }

    public function show(Event $event)
    {
        // select available sport's manager and pass 
        $sportManagers = Manager::where('active', 1)->get();

        return view('admin.eventshow', compact('event', 'sportManagers'));
    }

    public function games(Event $event)
    {
        $games = $event->games;
        return DataTables::of($games)->addColumn('action', function ($game) {
                $manager_id = $game->manager()->pluck('id')->first();
                return '
                    <div align="center">
                            <a href="#" class="btn btn-xs btn-info"><i class="fa fa-users"></i> Matches</a>
                             <button onclick="assignMngr('.htmlentities($game).', \''.$manager_id.'\')" class="btn btn-xs btn-success"><i class="fa fa-user"></i> Assign Mngr.</button>
                            <button onclick="deleteEventGame('.$game->id.', \'' .$game->game. '\')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Remove</button>
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
            ->rawColumns(['action', 'manager'])
            ->make(true);
    }

    public function gameTypes(Event $event)
    {
        $gametypes = GameType::select(['id', 'description', 'created_at'])->whereNotIn('id', $event->games->pluck('game_type_id'));
        return DataTables::of($gametypes)->addColumn('action', function ($gametype) {
                return '
                    <div align="center">
                            <button onclick="addEventGame('.$gametype->id.', \'' .$gametype->description. '\')" class="btn btn-xs btn-success"><i class="fa fa-plus-circle"></i> Add</button>
                    </div>
                ';
            })
             ->rawColumns(['action'])
            ->make(true);
    }

    public function storeGameType(Request $request, Event $event)
    {
       $games = $event->games()->create([
            'game' => $request->game,
            'game_type_id' => $request->game_type_id
        ]);
        return response()->json(['title' => $games ]);
    }

    public function destroyGame(Game $game)
    {
        $deleted = $game->game;

        Game::destroy($game->id);

        return response()->json(['title' => $deleted]);
    }

    public function eventstatus(Event $event, Request $request)
    {

        $status = null;

        if ($request->status == 1) {
            Event::where('id', '!=', $event->id)->update(['is_open' => false]);

            $event->is_open = true;
            $event->save();

            $status = 'Open';    
        }else {
            $event->is_open = false;
            $event->save();

            $status = 'Close';    
        }


        

        return response()->json(['title' => $event->year, 'status' => $status]);
    }

}
