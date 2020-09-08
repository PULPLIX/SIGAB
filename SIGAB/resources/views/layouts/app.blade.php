<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('titulo')</title>

    <!-- Hojas de estilo individuales -->
    @yield('css')

    <!-- Hojas de estilo globales -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plantilla/global.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plantilla/layout.css') }}" rel="stylesheet">

    <!-- Scripts globales -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

</head>

<body>
    <div class="wrapper bg-gris-claro">
        <!-- Sidebar  -->
        <nav id="sidebar" class="bg-rojo-oscuro">
            <div class="sidebar-header bg-rojo-oscuro">

                <h3 class="text-center titulo"> SIGAB</h3>




                <strong class="short">SIGAB</strong>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="#controlEstudiantil" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle link-drop-sidebar">

                        <i class="fas fa-graduation-cap"></i>
                        Control Estudiantil
                    </a>
                    <ul class="collapse list-unstyled" id="controlEstudiantil">

                        <li>
                            <a href="#">Añadir estudiante</a>
                        </li>
                        <li>
                            <a href="#">Listar estudiantes</a>
                        </li>
                        <li>
                            <a href="#">Listar Guías adémicas</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#controlPersonal" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle link-drop-sidebar">

                        <i class="far fa-address-book"></i>
                        Control de personal
                    </a>
                    <ul class="collapse list-unstyled" id="controlPersonal">
                        <li>
                            <a href="#">Añadir personal</a>
                        </li>
                        <li>
                            <a href="#">Listar Personal</a>
                        </li>
                    </ul>
                </li>
            </ul>

        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-rojo">
                        <i class="fas fa-align-left"></i>
                        <span>Menú</span>
                    </button>
                    <img src="img/login/logo.jpg" alt="logo_ebdi" class="logo border-left border-secondary">

                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse " id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto ">

                            <li class="nav-item active">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle border-left border-secondary px-4" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    {{ Auth::user()->persona_id }}

                                </a>
                                <div class="dropdown-menu dropdown-menu-right " aria-labelledby="navbarDropdown">


                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user"></i> &nbsp; Mi perfil

                                    </a>
                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-in-alt"></i> &nbsp; Salir

                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>

                            </li>

                        </ul>
                    </div>
                </div>
            </nav>
            <div class="card">
                <div class="card-body">
                    @yield('contenido')
                </div>
            </div>
        </div>
    </div>

    @yield('scripts')
    <script src="https://kit.fontawesome.com/39f4ebbbea.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });
        });

    </script>
</body>

</html>