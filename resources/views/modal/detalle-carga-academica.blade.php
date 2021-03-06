<div class="modal fade" id="detalle-carga_academica-modal" tabindex="-1" aria-labelledby="detalle-carga_academica-modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title font-weight-bold" id="detalle-carga_academica-modal">Detalle de la carga académica</h5>
                    <div class="d-flex justify-content-end">

                        @if(Accesos::ACCESO_MODIFICAR_CARGAS_ACADEMICAS())
                        <button type="button" class="btn btn-rojo" id="habilitar-edicion">
                            Habilitar edición
                        </button>
                        <button type="button" class="btn btn-rojo" id="cancelar-edicion">
                            Cancelar
                        </button>
                        @endif

                    </div>
            </div>
            <div class="modal-body">

                @if(Accesos::ACCESO_MODIFICAR_CARGAS_ACADEMICAS())
                {{-- Formulario para actualizar informacion de la graduación --}}
                <form autocomplete="off" method="POST" role="form" enctype="multipart/form-data" id="form-actualizar">
                    @csrf
                    @method('PATCH')
                    @endif

                    <div class="d-flex justify-content-center flex-column">

                        {{-- Campo: Nombre del curso--}}
                        <label for="nombre_curso">Nombre del curso <i class="text-danger">*</i></label>
                        <select class="form-control mb-3" id="nombre_curso" name="nombre_curso" size="10" disabled required>
                            @foreach($cursos as $curso)
                            <option>{{ $curso }}</option>
                            @endforeach
                        </select>
                        <div id="nombre-mostrar" class="mb-2"></div>


                        {{-- Campo: Ciclo lectivo --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between w-100">
                                <label for="ciclo_lectivo">Ciclo lectivo <i class="text-danger">*</i></label>
                                <span class="text-muted ml-2" id="mostrar_ciclo_lectivo"></span>
                            </div>
                            <select class="form-control" name="ciclo_lectivo" id="ciclo_lectivo" disabled required>
                                <option>I Ciclo</option>
                                <option>II Ciclo</option>
                            </select>
                        </div>

                        {{-- Campo: Año de graduación --}}
                        <div class=" mb-3">
                            <div class="d-flex justify-content-between w-100">
                                <label for="anio">Año <i class="text-danger">*</i></label>
                                <span class="text-muted ml-2" id="mostrar_anio"></span>
                            </div>
                            <select class="form-control form-control-md " id="anio" name="anio" disabled>
                                @foreach($anios as $anio2)
                                <option value="{{ $anio2 }}"> {{ $anio2 }} </option>
                                @endforeach
                            </select>
                        </div>


                        {{-- Campo: NRC--}}
                        <div class=" mb-3">
                            <div class="d-flex justify-content-between w-100">
                                <label for="nrc">NRC <i class="text-danger">*</i></label>
                                <span class="text-muted ml-2" id="mostrar_nrc"></span>
                            </div>
                            <input type='number' class="form-control" id="nrc" name="nrc" onkeypress="contarCaracteres(this,7)" min="0" disabled required>
                        </div>
                    </div>
                </form>

            </div>

            {{-- Botones para cerrar el modal o para guardar la edición --}}
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-gris" data-dismiss="modal" onclick="cancelarEdicion()">Cerrar</button>
                @if(Accesos::ACCESO_MODIFICAR_CARGAS_ACADEMICAS())
                <button onclick="actualizar()" class="btn btn-rojo ml-3" id="terminar-edicion">Terminar edición</button>
                @endif
            </div>
        </div>
    </div>
</div>
