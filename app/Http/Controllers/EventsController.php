<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    //
    public function getEvents() {

        $events = Events::latest()->take(1)->get(['title','start', 'end', 'days']);

        return response()->json($events, 200);

    }

    public function addEvent(Request $request) {
        $request->validate([
            'title' => 'required',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'days' => 'required',
        ]);


        $event = Events::create([
            'title' => $request->title,
            'start' => date('Y-m-d', strtotime($request->start)),
            'end' => date('Y-m-d', strtotime($request->end)),
            'days' => $request->days
        ]);

        return response()->json($event, 200);
    }
}
