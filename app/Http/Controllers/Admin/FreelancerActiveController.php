<?php

namespace App\Http\Controllers\Admin;

use App\Models\Freelancer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Freelancer_id;
use App\Models\Freelancer_service;
use App\Models\User;
use Illuminate\Support\Facades\File;


class FreelancerActiveController extends Controller
{

    public function index()
    {
        /*  $freelancers = Freelancer::orderByDesc('id')->paginate(5); */
        //$jobFiles = Job_file::where('connection_token', $job->connection_token)->get();
        //$userfreelancers = User::where('role', 'freelancer')->get();
        //$freelancers = Freelancer::all();
        $freelancers = Freelancer::where('status', 'active')->orderByDesc('updated_at')->get();
        return view('admin.freelancersactive.index', compact('freelancers'));
    }

    public function show($id)
    {
        $freelancer = Freelancer::findOrFail($id);
        $categories = Category::all();
        $freelanser_services = Freelancer_service::where('user_id', $freelancer->user_id)->get();
        $images = Freelancer_id::where('user_id', $freelancer->user_id)->get();
        return view('admin.freelancersactive.show', compact('freelancer', 'categories', 'images', 'freelanser_services'));
        //dd($images);
    }

    public function edit($id)
    {
        $freelancer = Freelancer::findOrFail($id);
        $categories = Category::all();
        //$freelanser_services = Freelancer_service::where('user_id', $freelancer->user_id)->get();
        $images = Freelancer_id::where('user_id', $freelancer->user_id)->get();
        return view('admin.freelancersactive.edit', compact('freelancer', 'categories', 'images'));
    }


    /* public function create()
    {
        $categories = Category::all();
        return view('admin.freelancersactive.create', compact('categories'));
    } */

    /*
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
            'address' => 'required',
            'status' => 'required',
            'category_id' => 'required',
            'id_image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('id_image')) {
            foreach ($request->file('id_image') as $file) {
                $filename = rand() . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $filename);
                Freelancer_id::create([
                    'file_name' => $filename,
                    'connection_token' => $connect_token,
                ]);
            }
        }

        Freelancer::create([
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

        return redirect()->route('admin.jobs.index')->with('msg', 'Freelancer created successfully')->with('type', 'success');

        //$connect_token = Auth::id() . '-' . rand() . '-' . time();
        //dd($connect_token);
    }
*/




    public function update(Request $request, $id)
    {
        $freelancer = Freelancer::findOrFail($id);
        $userfreelancer = User::findOrFail($freelancer->user_id);

        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
            'category_id' => 'required',
            'address' => 'required',
            'status' => 'required',
            'image.*' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $filename = rand() . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $filename);
                Freelancer_id::create([
                    'image' => $filename,
                    'user_id' => $freelancer->user_id,
                ]);
            }
        }
        $userfreelancer->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'notic' => $request->notic,
        ]);
        $freelancer->update([
            'category_id' => $request->category_id,
            'address' => $request->address,
            'status' => $request->status,
        ]);

        Freelancer_service::where('user_id', $freelancer->user_id)->delete();
        Freelancer_service::create([
            'user_id' => $freelancer->user_id,
            'category_id' => $request->category_id,
        ]);

        $selectedCheckboxes = $request->input('deleteFile');
        if ($selectedCheckboxes) {
            foreach ($selectedCheckboxes as $value) {
                $idFilesDelete = Freelancer_id::findOrFail($value);
                File::delete(public_path('uploads/' . $idFilesDelete->image));
                $idFilesDelete->delete();
            };
        }
        return redirect()->route('admin.freelancersactive.index')->with('msg', 'Freelancer updated successfully')->with('type', 'success');

        // $selectedCheckboxes = $request->input('deleteFile');
        //foreach ($selectedCheckboxes as $key => $value) {
        //    $idFilesDelete = Job_file::findOrFail($value);
        //    $idFilesDelete->delete();
        //}

        //dd($selectedCheckboxes);
    }

    public function destroy($id)
    {
        $freelancer_user = Freelancer::findOrFail($id);
        $user = User::findOrFail($freelancer_user->user_id);
        $user->update([
            'role' => 'user',
        ]);
        Freelancer_service::where('user_id', $freelancer_user->user_id)->delete();

        $freelancer = Freelancer::findOrFail($id);
        $freelancerFiles = Freelancer_id::where('user_id', $freelancer->user_id)->get();
        foreach ($freelancerFiles as $item) {
            File::delete(public_path('uploads/' . $item->image));
        };
        $freelancer->delete();
        foreach ($freelancerFiles as $item) {
            $item->delete();
        };
        return redirect()->route('admin.freelancersactive.index')->with('msg', 'Freelancer deleted successfully')->with('type', 'danger');
    }
}
