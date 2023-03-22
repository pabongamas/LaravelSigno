var CONSULTAR_VARIABLES = 100;
var CARGAR_MESES = 101;
var ACTUALIZAR_VARIABLES = 102;

var registros = null;
var datosModificados = [];
var nombreLogo = null;
var medidaLogo = 0;
var medidaLogoSVG = 0;
var token = $('[name="_token"]').val();

$(document).ready(function () {
    iniciarInterfaz();
    $("#datosNotaria").show();
});

function iniciarInterfaz() {
    $("#btn_salir").on("click", function () {
        var cambios = datosModificados.length;
        if (cambios > 0) {
            Swal.fire({
                title: '¿Esta seguro de salir',
                text: '¡hay cambios sin ser guardados.!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, Salir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = 'home';
                }
            });
        } else {
            location.href = 'home';
        }
    });
    $("#btn_registrar").on("click", function () {
        var datos = [];
        $.each(registros.datosBasicos, function (i, obj) {
            var id = "ve_" + obj.variable;
            var index = $.inArray(id, datosModificados);
            if (index !== -1) {
                var nuevoValor = $("#" + id).val();
                var valorActual = obj.valor;
                if (id === "ve_144") {
                    nuevoValor = $("#ns").prop('checked') + "";
                } else if (id === "ve_145") {
                    medidaLogo = $("#fotoC").width() + "x" + $("#fotoC").height();
                    nuevoValor = $("#fotoC").attr("src");
                    if (nuevoValor === undefined) {
                        nuevoValor = "''";
                        medidaLogo = 0;
                    }
                } else if (id === "ve_376") {
                    medidaLogoSVG = $("#fotoCSVG").width() + "x" + $("#fotoCSVG").height();
                    nuevoValor = $("#fotoCSVG").attr("src");
                    if (nuevoValor === undefined) {
                        nuevoValor = "''";
                        medidaLogoSVG = 0;
                    }
                } else if (id === "ve_15") {
                    nuevoValor = $("#municipio").val();
                    valorActual = registros.municipioNotarial;
                }
                var data = {
                    variable: obj.variable,
                    valor: nuevoValor,
                    valorAct: valorActual
                };
                datos.push(data);
            }
        });

        $.each(registros.datosNotario, function (i, obj) {
            var id = "ve_" + obj.variable;
            var index = $.inArray(id, datosModificados);
            if (index !== -1) {
                var nuevoValor = $("#" + id).val();
                var valorActual = obj.valor;
                if (id === "ve_142") {
                    nuevoValor = $("#muni").val();
                    valorActual = registros.municipioExpe;
                }
                var data = {
                    variable: obj.variable,
                    valor: nuevoValor,
                    valorAct: valorActual
                };
                datos.push(data);
            }
        });
        if (validar()) {
            actualizarVariables(JSON.stringify(datos));
        }
    });
    $("#limpiarFoto").on("click", limpiarFoto);
    $("#limpiarFotoSVG").on("click", limpiarFotoSVG);
    $("#foto").on("change", function (event) {
        
        var input = $(event).attr("target");
        cambios(event, "ve_145");
        cargarFoto(input);
    });
    $("#fotoSVG").on("change", function (event) {
        console.log("aca");
        var input = $(event).attr("target");
        cambios(event, "ve_376");
        cargarFotoSVG(input);
    });
    $("#ve_110 #ve_130 #ve_79").on('paste', function (e) {
        e.preventDefault();
    });

    $("#ve_110 #ve_130 #ve_79").on('copy', function (e) {
        e.preventDefault();
    });
    consultarVariables();
}



