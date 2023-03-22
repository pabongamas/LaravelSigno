@extends('adminlte::page')
@section('content')

<div class="row mt-2 cabecera paddingDivT paddingDivB msgDetalle msgHead rounded-sm bg-gray" style="margin-bottom: 15px;">
                    <div class="row textoInfo" id="msgDetalle">
                        <div class="col-12" id="imgInfo" style="padding-top: 9px; padding-left: 20px;padding-bottom:9px;">
                            <h3 class="m-0">Información general de la notaria</h3>
                            <p style="line-height: 1.2;">Utilice esta opción para definir los datos básicos de la notaria en el sistema</p>
                        </div>
                    </div>  
                </div>
<div class="row">
    <div class="col-md-12 text-right" style="padding-right: 0">
        <button id="btn_registrar" class="bg-signUsaPrimary-general hover:bg-signUsaPrimary-hover text-white py-1 px-2 rounded-sm ">Registrar</button>
        <button id="btn_salir" class="border-1px border-solid border-signUsaPrimary-general py-1 px-2 rounded-sm ">Salir</button>
    </div>
    <div class="col-12">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="divDatosBasicos-tab" data-toggle="tab" role="tab" aria-controls="divDatosBasicos" aria-selected="true" href="#divDatosBasicos">Datos básicos Notaría</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="divDatosNotario-tab" data-toggle="tab" role="tab" aria-controls="divDatosNotario" aria-selected="false" href="#divDatosNotario">Datos Notario titular</a>
            </li>

        </ul>
        <div class="tab-content">
            <div  class="tab-pane active" role="tabpanel" aria-labelledby="divDatosBasicos-tab" id="divDatosBasicos">
                <div class="col-12 borderTab">
                    <div class="row">
                        <div class="col-12 text-left" style="padding-top: 15px;">
                            <h5 class="textPrimary italic underlineText">Informaci&oacute;n General</h5>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-10" style="padding: 10px 15px 15px 15px;">
                            <table id="datosBasicos" class="table table-striped table-bordered" width="100%" style="font-size: 11px;">
                                <thead>
                                    <tr>
                                        <th style="width: 70%">
                                            <div class="col-md-12 text-left ">
                                                Par&aacute;metros
                                            </div>
                                        </th>
                                        <th style="width: 30%">
                                            <div class="col-md-12 text-center">
                                                Descripci&oacute;n
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-left">
                                            <div class ="col-md-12 text-left">
                                                <input type="text" class='form-control cajas' id="ve_12" onkeypress="cambios(event, 've_12');">
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            {{-- <div class ="col-md-2 text-right">
                                                <a href="#" class="tip"><img src='../../GIFS/General/info.png' class="imagen" alt=""><span>El nombre completo de la notaria que se presenta en factura de escrituras e informes.</span></a>
                                            </div> --}}
                                            <div class ="col-md-10 text-left">
                                                Nombre Completo
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                            <div class ="col-md-12 text-left">
                                                <input type="text" class='form-control cajas' id="ve_61" onkeypress="cambios(event, 've_61');">

                                            </div>
                                        </td>
                                        <td class="text-left">
                                            {{-- <div class ="col-md-2 text-right">
                                                <a href="#" class="tip"><img src='../../GIFS/General/info.png' class="imagen" alt=""><span>Nombre abreviado de la notaria para facturas de varios. Máximo 40 caracteres.</span></a>
                                            </div> --}}
                                            <div class ="col-md-10 text-left">
                                                Nombre Abreviado
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                            <div class ="col-md-12 text-left">
                                                <input type="text" class='form-control cajas' id="ve_110" onkeypress="cambios(event, 've_110');" style="text-align: right">
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            {{-- <div class ="col-md-2 text-right">
                                                <a href="#" class="tip"><img src='../../GIFS/General/info.png' class="imagen" alt=""><span>Número de la notaria para impresión en registro civil.</span></a>
                                            </div> --}}
                                            <div class ="col-md-10 text-left">
                                                N&uacute;mero Notaria
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                            <div class ="col-md-12 text-left">
                                                <input type="text" class='form-control cajas' id="ve_130" onkeypress="cambios(event, 've_130');"  style="text-align: right">
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            {{-- <div class ="col-md-2 text-right">
                                                <a href="#" class="tip"><img src='../../GIFS/General/info.png' class="imagen" alt=""><span>Código de la notaria ante la SNR. Este código se informa en reportes a entidades de control.</span></a>
                                            </div> --}}
                                            <div class ="col-md-10 text-left">
                                                C&oacute;digo ante SNR
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                            <div class ="col-md-12 text-left">
                                                <select id="departamentos" style="width: 100%" onchange="cargarMeses('departamentos')"></select>
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            {{-- <div class ="col-md-2 text-right">
                                                <a href="#" class="tip"><img src='../../GIFS/General/info.png' class="imagen" alt=""><span>Municipio donde se encuentra ubicada la notaria.</span></a>
                                            </div> --}}
                                            <div class ="col-md-10 text-left">
                                                Departamento
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                            <div class ="col-md-12 text-left">
                                                <select id="municipio" style="width: 100%" onchange="cambios(event, 've_15')"></select>
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            {{-- <div class ="col-md-2 text-right">
                                                <a href="#" class="tip"><img src='../../GIFS/General/info.png' class="imagen" alt=""><span>Ciudad donde se encuentra ubicada la notaria.</span></a>
                                            </div> --}}
                                            <div class ="col-md-10 text-left">
                                                Ciudad
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                            <div class ="col-md-12 text-left">
                                                <input type="text" class='form-control cajas' id="ve_16" onkeypress="cambios(event, 've_16');">

                                            </div>
                                        </td>
                                        <td class="text-left" style="width:50%">
                                            {{-- <div class ="col-md-2 text-right">
                                                <a href="#" class="tip"><img src='../../GIFS/General/info.png' class="imagen" alt=""><span>Dirección de la notaria a presentar el facturas e informes.</span></a>
                                            </div> --}}
                                            <div class ="col-md-10 text-left">
                                                Direcci&oacute;n
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                            <div class ="col-md-12 text-left">
                                                <input type="text" class='form-control cajas' id="ve_45" onkeypress="cambios(event, 've_45');"  style="text-align: right">

                                            </div>
                                        </td>
                                        <td class="text-left">
                                            {{-- <div class ="col-md-2 text-right">
                                                <a href="#" class="tip"><img src='../../GIFS/General/info.png' class="imagen" alt=""><span>Telefono de la notaria a presentar el facturas e informes.</span></a>
                                            </div> --}}
                                            <div class ="col-md-10 text-left">
                                                Tel&eacute;fonos
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                            <div class ="col-md-12 text-left">

                                                <input type="text" class='form-control cajas' id="ve_46" onkeypress="cambios(event, 've_46');">
                                            </div>
                                        </td>
                                        <td class="text-left" >
                                            {{-- <div class ="col-md-2 text-right">
                                                <a href="#" class="tip"><img src='../../GIFS/General/info.png' class="imagen" alt=""><span>Email de la notaria a presentar el facturas e informes.</span></a>
                                            </div> --}}
                                            <div class ="col-md-10 text-left">
                                                Correo electronico
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                            <div class ="col-md-12 text-left">
                                                <select id="ve_141" style="width: 100%" onchange="cambios(event, 've_141')">
                                                    <option value="1">Primera</option>
                                                    <option value="2">Segunda</option>
                                                    <option value="3">Tercera</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            {{-- <div class ="col-md-2 text-right">
                                                <a href="#" class="tip"><img src='../../GIFS/General/info.png' class="imagen" alt=""><span>Categoría de la notaria. Este dato se incluye en informe mensual SNR.</span></a>
                                            </div> --}}
                                            <div class ="col-md-10 text-left">
                                                Categor&iacute;a Notaria
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                            <div class="col-md-12 col-sm-12 col-xs-12 text-center" id="notarias">

                                            </div>
                                        </td>
                                        <td class="text-left">
                                            {{-- <div class ="col-md-2 text-right">
                                                <a href="#" class="tip"><img src='../../GIFS/General/info.png' class="imagen" alt=""><span>Indicar si la notaria es subsidiada. Este dato se incluye en informe mensual SNR</span></a>
                                            </div> --}}
                                            <div class ="col-md-10 text-left">
                                                Notaria Subsidiada
                                            </div>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-2 text-center" style="padding: 10px 15px 15px 15px;">
                            <div class="col-md-12" style="margin-bottom: 15px;">
                                <div id="contImagenAdd">
                                    <img id="limpiarFoto" class="cursor-pointer hidden" title="Eliminar Imagen" src="../../iconos/Exit.png" style="float: right;" >
                                    <div id="contenedorImg" class="fileUpload flexJustifyCenter">
                                        <img class="cursor-pointer" src="{{ asset('iconos/SubirLogo.png') }}" title="Agregar Imagen" style="object-fit: scale-down">
                                        <input id="foto" type="file" class="upload" style="width: 100%"/>
                                    </div>
                                </div>
                                <div class="text-center" style="margin-top: 15px">
                                    <div id="contImagenDet" class="text-center hidden"></div>
                                    <span class="control-label" >Logotipo de la Notar&iacute;a</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div id="contImagenAddSVG">
                                    <img id="limpiarFotoSVG" class="cursor-pointer hidden" title="Eliminar Imagen" src="../../iconos/Exit.png" style="float: right;" >
                                    <div id="contenedorImgSVG" class="fileUpload flexJustifyCenter">
                                        <img class="cursor-pointer" src="{{ asset('iconos/SubirLogo.png') }}" title="Agregar Imagen" style="object-fit: scale-down">
                                        <input id="fotoSVG" type="file" class="upload"/>
                                    </div>
                                </div>
                                <div class="text-center" style="margin-top: 15px">
                                    <div id="contImagenDetSVG" class="text-center hidden"></div>
                                    <span class="control-label" >Logo SVG</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" role="tabpanel" aria-labelledby="divDatosNotario-tab" id="divDatosNotario">
                <div class="col-12 borderTab">
                    <div class="row">
                        <div class="col-12 text-left" style="padding-top: 15px;">
                            <h5 class="textPrimary italic underlineText">Datos básicos del notario titular</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" style="padding: 10px 15px 15px 15px;">
                            <table id="datosNotario" class="table table-striped table-bordered" width="100%" style="font-size: 11px;">
                                <thead>
                                    <tr>
                                        <th style="width: 50%">
                                            <div class="col-md-12 text-left ">
                                                Par&aacute;metros
                                            </div>
                                        </th>
                                        <th style="width: 50%">
                                            <div class="col-md-12 text-left" style="padding-left: 19%;">
                                                Descripci&oacute;n
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-left">
                                            <div class ="col-md-12 text-left">
                                                <input type="text" class='form-control cajas' id="ve_10" onkeypress="cambios(event, 've_10');">
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            {{-- <div class ="col-md-2 text-right" style="padding: 0">
                                                <a href="#" class="tip"><img src='../../GIFS/General/info.png' class="imagen" alt=""><span>El nombre completo del notario titular que se presenta en factura de escrituras e informes.</span></a>
                                            </div> --}}
                                            <div class ="col-md-10 text-left">
                                                Nombre Completo
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                            <div class ="col-md-12 text-left">
                                                <input type="text" class='form-control cajas' id="ve_62" onkeypress="cambios(event, 've_62');">
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            {{-- <div class ="col-md-2 text-right" style="padding: 0">
                                                <a href="#" class="tip"><img src='../../GIFS/General/info.png' class="imagen" alt=""><span>Nombre abreviado del notario titular para facturas de varios. Máximo 40 caracteres.</span></a>
                                            </div> --}}
                                            <div class ="col-md-10 text-left">
                                                Nombre Abreviado
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                            <div class ="col-md-12 text-left">
                                                <input type="text" class='form-control cajas' id="ve_11" onkeypress="cambios(event, 've_11');" style="text-align: right">
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            {{-- <div class ="col-md-2 text-right" style="padding: 0">
                                                <a href="#" class="tip"><img src='../../GIFS/General/info.png' class="imagen" alt=""><span>Identificación del notario titular sin digito de verificación para presentar en  facturas e informes.</span></a>
                                            </div> --}}
                                            <div class ="col-md-10 text-left">
                                                N&uacute;mero de Identificaci&oacute;n
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                            <div class ="col-md-12 text-left">
                                                <input type="text" class='form-control cajas' id="ve_79" onkeypress="cambios(event, 've_79');" style="text-align: right">
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            {{-- <div class ="col-md-2 text-right" style="padding: 0">
                                                <a href="#" class="tip"><img src='../../GIFS/General/info.png' class="imagen" alt=""><span>Digito de verificación para la identificación del notario titular para presentar en facturas e informes.</span></a>
                                            </div> --}}
                                            <div class ="col-md-10 text-left">
                                                Digito de Verificaci&oacute;n
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                            <div class ="col-md-12 text-left">
                                                <select id="depto" style="width: 100%" onchange="cargarMeses('depto')"></select>
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            {{-- <div class ="col-md-2 text-right" style="padding: 0">
                                                <a href="#" class="tip"><img src='../../GIFS/General/info.png' class="imagen" alt=""><span>Lugar donde fue expedida la cedula del notario titular.</span></a>
                                            </div> --}}
                                            <div class ="col-md-10 text-left">
                                                Departamento de Expedici&oacute;n Cedula
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                            <div class ="col-md-12 text-left">
                                                <select id="muni" style="width: 100%" onchange="cambios(event, 've_142')"></select>
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            {{-- <div class ="col-md-2 text-right" style="padding: 0">
                                                <a href="#" class="tip"><img src='../../GIFS/General/info.png' class="imagen" alt=""><span>Lugar donde fue expedida la cedula del notario titular.</span></a>
                                            </div> --}}
                                            <div class ="col-md-10 text-left">
                                                Ciudad de Expedici&oacute;n Cedula
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                            <div class ="col-md-12 text-left">
                                                <input type="text" class='form-control cajas' id="ve_17" onkeypress="cambios(event, 've_17');">
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            {{-- <div class ="col-md-2 text-right" style="padding: 0">
                                                <a href="#" class="tip"><img src='../../GIFS/General/info.png' class="imagen" alt=""><span>Número de tarjeta profesional de notaria titular</span></a>
                                            </div> --}}
                                            <div class ="col-md-10 text-left">
                                                Tarjeta Profesional
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                            <div class ="col-md-12 text-left">
                                                <input type="text" class='form-control cajas' id="ve_14" onkeypress="cambios(event, 've_14');">
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            {{-- <div class ="col-md-2 text-right" style="padding: 0">
                                                <a href="#" class="tip"><img src='../../GIFS/General/info.png' class="imagen" alt=""><span>Texto en antefirma del notario titular.</span></a>
                                            </div> --}}
                                            <div class ="col-md-10 text-left">
                                                Firma
                                            </div>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
</div>
@endsection
<script  defer src="{{ asset('js/DatosNotaria.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/DatosNotaria.css') }}">
