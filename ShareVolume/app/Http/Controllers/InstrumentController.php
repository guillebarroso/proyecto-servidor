<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class InstrumentController extends Controller
{
    public function showAllInstruments()
    {
        return response()->json(Instrument::all());
    }

    public function showOneInstrument($id)
    {
        return response()->json(Instrument::find($id));
    }

    public function createInstrument(Request $request)
    {
//      $instrument = Instrument::create($request->all());
        $image_path = $request->file('image');
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('instruments')->put($image_path_name, File::get($image_path));
        }

        $instrument = Instrument::create([
            'user_id' => $request->input('user_id'),
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'starting_price' => $request->input('starting_price'),
            'description' => $request->input('description'),
            'image' => $image_path_name
        ]);

        return response()->json($instrument, 200);
    }

    public function updateInstrument($id, Request $request)
    {
        $name = $request->input('name');
        $price = $request->input('price');
        $description = $request->input('description');

        $instrument = DB::table('instruments')
            ->where('id', $id)
            ->update(['name' => $name, 'starting_price' => $price, 'description' => $description]);

        return response()->json($instrument, 200);
    }

    public function updateInstrumentImage($id, Request $request)
    {
        $image_path = $request->file('image');
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('instruments')->put($image_path_name, File::get($image_path));
        }

        DB::table('instruments')
            ->where('id', $id)
            ->update(['image' => $image_path_name]);

        return response()->json($image_path_name, 200);
    }

    public function deleteInstrument($id)
    {
        Instrument::findOrFail($id)->delete();
        return response('Instrumento borrado correctamente', 200);
    }

    public function instrumentComment(Request $request)
    {

        $commented_instrument = $request->input('commented_instrument');

        $comments = DB::table('instruments')
            ->join('comments_instruments', 'instruments.id', '=', 'comments_instruments.commented_instrument_id')
            ->join('users', 'users.id', '=', 'comments_instruments.user_id')
            ->where('comments_instruments.commented_instrument_id', '=', $commented_instrument)
            ->select('users.name as nameUser', 'comments_instruments.comment', 'instruments.name as nameInstrument')
            ->get();

        return response()->json($comments, 200);
    }

    public function instrumentCard()
    {
        $instruments_cards = DB::table('instruments')
            ->join('users', 'users.id', '=', 'instruments.user_id')
            ->select('users.id as user_id','users.nickname', 'users.location', 'instruments.name', 'instruments.description', 'instruments.id', 'instruments.image as instrument_image',
                DB::raw("(select avg(stars) from stars_instruments where liked_instrument_id = instruments.id) as stars"))
//            ->skip(0) Preguntar a javi si lo de arriba está bien
//            ->take(3)
            ->orderBy('users.nickname','desc')
            ->get();


        return response()->json($instruments_cards, 200);
    }

    public function userInstruments(Request $request)
    {

        $user_id = $request->input('user_id');

        $instruments = DB::table('instruments')
            ->where('user_id', '=', $user_id)
            ->select('id', 'name')
            ->get();

        return response()->json($instruments, 200);
    }

    public function uploadImage(Request $request)
    {

        $instrument_id= $request->input('instrument_id');
        $instrument = Instrument::find($instrument_id);

        $image_path = $request->file('image_path');
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('instruments')->put($image_path_name, File::get($image_path));
            $instrument->image = $image_path_name;
        }

        $instrument->save();

        return response('Se ha guardado correctamente', 200);
    }

    public function getImage($filename)
    {
        $file = Storage::disk('instruments')->get($filename);
        return response($file)->header('Content-type','image/png');
    }

    public function instrumentInfo(Request $request)
    {
        $instrument_id = $request->input('instrument_id');

        $user_info = DB::table('instruments')
            ->join('users', 'users.id', '=', 'instruments.user_id')
            ->where('instruments.id', '=', $instrument_id)
            ->select('users.nickname', 'users.location', 'users.name as userName', 'users.image as userImage',
                'instruments.image as principalImage', 'instruments.name as instrumentName', 'instruments.type', 'instruments.starting_price', 'instruments.description')
            ->get();

        $comments_info = DB::table('comments_instruments')
            ->join('users', 'users.id', '=', 'comments_instruments.user_id')
            ->where('comments_instruments.commented_instrument_id', '=', $instrument_id)
            ->select('comments_instruments.comment', 'users.nickname')
            ->get();

        $images = DB::table('images')
            ->where('instrument_id', '=', $instrument_id)
            ->select('image_path')
            ->take(5)
            ->get();

        $count['count']=DB::table('images')
            ->where('instrument_id', '=', $instrument_id)
            ->count();

        $stars['stars']=DB::table('stars_instruments')
            ->where('liked_instrument_id', '=', $instrument_id)
            ->avg('stars');

        return response()->json([$user_info, $comments_info, $images, [$count], [$stars]], 200);
    }

    public function search($word)
    {
        $instrument = DB::table('instruments')
            ->where('name', 'like', $word.'%')
            ->orWhere('description', 'like', $word.'%')
            ->get();

        return response()->json($instrument, 200);
    }
}
