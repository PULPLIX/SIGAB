@extends('layouts.app')

@section('titulo')
Registrar actividad interna
@endsection

@section('css')

@endsection

@section('scripts')
{{-- Link al script de registro de actividades internas --}}
<script src="{{ asset('js/control_actividades_internas/registrar.js') }}" defer></script>
@endsection

@section('contenido')

<div class="card">
    <div class="card-body">
        <h2>Registrar una actividad de tipo interna</h2>
        <hr>
        {{-- Formulario para registrar informacion del estudiante --}}
        <form action="/actividad-interna" method="POST" enctype="multipart/form-data" id="actividad-interna">
            @csrf


            {{-- Mensaje de exito (solo se muestra si ha sido exitoso el registro) --}}
            @if(Session::has('mensaje'))
            <div class="alert alert-success" role="alert">
                {!! \Session::get('mensaje') !!}
            </div>
            @endif

            {{-- Mensaje de error (solo se muestra si ha sido ocurrio algun error en la insercion) --}}
            @php
            $error = Session::get('error');
            @endphp

            @if(Session::has('error'))
            <div class="alert alert-danger" role="alert">
                {{ "¡Oops! Algo ocurrió. ".$error }}
            </div>
            @endif

            {{-- Mensaje de que muestra el objeto insertado
                    (solo se muestra si ha sido exitoso el registro)  --}}
            @if(Session::has('actividad_interna_insertada'))
            <div class="alert alert-dark" role="alert">

                @php
                //Se obtiene la actividad
                $actividad_insertada = Session::get('actividad_insertada');
                //Se obtiene actividad interna
                $actividad_interna_insertada = Session::get('actividad_interna_insertada');
                @endphp
                {{-- //Datos de la actividad a mostrar en el mensaje de exito --}}
                Se insertó la actividad interna con lo siguientes datos: <br> <br>
                <div class="row">
                    <div class="col-6 text-justify">
                        <b>ID de actividad: </b> {{$actividad_insertada->id}} <br>
                        <b>Tema: </b> {{$actividad_insertada->tema}} <br>
                        <b>Lugar: </b> {{$actividad_insertada->lugar ?? "No se digitó"}} <br>
                        <b>Estado: </b> {{$actividad_insertada->estado}} <br>
                        <b>Fecha de inicio actividad: </b> {{$actividad_insertada->fecha_inicio_actividad}} <br>
                        <b>Fecha de cierre actividad: </b> {{$actividad_insertada->fecha_final_actividad}} <br>
                        <b>Descripción: </b> {{$actividad_insertada->descripcion}} <br>
                        <b>Evaluación: </b> {{$actividad_insertada->evaluacion}} <br>
                        <b>Objetivos: </b> {{$actividad_insertada->objetivos ?? "No se digitó" }} <br>
                        <b>Responsable de coordinar: </b> {{$actividad_insertada->responsable_coordinar}} <br>
                        <b>Tipo de actividad: </b> {{$actividad_interna_insertada->tipo_actividad}} <br>
                        <b>Propósito: </b> {{$actividad_interna_insertada->proposito}} <br>
                        <b>Facilitador: </b> {{$actividad_interna_insertada->facilitador_actividad ?? "No se digitó" }} <br>
                        <b>Agenda: </b> {{$actividad_interna_insertada->agenda ?? "No se digitó"}} <br>
                        <b>Ámbito: </b> {{$actividad_interna_insertada->ambito}} <br>
                        <b>Certificación: </b> {{$actividad_interna_insertada->certificacion_actividad ?? "No se digitó"}} <br>
                        <b>Público dirigido: </b> {{$actividad_interna_insertada->publico_dirigido}} <br>

                        {{-- Link directo al detalle de la actividad recien agregada --}}
                        <br>
                        <a clas="btn btn-rojo" href="#">
                            <input type="button" value="Editar" class="btn btn-rojo">
                        </a>
                        <br>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                {{-- Campos de la izquierda --}}
                <div class="col">
                    {{-- Campo: Tema --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="tema">Tema <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="tema" name="tema" required>
                        </div>
                    </div>

                    {{-- Campo: Lugar --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="lugar">Lugar </label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="lugar" name="lugar">
                        </div>
                    </div>

                    {{-- Campo: Fecha de actividad--}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="fecha_actividad">Fecha y hora de inicio de actividad<i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='datetime-local' class="form-control w-100" id="fecha_inicio_actividad" name="fecha_inicio_actividad" required>
                        </div>
                    </div>
                    {{-- Campo: Fecha de actividad--}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="fecha_actividad">Fecha y hora final de actividad<i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='datetime-local' class="form-control w-100" id="fecha_final_actividad" name="fecha_final_actividad" required>
                        </div>
                    </div>

                    {{-- Campo: Estado --}}
                    <div class=" d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="estado">Estado <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" id="estado" name="estado" required>
                                <option value="Para ejecución">Para ejecución</option>
                                <option value="En progreso">En progreso</option>
                                <option value="Ejecutada">Ejecutada</option>
                            </select>
                        </div>
                    </div>


                    {{-- Campo: Objetivos --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="objetivos">Objetivos</label>
                        </div>
                        <div class="col-6">
                            <textarea type='text' class="form-control w-100" id="objetivos" name="objetivos"></textarea>
                        </div>
                    </div>

                    {{-- Campo: Responsable de coordinar --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="responsable_coordinar">Responsable de coordinar<i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <div class="alert alert-danger" role="alert" id="mensaje-alerta"></div>
                            <input type='text' id="cedula-responsable" class="form-control w-100">
                            <a class="btn btn-rojo" onclick="buscarResponsable()"> Buscar </a>
                            <input type='hidden' id="responsable_coordinar" name="responsable_coordinar" value="none">
                            <div id="informacion-responsable"></div>
                        </div>
                    </div>
                    {{-- Campo: Facilitador de actividad --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="facilitador_actividad">Facilitador de actividad<i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="facilitador_actividad" name="facilitador_actividad" max="45" required>
                        </div>
                    </div>


                </div>

                {{-- Campos de la derecha --}}
                <div class="col">
                    {{-- Campo: Proposito--}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="proposito">Propósito<i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" id="proposito" name="proposito" required>
                                <option value="Inducción">Inducción</option>
                                <option value="Capacitación">Capacitación</option>
                                <option value="Actualización">Actualización</option>
                                <option value="Involucramiento del personal">Involucramiento del personal</option>
                            </select>
                        </div>
                    </div>
                    {{-- Campo: Tipo de actividad --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="tipo_actividad">Tipo de actividad<i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" id="tipo_actividad" name="tipo_actividad" required>
                                <option value="Curso">Curso</option>
                                <option value="Conferencia">Conferencia</option>
                                <option value="Taller">Taller</option>
                                <option value="Seminario">Seminario</option>
                                <option value="Conversatorio">Conversatorio</option>
                                <option value="Órgano colegiado">Órgano colegiado</option>
                                <option value="Tutorías">Tutorías</option>
                                <option value="Lectorías">Lectorías</option>
                                <option value="Tribunales de prueba de grado">Tribunales de prueba de grado</option>
                                <option value="Tribunales de defensas públicas">Tribunales de defensas públicas</option>
                                <option value="Comisiones de trabajo">Comisiones de trabajo</option>
                                <option value="Externa">Externa</option>
                            </select>
                        </div>
                    </div>
                    {{-- Campo: Tipo de publico al que se dirige --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="publico_dirigido">Dirigido a <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" id="publico_dirigido" name="publico_dirigido" required>
                                <option value="Estudiantes">Estudiantes</option>
                                <option value="Graduados">Graduados</option>
                                <option value="Académicos">Académicos</option>
                                <option value="Docentes">Docentes</option>
                                <option value="Personal Administrativo">Personal Administrativo</option>
                            </select>
                        </div>
                    </div>
                    {{-- Campo: Descripción --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="descripcion">Descripción <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <textarea type='text' class="form-control w-100" id="descripcion" name="descripcion" required></textarea>
                        </div>
                    </div>
                    {{-- Campo: Certificacion --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="certificacion">Certificación</label>
                        </div>
                        <div class="col-6">
                            <input class="form-control w-100" type='text' name="certificacion_actividad" id="certificacion_actividad" max="100">
                        </div>
                    </div>


                    {{-- Campo: Agenda --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="agenda">Agenda </label>
                        </div>
                        <div class="col-6">
                            <textarea class="form-control w-100" id="agenda" name="agenda"></textarea>
                        </div>
                    </div>

                    {{-- Campo: Ambito --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="ambito">Ámbito<i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" id="ambito" name="ambito" required>
                                <option value="Nacional">Nacional</option>
                                <option value="Internacional">Internacional</option>
                            </select>
                        </div>
                    </div>
                    {{-- Campo: Evaluacion --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="evaluacion">Evaluación</label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="evaluacion" name="evaluacion">
                        </div>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-center">
                {{-- Boton para agregar informacion de la actividad --}}
                <a class="btn btn-rojo btn-lg" onclick="submit()">Agregar</a>
            </div>

        </form>
    </div>
</div>

@endsection

@section('pie')
Copyright
@endsection
