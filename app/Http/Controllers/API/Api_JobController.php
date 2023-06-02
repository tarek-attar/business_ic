<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Job_file;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class Api_JobController extends Controller
{

    public function index()
    {
        $jobs = Job::all();
        return response()->json($jobs);
    }

    public function createJop(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'price_min' => 'required',
            'price_max' => 'required',
            'category_id' => 'required',
            'delivery_time' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => $validator->errors(),
            ];
            return response()->json($response, 400);
        }
        $connect_token = Auth::id() . rand() . time();
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $filename = rand() . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/job'), $filename);
                Job_file::create([
                    'file_name' => $filename,
                    'connection_token' => $connect_token,
                ]);
            }
        }

        Job::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'price_min' => $request->price_min,
            'price_max' => $request->price_max,
            'category_id' => $request->category_id,
            'delivery_time' => $request->delivery_time,
            'notic' => $request->notic,
            'connection_token' => $connect_token,
            //'user_id' => Auth::id(),
            'user_id' => $request->user_id,
        ]);
        return response()->json('User created successfully');
    }

    /* public function edit($id)
    {
        $job = Job::findOrFail($id);
        $categories = Category::all();
        $images = Job_file::where('connection_token', $job->connection_token)->get();
        return view('admin.jobs.edit', compact('job', 'categories', 'images'));
    } */


    public function updateJop(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'category_id' => 'required',
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'price_min' => 'required',
            'price_max' => 'required',
            'delivery_time' => 'required',
            'status' => 'required',
            'image.*' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => $validator->errors(),
            ];
            return response()->json($response, 400);
        }


        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $filename = rand() . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/job'), $filename);
                Job_file::create([
                    'file_name' => $filename,
                    'connection_token' => $job->connection_token,
                ]);
            }
        }

        $job->update([
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'price_min' => $request->price_min,
            'price_max' => $request->price_max,
            'delivery_time' => $request->delivery_time,
            'notic' => $request->notic,
            'status' => $request->status,
        ]);
        $selectedCheckboxes = $request->input('deleteFile'); // id of image in table job_files
        if ($selectedCheckboxes) {
            foreach ($selectedCheckboxes as $value) {
                $idFilesDelete = Job_file::findOrFail($value);
                File::delete(public_path('uploads/job/' . $idFilesDelete->file_name));
                $idFilesDelete->delete();
            };
        }
        return response()->json('Job updated successfully');
    }

    public function destroyJop(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        $jobFiles = Job_file::where('connection_token', $job->connection_token)->get();
        foreach ($jobFiles as $item) {
            File::delete(public_path('uploads/job/' . $item->file_name));
        };
        $job->delete();
        foreach ($jobFiles as $item) {
            $item->delete();
        };
        return response()->json('Job deleted successfully');
    }
}
