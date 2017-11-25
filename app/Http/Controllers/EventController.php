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
                        <div class="btn-group"> 
                            <a href="#" class="btn btn-xs btn-info"><i class="fa fa-search"></i> Select</a>
                            <button class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</button>
                            <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</button>
                        </div>
                    </div>
                ';
            })
            ->make(true);
    }

}
