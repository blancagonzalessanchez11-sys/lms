@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-gray-100">
    
    <!-- Sidebar Navigation -->
    <div class="w-64 bg-white shadow-lg">
        <div class="p-6 border-b border-gray-200">
            <a href="{{ route('teacher.courses') }}" class="flex items-center text-gray-600 hover:text-gray-900 mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span class="text-sm">Volver a Cursos</span>
            </a>
            <h2 class="text-xl font-bold text-gray-900 mt-4">{{ $training->course->title }}</h2>
            <p class="text-xs text-gray-600 mt-1">Código: {{ $training->course->code ?? 'N/A' }}</p>
        </div>

        <!-- Navigation Menu -->
        <nav class="mt-6">
            <a href="{{ route('teacher.courses.show', $training->training_id) }}?tab=inicio" 
               class="nav-link px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 border-l-4 border-transparent transition-all @if(request('tab', 'inicio') === 'inicio') border-blue-600 bg-blue-50 text-blue-600 @endif">
                <svg class="w-5 h-5 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l9-8m0 0h3m-3 0v3"></path>
                </svg>
                Inicio
            </a>

            <a href="{{ route('teacher.courses.show', $training->training_id) }}?tab=estudiantes" 
               class="nav-link px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 border-l-4 border-transparent transition-all @if(request('tab') === 'estudiantes') border-blue-600 bg-blue-50 text-blue-600 @endif">
                <svg class="w-5 h-5 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 12H9m6 0a6 6 0 11-12 0 6 6 0 0112 0z"></path>
                </svg>
                Estudiantes
            </a>

            <a href="{{ route('teacher.courses.show', $training->training_id) }}?tab=asistencias" 
               class="nav-link px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 border-l-4 border-transparent transition-all @if(request('tab') === 'asistencias') border-blue-600 bg-blue-50 text-blue-600 @endif">
                <svg class="w-5 h-5 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Asistencias
            </a>

            <a href="{{ route('teacher.courses.show', $training->training_id) }}?tab=contenido" 
               class="nav-link px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 border-l-4 border-transparent transition-all @if(request('tab') === 'contenido') border-blue-600 bg-blue-50 text-blue-600 @endif">
                <svg class="w-5 h-5 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                </svg>
                Contenido/Tareas
            </a>

            <a href="{{ route('teacher.courses.show', $training->training_id) }}?tab=calificaciones" 
               class="nav-link px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 border-l-4 border-transparent transition-all @if(request('tab') === 'calificaciones') border-blue-600 bg-blue-50 text-blue-600 @endif">
                <svg class="w-5 h-5 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Calificaciones
            </a>
        </nav>

        <!-- Quick Stats -->
        <div class="mt-8 px-6 py-6 border-t border-gray-200 bg-gray-50 rounded-lg mx-4">
            <h3 class="text-xs font-bold text-gray-600 uppercase mb-4">Estadísticas Rápidas</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalStudents }}</p>
                    <p class="text-xs text-gray-600">Estudiantes</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-green-600">{{ $totalAssessments }}</p>
                    <p class="text-xs text-gray-600">Tareas/Evaluaciones</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-purple-600">{{ $totalAttendanceRecords }}</p>
                    <p class="text-xs text-gray-600">Registros de Asistencia</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <div class="p-8">
            
            <!-- Inicio / Dashboard -->
            @if(request('tab', 'inicio') === 'inicio')
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Panel del Curso</h1>
                    
                    <!-- Quick Actions -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <a href="{{ route('teacher.attendance', $training->training_id) }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow border-l-4 border-blue-500">
                            <h3 class="font-bold text-gray-900 mb-2">Registrar Asistencia</h3>
                            <p class="text-sm text-gray-600">Marca la asistencia de tus estudiantes</p>
                        </a>
                        
                        <a href="{{ route('teacher.tasks.create', $training->training_id) }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow border-l-4 border-green-500">
                            <h3 class="font-bold text-gray-900 mb-2">Crear Tarea</h3>
                            <p class="text-sm text-gray-600">Asigna una nueva tarea o evaluación</p>
                        </a>

                        <a href="{{ route('teacher.students', $training->training_id) }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow border-l-4 border-purple-500">
                            <h3 class="font-bold text-gray-900 mb-2">Ver Estudiantes</h3>
                            <p class="text-sm text-gray-600">Consulta la lista completa de estudiantes</p>
                        </a>

                        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-orange-500">
                            <h3 class="font-bold text-gray-900 mb-2">Información del Curso</h3>
                            <p class="text-sm text-gray-600">
                                <strong>Modalidad:</strong> {{ ucfirst($training->modality) }}<br>
                                <strong>Estado:</strong> <span class="text-green-600">Activo</span><br>
                                <strong>Estudiantes:</strong> {{ $totalStudents }}
                            </p>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Actividad Reciente</h2>
                        <p class="text-gray-600 text-sm">La información de actividad reciente se mostrará aquí.</p>
                    </div>
                </div>

            <!-- Estudiantes -->
            @elseif(request('tab') === 'estudiantes')
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Estudiantes Matriculados ({{ $totalStudents }})</h1>
                    
                    @if($training->enrollments->count() > 0)
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Nombre</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">DNI</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Teléfono</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($training->enrollments as $enrollment)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $enrollment->student->person->first_names }} {{ $enrollment->student->person->last_names }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-600">{{ $enrollment->student->person->document_number }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-600">{{ $enrollment->student->person->email }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-600">{{ $enrollment->student->person->phone }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-white rounded-lg shadow p-8 text-center">
                            <p class="text-gray-600">No hay estudiantes matriculados en este curso aún.</p>
                        </div>
                    @endif
                </div>

            <!-- Asistencias -->
            @elseif(request('tab') === 'asistencias')
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Registro de Asistencias</h1>
                    
                    <div class="bg-white rounded-lg shadow p-6">
                        <a href="{{ route('teacher.attendance', $training->training_id) }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                            Ir a Registro de Asistencias
                        </a>
                        <p class="text-gray-600 text-sm mt-4">Total de registros: {{ $totalAttendanceRecords }}</p>
                    </div>
                </div>

            <!-- Contenido/Tareas -->
            @elseif(request('tab') === 'contenido')
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Contenido y Tareas</h1>
                    
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <a href="{{ route('teacher.tasks.create', $training->training_id) }}" class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
                            + Crear Nueva Tarea
                        </a>
                    </div>

                    @if($training->assessments->count() > 0)
                        <div class="grid grid-cols-1 gap-6">
                            @foreach($training->assessments as $assessment)
                                <div class="bg-white rounded-lg shadow p-6">
                                    <h3 class="text-lg font-bold text-gray-900">{{ $assessment->title }}</h3>
                                    <p class="text-sm text-gray-600 mt-2">{{ $assessment->description }}</p>
                                    <div class="mt-4 flex justify-between text-xs text-gray-600">
                                        <span>Vencimiento: {{ $assessment->end_date->format('d/m/Y') }}</span>
                                        <span class="text-green-600">{{ $assessment->active ? 'Activa' : 'Inactiva' }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white rounded-lg shadow p-8 text-center">
                            <p class="text-gray-600">No hay tareas creadas aún. Crea una nueva tarea.</p>
                        </div>
                    @endif
                </div>

            <!-- Calificaciones -->
            @elseif(request('tab') === 'calificaciones')
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Calificaciones</h1>
                    
                    <div class="bg-white rounded-lg shadow p-8 text-center">
                        <p class="text-gray-600">El módulo de calificaciones estará disponible pronto.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>

</div>
@endsection
