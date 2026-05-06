<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function store($trainingId)
    {
        $user = Auth::user();

        // 🚨 evitar duplicados
        $exists = Enrollment::where('student_id', $user->user_id)
            ->where('training_id', $trainingId)
            ->first();

        if ($exists) {
            return back()->with('error', 'Ya estás inscrito en este curso');
        }

        Enrollment::create([
            'student_id' => $user->user_id,
            'training_id' => $trainingId,
            'status' => 'in_progress'
        ]);

        return back()->with('success', 'Inscripción exitosa');
    }
}