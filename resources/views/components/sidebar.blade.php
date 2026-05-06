@php
    $role = optional(auth()->user()->roles->first())->name;
@endphp

<div class="sidebar-content d-flex flex-column h-100 p-3">

    <span class="badge bg-secondary mb-3">
        Rol: {{ $role }}
    </span>

    @if($role === 'Administrator')
        @include('components.sidebars.admin')

    @elseif($role === 'Teacher')
        @include('components.sidebars.teacher')

    @elseif($role === 'Student')
        @include('components.sidebars.student')
    @endif

</div>