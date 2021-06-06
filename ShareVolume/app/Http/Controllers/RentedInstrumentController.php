<?php

namespace App\Http\Controllers;

use App\Models\Rented_instrument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RentedInstrumentController extends Controller
{
    public function showAllRentedInstruments()
    {
        return response()->json(Rented_instrument::all());
    }

    public function showOneRentedInstrument($id)
    {
        return response()->json(Rented_instrument::find($id));
    }

    public function rentInstrument(Request $request)
    {
        $rentedInstrument = Rented_instrument::create($request->all());

        return response()->json($rentedInstrument, 200);
    }

    public function updateRentedInstrument($id, Request $request)
    {
        $rentedInstrument = Rented_instrument::findOrFail($id);
        $rentedInstrument->update($request->all());

        return response()->json($rentedInstrument, 200);
    }

    public function datesRentedInstrument($id)
    {
        $rentedInstrument = DB::table('rented_instruments')
            ->where('instrument_id', '=', $id)
            ->where('return_date', '>=', date('Y-m-d H:i:s'))
            ->select('initial_date', 'return_date')
            ->get();


        return response()->json($rentedInstrument, 200);
    }

    public function deleteRentedInstrument($id)
    {
        Rented_instrument::findOrFail($id)->delete();
        return response('El instrumento ya no está alquilado', 200);
    }
}
