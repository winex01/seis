<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Event;
use DataTables;

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
            'start' => 'required',
            'end' => 'required',
        ]);

        //validation success
        $event = Event::create([
            'start' => $request->start,
            'end' => $request->end
        ]);

        $start = new Carbon($event->start);
        $end   = new Carbon($event->end);

        flash($start->format('F d, Y').' to '.$end->format('F d, Y').' <br/>Event created successfully!')->success();
        return back();

    }

}
