<?php

namespace App\Http\Controllers\API;
use App\Event;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
//        $event=Event::all(0);
//        $event->data_begin=Carbon::parse($event->data_begin)->format('m/d/Y');
//        return $event;
        return response()->json([
            'events'=>Event::latest()->get()
        ],200);
    }

    public function add(Request $request)
    {
        $file = $request->fileimage;
        $original_name = $file->getClientOriginalName();
        $file->move(public_path().'/images/event/', $original_name);


        Event::create([
            'image'=>'/images/event/'.$original_name,
            'event_name'=>$request->event_name,
            'data_begin'=>$request->data_begin,
            'data_end'=>$request->data_begin,
            'active'=>$request->active,
            'link'=>$request->link
        ]);




    }

    public function show($id)
    {
        return Event::where('id', $id)->get();
    }

    public function store(Request $request, $id)
    {
        $event = Event::find($id);
        if ($request->fileimage){
            $file = $request->fileimage;
        $original_name = $file->getClientOriginalName();
        $file->move(public_path() . '/images/event/', $original_name);
        $event->image = '/images/event/'.$original_name;
         }
        $event->event_name=$request->event_name;
        $event->data_begin=$request->data_begin;
        $event->data_end=$request->data_end;
        $event->active=$request->active;
        $event->link=$request->link;
        $event->save();
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();
    }

}
