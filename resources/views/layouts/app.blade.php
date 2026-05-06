<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Systematic LMS')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- Custom -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    {{-- NAVBAR --}}
    @include('components.navbar')

    <div class="flex-grow-1" style="padding-top: 70px;">

        <div class="container-fluid">
            <div class="row g-0">

                {{-- SIDEBAR DESKTOP --}}
                @auth
                    @unless(View::hasSection('noSidebar'))
                        <aside class="col-lg-2 d-none d-lg-block bg-white border-end">
                            <div class="h-100 p-3">
                                @include('components.sidebar')
                            </div>
                        </aside>
                    @endunless
                @endauth

                {{-- CONTENIDO --}}
                <main class="@auth @unless(View::hasSection('noSidebar')) col-lg-10 @endunless @endauth col-12 p-4">

                    {{-- ALERTAS --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @yield('content')

                </main>

            </div>
        </div>

    </div>

    {{-- FOOTER --}}
    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>