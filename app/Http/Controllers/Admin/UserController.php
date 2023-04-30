<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Freelancer;
use App\Models\Freelancer_id;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('id')->paginate(5);
        $superadmin = User::where('role', 'superadmin')->get();
        $currentuser = Auth::id();
        //dd($superadmin);
        $action = 'false';
        foreach ($superadmin as $key => $super) {
            if ($super->id == $currentuser) {
                $action = 'true';
            }
        }

        return view('admin.users.index', compact('users', 'action'));
    }
    public function create()
    {
        return view('admin.users.create');
    }
    public function store(Request $request)
    {
        //dd($request);

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_number' => ['required', 'numeric', 'min:10'],
            'password' => ['required', 'min:8'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'notic' => $request->notic,
        ]);

        return redirect()->route('admin.users.index')->with('msg', 'User created successfully')->with('type', 'success');
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $categories = Category::all();
        return view('admin.users.edit', compact('user', 'categories'));
    }

    public function upgrade($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.upgrade', compact('user'));
    }


    public function update(Request $request, $id)
    {
        //dd($request);
        if ($request->type == 'upgrade') {
            $request->validate([
                'role' => 'required',
            ]);
            $user = User::findOrFail($id);

            $user->update([
                'role' => $request->role,
            ]);
            return redirect()->route('admin.users.index')->with('msg', 'User convert to ' . $request->role . ' successfully')->with('type', 'success');
        } else {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'phone_number' => 'required',
            ]);

            if ($request->yesno == 'yes') {
                $userID = $request->user_id;
                Freelancer::create([
                    'user_id' => $userID,
                    'status' => $request->status,
                    'address' => $request->address,
                    'category_id' => $request->category_id,
                ]);
                if ($request->hasFile('image')) {
                    foreach ($request->file('image') as $file) {
                        $filename = rand() . time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('uploads'), $filename);
                        Freelancer_id::create([
                            'user_id' => $userID,
                            'image' => $filename,
                        ]);
                    }
                }
                $user = User::findOrFail($id);
                $user->update([
                    'role' => 'freelancer',
                ]);
            }
            $user = User::findOrFail($id);

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'notic' => $request->notic,
            ]);
            return redirect()->route('admin.users.index')->with('msg', 'User edited successfully')->with('type', 'success');
        }
    }
    public function ajax_search(Request $request)
    {
        if ($request->ajax() != '') {
            $searchByID = $request->searchByID;
            $users = User::where("id", "like", "%{$searchByID}%")->orderby("id", "Desc")->get();
            return view('admin.search.ajax_search', ['users' => $users]);
        }
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('msg', 'User deleted successfully')->with('type', 'danger');
    }
    public function getcreatefreelancer()
    {
        return view('admin.users.create');
    }
    public function storefreelancer(Request $request)
    {
        //dd($request);

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_number' => ['required', 'numeric', 'min:10'],
            'password' => ['required', 'min:8'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'notic' => $request->notic,
        ]);

        return redirect()->route('admin.users.index')->with('msg', 'User created successfully')->with('type', 'success');
    }
}
