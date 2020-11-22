<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\StatusRing;
use Illuminate\Http\Request;

class StatusRingController extends Controller
{
    public function index ()
    {
        return StatusRing::all();
    }
}
