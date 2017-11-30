<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;
use App\Event;

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
        
        $events = Event::select(['id', 'year', 'created_at']);
        return DataTables::of($events)->addColumn('action', function ($event) {
                return '
                    <div align="center">
                            <a href="'.route('event.show', $event->id).'" class="btn btn-xs btn-info"><i class="fa fa-list"></i> Games</a>
                            <button onclick="editEvent('.$event->id.', \'' .$event->year. '\')" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</button>
                            <button onclick="deleteEvent('.$event->id.', \'' .$event->year. '\')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</button>
                    </div>
                ';
            })
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

        return view('admin.eventshow', compact('event'));
    }

    public function games(Event $event)
    {
        $events = $event->games;
        return DataTables::of($events)->addColumn('action', function ($event) {
                return '

                ';
            })
             ->rawColumns(['action'])
            ->make(true);
    }

}
