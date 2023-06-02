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

class Api_UserController extends Controller
{
    public function index()
    {
        //$users = User::all();
        $users = User::whereNotIn('role', ['admin', 'superadmin'])->get();
        return response()->json($users);
    }
    public function admin()
    {
        $admins = User::whereIn('role', ['admin', 'superadmin'])->get();
        return response()->json($admins);
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_number' => ['required', 'numeric', 'min:10'],
            'password' => ['required', 'min:8'],
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
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

        return response()->json('User created successfully');
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail($id);
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

        return response()->json('User updated successfully');
    }

    public function new_freelancer(Request $request, $id)
    {

        //return response()->json($request->category_id);
        $exist_freelancer = Freelancer::where('user_id', $id)->count();
        /* if ($exist_freelancer == 1) {
            return response()->json($exist_freelancer);
        } else {
            return response()->json('empty');
        } */
        if ($exist_freelancer == 1) {
            return response()->json('your request is already sended and waiting for accept');
        } else {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'phone_number' => 'required',
                'address' => 'required',
                'category_id' => 'required',
                //'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

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
            return response()->json('your request sended successfully');
        }
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json('User deleted successfully');
    }
}
