<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Statusorder;
use Illuminate\Http\Request;

class StatusorderController extends Controller
{
    public function index()
    {

        return response()->json([
            'status'=>Statusorder::latest()->get()
        ],200);
    }

    public function show($id)
    {
        return Statusorder::where('id', $id)->get();
    }
}
