<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Response;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'categories'=>Category::latest()->get()
        ],200);


    }

//    public function create()
//    {
//        $category = new Category();
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->fileimage;
        $original_name = $file->getClientOriginalName();
        $file->move(public_path().'/images/category/', $original_name);

        Category::create([
            'photo'=>'/images/category/'.$original_name,
            'category'=>$request->category,
            ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       return Category::where('id', $id)->get();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updatecategory(Request $request, $id)
    {
        $category = Category::find($id);
        if ($request->fileimage){
            $file = $request->fileimage;
            $original_name = $file->getClientOriginalName();
            $file->move(public_path() . '/images/category/', $original_name);
            $category->photo = '/images/category/'.$original_name;
        }
        $category->category=$request->category;
        $category->save();
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
    }

}
