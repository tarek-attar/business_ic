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
        return response()->json($all_freelancer);
    }
    public function add_new_freelancer_to_tell_me()
    {
        $freelancer_exist = Tell_me::where('user_id', Auth::id())->exists();
        if ($freelancer_exist == true) {
            return response()->json('freelancer is already exist');
        }
        $tell_me = Tell_me::create([
            'user_id' => Auth::id(),
        ]);
        return response()->json('New freelancer added to tell me  successfully');
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
            return response()->json('freelancer updated successfully');
        }
        return response()->json('freelancer dose not exist', 400);
    }

    public function delete()
    {
        $freelancer_exist = Tell_me::where('user_id', Auth::id())->exists();
        if ($freelancer_exist == true) {
            $delete_freelancer = Tell_me::where('user_id', Auth::id())->first();
            $delete_freelancer->delete();
            return response()->json('freelancer deleted from tell me successfully');
        }
        return response()->json('freelancer dose not exist', 400);
    }

    /* public function send_job_message(Request $request)
    {
        
    } */
}
