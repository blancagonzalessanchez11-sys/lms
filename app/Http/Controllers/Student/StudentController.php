<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $studentId = Auth::user()->user_id;

        $enrollments = Enrollment::with([
            'training.course',
            'training.teacher'
        ])
            ->where('student_id', $studentId)
            ->get();

        $totalCourses = $enrollments->count();
        $completed = 0; // TODO: Implementar estados 'C' (Completed) cuando se desarrolle la lógica de progreso.
        $inProgress = $enrollments->where('status', 'A')->count();

        return view('student.dashboard', compact(
            'enrollments',
            'totalCourses',
            'completed',
            'inProgress'
        ));
    }
}