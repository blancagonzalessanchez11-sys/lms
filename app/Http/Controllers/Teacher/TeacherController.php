<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        $trainings = Training::with(['course', 'enrollments'])
            ->withCount('enrollments')
            ->where('teacher_id', $user->user_id)
            ->get();

        $totalCourses = $trainings->count();
        $totalStudents = $trainings->sum('enrollments_count');

        return view('teacher.dashboard', compact(
            'trainings',
            'totalCourses',
            'totalStudents'
        ));
    }

    public function courses()
    {
        $user = auth()->user();

        $courses = Training::with('course')
            ->where('teacher_id', $user->user_id)
            ->get()
            ->pluck('course')
            ->unique('course_id')
            ->values();

        return view('teacher.courses.index', compact('courses'));
    }

    public function students($id)
    {
        $user = auth()->user();

        $training = Training::with([
            'course',
            'enrollments.student.person',
            'enrollments.progress'
        ])
            ->where('training_id', $id)
            ->where('teacher_id', $user->user_id)
            ->firstOrFail();

        $students = $training->enrollments;

        return view('teacher.courses.students', compact('training', 'students'));
    }

    public function attendance($id)
    {
        $user = auth()->user();

        $training = Training::with([
            'course',
            'enrollments.student.person'
        ])
            ->where('training_id', $id)
            ->where('teacher_id', $user->user_id)
            ->firstOrFail();

        $students = $training->enrollments;

        return view('teacher.attendance', compact('training', 'students'));
    }

    public function storeAttendance(Request $request)
    {
        $request->validate([
            'training_id' => 'required|exists:trainings,training_id',
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:users,user_id',
            'attendances.*.status' => 'required|in:P,A'
        ]);

        $user = auth()->user();

        // Validar que el training pertenezca al docente
        $training = Training::where('training_id', $request->training_id)
            ->where('teacher_id', $user->user_id)
            ->first();

        if (!$training) {
            abort(403, 'No autorizado: Este training no te pertenece.');
        }

        // Obtener IDs de estudiantes inscritos
        $enrolledStudentIds = $training->enrollments->pluck('student_id')->toArray();

        DB::transaction(function () use ($request, $enrolledStudentIds) {
            $date = now()->toDateString();

            foreach ($request->attendances as $attendance) {
                // Validar que el estudiante esté inscrito
                if (!in_array($attendance['student_id'], $enrolledStudentIds)) {
                    continue; // O lanzar error, pero por simplicidad, ignorar
                }

                Attendance::updateOrCreate(
                    [
                        'training_id' => $request->training_id,
                        'student_id' => $attendance['student_id'],
                        'date' => $date
                    ],
                    [
                        'status' => $attendance['status']
                    ]
                );
            }
        });

        return redirect()->back()->with('success', 'Asistencia registrada correctamente.');
    }
}