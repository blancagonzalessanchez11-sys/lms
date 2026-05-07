@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">Mis Capacitaciones</h1>
        <p class="text-gray-600 mt-2">Accede a tus cursos y gestiona tus estudiantes</p>
    </div>

    <!-- Courses Grid -->
    @if($trainings->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($trainings as $training)
                <a href="{{ route('teacher.courses.show', $training->training_id) }}" class="group">
                    <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden h-full flex flex-col">
                        
                        <!-- Color Header (based on course) -->
                        <div class="h-32 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                            <div class="text-5xl font-bold text-white opacity-80">
                                {{ strtoupper(substr($training->course->title, 0, 1)) }}
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 flex-grow flex flex-col justify-between">
                            <!-- Course Info -->
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                    {{ $training->course->title }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    Código: <span class="font-semibold text-gray-700">{{ $training->course->code ?? 'N/A' }}</span>
                                </p>
                            </div>

                            <!-- Stats -->
                            <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-2 gap-4">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-blue-600">
                                        {{ $training->enrollments->count() }}
                                    </div>
                                    <p class="text-xs text-gray-600">Alumnos</p>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-green-600">
                                        {{ ucfirst($training->modality) }}
                                    </div>
                                    <p class="text-xs text-gray-600">Modalidad</p>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <div class="mt-4">
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                    ✓ Activo
                                </span>
                            </div>
                        </div>

                        <!-- Footer Arrow -->
                        <div class="px-6 py-4 bg-gray-50 flex justify-end group-hover:bg-blue-50 transition-colors">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition-colors transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m0 0h6M6 12a6 6 0 100-12 6 6 0 000 12z"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No hay capacitaciones</h3>
            <p class="mt-2 text-sm text-gray-600">
                No tienes cursos asignados aún. Contacta con el administrador.
            </p>
        </div>
    @endif
</div>
@endsection