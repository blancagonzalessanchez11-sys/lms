@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="d-flex justify-content-between mb-3">
            <h2>Mis cursos</h2>

        </div>

        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Precio</th>
                    <th>Horas</th>
                </tr>
            </thead>

            <tbody>
                @forelse($courses as $course)
                        <tr data-id="{{ $course->course_id }}">
                            <td>{{ $course->course_id }}</td>
                            <td>{{ $course->title }}</td>

                            <td>
                                {{ $course->reference_price
                    ? 'S/ ' . number_format($course->reference_price, 2)
                    : '—' 
                        }}
                            </td>

                            <td>{{ $course->hours_count ?? '—' }}</td>
                        </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            No tienes cursos asignados aún
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

@endsection