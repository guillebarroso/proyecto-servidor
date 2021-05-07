<?php

namespace App\Http\Controllers;

use App\Models\Comments_instrument;
use Illuminate\Http\Request;

class CommentsInstrumentController extends Controller
{
    public function createComment(Request $request)
    {
        $comment = Comments_instrument::create($request->all());

        return response()->json($comment, 200);
    }

}
