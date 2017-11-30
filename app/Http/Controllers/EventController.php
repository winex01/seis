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
                            <button class="btn btn-xs btn-info"><i class="fa fa-list"></i> Games</button>
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

}
