<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Freelancer_service;
use App\Models\Tell_me;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Api_Tell_meController extends Controller
{

    public function show()
    {
        $all_freelancer = Tell_me::all();
        $all_freelancer->each(function ($freelancer) {
            $freelancer_services_ids = Freelancer_service::where('user_id', $freelancer->user_id)->pluck('category_id')->toArray();
            $category_names = Category::whereIn('id', $freelancer_services_ids)->pluck('name_ar')->toArray();
            $freelancer->service = $category_names;
        });
        $response = [
            'status' => true,
            'message' => 'you get all freelancer',
            'data' => $all_freelancer
        ];
        return response()->json($response, 200);
    }
    public function add_new_freelancer_to_tell_me()
    {
        $freelancer_exist = Tell_me::where('user_id', Auth::id())->exists();
        if ($freelancer_exist == true) {
            $response = [
                'status' => false,
                'message' => 'freelancer is already exist',
                'data' => []
            ];
            return response()->json($response, 400);
        }
        $tell_me = Tell_me::create([
            'user_id' => Auth::id(),
        ]);
        $response = [
            'status' => true,
            'message' => 'New freelancer added to tell me  successfully',
            'data' => []
        ];
        return response()->json($response, 200);
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vip' => 'required|in:1,0',
            'note' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => $validator->errors(),
            ];
            return response()->json($response, 400);
        }

        $freelancer_exist = Tell_me::where('user_id', Auth::id())->exists();
        if ($freelancer_exist == true) {
            $update_freelancer = Tell_me::where('user_id', Auth::id())->first();
            $update_freelancer->update([
                'vip' => $request->vip,
                'note' => $request->note,
            ]);
            $response = [
                'status' => true,
                'message' => 'freelancer updated successfully',
                'data' => []
            ];
            return response()->json($response, 200);
        }
        $response = [
            'status' => false,
            'message' => 'freelancer dose not exist',
            'data' => []
        ];
        return response()->json($response, 400);
    }

    public function delete()
    {
        $freelancer_exist = Tell_me::where('user_id', Auth::id())->first();
        if (!$freelancer_exist) {
            $response = [
                'status' => true,
                'message' => 'freelancer dose not exist',
                'data' => []
            ];
            return response()->json($response, 400);
        }
        $delete_freelancer = Tell_me::where('user_id', Auth::id())->first();
        $delete_freelancer->delete();
        $response = [
            'status' => true,
            'message' => 'freelancer deleted from tell me successfully',
            'data' => []
        ];
        return response()->json($response, 200);
    }

    /* public function send_job_message(Request $request)
    {
        
    } */
}
