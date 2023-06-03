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
        $jobs->each(function ($job) {
            $job_files = Job_file::where('job_id', $job->id)->pluck('file_name')->toArray();
            $job->job_files = $job_files;
        });
        if ($jobs == null) {
            $response = [
                'status' => false,
                'message' => 'there is no data',
                'data' => []
            ];
            return response()->json($response, 400);
        }
        $response = [
            'status' => true,
            'message' => 'you get all jobs successfully',
            'data' => $jobs
        ];
        return response()->json($response);
    }

    public function getOneJob(Request $request)
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

        $job = Job::where('id', $request->id)->first();
        $job_files = Job_file::where('job_id', $job->id)->pluck('file_name')->toArray();
        $job->job_files = $job_files;

        if ($job == null) {
            $response = [
                'status' => false,
                'message' => 'there is no data',
                'data' => []
            ];
            return response()->json($response, 400);
        }
        $response = [
            'status' => true,
            'message' => 'you get a one job successfully',
            'data' => $job
        ];
        return response()->json($response, 200);
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
                'data' => []
            ];
            return response()->json($response, 400);
        }

        $job = Job::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'price_min' => $request->price_min,
            'price_max' => $request->price_max,
            'category_id' => $request->category_id,
            'delivery_time' => $request->delivery_time,
            'notic' => $request->notic,
            'user_id' => Auth::id(),
        ]);
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $filename = $job->id . '-' . rand() . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/job'), $filename);
                Job_file::create([
                    'file_name' => $filename,
                    'job_id' => $job->id,
                ]);
            }
        }
        $response = [
            'status' => true,
            'message' => 'Job created successfully',
            'data' => []
        ];
        return response()->json($response, 200);
    }

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
                'data' => []
            ];
            return response()->json($response, 400);
        }
        $selectedCheckboxes = $request->input('deleteFile'); // id of image in table job_files
        if ($selectedCheckboxes) {
            foreach ($selectedCheckboxes as $value) {
                $idFilesDelete = Job_file::where('id', $value)->first();
                if ($idFilesDelete) {
                    File::delete(public_path('uploads/job/' . $idFilesDelete->file_name));
                    $idFilesDelete->delete();
                } else {
                    $response = [
                        'status' => false,
                        'message' => "the file id:$value is not exists to delete",
                        'data' => []
                    ];
                    return response()->json($response, 400);
                }
            };
        }

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $filename = $job->id . '-' . rand() . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/job'), $filename);
                Job_file::create([
                    'file_name' => $filename,
                    'job_id' => $job->id,
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

        $response = [
            'status' => true,
            'message' => 'Job updated successfully',
            'data' => []
        ];
        return response()->json($response, 200);
    }

    public function destroy(Request $request, $id)
    {
        $job = Job::where('id', $id)->first();
        if ($job) {
            $jobFiles = Job_file::where('job_id', $job->id)->get();
            foreach ($jobFiles as $item) {
                File::delete(public_path('uploads/job/' . $item->file_name));
            };
            $job->delete();
            foreach ($jobFiles as $item) {
                $item->delete();
            };
            $response = [
                'status' => true,
                'message' => 'Job deleted successfully',
                'data' => []
            ];
            return response()->json($response, 200);
        }
        //return response()->json('else', 400);
        $response = [
            'status' => false,
            'message' => 'Job not deleted',
            'data' => []
        ];
        return response()->json($response, 400);
    }
}