function consultarVariables() {
    spinner("Consultando Datos por favor espere");
    $.ajax({
        url: "DatosNotaria/Consulta",
        dataType: 'json',
        type: "POST",
        data: {
            accion: CONSULTAR_VARIABLES,
            _token: token,
        },
        success: function(result) {
           if(result.success){
            registros = result.data;
            var datos = result.data;
            var datosBasicos = datos.datosBasicos;
            var departamentos = datos.departamentos;
            var municipios = datos.municipios;
            var depaNotarial = datos.departamentoNotarial;
            var munNotarial = datos.municipioNotarial;
            var logo = datos.logo;
            var logoSvg = datos.logoSvg;
            
            var datosNotario = datos.datosNotario;
            var deparExpe = datos.departamentoExpe;
            var municipiosNotario = datos.municipiosNotario;
            var muniExpe = datos.municipioExpe;
    
            if (logo !== "") {
                var img = $("<img/>");
                img.attr({
                    id: "fotoC",
                    src: logo,
                    style: "width: 75%;"
                });
                $("#limpiarFoto").removeClass("hidden");
                $("#contenedorImg").html(img);
            } else {
                $("#contImagenAdd").removeClass("hidden");
                $("#contImagenDet").addClass("hidden");
            }
            if (logoSvg !== "") {
                var img = $("<img/>");
                img.attr({
                    id: "fotoCSVG",
                    src: logoSvg,
                    style: "width: 75%;"
                });
                $("#limpiarFotoSVG").removeClass("hidden");
                $("#contenedorImgSVG").html(img);
            } else {
                $("#contImagenAddSVG").removeClass("hidden");
                $("#contImagenDetSVG").addClass("hidden");
            }
            $.each(datosBasicos, function (i, obj) {
                var id = "ve_" + obj.variable;
                $("#" + id).val(obj.valor);
                if (obj.variable === 144) {
                    $("#notarias").html("<input class='toggle-demo' id='ns' onchange='cambios(" + "event" + " ,\"ve_144\" )' data-toggle='toggle' data-onstyle='success' type='checkbox' data-on='Si' data-size='mini' data-off='No' data-style='checkToggle'>");
                    if (obj.valor === "true") {
                        $("#notarias").html("<input checked class='toggle-demo' id='ns' onchange='cambios(" + "event" + " ,\"ve_144\" )' + data-toggle='toggle' data-onstyle='success' type='checkbox' data-on='Si' data-size='mini' data-off='No' data-style='checkToggle'>");
    
                    }
                }
            });
            // $('.toggle-demo').bootstrapToggle();
            $("#departamentos,#municipio,#depto,#muni").html("");
            $.each(departamentos, function (i, obj) {
                var option = $("<option/>");
                option.val(obj.iddepartamento);
                option.html(obj.nombre);
                if (depaNotarial === obj.iddepartamento) {
                    option.attr("selected", "selected");
                }
                $("#departamentos").append(option);
    
                var option2 = $("<option/>");
                option2.val(obj.iddepartamento);
                option2.html(obj.nombre);
                if (deparExpe === obj.iddepartamento) {
                    option2.attr("selected", "selected");
                }
                $("#depto").append(option2);
    
            });
            $.each(municipios, function (i, obj) {
                var option = $("<option/>");
                option.val(obj.idmunicipio);
                option.html(obj.nombre);
                if (munNotarial * 1 === obj.idmunicipio * 1) {
                    option.attr("selected", "selected");
                }
                $("#municipio").append(option);
            });
    
            $.each(datosNotario, function (i, obj) {
                var id = "ve_" + obj.variable;
                $("#" + id).val(obj.valor);
            });
    
            $.each(municipiosNotario, function (i, obj) {
                var option = $("<option/>");
                option.val(obj.idmunicipio);
                option.html(obj.nombre);
                if (muniExpe * 1 === obj.idmunicipio * 1) {
                    option.attr("selected", "selected");
                }
                $("#muni").append(option);
            });
           }
           spinner(false);
        },
        error:function(){
              
        }
    });
}

function cargarMeses(id) {
    $.ajax({
        url: "DatosNotaria/cargarMunicipios",
        dataType: 'json',
        type: "POST",
        data: {
            _token: token,
            id: $("#" + id).val()
        },
        success: function(result) {
            var datos = result.data;
            if (id === "departamentos") {
                $('#municipio').find('option').remove().end();
                $.each(datos, function (i, obj) {
                    var option = $("<option/>");
                    option.val(obj.idmunicipio);
                    option.html(obj.nombre);
                    $("#municipio").append(option);
                });
                $('#municipio').trigger("change");
            } else {
                $('#muni').find('option').remove().end();
                $.each(datos, function (i, obj) {
                    var option = $("<option/>");
                    option.val(obj.idmunicipio);
                    option.html(obj.nombre);
                    $("#muni").append(option);
                });
                $('#muni').trigger("change");
            }
            }
    });
}

