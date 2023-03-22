function spinner(texto) {
    if (texto === "") {
        texto = "Cargando...";
    }
    if (texto === false) {
        $("#overlay").hide();
        return;
    }
    $("#textLoad").html(texto);
    $("#overlay").show();
}