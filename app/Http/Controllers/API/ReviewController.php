<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Review;
use App\Tovar;
use Illuminate\Http\Request;
//отзывы
class ReviewController extends Controller
{

    public function showreview($id)
    {

        return Review::where('id_tovars', $id)->orderByDesc('created_at')->get();
    }

    public function storereview(Request $request)
    {
        $review = new Review();
        $review->id_tovars = $request->id_tovars;
        $review->review = $request->review;
        $review->reviewgood = $request->reviewgood;
        $review->reviewbad = $request->reviewbad;
        $review->user = $request->user;
        $review->rating = $request->rating;
        $review->data=date('d.m.Y');
        $review->save();
    }
}
