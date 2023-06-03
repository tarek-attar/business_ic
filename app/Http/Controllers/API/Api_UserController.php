<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Freelancer;
use App\Models\Freelancer_id;
use App\Models\Freelancer_service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Api_UserController extends Controller
{
    public function index()
    {
        //$users = User::all();
        $users = User::whereNotIn('role', ['admin', 'superadmin'])->get();
        $response = [
            'status' => true,
            'message' => 'you get all users (not admin/auperadmin) successfully',
            'data' => $users
        ];
        return response()->json($response);
    }
    public function admin()
    {
        $admins = User::whereIn('role', ['admin', 'superadmin'])->get();
        $response = [
            'status' => true,
            'message' => 'you get all admin - auperadmin successfully',
            'data' => $admins
        ];
        return response()->json($response);
    }
    public function getOneUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => $validator->errors(),
                'data' => []
            ];
            return response()->json($response, 400);
        }
        $user = User::where('id', $request->id)->first();
        if (!$user) {
            $response = [
                'status' => false,
                'message' => 'this user dose not exists',
                'data' => []
            ];
            return response()->json($response, 400);
        }
        $response = [
            'status' => true,
            'message' => 'you get a one user successfully',
            'data' => $user
        ];
        return response()->json($response, 200);
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'numeric', 'min:10'],
            'password' => ['required', 'min:8'],
            'user_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => $validator->errors(),
            ];
            return response()->json($response, 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'notic' => $request->notic,
        ]);

        if ($request->hasFile('id_image')) {
            $file = $request->file('id_image');
            $filename = 'id_image' . '_' . rand() . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/user'), $filename);
            $user->update([
                'id_image' => $filename,
            ]);
        }
        if ($request->hasFile('user_image')) {
            $file = $request->file('user_image');
            $filename = 'user_image' . '_' . rand() . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/user'), $filename);
            $user->update([
                'user_image' => $filename,
            ]);
        }

        $response = [
            'status' => true,
            'message' => 'User created successfully',
            'data' => []
        ];
        return response()->json($response);
    }

    // id will come from auth user
    public function updateUser(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        if (!$user) {
            $response = [
                'status' => false,
                'message' => 'user dose not exists',
            ];
            return response()->json($response, 400);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'numeric', 'min:10'],
            'password' => ['required', 'min:8'],
            'user_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => $validator->errors(),
            ];
            return response()->json($response, 400);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'notic' => $request->notic,
        ]);

        if ($request->hasFile('id_image')) {
            $file = $request->file('id_image');
            $filename = rand() . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/user'), $filename);
            $user->update([
                'id_image' => $filename,
            ]);
        }
        if ($request->hasFile('user_image')) {
            $file = $request->file('user_image');
            $filename = rand() . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/user'), $filename);
            $user->update([
                'user_image' => $filename,
            ]);
        }
        $response = [
            'status' => true,
            'message' => 'User updated successfully',
            'data' => []
        ];
        return response()->json($response);
    }

    public function new_freelancer(Request $request, $id)
    {
        $exist_user = User::where('id', $id)->first();
        $exist_freelancer = Freelancer::where('user_id', $id)->first();
        if (!$exist_user) {
            $response = [
                'status' => false,
                'message' => 'the user dose not exist',
                'data' => []
            ];
            return response()->json($response);
        }
        if ($exist_freelancer) {
            $response = [
                'status' => false,
                'message' => 'your request is already sended and waiting for accept',
                'data' => []
            ];
            return response()->json($response);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone_number' => ['required', 'numeric', 'min:10'],
                'address' => 'required',
                'category_id' => 'required',
                //'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            if ($validator->fails()) {
                $response = [
                    'status' => false,
                    'message' => $validator->errors(),
                ];
                return response()->json($response, 400);
            }

            Freelancer::create([
                'user_id' => $id,
                'status' => 'unactive',
                'address' => $request->address,
                'category_id' => 6,
            ]);

            foreach ($request->category_id as  $categories) {
                Freelancer_service::create([
                    'user_id' => $id,
                    'category_id' => $categories,
                ]);
            }

            /* if ($request->hasFile('image')) {
                foreach ($request->file('image') as $file) {
                    $filename = rand() . time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $filename);
                    Freelancer_id::create([
                        'user_id' => $id,
                        'image' => $filename,
                    ]);
                }
            } */

            /* $user = User::findOrFail($id);
            $user->update([
                'role' => 'freelancer',
            ]); */

            $user = User::findOrFail($id);

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'role' => 'freelancer',
                'notic' => $request->notic,
            ]);
            $response = [
                'status' => true,
                'message' => 'your request sended successfully',
                'data' => []
            ];
            return response()->json($response);
        }
    }

    public function destroyUser(Request $request, $id)
    {
        if ($id != Auth::id()) {
            $response = [
                'status' => false,
                'message' => 'you not allowed to delete user',
                'data' => []
            ];
            return response()->json($response);
        }

        $user = User::where('id', $id)->first();
        if (!$user) {
            $response = [
                'status' => false,
                'message' => 'the user dose not exist',
                'data' => []
            ];
            return response()->json($response);
        }
        return response()->json($user);
        $user->delete();

        $response = [
            'status' => true,
            'message' => 'User deleted successfully',
            'data' => []
        ];
        return response()->json($response);
    }
}
