@extends('layouts.app')

@section('titulo')
Mis actividades
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('contenido')

<header class="page-header page-header-dark bg-red-polygon py-5 overflow-hidden">
    <div class="container py-3">
    </div>
</header>

<div class="container-fluid " style="margin-top: -4.4rem;">
    <div class="row">
        <div class="col">
            <div class="card shadow pb-2">

                <div class="card-header py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="texto-rojo-medio font-weight-light m-0 texto-rojo">Mis Actividades</h3>
                        </div>
                        <div>
                            {{-- Botón para regresar a la vista principal --}}
                            <a href="{{ route('home') }}" class="btn btn-contorno-rojo"><i class="fas fa-home"></i> &nbsp; Página Principal </a>
                            {{-- Botón para regresar mi perfil --}}
                            <a href="{{ route('perfil.show') }}" class="btn btn-contorno-rojo"><i class="fas fa-user"></i> &nbsp; Mi Perfil </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    {{-- Pestañas de navegación --}}
                    <ul class="nav nav-tabs" id="opciones-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link " id="act-int-tab" href="{{ route('perfil.mis-actividades') }}">Actividades internas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="act-prom-tab" href="{{ route('perfil.mis-actividades.promocion') }}">Actividades de promoción</a>
                        </li>
                    </ul>


                    <div class="table-responsive table mt-2 pt-3 table-hover" role="grid">
                        <table class="table my-0" id="dataTable">
                            {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th style="width: 21rem;">Tema</th>
                                    <th>ID Coordinador</th>
                                    <th>Tipo de actividad</th>
                                    <th>Estado</th>
                                    <th>Fecha de inicio</th>
                                    <th>Autorización</th>
                                    <th>Ver detalle</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- En caso de que no existan registros --}}
                                @if(count($actividadesPromocion) == 0)
                                <tr class="cursor-pointer">
                                    <td colspan="7"> <i class="text-danger fas fa-exclamation-circle fa-lg">
                                        </i> &nbsp; No existen registros</td>
                                </tr>
                                @endif
                                {{-- Inserción iterativa de las actividades a la tabla --}}
                                @foreach($actividadesPromocion as $actividadPromocion)

                                <tr id="promocion" class="cursor-pointer">
                                    <td>{{ $actividadPromocion->actividad_id}}</td>
                                    <td>{{ $actividadPromocion->tema}}</td>
                                    <td>{{ $actividadPromocion->responsable_coordinar }}</td>
                                    <td>{{$actividadPromocion->tipo_actividad}}</td>
                                    @if ( $actividadPromocion->estado == 'Para ejecución' )
                                    <td><span class=" bg-info text-dark font-weight-bold px-2 rounded">{{ $actividadPromocion->estado }}</span></td>
                                    @elseif($actividadPromocion->estado == 'Cancelada')
                                    <td><span class=" bg-danger text-white px-2 rounded">{{ $actividadPromocion->estado }}</span></td>
                                    @elseif($actividadPromocion->estado == 'En progreso')
                                    <td><span class=" bg-warning text-dark px-2 rounded">{{ $actividadPromocion->estado }}</span></td>
                                    @elseif($actividadPromocion->estado == 'Ejecutada')
                                    <td><span class=" bg-success text-white px-2 rounded">{{ $actividadPromocion->estado }}</span></td>
                                    @endif
                                    <td>{{ date("d/m/Y",strtotime($actividadPromocion->fecha_inicio_actividad)) }} </td>
                                    @if($actividadPromocion->autorizada == 0)
                                    <td><span class="bg-info text-dark font-weight-bold px-2 rounded">Pendiente <i class="far fa-clock"></i></span></td>
                                    @else
                                    <td><span class="bg-success text-white px-2 rounded"> Autorizada <i class="fas fa-check"></i> </span></td>
                                    @endif
                                    <td>
                                        {{-- Botón para ver el detalle de la actividad --}}
                                        <strong>
                                            <a href="{{ route('actividad-promocion.show',$actividadPromocion->actividad_id) }}" class="btn btn-contorno-rojo"> Detalle </a>
                                        </strong><br />
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row justify-content-center mt-5">
                        {{ $actividadesPromocion->withQueryString()->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection
