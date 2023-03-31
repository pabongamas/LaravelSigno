<div>
   
    <header class="p-3">
        <div class="flex items-center">
            <h1 class="inline-block text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight dark:text-slate-200">Administracion de usuarios</h1>
        </div>
      
    </header>
    
    <table class="table table-striped table-hover table-responsive font-sans">
        <thead>
          <tr>
            <th class="w-w10  text-center" scope="col" colspan="2">Acciones</th>
            <th scope="col" class="text-center w-w10">Id</th>
            <th scope="col" class="text-left w-w40">Nombres y apellidos</th>
            <th scope="col" class="text-left w-w30">usuario</th>
            <th scope="col" class="text-center w-w30">Contraseña</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($usuarios as $user)
              <tr>
                <td class="w-w5 text-center">
                    <button class="lg:w-w100 md:w-w90 p-1 px-8 w-w100 btn bg-secondary-500 hover:bg-secondary-400 text-whitePrincipal hover:text-whitePrincipal">Eliminar</button>
                </td>
                <td class="w-w5 text-center">
                    <button class="lg:w-w100 md:w-w90 p-1 px-8 w-w100 btn bg-primary-500 hover:bg-primary-400 text-whitePrincipal hover:text-whitePrincipal">Editar</button>
                </td>
                <td class="w-w10 text-center">
                    <span>{{$user->id_usuario}}</span>
                </td>
                <td class="w-w40">
                    <span>{{$user->nombre_usuario}} {{$user->apellidos_usuario}}</span>
                </td>
                <td class="w-w30">
                    <span>{{$user->login}}</span>
                </td>
                <td class="w-w30 text-center">
                    @if ($editingUserId == $user->id_usuario)
                        <input type="password" wire:model="password" wire:blur="updatePassword()" placeholder="Ingrese contraseña" class="form-control shadow-md focus:bg-primary-100 border-1px border-solid border-primary-500 focus:border-1px">
                    @else
                        <span wire:click='changePassword({{$user->id_usuario}})' class="cursor-pointer" >*********</span>
                    @endif
                    
                </td>
          @endforeach
        </tbody>
      </table>
</div>
