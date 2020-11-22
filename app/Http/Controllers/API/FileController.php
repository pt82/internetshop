<?php

namespace App\Http\Controllers\API;

use App\File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function storeimage(Request $request)
    {
        $file = $request->imagegallery;
        $newfiles = new File();
        $original_name = $file->getClientOriginalName();
        $file->move(public_path().'/images/product_gallery/'.$request->id_product.'/', $original_name);
//        помещаем картинку в папку с id товра
        $newfiles->path = '/images/product_gallery/'.$request->id_product.'/'.$original_name;
        $newfiles->id_tovars = $request->id_product;
        $newfiles->save();
    }

    public function showimage($id)
    {
        return File::where('id_tovars', $id)->get();
    }

    public function delimage($id)
    {


        $image = File::find($id);
        $image->delete();

    }


}
