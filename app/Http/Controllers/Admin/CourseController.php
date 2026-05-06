<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'reference_price' => 'nullable|numeric'
        ]);

        Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'reference_price' => $request->reference_price,
            'specialty_id' => $request->specialty_id ?? null,
            'hours_count' => $request->hours_count ?? 0
        ]);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Curso creado correctamente');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $course->update([
            'title' => $request->title,
            'description' => $request->description,
            'reference_price' => $request->reference_price
        ]);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Curso actualizado');
    }

    public function destroy($id)
    {
        Course::destroy($id);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Curso eliminado');
    }
}