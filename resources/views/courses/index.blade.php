@extends('layouts.app')

@section('content')

    <div class="container">
        <h2>Cursos</h2>

        <ul>
            @foreach($courses as $course)
                <li>{{ $course->title }} - S/. {{ $course->reference_price }}</li>
            @endforeach
        </ul>
    </div>

@endsection