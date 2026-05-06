<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Training;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function store($trainingId)
    {
        // Validar que training exista
        $training = Training::findOrFail($trainingId);

        $user = Auth::user();

        // 🚨 evitar duplicados
        $exists = Enrollment::where('student_id', $user->user_id)
            ->where('training_id', $trainingId)
            ->first();

        if ($exists) {
            return back()->with('error', 'Ya estás inscrito en este curso');
        }

        Enrollment::create([
            'training_id' => $trainingId,
            'student_id' => $user->user_id,
            'administrator_id' => 1,
            'enrollment_date' => now()->toDateString(),
            'status' => 'A'
        ]);

        return back()->with('success', 'Inscripción exitosa');
    }
}