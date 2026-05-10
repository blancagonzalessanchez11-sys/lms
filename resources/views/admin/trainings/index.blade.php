@extends('layouts.app')

@section('content')

    <div class="container-fluid px-4 py-1">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-4 text-gray-800">Capacitaciones</h1>
            </div>
            <button class="btn btn-primary" data-toggle="modal" data-target="#createTrainingModal"
                    data-backdrop="static" data-keyboard="false">
                + Crear capacitación
            </button>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="align-middle"></th>
                                <th class="align-middle">Capacitación</th>
                                <th class="align-middle">Detalles</th>
                                <th class="align-middle">Estado</th>
                                <th class="align-middle text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($trainings as $training)
                                <tr>
                                    <td class="align-middle pe-3">
                                        <div class="avatar-circle rounded-circle bg-avatar-{{ ($loop->index % 4) + 1 }}">
                                            {{ strtoupper(substr(optional($training->course)->title ?? 'C', 0, 1)) }}
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="fw-bold">{{ optional($training->course)->title ?? 'Sin curso' }}</div>
                                        <div class="text-muted small">
                                            {{ optional($training->teacher->person)->first_names ?? 'Sin nombre' }}</div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="text-muted small">
                                            Modalidad: {{ ucfirst($training->modality) }}<br>
                                            Precio: S/ {{ number_format($training->price, 2) }}
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        @php
                                            $badgeClass = match ($training->modality) {
                                                'virtual' => 'bg-primary',
                                                'presential' => 'bg-success',
                                                'hybrid' => 'bg-warning text-dark',
                                                default => 'bg-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ ucfirst($training->modality) }}</span>
                                    </td>
                                    <td class="align-middle text-end">
                                        <button class="btn btn-sm btn-warning edit-btn" data-id="{{ $training->training_id }}"
                                            data-course="{{ $training->course_id }}" data-teacher="{{ $training->teacher_id }}"
                                            data-modality="{{ $training->modality }}" data-price="{{ $training->price }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger"
                                            onclick="confirmDelete('{{ route('admin.trainings.destroy', $training->training_id) }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No hay capacitaciones activas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="createTrainingModal" tabindex="-1" role="dialog"
             aria-labelledby="createTrainingModalLabel" aria-hidden="true"
             data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-3">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold" id="createTrainingModalLabel">Crear Capacitación</h5>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('admin.trainings.store') }}" id="createTrainingForm">
                            @csrf
                            <div class="mb-3">
                                <label for="course_id" class="form-label">Curso</label>
                                <select name="course_id" id="course_id" class="form-control" required>
                                    <option value="">Seleccionar curso</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->course_id }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="teacher_id" class="form-label">Docente</label>
                                <select name="teacher_id" id="teacher_id" class="form-control" required>
                                    <option value="">Seleccionar docente</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->user_id }}">
                                            {{ $teacher->person->first_names ?? 'Sin nombre' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="modality" class="form-label">Modalidad</label>
                                <select name="modality" id="modality" class="form-control" required>
                                    <option value="virtual">Virtual</option>
                                    <option value="presential">Presencial</option>
                                    <option value="hybrid">Híbrida</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Precio</label>
                                <input type="number" name="price" id="price" class="form-control" step="0.01" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer border-0 bg-light rounded-bottom-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" form="createTrainingForm" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
             aria-labelledby="editModalLabel" aria-hidden="true"
             data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-3">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold" id="editModalLabel">Editar Capacitación</h5>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="edit_course_id" class="form-label">Curso</label>
                                <select name="course_id" id="edit_course_id" class="form-control" required>
                                    <option value="">Seleccionar curso</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->course_id }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_teacher_id" class="form-label">Docente</label>
                                <select name="teacher_id" id="edit_teacher_id" class="form-control" required>
                                    <option value="">Seleccionar docente</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->user_id }}">
                                            {{ $teacher->person->first_names ?? 'Sin nombre' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_modality" class="form-label">Modalidad</label>
                                <select name="modality" id="edit_modality" class="form-control" required>
                                    <option value="virtual">Virtual</option>
                                    <option value="presential">Presencial</option>
                                    <option value="hybrid">Híbrida</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_price" class="form-label">Precio</label>
                                <input type="number" name="price" id="edit_price" class="form-control" step="0.01" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer border-0 bg-light rounded-bottom-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" form="editForm" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const course = this.getAttribute('data-course');
                const teacher = this.getAttribute('data-teacher');
                const modality = this.getAttribute('data-modality');
                const price = this.getAttribute('data-price');

                document.getElementById('edit_course_id').value = course;
                document.getElementById('edit_teacher_id').value = teacher;
                document.getElementById('edit_modality').value = modality;
                document.getElementById('edit_price').value = price;

                document.getElementById('editForm').action = `/admin/trainings/${id}`;

                new bootstrap.Modal(document.getElementById('editModal'), {
                    backdrop: 'static',
                    keyboard: false
                }).show();
            });
        });

        function confirmDelete(url) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;
                    form.innerHTML = '@csrf @method("DELETE")';
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection