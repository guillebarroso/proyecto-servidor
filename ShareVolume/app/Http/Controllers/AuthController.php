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
            Auth::user()
        ])->withCookie($cookie);
    }

    public function user()
    {
        return Auth::user();
    }

    public function getUser($id)
    {
        $user = DB::table('users')->find($id);;
        return response()->json([$user], 200);
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
            ->get();

        $count['count']=DB::table('images')
            ->where('instrument_id', '=', $instrument_id)
            ->count();

        $stars['stars']=DB::table('stars_instruments')
            ->where('liked_instrument_id', '=', $instrument_id)
            ->avg('stars');

        return response()->json([$user_info, $comments_info, $images, [$count], [$stars]], 200);
    }
}
