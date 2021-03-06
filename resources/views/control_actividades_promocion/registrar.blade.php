@extends('layouts.app')

@section('titulo')
Registrar actividad de promocion
@endsection

@section('css')
<style>
    input[type=time]::-webkit-datetime-edit-ampm-field {
        display: none;
    }

</style>
@endsection

{{-- Arreglos de opciones de los select utilizados --}}
@php
$tiposActividad = GlobalArrays::TIPOS_ACTIVIDAD_PROMOCION;
$estados = GlobalArrays::ESTADOS_ACTIVIDAD;
@endphp

@section('contenido')

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h3>Registrar una actividad de promoción de la carrera</h3>
            @if(Accesos::ACCESO_LISTAR_ACTIVIDADES())
            <div>
                <a href="{{ route('actividad-promocion.listado' ) }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Volver al listado  </a>
            </div>
            @endif
        </div>
        <hr>
        @if(Accesos::ACCESO_REGISTRAR_ACTIVIDADES())
        {{-- Formulario para registrar informacion de la actividad --}}
        <form autocomplete="off" action="{{ route('actividad-promocion.store') }}" method="POST" enctype="multipart/form-data" id="form-guardar">
            @csrf
            @endif
            {{-- Mensajes para la validación de errores  --}}
            <div class="mensaje-container" id="mensaje-error" style="display:none;">
                <div class="col-3 icono-mensaje d-flex align-items-center" id="icono-mensaje" style=" background-image: url('/img/recursos/iconos/error.png');"></div>
                <div class="col-9 texto-mensaje d-flex align-items-center text-center" id="texto-mensaje" style="color: #b30808e8; "> </div>
            </div>
            {{-- Alerts --}}
            @include('layouts.messages.alerts')

            {{-- Mensaje de que muestra el objeto insertado
                    (solo se muestra si ha sido exitoso el registro)  --}}
            @if(Session::has('actividad_promocion_insertada'))
            <div class="alert alert-dark" role="alert">

                @php
                //Se obtiene la actividad
                $actividad_insertada = Session::get('actividad_insertada');
                //Se obtiene actividad promocion
                $actividad_promocion_insertada = Session::get('actividad_promocion_insertada');
                @endphp
                {{-- //Datos ingresados de la actividad a mostrar en el mensaje de exito --}}
                Se registró la actividad de promoción de la carrera con lo siguientes datos: <br> <br>
                <div class="row">
                    <div class="col-6 text-justify">
                        <b>Código: </b> {{$actividad_insertada->id}} <br>
                        <b>Tema: </b> {{$actividad_insertada->tema}} <br>
                        <b>Lugar: </b> {{$actividad_insertada->lugar ?? "No se digitó"}} <br>
                        <b>Estado: </b> {{$actividad_insertada->estado}} <br>
                        <b>Fecha de inicio actividad: </b> {{$actividad_insertada->fecha_inicio_actividad}} <br>
                        <b>Fecha de cierre actividad: </b> {{$actividad_insertada->fecha_final_actividad}} <br>
                        <b>Descripción: </b> {{$actividad_insertada->descripcion ?? "No se digitó"}} <br>
                        {{-- Link directo al detalle de la actividad recien agregada --}}
                        <br>
                        <a clas="btn btn-rojo" href="{{ route('actividad-promocion.show',$actividad_insertada->id) }}">
                            <input type="button" @if(Accesos::ACCESO_MODIFICAR_ACTIVIDADES()) value="Editar" @else value="Detalle" @endif class="btn btn-rojo">
                        </a>
                        <br>
                    </div>

                    <div class="col-6 text-justify">
                        <b>Evaluación: </b> {{$actividad_insertada->evaluacion ?? "No se digitó"}} <br>
                        <b>Objetivos: </b> {{$actividad_insertada->objetivos ?? "No se digitó" }} <br>
                        <b>Responsable de coordinar: </b> {{$actividad_insertada->responsable_coordinar}} <br>
                        <b>Tipo de actividad: </b> {{$actividad_promocion_insertada->tipo_actividad}} <br>
                        <b>Instituciones Patrocinadoras: </b> {{$actividad_promocion_insertada->instituciones_patrocinadoras ?? "No se digitó"}} <br>
                        <b>Duración: </b> {{$actividad_insertada->duracion." h" ?? "No se digitó"}} <br>
                        <b>Recursos: </b> {{$actividad_promocion_insertada->recursos ?? "No se digitó"}} <br>
                    </div>
                </div>
            </div>

            <div class="h3 mb-5 mt-4 mx-3">Agregar una nueva actividad de promoción de la carrera:</div>

            @endif

            <div class="container-fluid w-100">
                {{-- Campos iniciales --}}
                <div class="row py-3 mt-4 border-bottom">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">Datos generales </p>
                            </div>

                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                {{-- Campo: Tema --}}
                                <div class="w-90">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text text-dark">Tema: <i class="text-danger">*</i></span>
                                        </div>
                                        <input type='text' class="form-control " id="tema" name="tema" onkeypress="contarCaracteres(this,100)" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text texto-azul-una" data-toggle="tooltip" data-placement="top" title="Tema o nombre de la actividad" class="mx-2"> <i class="far fa-question-circle fa-lg"></i></span>
                                        </div>
                                        <div class="d-flex justify-content-end align-items-center w-5">
                                            <span id="mostrar_tema"></span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Campo: LUGAR --}}
                                <div class="w-90">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text text-dark">Lugar: <i class="text-danger">*</i></span>
                                        </div>
                                        <input type='text' class="form-control" id="lugar" name="lugar" onkeypress="contarCaracteres(this,60)">
                                        <div class="input-group-append">
                                            <span class="input-group-text texto-azul-una" data-toggle="tooltip" data-placement="top" title="Lugar a realizar la actividad" class="mx-2"> <i class="far fa-question-circle fa-lg"></i></span>
                                        </div>
                                        <div class="d-flex justify-content-end align-items-center w-5">
                                            <span id="mostrar_lugar"></span>
                                        </div>
                                    </div>
                                </div>



                                {{-- Campo: TIPO DE ACTIVIDAD--}}
                                <div class="w-90">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text text-dark">Tipo de actividad: <i class="text-danger">*</i></span>
                                        </div>
                                        <select class="form-control" id="tipo_actividad" name="tipo_actividad" required>
                                            <option value="">Seleccione</option>
                                            @foreach($tiposActividad as $tipoActividad)
                                            <option value="{{ $tipoActividad }}"> {{ $tipoActividad }} </option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <span class="input-group-text texto-azul-una" data-toggle="tooltip" data-placement="top" title="Tipo de actividad de actividad" class="mx-2"> <i class="far fa-question-circle fa-lg"></i></span>
                                        </div>
                                        <div class=" w-5">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card ">
                            <div class="card-header">
                                <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">Características de la actividad </p>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-center align-items-center pb-4">

                                {{-- DURACIÓN --}}
                                <div class="w-90 d-flex justify-content-between">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text text-dark">Duración Total: </span>
                                        </div>
                                        <div class="w-50 mx-2">
                                            <input type="number" value="0" min="0" step="1" name="duracion" id="duracion" />
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text font-weight-bold font-italic"> h</span>
                                            <span class="input-group-text texto-azul-una" data-toggle="tooltip" data-placement="top" title="Se ingresa el número de horas totales de la duración de la actividad" class="mx-2"> <i class="far fa-question-circle fa-lg"></i></span>
                                        </div>
                                        <div class="w-5">
                                        </div>
                                    </div>
                                </div>
                                {{-- Campo: RANGO DE FECHAS --}}
                                <div class="w-90">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text text-dark">Fechas: <i class="text-danger">*</i></span>
                                        </div>
                                        <input type="text" class="form-control datetimepicker" name="rango_fechas" id="rango_fechas" placeholder="DD/MM/YYYY - DD/MM/YYYY" value="{{ $rango_fechas ?? null }}" required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-contorno-rojo" data-toggle="tooltip" data-placement="top" title="Vaciar el campo de fecha" onclick="eliminarFechas(this);"><i class="fas fa-calendar-times fa-lg"></i></button>
                                            <span class="input-group-text texto-azul-una" data-toggle="tooltip" data-placement="top" title="Fecha de inicio y fecha final en el que se ejecuta la actividad. Presione 'Apply' para insertar las fechas seleccionadas. De ser un único día, presion dos veces el día seleccionado y posteriormente 'Apply'. Para eliminar le fecha seleccionada presione 'Clear' " class="mx-2"> <i class="far fa-question-circle fa-lg"></i></span>
                                        </div>
                                        <div class=" w-5">
                                        </div>
                                    </div>
                                </div>
                                <div class="w-90">
                                    {{-- ESTADO --}}
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text text-dark">Estado: <i class="text-danger">*</i></span>
                                        </div>
                                        <select class="form-control" id="estado" name="estado" required>
                                            <option value="">Seleccione</option>
                                            @foreach($estados as $estado)
                                            <option value="{{ $estado }}"> {{ $estado }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                {{-- Cooordinador --}}
                <div class="row my-4 px-3">
                    <div class="card w-100">
                        <div class="card-header">
                            <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">Personal responsable </p>
                        </div>

                        <div class="card-body row justify-content-center align-items-center">
                            {{-- RESPONSABLE DE ACTIVIDAD --}}
                            <div class="col-7">
                                {{-- INPUT PARA REALIZAR LA BÚSQUEDA DEL RESPONSABLE --}}
                                <div class="row d-flex justify-content-center my-4">
                                    <div class="input-group w-90">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text textd-dark font-weight-bold"> Responsable de coordinar: <i class="text-danger">*</i> </span>
                                        </div>

                                        <input type='text' id="cedula-responsable" name="responsable_coordinar" class="form-control " required>
                                        <div class="input-group-append">
                                            <span class="input-group-text texto-azul-una" data-toggle="tooltip" data-placement="right" title="Ingrese sin espacio y sin guiones el número de cédula del responsable de coordinar la actividad y presione buscar"> <i class="far fa-question-circle fa-lg "></i></span>
                                            <button type="button" id="buscarCoordinador" class="btn btn-contorno-azul-una">Buscar</button>
                                        </div>
                                    </div>
                                    <input class="form-control" type='hidden' id="responsable-encontrado" name="responsable_encontrado" value="false">
                                </div>

                                {{-- MENSAJE DE ALERTA PARA MANEJO DE ERRORES --}}
                                <div class="row d-flex justify-content-center">
                                    <div class="alert alert-danger w-50 text-center" role="alert" id="alerta-responsable" style="display: none;"></div>
                                </div>
                                {{-- TARJETA CON LA INFORMACIÓN DEL RESPONSABLE --}}
                                <div class="row justify-content-center pb-3" id="responsable-info" style="display: none;">
                                    <div class="w-75 p-3 d-flex border-top justify-content-center">
                                        <div class="col-3 p-0">
                                            <div class="d-flex justify-content-center mb-2">
                                                <div class="overflow-hidden rounded " style="max-width: 160px; max-height: 160px; ">
                                                    <img class="rounded mb-3" id="imagen-responsable" style="max-width: 100%;  " />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-9  d-flex justify-content-start align-items-center ">
                                            <div class="d-flex w-100 justify-content-start align-items-center ">
                                                <div class="text-start mb-3">
                                                    <strong>Persona id:</strong> &nbsp;&nbsp;<span id="cedula-responsable-card"> </span> <br>
                                                    <strong>Nombre: </strong>&nbsp;&nbsp; <span id="nombre-responsable"> </span> <br>
                                                    <strong>Correo institucional: </strong> &nbsp;&nbsp;<span id="correo-responsable"> </span> <br>
                                                    <strong>Número de teléfono: </strong> &nbsp;&nbsp;<span id="num-telefono-responsable"></span> <br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="row">
                        {{-- Campo: Objetivos --}}
                        <div class="col">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="w-100">
                                    <div class="card shadow-sm rounded pb-2">
                                        <div class="card-header py-3">
                                            <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">
                                                <i class="far fa-file-alt fa-2x"></i> &nbsp;&nbsp
                                                Objetivos de la actividad &nbsp;&nbsp
                                                <span data-toggle="tooltip" data-placement="right" title="Se describen los objetivos de la actividad">
                                                    <i class="far fa-question-circle fa-lg"></i>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <textarea type='text' class="form-control w-100" id="objetivos" name="objetivos" rows="4"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        {{-- Campo: Descripción --}}
                        <div class="col">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="w-100">

                                    <div class="card shadow-sm rounded pb-2">
                                        <div class="card-header py-3">
                                            <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">
                                                <i class="fas fa-receipt fa-2x"></i> &nbsp;&nbsp
                                                Descripción &nbsp;&nbsp
                                                <span data-toggle="tooltip" data-placement="right" title="Descripción y detalles de la actividad. Se incluyen datos como: moderador, cantidad total de participantes, público meta (estudiantes, docentes, empleadores, entre otros), cantidad de publicaciones y seguidores en redes sociales.">
                                                    <i class="far fa-question-circle fa-lg"></i>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <textarea class="form-control w-100" id="descripcion" name="descripcion" rows="4"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Campo: Evaluacion --}}
                        <div class="col">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="w-100">
                                    <div class="card shadow-sm rounded pb-2">
                                        <div class="card-header py-3">
                                            <div class=" d-flex justify-content-between align-items-center">
                                                <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">
                                                    <i class="fas fa-user-edit fa-2x"></i> &nbsp;&nbsp
                                                    Evaluación &nbsp;&nbsp
                                                    <span data-toggle="tooltip" data-placement="right" title="Se ingresa una evaluación o comentario sobre la actividad">
                                                        <i class="far fa-question-circle fa-lg"></i>
                                                    </span>


                                                </p>
                                                <span class="text-muted" id="mostrar_evaluacion"></span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <textarea type='text' class="form-control w-100" id="evaluacion" name="evaluacion" rows="4" onkeypress="contarCaracteres(this,500)"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- Campo: Recursos --}}
                        <div class="col">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="w-100">
                                    <div class="card shadow-sm rounded pb-2">
                                        <div class="card-header py-3">
                                            <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">
                                                <i class="fas fa-pencil-ruler fa-2x"></i> &nbsp;&nbsp
                                                Recursos &nbsp;&nbsp
                                                <span data-toggle="tooltip" data-placement="right" title="Recursos necesarios para desarrollar la actividad ">
                                                    <i class="far fa-question-circle fa-lg"></i>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <textarea type='text' class="form-control w-100" id="recursos" name="recursos" rows="4" onkeypress="contarCaracteres(this,500)"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Campo: Instituciones patrocinadora --}}
                        <div class="col">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="w-100">
                                    <div class="card shadow-sm rounded pb-2">
                                        <div class="card-header py-3">
                                            <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">
                                                <i class="far fa-building fa-2x"></i> &nbsp;&nbsp
                                                Instituciones patrocinadoras &nbsp;&nbsp
                                                <span data-toggle="tooltip" data-placement="right" title="Se describen los puntos a tratar en la actividad">
                                                    <i class="far fa-question-circle fa-lg"></i>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <textarea type='text' class="form-control w-100" id="instituciones_patrocinadoras" name="instituciones_patrocinadoras" rows="4"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(Accesos::ACCESO_REGISTRAR_ACTIVIDADES())
                <div class="d-flex justify-content-center">
                    {{-- Boton para agregar informacion de la actividad --}}
                    <button type="submit" class="btn btn-rojo btn-lg mt-2" id="agregar-actividad">
                        @if(Accesos::ACCESO_AUTORIZAR_ACTIVIDAD())
                        <i class="fas fa-save"></i>&nbsp;Registrar actividad
                        @else
                        <i class="fas fa-lock"></i>&nbsp;Enviar actividad para autorización
                        @endif
                    </button>
                </div>
                @endif
            </div>
            @if(Accesos::ACCESO_REGISTRAR_ACTIVIDADES())
        </form>
        @endif
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Variables globales
    var fotosURL = "{{ URL::asset('img/fotos/') }}";

</script>
{{-- Link al script de registro de actividades promocion --}}
<script src="{{ asset('js/global/contarCaracteres.js') }}" defer></script>
<script src="{{ asset('js/control_actividades_internas/registrar.js') }}" defer></script>
<script src="{{ mix('js/bootstrap-input-spinner.js') }}"></script>
{{-- Scripts para modificar la forma en la que se ven los input de tipo number --}}
<script defer>
    $("input[type='number']").inputSpinner();
</script>
@endsection
