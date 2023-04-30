<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $adminCount = User::where('role', 'admin')->count();
        $userCount = User::where('role', 'user')->count();
        $freelancerCount = User::where('role', 'user')->count();
        $jobCount = Job::where('status', 1)->count();
        return view('admin.index', compact('adminCount', 'jobCount', 'userCount', 'freelancerCount'));
    }
}
