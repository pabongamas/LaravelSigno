<?php

namespace App\Http\Controllers;

use App\Models\DataNotaria;
use Illuminate\Http\Request;
use App\Models\VariableEntorno;
use App\Models\Municipio;
use App\Models\Departamento;
use App\Models\Auditoria;
use App\Models\AccionAuditable;
use App\Models\Tarea;
use App\Models\User;
use App\Models\AuditoriaPrincipal;
use Illuminate\Support\Facades\Auth;

class DataNotariaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      
            return view('admin.mantenimiento.infoGeneral.datosNotaria');
      
    }

    public function consultaVariables(){
        $departamentoSQL=[];
        $municipioObj=[];
        $registros = array();
        $registroNotario = array();
        try {
            $ve15= VariableEntorno::find(15)->valor_variable;
            $ve145= VariableEntorno::find(145)->valor_variable;
            $ve376= VariableEntorno::find(376)->valor_variable;
            $ve142= VariableEntorno::find(142)->valor_variable;


            $departamentoNotarial=Municipio::find($ve15);
            $departamentoExpe=Municipio::find($ve142);

            $departamentoSQL=Departamento::whereIn('idpais',[5,169])->orderBy('nombre')->get();
            $idDepartamento = isset($departamentoNotarial->iddepartamento)? $departamentoNotarial->iddepartamento : 0;
            $idDepExpe = isset($departamentoExpe->iddepartamento)? $departamentoExpe->iddepartamento : 0;

            $municipios=Municipio::where('iddepartamento',$idDepartamento)->get();
            $municipiosExped=Municipio::where('iddepartamento',$idDepExpe)->get();

            $datosBasicosNotaria = VariableEntorno::whereIn("codigo_variable",[12,61,110,130,15,16,45,46,145,141,144,376])->orderBy('codigo_variable')->get();
            foreach ($datosBasicosNotaria as $value) {
                $obj =new \stdClass();
                $obj->variable = $value->codigo_variable;
                $obj->valor = $value->valor_variable;
                $registros[] = $obj;
            }

            $contenido = explode(",", $ve145);
            $img = "";
            if (isset($contenido[1])) {
                $base64 = base64_decode($contenido[1]);
                if ($contenido[1] === base64_encode($base64)) {
                    $img = $ve145;
                }
            }

            $contenidoSVG = explode(",", $ve376);
            $imgSVG = "";
            if (isset($contenidoSVG[1])) {
                $base64 = base64_decode($contenidoSVG[1]);
                if ($contenidoSVG[1] === base64_encode($base64)) {
                    $imgSVG = $ve376;
                }
            }
            $datosNotario=VariableEntorno::whereIn("codigo_variable",[10,62,11,79,142,17,14])->orderBy('codigo_variable')->get();
            foreach ($datosNotario as $value) {
                $obj =new \stdClass();
                $obj->variable = $value->codigo_variable;
                $obj->valor = $value->valor_variable;
                $registroNotario[] = $obj;
            }
            $success=true;
        } catch (\Exception $e) {
            return response()->json([
                'success'=>false,
                'error'=>$e->getMessage()
            ]);
        }
        $respuesta =  new \stdClass();
        $respuesta->datosBasicos=$registros;
        $respuesta->datosNotario=$registroNotario;
        $respuesta->departamentos=$departamentoSQL;
        $respuesta->municipios=$municipios;
        $respuesta->departamentoNotarial=$idDepartamento;
        $respuesta->municipioNotarial=$ve15;
        $respuesta->departamentoExpe=$idDepExpe;
        $respuesta->municipioExpe=$ve142;
        $respuesta->municipiosNotario=$municipiosExped;
        $respuesta->logo=$img;
        $respuesta->logoSvg=$imgSVG;
      
        return response()->json([
            'success'=>$success,
            'data'=>$respuesta
          ]);

    }
    public function cargarMunicipios(Request $request){
        $idDepartamento = $request->input("id");
        try{
            $municipios=Municipio::where('iddepartamento',$idDepartamento)->orderBy('nombre')->get();
            $success=true;
        } catch (\Exception $e) {
            return response()->json([
                'success'=>false,
                'error'=>$e->getMessage()
            ]);
        }

        return response()->json([
            'success'=>$success,
            'data'=>$municipios
          ]);
    }
    public function actualizarVariable(Request $request){
        try{
            $user = Auth::user();
            $userId = $user->id_usuario;
            $datos = json_decode($request->input("datos"));
            $medidasLogo =$request->input("medidasLogo");

            $auditoria=new Auditoria;
            $accionAuditable=AccionAuditable::find(AccionAuditable::Modificacion);
            $tarea=Tarea::find(Tarea::DATOS_NOTARIA);
            $usuario=User::find($userId);
            $auditoria->id_tarea=$tarea->id_tarea;
            $auditoria->idaccionauditable=$accionAuditable->idaccionauditable;
            $auditoria->id_usuario=$usuario->id_usuario;
            $auditoria->fecha=now();
            $auditoria->descripcion="Actualizacion de Variables de datos de la notaria";
            $auditoria->save();

            foreach ($datos as $value) {
                $variableEntorno=VariableEntorno::find($value->variable);
                $variableEntorno->valor_variable=$value->valor;
                $variableEntorno->save();

                if ($value->variable == 11 || $value->variable == 79) {
                    $ve11= VariableEntorno::find(11)->valor_variable;
                    $ve79= VariableEntorno::find(79)->valor_variable;
                    $ve301= VariableEntorno::find(301)->valor_variable;
                    $ve301->valor_variable=$ve11."".$ve79;
                    $ve301-save();
                }
                $auditoriaPrincipal=new AuditoriaPrincipal;
                $auditoriaPrincipal->id_evento=224;
                $auditoriaPrincipal->id_usuario=$userId;
                $auditoriaPrincipal->fecha=now();
                $msgAuditoria = "Se actualiza " . $variableEntorno->descripcion . ". Dato anterior : " . $value->valorAct . " Nuevo dato: " . $value->valor;
                if ($value->variable == 145) {
                    $msgAuditoria = "Se actualiza " . $variableEntorno->descripcion . ". Dato anterior : " . sha1($value->valorAct) . " Nuevo dato: " . sha1($value->valor);
                } else if ($value->variable == 376) {
                    $msgAuditoria = "Se actualiza " . $variableEntorno->descripcion . ". Dato anterior : " . sha1($value->valorAct) . " Nuevo dato: " . sha1($value->valor);
                } else if ($value->variable == 141) {
                    $msgAuditoria = "Se actualiza categoria de la notaria. Dato anterior : " . ($value->valorAct == 1 ? "Primera" : ($value->valorAct == 2 ? "Segunda" : "Tercera")) . " Nuevo dato: " . ($value->valor == 1 ? "Primera" : ($value->valor == 2 ? "Segunda" : "Tercera"));
                }
                $auditoriaPrincipal->descripcion=$msgAuditoria;
                $auditoriaPrincipal->save();


            }
            if (!empty($medidasLogo)) {
                $variableEntorno = VariableEntorno::find(235);
                $variableEntorno->valor_variable=$medidasLogo;
                $variableEntorno->save();
            }
            $success=true;
        }catch(\Exception $e){
            return response()->json([
                'success'=>false,
                'error'=>$e->getMessage()
            ]);
        }
      
    return response()->json([
        'success'=>$success,
      ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DataNotaria $dataNotaria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataNotaria $dataNotaria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataNotaria $dataNotaria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataNotaria $dataNotaria)
    {
        //
    }
}
