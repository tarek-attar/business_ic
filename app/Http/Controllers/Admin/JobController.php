<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Job_file;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class JobController extends Controller
{

    public function index()
    {
        $jobs = Job::orderByDesc('id')->paginate(5);
        return view('admin.jobs.index', compact('jobs'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('admin.jobs.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
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

        $connect_token = Auth::id() . rand() . time();

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $filename = rand() . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $filename);
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
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.jobs.index')->with('msg', 'Job created successfully')->with('type', 'success');

        /* $connect_token = Auth::id() . '-' . rand() . '-' . time();
        dd($connect_token); */
    }


    public function show($id)
    {
        $job = Job::findOrFail($id);
        $categories = Category::all();
        $images = Job_file::where('connection_token', $job->connection_token)->get();
        return view('admin.jobs.show', compact('job', 'categories', 'images'));
        //dd($images);
    }


    public function edit($id)
    {
        $job = Job::findOrFail($id);
        $categories = Category::all();
        $images = Job_file::where('connection_token', $job->connection_token)->get();
        return view('admin.jobs.edit', compact('job', 'categories', 'images'));
    }


    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        $request->validate([
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
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $filename = rand() . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $filename);
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
        $selectedCheckboxes = $request->input('deleteFile');
        if ($selectedCheckboxes) {
            foreach ($selectedCheckboxes as $key => $value) {
                $idFilesDelete = Job_file::findOrFail($value);
                File::delete(public_path('uploads/' . $idFilesDelete->file_name));
                $idFilesDelete->delete();
            };
        }
        return redirect()->route('admin.jobs.index')->with('msg', 'Job updated successfully')->with('type', 'success');

        /* $selectedCheckboxes = $request->input('deleteFile');
        foreach ($selectedCheckboxes as $key => $value) {
            $idFilesDelete = Job_file::findOrFail($value);
            $idFilesDelete->delete();
        } */

        //dd($selectedCheckboxes);
    }

    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $jobFiles = Job_file::where('connection_token', $job->connection_token)->get();
        foreach ($jobFiles as $item) {
            File::delete(public_path('uploads/' . $item->file_name));
        };
        $job->delete();
        foreach ($jobFiles as $item) {
            $item->delete();
        };
        return redirect()->route('admin.jobs.index')->with('msg', 'Category deleted successfully')->with('type', 'danger');
    }
}