function validar() {
    var errores = [];
    var ve12 = $("#ve_12").val();
    var ve61 = $("#ve_61").val();
    var ve110 = $("#ve_110").val();
    var ve130 = $("#ve_130").val();
    var ve16 = $("#ve_16").val();
    var ve45 = $("#ve_45").val();
    var ve46 = $("#ve_46").val();
    var ve10 = $("#ve_10").val();
    var ve62 = $("#ve_62").val();
    var ve11 = $("#ve_11").val();
    var ve79 = $("#ve_79").val();
    var ve17 = $("#ve_17").val();
    var ve14 = $("#ve_14").val();

    if (ve12 !== "") {
        if (ve12.length < 4 || ve12.length > 120) {
            errores.push("- El nombre de la notaria debe tener mínimo 4 caracteres y máximo 120.");
        }
    }

    if (ve61 !== "") {
        if (ve61.length < 4 || ve61.length > 40) {
            errores.push("- El nombre abreviado de la notaria debe tener mínimo 4 caracteres y máximo 40.");
        }
    }

    if (ve110 !== "") {
        if (/[^-0-9]/g.test(ve110)) {
            errores.push("- El número de la notaria debe ser numérico.");
        }
    }

    if (ve130 !== "") {
        if (/[^-0-9]/g.test(ve130)) {
            errores.push("- El código ante SNR debe ser numérico.");
        }
    }

    if (ve16 !== "") {
        if (ve16.length < 4 || ve16.length > 100) {
            errores.push("- La direccion de la notaria debe tener mínimo 4 caracteres y máximo 100.");
        }
    }

    if (ve45 !== "") {
        if (ve45.length < 4 || ve45.length > 100) {
            errores.push("- El teléfono de la notaria debe tener mínimo 4 caracteres y máximo 100.");
        }
    }

    if (ve46 !== "") {
        if (ve46.length < 4 || ve46.length > 100) {
            errores.push("- El email de la notaria debe tener mínimo 4 caracteres y máximo 100.");
        }
    }

    if (ve10 !== "") {
        if (ve10.length < 4 || ve10.length > 100) {
            errores.push("- El nombre del notario debe tener mínimo 4 caracteres y máximo 100.");
        }
    }

    if (ve62 !== "") {
        if (ve62.length < 4 || ve62.length > 40) {
            errores.push("- El nombre abreviado del notario debe tener mínimo 4 caracteres y máximo 40.");
        }
    }

    if (ve11 !== "") {
        if (ve11.length < 4 || ve11.length > 40) {
            errores.push("- La identificación del notario debe tener mínimo 4 caracteres y máximo 40.");
        }
        if (!/^\d+$/.test(ve11)) {
            errores.push("- La identificación del notario solo puede contener valores numericos");
        }
    }

    if (ve79 !== "") {
        if (/[^-0-9]/g.test(ve79)) {
            errores.push("- El digito de verificación debe ser numérico.");
        }
    }

    if (ve17 !== "") {
        if (ve17.length < 4 || ve17.length > 100) {
            errores.push("- La tarjeta profesional del notario debe tener mínimo 4 caracteres y máximo 100.");
        }
    }
    if (ve14 !== "") {
        if (ve14.length < 4 || ve14.length > 100) {
            errores.push("- La firma del notario debe tener mínimo 4 caracteres y máximo 100.");
        }
    }

    if (errores.length > 0) {
        jAlert("<b>Se han detectado los siguientes errores: </b>" + errores.join("<br>"), "Alerta del Sistema");
        return;
    }

    return true;
}

