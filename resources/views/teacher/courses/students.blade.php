@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <h2>
            Estudiantes del curso: {{ $training->course->title }}
        </h2>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $enrollment)
                    <tr>
                        <td>
                            {{ $enrollment->student->person->first_names }}
                            {{ $enrollment->student->person->last_names }}
                        </td>
                        <td>
                            {{ $enrollment->student->person->email }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">No hay estudiantes inscritos</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection