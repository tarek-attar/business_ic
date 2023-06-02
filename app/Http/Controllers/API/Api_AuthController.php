<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class Api_AuthController extends Controller
{
    public function register(Request $request)
    {
        /* if (!$request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ])) {
            $response = [
                'status' => false,
            ];
            return response()->json($response);
        } */
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => $validator->errors(),
            ];
            return response()->json($response, 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
        ]);
        //$success['token'] = $user->createToken('MyApp')->plainTextToken;
        $token = $user->createToken($user->name);
        $success['token'] = $token->plainTextToken;
        $success['name'] = $user->name;

        $user->api_token = $token->plainTextToken;
        $user->save();

        $response = [
            'status' => true,
            'data' => $success,
            'message' => 'User register successfully'
        ];

        return response()->json($response);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            /* $user = Auth::user();
            $token = $user->createToken($user->name)->plainTextToken; */
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken($user->name);
            $success['token'] = $token->plainTextToken;
            $success['name'] = $user->name;

            $user->api_token = $token->plainTextToken;
            $user->save();

            $response = [
                'status' => true,
                'data' => $success,
                'message' => 'User login successfully'
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => 'Unauthhorised'
            ];
            return response()->json($response, 400);
        }


        /*  $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!Hash::check($request->password, $user->password)) {
            // return response()->json($user);
            return response()->json('cannot login');
        }
        $token = $user->createToken($user->name);

        return response()->json(['token' => $token->plainTextToken, 'user' => $user]); */
    }
    public function logout(Request $request)
    {
        if (auth()->user()) {
            $user = auth()->user();
        }
        $request->user()->currentAccessToken()->delete();
        $token_user = User::where('id', $user->id)->first();
        $token_user->update([
            'api_token' => null,
        ]);

        $response = [
            'status' => true,
            'message' => 'user logout successfully'
        ];
        //$user = auth()->user();
        return response()->json($response, 400);
    }
}
