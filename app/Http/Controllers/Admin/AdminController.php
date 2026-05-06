<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Training;
use App\Models\Enrollment;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalCourses = Course::count();
        $totalTrainings = Training::count();
        $totalEnrollments = Enrollment::count();

        $latestUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalCourses',
            'totalTrainings',
            'totalEnrollments',
            'latestUsers'
        ));
    }
}