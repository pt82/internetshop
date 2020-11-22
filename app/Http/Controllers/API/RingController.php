<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Ring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//звонки
class RingController extends Controller
{
    public function index ()
    {

        return   DB::table('rings')
            ->Join('status_rings', 'rings.id_status_rings','=','status_rings.id')
            ->select('rings.*', 'status_rings.status')
            ->orderBy('created_at')
            ->get();
    }

    public function create (Request $request)
    {
            $this->validate($request, [
            'phone' => 'required|max:255',
            ]);
        $ring = new Ring();
        $ring->id_status_rings=1;
        $ring->name=$request->name;
        $ring->phone=$request->phone;
        $ring->save();
        if(!$ring->save())
        {
            return response()->json([

            ],422);
        }

        if($ring->save()) {
            return response()->json([
                'success' => true,
            ]);
        }

    }
    public function show ($id)
    {
        return Ring::where('id', $id)->get();
    }

    public function store(Request $request)
    {
        $ring = Ring::find($request->id);

        $ring->id_status_rings=$request->id_status_rings;
        $ring->name=$request->name;
        $ring->phone=$request->phone;
        $ring->coment=$request->coment;

        $ring->save();
    }

}



