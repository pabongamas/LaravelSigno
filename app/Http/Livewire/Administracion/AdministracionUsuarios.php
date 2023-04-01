<?php

namespace App\Http\Livewire\Administracion;

use Livewire\Component;
use App\Models\User;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdministracionUsuarios extends Component
{
    public $usuarios;
    public $editingUserId=null;
    public $password;
    public $AdminModalTitle;

    protected $listeners = ['render'];

    public function render()
    {
        $this->usuarios=User::select("usuarios.id_usuario as DT_RowId","horasacceso","usuarios.id_usuario","login","usuarios.estado as estado","persona.*","abreviatura")
        // ->whereRaw('(select count(*) from usuariorol where usuariorol.id_usuario=usuarios.id_usuario) as roles')
        ->leftJoin('usuariosucursal', 'usuariosucursal.id_usuario', '=', 'usuarios.id_usuario')
        ->join('persona', function($join) {
            $join->on('persona.tipo_documento', '=', 'usuarios.tipo_documento')
                 ->on('persona.id_documento', '=', 'usuarios.id_documento');
        })
        ->join('tipodocumento', 'tipodocumento.tipo_documento', '=', 'usuarios.tipo_documento')
        ->get();

        return view('livewire.administracion.administracion-usuarios')->layout('adminlte::page');;
    }


    public function mount() {
        $this->usuarios = array();
        $this->AdminModalTitle="";
    }
    
    public function changePassword($iduser){
        $this->editingUserId = $iduser;
    }
    public function updatePassword(){
        $userId=$this->editingUserId;
        $password=$this->password;
        $this->editingUserId=null;
        $this->password='';
        if(!empty($password)){
            $user=User::find($userId);
            $user->clave=bcrypt($password);
            $user->save();
            $this->emit('mostrar-alerta', [
                'titulo' => 'Actualización exitosa',
                'mensaje' =>"Se ha actualizado correctamente la contraseña para el usuario ". $user->login,
                'tipo' => 'success'
            ]);
        }
       
    }
    public function openModalAdmin($accion){
        if($accion=='new'){
            $title="Nuevo Usuario";
        }else{
            $title="Edición Usuario";
        }
        $this->emit('open-modal',[
            'title' => $title
        ]);
    }



    
    
}
