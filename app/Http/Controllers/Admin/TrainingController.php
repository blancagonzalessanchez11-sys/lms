<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\Course;

class TrainingController extends Controller
{
    /**
     * Display a listing of trainings.
     */
    public function index()
    {
        $trainings = Training::with('course')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.trainings.index', compact('trainings'));
    }

    /**
     * Show the form for creating a new training.
     */
    public function create()
    {
        $courses = Course::all();

        return view('admin.trainings.create', compact('courses'));
    }

    /**
     * Store a newly created training in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,course_id',
            'teacher_id' => 'required|exists:users,user_id',
            'modality' => 'required|in:virtual,presential,hybrid',
            'price' => 'required|numeric|min:0.01',
        ]);

        Training::create([
            'course_id' => $request->course_id,
            'teacher_id' => $request->teacher_id,
            'administrator_id' => 1,
            'modality' => $request->modality,
            'price' => $request->price,
            'creation_date' => now()->toDateString(),
            'status' => 'A',
        ]);

        return redirect()
            ->route('admin.trainings.index')
            ->with('success', 'Training creado correctamente');
    }

    /**
     * Show the form for editing the specified training.
     */
    public function edit($id)
    {
        $training = Training::findOrFail($id);
        $courses = Course::all();

        return view('admin.trainings.edit', compact('training', 'courses'));
    }

    /**
     * Update the specified training in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,course_id',
            'description' => 'nullable|string',
        ]);

        $training = Training::findOrFail($id);

        $training->update([
            'title' => $request->title,
            'course_id' => $request->course_id,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('admin.trainings.index')
            ->with('success', 'Training actualizado correctamente');
    }

    /**
     * Remove the specified training from storage.
     */
    public function destroy($id)
    {
        $training = Training::findOrFail($id);
        $training->delete();

        return redirect()
            ->route('admin.trainings.index')
            ->with('success', 'Training eliminado correctamente');
    }
}