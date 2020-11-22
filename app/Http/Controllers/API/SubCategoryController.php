<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\SubCategory;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Reference;
use function GuzzleHttp\Promise\all;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        return SubCategory::all();
        return SubCategory::OrderBy('updated_at', 'desc')->get();
//        return response()->json([
//            'subcategory'=>SubCategory::latest()->get()
//        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function addsubcat(Request $request)
    {

        $file = $request->fileimage;
        $original_name = $file->getClientOriginalName();
        $file->move(public_path().'/images/subcategory/', $original_name);


        SubCategory::create([
            'photo'=>'/images/subcategory/'.$original_name,
            'id_categories'=>$request->id_categories,
            'subcategori'=>$request->subcategory
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
        return Subcategory::where('id_categories', $id)->get();
    }



    public function showsubcatone($id)
    {
        return Subcategory::where('id', $id)->get();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function updatesubcat(Request $request, $id)
    {
        $subcategory = SubCategory::find($id);
        if ($request->fileimage){
            $file = $request->fileimage;
            $original_name = $file->getClientOriginalName();
            $file->move(public_path().'/images/subcategory/', $original_name);
            $subcategory->photo = '/images/subcategory/'.$original_name;
        }

        $subcategory->id_categories=$request->id_categories;
        $subcategory->subcategori=$request->subcategory;
        $subcategory->save();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategory = SubCategory::find($id);
        $subcategory->delete();
    }
}