function actualizarVariables(datos) {
    spinner("Registrando datos por favor espere");
    $.ajax({
        url: "DatosNotaria/Actualizar",
        dataType: 'json',
        type: "POST",
        data: {
            _token: token,
            datos:datos,
            logo:nombreLogo,
            medidasLogo: medidaLogo,
            medidasLogoSVG: medidaLogoSVG
        },
        success: function(data) {
            spinner(false);
            // jAlert("Se actualizo la información exitosamente", "Alerta del Sistema", function () {
                         datosModificados = [];
                         consultarVariables();
                //     });
        }
    });
}

function cargarFoto(input) {
    var file = $(input).prop("files");
    var type = $(file).attr("type");
    var size = $(file).attr("size");
    if (!type.match('image.png') && !type.match('image.jpg') && !type.match('image.jpeg') && !type.match('image.bmp')) {
        jAlert("Extensión de archivo no válido. Sólo se permiten archivos (png, jpg, jpeg, bmp)", "Mensaje", function () {
            limpiarFoto();
        });
        return;
    }
    if (size > 1000000) {
        jAlert("El archivo seleccionado debe pesar como maximo 1 Mega", "Mensaje", function () {
            limpiarFoto();
        });
        return;
    }
    var reader = new FileReader();
    reader.onload = function () {
        var dataURL = reader.result;
        var img = $("<img/>");
        img.attr({
            id: "fotoC",
            src: dataURL,
            style: "width: 75%;"
        });
        $("#limpiarFoto").removeClass("hidden");
        $("#contenedorImg").html(img);
    };
    reader.readAsDataURL(file[0]);
}

function cargarFotoSVG(input) {
    var file = $(input).prop("files");
    var type = $(file).attr("type");
    var size = $(file).attr("size");
    if (!type.match('image.svg')) {
        // jAlert("Extensión de archivo no válido. Sólo se permiten archivos (svg)", "Mensaje", function () {
        //     limpiarFotoSVG()();
        // });
        // return;
    }
    if (size > 1000000) {
        // jAlert("El archivo seleccionado debe pesar como maximo 1 Mega", "Mensaje", function () {
        //     limpiarFotoSVG();
        // });
        // return;
    }
    var reader = new FileReader();
    reader.onload = function () {
        var dataURL = reader.result;
        var img = $("<img/>");
        img.attr({
            id: "fotoCSVG",
            src: dataURL,
            style: "width: 75%;"
        });
        $("#limpiarFotoSVG").removeClass("hidden");
        $("#contenedorImgSVG").html(img);
    };
    reader.readAsDataURL(file[0]);
}

function limpiarFoto() {
    cambios(event, 've_145', true);
    var logoActual = registros.logo;
    var id = "ve_145";
    var imgC = $("<img/>");
    imgC.attr("src", "../../iconos/SubirLogo.png");
    imgC.css({
        width: 180,
        height: 180
    });
    imgC.addClass("cursor-pointer");
    var input = $("<input/>");
    input.attr({
        id: "foto",
        type: "file"
    });
    input.addClass("upload");
    input.on("change", function (event) {
        var input = $(event).attr("target");
        cargarFoto(input);
        cambios(event, 've_145');
    });
    input.css({
        width: 180,
        height: 180
    });
    $("#limpiarFoto").addClass("hidden");
    $("#contenedorImg").html("");
    $("#contenedorImg").append(imgC, input);
    var index = datosModificados.indexOf(id);
    if (index !== -1 && logoActual === "") {
        datosModificados.splice(index, 1);
    }
}

function limpiarFotoSVG() {
    cambios(event, 've_376', true);
    var logoActual = registros.logoSvg;
    var id = "ve_376";
    var imgC = $("<img/>");
    imgC.attr("src", "../../iconos/SubirLogo.png");
    imgC.css({
        width: 180,
        height: 180
    });
    imgC.addClass("cursor-pointer");
    var input = $("<input/>");
    input.attr({
        id: "fotoSVG",
        type: "file"
    });
    input.addClass("upload");
    input.on("change", function (event) {
        var input = $(event).attr("target");
        cargarFotoSVG(input);
        cambios(event, 've_376');
    });
    input.css({
        width: 180,
        height: 180
    });
    $("#limpiarFotoSVG").addClass("hidden");
    $("#contenedorImgSVG").html("");
    $("#contenedorImgSVG").append(imgC, input);
    var index = datosModificados.indexOf(id);
    if (index !== -1 && logoActual === "") {
        datosModificados.splice(index, 1);
    }
}

