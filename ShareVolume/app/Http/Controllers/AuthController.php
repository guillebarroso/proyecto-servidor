<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        return User::create([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'age' => $request->input('age'),
            'email' => $request->input('email'),
            'nickname' => $request->input('nickname'),
            'location' => $request->input('location'),
            'password' => Hash::make($request->input('password')),
            'image' => $request->input('image')
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'message' => 'Invalid credentials!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();

        $token = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 24); // 1 day

        return response([
            'message' => $token
        ])->withCookie($cookie);
    }

    public function user()
    {
        return Auth::user();
    }

    public function logout()
    {
        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'Success'
        ])->withCookie($cookie);
    }

    public function uploadImage(Request $request)
    {

        $user_id= $request->input('user_id');
        $user = User::find($user_id);

        $image_path = $request->file('image_path');
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('users')->put($image_path_name, File::get($image_path));
            $user->image = $image_path_name;
        }

        $user->save();

        //$user = $request->file('image_path')->store('uploads','public');

        return response('Se ha guardado correctamente', 200);
    }

    public function getImage($filename)
    {
        $file = Storage::disk('users')->get($filename);
        return response($file)->header('Content-type','image/png');
    }

    public function userInfo(Request $request)
    {
        $user_id = $request->input('user_id');
        $instrument_id = $request->input('instrument_id');

        $user_info = DB::table('users')
            ->where('id', '=', $user_id)
            ->select('nickname', 'location', 'name')
            ->get();

        $comments_info = DB::table('comments_instruments')
            ->where('user_id', '=', $user_id)
            ->select('comment')
            ->get();

        $images = DB::table('images')
            ->where('instrument_id', '=', $instrument_id)
            ->select('image_path')
            ->get();
        return response()->json([$user_info, $comments_info, $images], 200);
    }
}
