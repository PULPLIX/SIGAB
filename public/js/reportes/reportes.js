//-----------------------------------------
// Funcionalidades basicas
//-----------------------------------------

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });

if (naturalezaActividad === undefined) {
    naturalezaActividad = "Actividad interna";
}
if (naturalezaActividad === 'Actividad interna') {
    mostrarTipos(0);
} else {
    mostrarTipos(1);
}

cargarTipos();


function cargarTipos() {
    let select = $("#actividad");
    select.on('change', function () {
        let val = select.val();
        if (val === "Seleccionar") limpiarTipos();
        else {
            if (val === "Actividad interna") {
                mostrarTipos(0);
            }
            if (val === "Actividad de promoción")
                mostrarTipos(1);
        }

    });
}

function mostrarTipos(tipo) {
    switch (tipo) {
        case 0:
            $("#tipo-actividad-prom").hide();
            $("#tipo-actividad-int").show();
            break;
        case 1:
            $("#tipo-actividad-int").hide();
            $("#tipo-actividad-prom").show();
            break;

    }
}

function enviar() {
    $("#formulario-reporte").trigger("submit");
}

async function reporte() {
    // ApexCharts.exec("grafico", "dataURI").then(({ imgURI, blob }) => {
    //     const jspdf = require('jspdf');
    //     let doc = new jspdf();

    //     doc.setFontSize(40);
    //     doc.text(35, 25, 'PDF with jsPDF!');
    //     const { jsPDF } = window.jspdf
    //     const pdf = new jsPDF();
    //     pdf.addImage(imgURI, 'PNG', 0, 0);
    //     pdf.save("pdf-chart.pdf");
    //     window.location.href = '/reportes/actividades/reporte?data=' + "data";
    // });
}

//-----------------------------------------
// Variables globales para el grafico
//-----------------------------------------

let locales = [{
    "name": "es",
    "options": {
        "months": [
            "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        ],
        "shortMonths": [
            "Ene", "Feb", "Mar", "Abr", "May", "Jun",
            "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"
        ],
        "days": [
            "Domingo", "Lunes", "Martes", "Miércoles",
            "Jueves", "Viernes", "Sábado"
        ],
        "shortDays": ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
        "toolbar": {
            "exportToSVG": "Descargar SVG",
            "exportToPNG": "Descargar PNG",
            "exportToCSV": "Descargar CSV",
            "menu": "Menu",
            "selection": "Seleccionar",
            "selectionZoom": "Seleccionar Zoom",
            "zoomIn": "Aumentar",
            "zoomOut": "Disminuir",
            "pan": "Navegación",
            "reset": "Reiniciar Zoom"
        }
    }
}];

let grid = {
    show: true,
    borderColor: '#ECECEC',
    strokeDashArray: 0,
    position: 'back',
    xaxis: {
        lines: {
            show: true
        }
    },
    yaxis: {
        lines: {
            show: true
        }
    }
};

let nameSeries = "Total"

let svg;