function cambios(event, id, eliminar = false) {
    console.log("aca");
    setTimeout(function (event) {
        var valor = $(event.target).val();
        switch (id) {
            case 've_15':
                var municipioActual = registros.municipioNotarial;
                var variableId = id;
                var index = datosModificados.indexOf(variableId);
                if (municipioActual * 1 !== valor * 1) {
                    if (index === -1) {
                        datosModificados.push(variableId);
                    }
                } else {
                    if (index !== -1) {
                        datosModificados.splice(index, 1);
                    }
                }
                break;
            case 've_145':
                var logoActual = registros.logo;
                var logoCargado = $("#contImagenDet").hasClass("hidden");
                var value = $("#fotoC").attr("src");
                var index = datosModificados.indexOf(id);
                if (!logoCargado) {
                    value = $("#imgCargado").attr("src");
                }
                if (value !== logoActual) {
                    if (index === -1) {
                        datosModificados.push(id);
                    }
                } else {
                    if (index !== -1) {
                        datosModificados.splice(index, 1);
                    }
                    if (eliminar) {
                        datosModificados.push(id);
                    }
                }
                break;
            case 've_376':
                var logoActual = registros.logoSvg;
                var logoCargado = $("#contImagenDetSVG").hasClass("hidden");
                var value = $("#fotoCSVG").attr("src");
                var index = datosModificados.indexOf(id);
                if (!logoCargado) {
                    value = $("#imgCargadoSVG").attr("src");
                }
                if (value !== logoActual) {
                    if (index === -1) {
                        datosModificados.push(id);
                    }
                } else {
                    if (index !== -1) {
                        datosModificados.splice(index, 1);
                    }
                    if (eliminar) {
                        datosModificados.push(id);
                    }
                }
                break;
            case 've_142':
                var muniExpActual = registros.municipioExpe;
                var variableId = id;
                var index = datosModificados.indexOf(variableId);
                if (muniExpActual * 1 !== valor * 1) {
                    if (index === -1) {
                        datosModificados.push(variableId);
                    }
                } else {
                    if (index !== -1) {
                        datosModificados.splice(index, 1);
                    }
                }
                break;
            default:
                $.each(registros.datosBasicos, function (i, obj) {
                    var variableId = "ve_" + obj.variable;
                    var index = datosModificados.indexOf(variableId);
                    if (variableId === "ve_144") {
                        valor = $("#ns").prop('checked') + "";
                    }
                    if (id === variableId && trim(valor.toLowerCase()) !== trim(obj.valor.toLowerCase())) {
                        if (index === -1) {
                            datosModificados.push(variableId);
                        }
                    } else if (id === variableId && trim(valor.toLowerCase()) === trim(obj.valor.toLowerCase())) {
                        if (index !== -1) {
                            datosModificados.splice(index, 1);
                        }
                    }
                });

                valor = $(event.target).val();
                $.each(registros.datosNotario, function (i, obj) {
                    var variableId = "ve_" + obj.variable;
                    var index = datosModificados.indexOf(variableId);
                    if (id === variableId && trim(valor.toLowerCase()) !== trim(obj.valor.toLowerCase())) {
                        if (index === -1) {
                            datosModificados.push(variableId);
                        }
                    } else if (id === variableId && trim(valor.toLowerCase()) === trim(obj.valor.toLowerCase())) {
                        if (index !== -1) {
                            datosModificados.splice(index, 1);
                        }
                    }
                });
                break;
        }
    }, 60, event);
}
function trim(cadena) {
    cadena = '' + cadena + '';
    return cadena.replace(/^\s*|\s*$/g, '');
}



