@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="d-flex justify-content-between mb-3">
            <h2>Cursos (Admin)</h2>

            <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
                + Crear curso
            </a>
        </div>

        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($courses as $course)
                    <tr>
                        <td>{{ $course->course_id }}</td>
                        <td>{{ $course->title }}</td>
                        <td>S/ {{ $course->reference_price }}</td>

                        <td class="d-flex gap-2">

                            <a href="{{ route('admin.courses.edit', $course->course_id) }}" class="btn btn-sm btn-warning">
                                Editar
                            </a>

                            <form method="POST" action="{{ route('admin.courses.destroy', $course->course_id) }}">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger">
                                    Eliminar
                                </button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

    </div>

@endsection