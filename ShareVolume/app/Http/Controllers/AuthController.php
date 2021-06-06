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
        $image_path = $request->file('image');
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('public')->put($image_path_name, File::get($image_path));
        }
        else{
            $image_path_name = 'logoSharevolume.png';
        }

        return User::create([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'age' => $request->input('age'),
            'email' => $request->input('email'),
            'nickname' => $request->input('nickname'),
            'location' => $request->input('location'),
            'password' => Hash::make($request->input('password')),
            'description' => $request->input('description'),
            'image' => $image_path_name
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

        $user = DB::table('users')->select('nickname','name','surname','age', 'location', 'image')->find($id);;
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
        $user_id = $request->input('user_id');

        $user_info = DB::table('users')
            ->where('id', '=', $user_id)
            ->select('nickname', 'location', 'name', 'image', 'age','surname','description')
            ->get();

        $comments_info = DB::table('comments_users')
            ->join('users', 'users.id', '=', 'comments_users.user_id')
            ->where('comments_users.commented_user_id', '=', $user_id)
            ->select('comments_users.comment', 'users.nickname')
            ->get();

        return response()->json([$user_info, $comments_info], 200);
    }

    public function updateUser($id, Request $request)
    {
        $name = $request->input('name');
        $age = $request->input('age');
        $nickname = $request->input('nickname');
        $location = $request->input('location');
        $surname = $request->input('surname');
        $description = $request->input('description');
        $password = $request->input('password');

        $user = DB::table('users')
            ->where('id', $id)
            ->update(['name' => $name, 'age' => $age, 'nickname' => $nickname
                , 'location' => $location, 'description' => $description, 'surname' => $surname
                , 'password' => Hash::make($password)]);

        return response()->json($user, 200);
    }

    public function updateUserImage($id, Request $request)
    {
        $image_path = $request->file('image');
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('users')->put($image_path_name, File::get($image_path));
        }

        DB::table('users')
            ->where('id', $id)
            ->update(['image' => $image_path_name]);

        return response()->json($image_path_name, 200);
    }

    public function search(Request $request)
    {
        $word = $request->input('word');
        $user = DB::table('users')
            ->where('name', 'like', $word.'%')
            ->orWhere('surname', 'like', $word.'%')
            ->orWhere('nickname', 'like', $word.'%')
            ->orWhere('location', 'like', $word.'%')
            ->orWhere('description', 'like', $word.'%')
            ->get();

        return response()->json($user, 200);
    }
}
