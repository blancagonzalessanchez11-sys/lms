@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb-3">
            <h2>Lista de Estudiantes</h2>
        </div>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Iniciales</th>
                    <th>Progreso</th>
                    <th>Última participación</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->person->first_names ?? 'Sin nombre' }} {{ $user->person->last_names ?? '' }}</td>
                        <td>
                            <div class="avatar-circle rounded-circle bg-avatar-{{ ($loop->index % 4) + 1 }}">
                                {{ strtoupper(substr($user->person->first_names ?? 'S', 0, 1) . substr($user->person->last_names ?? 'N', 0, 1)) }}
                            </div>
                        </td>
                        <td>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-info progress-bar-striped" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td>{{ $user->updated_at ? $user->updated_at->diffForHumans() : 'Nunca' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $users->links() }}
    </div>
@endsection