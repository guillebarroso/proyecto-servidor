<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        $image_path = $request->file('image_path');
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('public')->put($image_path_name, File::get($image_path));
        }

        $instrument_image = Image::create([
            'instrument_id' => $request->input('instrument_id'),
            'image_path' => $image_path_name
        ]);

        return response()->json($instrument_image, 200);
    }

    public function uploadImages(Request $request)
    {
        $images_path = $request->file('image_path');

        if($request->hasFile('image_path'))
        {
            foreach ($images_path as $image_path) {
                $image_path_name = time().$image_path->getClientOriginalName();
                Storage::disk('public')->put($image_path_name, File::get($image_path));
                Image::create([
                    'instrument_id' => $request->input('instrument_id'),
                    'image_path' => $image_path_name
                ]);
            }
        }
        return response( 200);
    }

    public function getImage($filename)
    {
        $file = Storage::disk('public')->get($filename);
        return response($file)->header('Content-type','image/png');
    }

    public function deleteImage(Request $request, $filename)
    {

        $id = $request->input('image_id');
        // Value is not URL but directory file path
        if(File::exists($filename)) {
            File::delete($filename);
        }
        Image::findOrFail($id)->delete();
        return response('Instrumento borrado correctamente', 200);
    }

    public function userImages(Request $request)
    {

        $instrument_id = $request->input('instrument_id');

        $images = DB::table('images')
            ->where('instrument_id', '=', $instrument_id)
            ->select('image_path')
            ->get();

        return response()->json($images, 200);
    }

    public function getAllImages($id)
    {
        $images = DB::table('images')
            ->where('instrument_id', '=', $id)
            ->select('image_path')
            ->get();

        return response()->json($images, 200);
    }
}
