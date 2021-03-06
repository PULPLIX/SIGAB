
document.addEventListener("DOMContentLoaded", cargaInicial); //Se agrega el evento carga inicial al momento de cargar el documento

let editarActivido = false;
// ===============================================================================================
//Función encargada de hacer el llamado  de todos los métodos utilizados en el registro.
// ===============================================================================================
function cargaInicial(event) {
    ocultarElementos();
    eventos();
    AparecerMensajeExito();
}

function ocultarElementos() {
    $("#campo-buscar").removeClass('d-flex');
    $("#campo-buscar").hide();
    $("#cancelar-edi").hide();
    $("#info-responsable").removeClass('border-top');
    $("#card-footer").hide();
    $("#avatar").hide();
}


// ===============================================================================================
//Función encargada de hacer llamar los metodos de eventos
// ===============================================================================================
function eventos() {
    infoGeneralEvt();
    evtSubmit();
    evtBuscarResponsable();
    editar();
    validarInfo();
    EvtCancelarEdicion();
}

function EvtCancelarEdicion() {
    $("#cancelar-edi").on("click", function () {
        location.reload(); // Recarga la página inicial para eliminar todos los cambios hechos y volver a bloquer todos los cambios
    });
}

// ===============================================================================================
//Función encargada de validar que se haya ingresado un personal
// ===============================================================================================
function evtSubmit() {
    $("#guardar-cambios").on("click", function (e) {
        if (editarActivido === true && $("#responsable-encontrado").val() === "false") {
            e.preventDefault();
            $("#cedula-responsable").val("");
            $("#cedula-responsable").trigger("focus");
            toastr.error("Debe designar un responsable")
        }
    });
}

function editar() {
    $("#editar-actividad").on("click", function () {
        editarActivido = true;
        $("input").removeAttr("disabled");
        $("button").removeAttr("disabled");
        $("select").removeAttr("disabled");
        $("textarea").removeAttr("disabled");
        $("#editar-actividad").hide();
        $("#cancelar-edi").show();
        $("#guardar-cambios").show();
        $("#cambiar-foto").show();
        $("#campo-buscar").addClass('d-flex');
        $("#campo-buscar").show();
        $("#info-responsable").addClass('border-top');
        $("#card-footer").show();
        $("#avatar").show();
    });
}

function infoGeneralEvt() {
    $("#info-gen-tab").on("click", function (e) {
        $("#info-gen-tab").addClass("active");// Desacitva la vista de información general
        $("#info-esp-tab").removeClass("active");// Desacitva la vista de información general
        $("#info-esp").removeClass('active'); // Desactiva la clase para el botón de volver a información general en la vista de participaciones.
        $("#info-gen").tab("show"); // Muestra la vista de informacion general.

    });
}
function validarInfo() {
    $("#info-esp-tab").on("click", function (e) {
        e.preventDefault();
        let $actividadForm = $("#actividad-form"); // Variable que contiene el form de información general del personal
        if($actividadForm.length > 0){
            if (!$actividadForm[0].checkValidity() ||  $("#responsable-encontrado").val() === "false") { // Valida el form antes de que se proceda a la siguiente página para evitar que se envíen datos incorrectos
                $("#guardar-cambios").trigger("click"); // Fuerza el envío de datos en el form para que realice la validación automática de los campos
                $("#info-gen-tab").addClass('active');
                $("#info-esp-tab").removeClass('active');

            } else { // En caso de que se hayan completado los campos de manera correcta procede a mostrar la información de participaciones
                $("#info-esp-tab").addClass("active");// Desacitva la vista de información general
                $("#info-gen-tab").removeClass("active");// Desacitva la vista de información general
                $("#info-gen").removeClass('active'); // Desactiva la clase para el botón de volver a información general en la vista de participaciones.
                $("#info-esp").tab("show"); // Muestra la vista de participaciones.
            }
        } else { // En caso de que se hayan completado los campos de manera correcta procede a mostrar la información de participaciones
            $("#info-esp-tab").addClass("active");// Desacitva la vista de información general
            $("#info-gen-tab").removeClass("active");// Desacitva la vista de información general
            $("#info-gen").removeClass('active'); // Desactiva la clase para el botón de volver a información general en la vista de participaciones.
            $("#info-esp").tab("show"); // Muestra la vista de participaciones.
        }
    });
}

function AparecerMensajeExito() {
    $("#mensaje_exito")
        .fadeTo(3000, 500)
        .slideUp(500, function() {
            $("#mensaje_exito").slideUp(800);
        });
}


