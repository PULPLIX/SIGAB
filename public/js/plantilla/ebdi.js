let flag = true;
$('[data-toggle="tooltip"]').tooltip();

$('[data-toggle="tooltip"]').tooltip();


let colapsado = localStorage.getItem('colapsado');

if (!colapsado) {
    $("#sidebar").css({ transition: 'all 0s' });
    $("#content").css({ transition: 'all 0s' });
    $("#sidebar").toggleClass("active");
}

/*$(document).ready(function() {
    $("#sidebarCollapse").on("click", function() {
        $("#sidebar").toggleClass("active");
    });
});*/

$(document).ready(function() {
    $("#sidebarCollapse").on("click", function () {
        if (!colapsado) {
            $("#sidebar").css({ transition: 'all 0.3s' });
            $("#content").css({ transition: 'all 0.3s' });
            localStorage.setItem('colapsado', 1);
            $("#sidebar").toggleClass("active");
        } else {
            $("#sidebar").css({ transition: 'all 0.3s' });
            $("#content").css({ transition: 'all 0.3s' });
            localStorage.removeItem("colapsado");
            $("#sidebar").toggleClass("active");
        }
    });
});
