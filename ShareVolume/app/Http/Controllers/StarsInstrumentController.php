<?php

namespace App\Http\Controllers;

use App\Models\Stars_instrument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StarsInstrumentController extends Controller
{
    public function rate(Request $request)
    {
//        $starsInstrument = Stars_instrument::create($request->all());

        $instrument_id = $request->input('liked_instrument_id');
        $user_id = $request->input('user_id');
        $stars = $request->input('stars');

        $starsInstrument = DB::table('stars_instruments')->insert([
            'user_id' => $user_id,
            'stars' => $stars,
            'liked_instrument_id' => $instrument_id
        ]);

        return response()->json($starsInstrument, 200);


    }

    public function editStars(Request $request)
    {
        $instrument_id = $request->input('instrument_id');
        $user_id = $request->input('user_id');
        $stars = $request->input('stars');


        return response()->json("adios", 200);
    }
}
