<?php

namespace App\Http\Controllers\API;

use App\Review;
use App\Tovar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TovarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'tovar'=>Tovar::OrderBy('updated_at','desc')->get()
        ],200);
    }

    public function search($name)
    {

          return Tovar::where("name", 'LIKE', "%" . $name . "%")->limit(10)->get();
//            return response()->json($tovar);

    }

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
        $file->move(public_path().'/images/product/', $original_name);

        Tovar::create([
            'photo'=>'/images/product/'.$original_name,
            'id_categories'=>$request->id_categories,
            'id_subcategories'=>$request->id_subcategories,
            'article'=>$request->article,
            'name'=>$request->product,
            'desc'=>$request->desc,
            'pricein'=>$request->pricein,
            'balance'=>$request->balance,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //отображение списка товара в магазине с avg рейтингом
    public function show($id)
    {

     return  Tovar::where('id_subcategories', $id)
            ->leftJoin('reviews', 'reviews.id_tovars','=','tovars.id')
            ->select (array('tovars.*',
            DB::raw('AVG(ROUND(reviews.rating,1)) as avg_rating '),
            DB::raw('COUNT(reviews.id) as count_review')
            ))
            ->groupBy('id')
            ->get();

//     рабочий   return Tovar::where('subcategoryid', $id)->get();
    }
//для магазина один товар
    public function showonetovar($subcategori, $id)
    {
//        $rating = Review::where('tovarid', $id);


       return Tovar::where('id_subcategories', $subcategori)->where ('id', $id)->get();
    }

    //для админ панели редактируем товар
    public function tovarone($id)
    {
        return Tovar::where('id', $id)->get();
//        $tovar = Tovar::table('tovars')
//                        ->join('categories', 'id', '=', 'categoryid')
//                        ->select('tovars.*')->where('id','=', $id);
//        var_dump($tovar);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_product(Request $request, $id)
    {
        $product = Tovar::find($id);
        if ($request->fileimage){
             $file = $request->fileimage;
             $original_name = $file->getClientOriginalName();
             $file->move(public_path() . '/images/product/', $original_name);
             $product->photo='/images/product/'.$original_name;
          }
        $product->id_categories=$request->id_categories;
        $product->id_subcategories=$request->id_subcategories;
        $product->article=$request->article;
        $product->desc=$request->desc;
          $product->name=$request->product;
        $product->balance=$request->balance;
        $product->pricein=$request->pricein;
        $product->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tovar = Tovar::find($id);
        $tovar->delete();
    }

    public function addtovar(Request $request) {
//    $tovar = new Tovar;
//        $tovar->name=$request->name;
//
////      $tovar = new Tovar($request->all());
//     // $tovar->name = $request->name;
//        // $tovar ->fill( $request->name);
//        // $tovar->all($request->except(['name', 'desc']));
//        $tovar->save();
//      //  return $request;
//
//        return response()->json([
//            'success' => true
//        ]);
   }
}