function evtBuscarResponsable() {
    $("#buscarCoordinador").on("click", function () {
        if ($("#cedula-responsable").val() === "") {
            $("#responsable-encontrado").val("false");
            esconderTarjetaInfo("responsable-info");
            desplegarAlerta("alerta-responsable", "La cédula digitada no existe");
        } else {
            $.ajax({
                url:
                    rutas['personal.edit'] + $("#cedula-responsable").val(),
                type: "GET",
                success: function (personal) {
                    $("#responsable-encontrado").val(personal.persona_id);
                    var infoTarjeta = {
                        imageID: "imagen-responsable",
                        nombreID: "nombre-responsable",
                        cedulaID: "cedula-responsable-card",
                        correoID: "correo-responsable",
                        telefonoID: "num-telefono-responsable",
                    };
                    llenarTarjetaInfo("responsable-info", personal, infoTarjeta);
                },
                statusCode: {
                    404: function () {
                        $("#responsable-encontrado").val("false");
                        esconderTarjetaInfo("responsable-info");
                        desplegarAlerta("alerta-responsable", "No se encontró el personal");
                    }
                }
            });
        }
    });
}

function llenarTarjetaInfo(idTarjeta, personal, infoTarjeta) {
    $("#" + idTarjeta).addClass("d-flex");
    let src = fotosURL + "/" + personal.imagen_perfil;
    $("#" + infoTarjeta.imageID).attr("src", src);
    $("#" + infoTarjeta.nombreID).html(
        personal.nombre + " " + personal.apellido
    );
    $("#" + infoTarjeta.cedulaID).html(personal.persona_id);
    $("#" + infoTarjeta.correoID).html(personal.correo_institucional);
    $("#" + infoTarjeta.telefonoID).html(personal.telefono_celular);

    $("#" + idTarjeta).show("d-flex");
}

function desplegarAlerta(idAlerta, contenido) {
    $("#" + idAlerta).html(contenido);
    $("#" + idAlerta)
        .fadeTo(3000, 1000)
        .slideUp(500, function () {
            $("#" + idAlerta).slideUp(5000);
        });
}

function esconderTarjetaInfo(idTarjeta) {
    $("#" + idTarjeta).removeClass("d-flex");
    $("#" + idTarjeta).hide();
}


function validarInfo() {
    $("#info-esp-tab").on("click", function (e) {
        e.preventDefault();
        let $actividadForm = $("#actividad-form"); // Variable que contiene el form de información general del personal
        if ($actividadForm.length > 0) {
            if (!$actividadForm[0].checkValidity() || $("#responsable-encontrado").val() === "false") { // Valida el form antes de que se proceda a la siguiente página para evitar que se envíen datos incorrectos
                $("#guardar-cambios").trigger("click"); // Fuerza el envío de datos en el form para que realice la validación automática de los campos
                $("#info-gen-tab").addClass('active');
                $("#info-esp-tab").removeClass('active');
            } else { // En caso de que se hayan completado los campos de manera correcta procede a mostrar la información de participaciones
                $("#info-esp-tab").addClass("active");// Desacitva la vista de información general
                $("#info-gen-tab").removeClass("active");// Desacitva la vista de información general
                $("#info-gen").removeClass('active'); // Desactiva la clase para el botón de volver a información general en la vista de participaciones.
                $("#info-esp").tab("show"); // Muestra la vista de participaciones.
            }
        } else { // En caso de que se hayan completado los campos de manera correcta procede a mostrar la información de participaciones
            $("#info-esp-tab").addClass("active");// Desacitva la vista de información general
            $("#info-gen-tab").removeClass("active");// Desacitva la vista de información general
            $("#info-gen").removeClass('active'); // Desactiva la clase para el botón de volver a información general en la vista de participaciones.
            $("#info-esp").tab("show"); // Muestra la vista de participaciones.
        }
    });
}

function mostrarMensajeValidar(idAlerta, mensaje) {
    $("#"+idAlerta).addClass("d-flex");
    $("#"+idAlerta).show();
    $("#"+idAlerta).css("animation-name", "mostrar-mensaje");
    $("#texto-mensaje").html(mensaje)
    setTimeout(function() { 
        $("#"+idAlerta).css("animation-name", "esconder-mensaje");
    }, 4000);
    setTimeout(function() {
        $("#"+idAlerta).removeClass("d-flex");
        $("#"+idAlerta).hide();
        window.history.replaceState(
            {},
            "/" + window.location.href.split("?")[0]
        );
    }, 4790);
}


$(function () {
    $('.check-list').on('click', function () {
        if($('#checkListasAsistencia:checked').length > 0 
            && $('#checkEvidencias:checked').length > 0 ){
            $("#button-submit-eliminar").prop("disabled", false);
        } else {
            $("#button-submit-eliminar").prop("disabled", true);
        }
    });
});
