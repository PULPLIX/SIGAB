@extends('layouts.app')

@section('titulo')
Registrar curso
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('contenido')
<div class="card">
    <div class="card-body pb-5">
        <div class="d-flex justify-content-between">
            <h2>Detalle curso</h2>
            <div>
                @if(Accesos::ACCESO_LISTAR_ESTUDIANTES())
                <div><a href="{{ route('listado-estudiantil') }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Volver al listado </a></div>
                @endif
            </div>
        </div>
        <hr>

        @if(Accesos::ACCESO_REGISTRAR_ESTUDIANTES())
        {{-- Formulario para registrar informacion del estudiante --}}
        <form action="{{ route('estudiante.store') }}" autocomplete="off" method="POST" enctype="multipart/form-data" id="estudiante" onsubmit="activarLoader('Agregando Estudiante');">
            @csrf
            @endif
            {{-- Alerts --}}
            @include('layouts.messages.alerts')

            {{-- Mensaje de que muestra el objeto insertado (solo se muestra si ha sido exitoso el registro)  --}}
            @if(isset($estudiante_insertado))
            <div class="alert alert-dark" role="alert">
                Se registró el estudiante con lo siguientes datos: <br> <br>
                <div class="row">
                    <div class="col-6 text-justify">
                        {{-- <b>Cédula:</b> {{ $persona_insertada->persona_id }} <br>
                        <b>Nombre/s:</b> {{ $persona_insertada->nombre }} <br>
                        <b>Apellido/s:</b> {{ $persona_insertada->apellido }} <br>
                        <b>Cantidad de hijos:</b> {{ $estudiante_insertado->cant_hijos ?? "No se digitó" }} <br> --}}
                        {{-- Link directo al estudiante recien agregado --}}
                        {{-- <br>
                    <a clas="btn btn-rojo" href="{{ route('estudiante.show', $estudiante_insertado->persona_id) }}">
                        <input type="button" @if(Accesos::ACCESO_MODIFICAR_ESTUDIANTES()) value="Editar" @else value="Detalle" @endif class="btn btn-rojo">
                        </a>
                        <br> --}}
                    </div>
                </div>
                <div class="h3 mb-5 mt-4 mx-3">Agregar un nuevo curso:</div>
                @endif
                {{-- INICIO DE LA SECCION DE REGISTRO --}}
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-9">

                        <div class="card">
                            <div class="card-header">
                                <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">Información general </p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 d-flex justify-content-center align-items-center border-right">
                                        <img src="{{ asset('img/logoEBDI.png') }}" class="w-75" id="logo-EBDI" alt="logo_ebdi">
                                    </div>
                                    <div class="col-9 d-flex flex-column">
                                        <div class="d-flex justify-content-center w-100">
                                            <div class="input-group px-2 mb-3 w-100 ml-1 pl-3">
                                                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre del curso"  required disabled>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" data-toggle="tooltip" data-placement="top" title="Nombre con el que quiere guardar el curso"><i class="far fa-edit texto-azul-una"></i></span>
                                                </div>
                                                <span class="ml-1 text-muted d-flex align-items-center" id="mostrar_nombre"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center w-100">
                                            <div class="input-group px-2 mb-3 w-75 ml-1 pl-3">
                                                <input type="text" id="codigo" name="codigo" class="form-control" placeholder="Código de curso" onkeydown="contarCaracteres(this,15)" required disabled>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" data-toggle="tooltip" data-placement="top" title="Código de curso"><i class="far fa-edit texto-azul-una"></i></span>
                                                </div>
                                                <span class="ml-1 text-muted d-flex align-items-center" id="mostrar_codigo"></span>
                                            </div>
                                            <div class="input-group px-2 mb-3 w-75 ml-1 pl-3">
                                                <input type="text" id="nrc" name="nrc" aria-label="NRC" class="form-control" placeholder="NRC"  required disabled>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" data-toggle="tooltip" data-placement="top" title="NRC del curso"><i class="far fa-edit texto-azul-una"></i></span>
                                                </div>
                                                <span class="ml-1 text-muted d-flex align-items-center" id="mostrar_nrc"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center w-100 mt-auto">
                                            <button class="btn btn-rojo ml-3" type="submit" onclick="activarLoader('Guardando datos');"><i class="fas fa-save"></i> &nbsp; Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    @endsection

    @section('scripts')
    <script src="{{ asset('js/global/mensajes.js') }}"></script>
    <script src="{{ asset('js/global/contarCaracteres.js') }}"></script>
    @endsection
