<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
       

        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            // Add some items to the menu...

            $user = Auth::user();
            $userId = $user->id_usuario;
            $menus = DB::table('menu')
                        ->select('menu.id_tarea', 'menu.id_padre', 'menu.id_menu', 'perfil.estado')
                        ->leftJoin('tarea', function ($join) {
                            $join->on('menu.id_tarea', '=', 'tarea.id_tarea')
                                ->where('tarea.estado', true);
                        })
                        ->leftJoin('area', 'menu.id_area', '=', 'area.id_area')
                        ->leftJoin('perfiltarea', 'perfiltarea.id_tarea', '=', 'tarea.id_tarea')
                        ->leftJoin('perfil', function ($join) {
                            $join->on('perfil.id_perfil', '=', 'perfiltarea.id_perfil')
                                ->where('perfil.estado', 't');
                        })
                        ->leftJoin('rolperfil', 'perfil.id_perfil', '=', 'rolperfil.id_perfil')
                        ->leftJoin('usuariorol', 'rolperfil.id_rol', '=', 'usuariorol.id_rol')
                        ->where('usuariorol.id_usuario',$userId)
                        ->where('perfil.estado', 't')
                        ->groupBy('id_padre', 'menu.id_menu', 'perfil.estado', 'menu.id_tarea')
                        ->orderBy('id_padre')
                        ->get();
           
                        $in = array();
                        $inHijo = array();
            foreach ($menus as $menu) {
                if (!in_array($menu->id_padre, $in)) {
                    $in[] = $menu->id_padre;
                }
                if (!in_array($menu->id_tarea, $inHijo)) {
                    $inHijo[] = $menu->id_menu;
                }
            }

            $buscarPadre = true;
            $inPadres = $in;
            $primeraVez = true;
            while ($buscarPadre) {
                $inPadres = array();
                if ($primeraVez) {
                    $inPadres = $in;
                    $primeraVez = false;
                }

                if (count($inPadres) > 0) {
                    $menu = DB::table('menu')
                                ->select('menu.id_padre')
                                ->leftJoin('tarea', 'menu.id_tarea', '=', 'tarea.id_tarea')
                                ->whereIn('id_menu', $inPadres)
                                ->groupBy('menu.id_padre')
                                ->get();
                    foreach ($menu as $m) {

                        if (!in_array($m->id_padre, $in)) {
                            $inPadres[] = $m->id_padre;
                            if (!in_array($m->id_padre, $in)) {
                                $in[] = $m->id_padre;
                            }
                        }
                    }
                } else {
                    $buscarPadre = false;
                }
            }
            $in = array_merge($in, $inHijo);

            if (!empty($in)) {
                $menu = DB::table('menu')
                                ->select('menu.id_padre', 'menu.id_menu', 'tarea.url', 'menu.nombre as nombreMenu', 'area.imagen as icono')
                                ->leftJoin('tarea', function($join) {
                                    $join->on('menu.id_tarea', '=', 'tarea.id_tarea');
                                    $join->where('tarea.estado', true);
                                })
                                ->leftJoin('area', 'menu.id_area', '=', 'area.id_area')
                                ->whereIn('id_menu', $in)
                                ->orderBy('menu.orden')
                                ->get();
            } else {
                $menu = array();
            }
            // $event->menu->add('Menu principal');
            
            $valores = json_decode($menu);
            $valoresCascada1 = [];
            $valoresCascada2 = [];
            $valoresDependencia = [];
            function buscarDependencia($valoresDependencia, $padre, $menu) {
                foreach ($valoresDependencia as $value) {
                    if ($value->id_padre == $padre && $value->id_menu == $menu && $value->depende == false) {
                        return false;
                    } else if ($value->id_menu == $padre) {
                        return $value->id_padre . "-" . $value->id_menu;
                    }
                }
            }
            foreach ($valores as $value) {
                $obj =  new \stdClass();
                $obj->id_padre = $value->id_padre;
                $obj->id_menu = $value->id_menu;
                $buscaHijo = true;
                if ($value->id_padre == $value->id_menu && empty($value->url)) {
                    $obj->depende = false;
                    $valoresDependencia[] = $obj;
                    $buscaHijo = false;
                    $value->hijos = [];
                } else if (empty($value->url)) {
                    $obj->depende = true;
                    $valoresDependencia[] = $obj;
                    $value->hijos = [];
                }

                $buscar = true;
                $cadenaDependencia = [];
                $padre = $value->id_padre;
                $menu = $value->id_menu;
                while ($buscar) {
                    $retorno = buscarDependencia($valoresDependencia, $padre, $menu);
                    if ($retorno == false) {
                        $buscar = false;
                    } else if (!empty($retorno)) {
                        $partesRetorno = explode("-", $retorno);
                        $cadenaDependencia[] = $partesRetorno[0] . "-" . $partesRetorno[1];
                        $padre = $partesRetorno[0];
                        $menu = $partesRetorno[1];
                    }
                }

                $dependencia = array_reverse($cadenaDependencia);
                $value->dependencia = implode(",", $dependencia);
                $valoresCascada1[$value->id_padre . "-" . $value->id_menu] = $value;

                if (!$buscaHijo) {
                    $valoresCascada2[$value->id_padre . "-" . $value->id_menu] = $value;
                } else {
                    $raiz = "";
                    $comvalvariable = [];

                    switch (count($dependencia)) {
                        case 1:
                            $valoresCascada2[$dependencia[0]]->hijos[$value->id_padre . "-" . $value->id_menu] = $value;
                            break;
                        case 2:
                            $valoresCascada2[$dependencia[0]]->hijos[$dependencia[1]]->hijos[$value->id_padre . "-" . $value->id_menu] = $value;
                            break;
                        case 3:
                            $valoresCascada2[$dependencia[0]]->hijos[$dependencia[1]]->hijos[$dependencia[2]]->hijos[$value->id_padre . "-" . $value->id_menu] = $value;
                            break;
                        default:
                            die("Error con valor " . $value->id_padre . "-" . $value->id_menu . ". No concuerda la cantidad de dependecias.");
                            break;
                    }
                }
                // echo $value->id_padre . "-" . $value->id_menu . " depende: " . implode(",", array_reverse($cadenaDependencia)) . '<br>';
            }
            function tieneHijos($hijos){
                return count($hijos)>0;
            }
            $string="";
            foreach($valoresCascada2 as $menuRow){
                // dump($menuRow);
               
                if(tieneHijos($menuRow->hijos)){
                    $arrayStringsHIjos=array();
                    foreach($menuRow->hijos as $hijo){
                        $principalHIjos="[
                            'text' => $hijo->nombreMenu,
                            'url' =>,
                        ]";
                        $arrayStringsHIjos[]=$principalHIjos;
                    }
                    
                    
                }else{
                   
                 }
                 $string=implode(",",$arrayStringsHIjos);
                 $principal=[
                    'text' => $menuRow->nombreMenu,
                    'url' =>"",
                    'submenu'=>[$string]
                 ];
                //  var_dump(($principal));
                //  exit();
                // $event->menu->add($principal);
                // dump($event->menu->menu);
                // exit();
                
                
            }
            // $menuini=[
            //     'key'  => 'pages',
            //     'text' => 'Pages',
            //     'url'  => 'admin/pages',
            //     'icon' => 'far fa-fw fa-file',
            // ];
            // $event->menu->add($menuini);
           
            // $event->menu->addAfter('pages', [
            //     'key' => 'account_settings',
            //     'header' => 'Account Settings',
            // ]);
        
            // $event->menu->addIn('account_settings', [
            //     'key' => 'account_settings_notifications',
            //     'text' => 'Notifications',
            //     'url' => 'account/edit/notifications',
            // ]);
        
            // $event->menu->addBefore('account_settings_notifications', [
            //     'key' => 'account_settings_profile',
            //     'text' => 'Profile',
            //     'url' => 'account/edit/profile',
            // ]);
        
        });
    }
}
