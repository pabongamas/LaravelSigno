<div>
    <div class="mx-auto max-w-8xl font-sans">
        <div class="lg:flex lg:items-center lg:justify-between  md:flex md:items-center md:justify-between  sm:flex sm:items-center sm:justify-between  p-3 md:flex md:items-center md:justify-between  p-3">
          <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">Administracion de usuarios</h2>
          </div>
          <div class=" flex lg:ml-4 lg:mt-0">
            <button wire:click="openModalAdmin('new')" class=" p-1 px-8 w-w100 btn bg-primary-500 hover:bg-primary-400 text-whitePrincipal hover:text-whitePrincipal">+ Nuevo</button>
          </div>
        </div>
      
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="table w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th class="w-w10 px-6 py-3 text-center" scope="col" colspan="2">Acciones</th>
            <th scope="col" class="text-center w-w10 px-6 py-3">Id</th>
            <th scope="col" class="text-left w-w40 px-6 py-3">Nombres y apellidos</th>
            <th scope="col" class="text-left w-w30 px-6 py-3">usuario</th>
            <th scope="col" class="text-center w-w30 px-6 py-3">Contraseña</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($usuarios as $user)
              <tr class="border-b">
                <td class="w-w5 text-center px-2 py-2">
                    <button class="lg:w-w100 md:w-w90 p-1 px-8 w-w100 btn bg-secondary-500 hover:bg-secondary-400 text-whitePrincipal hover:text-whitePrincipal">Eliminar</button>
                </td>
                <td class="w-w5 text-center px-2 py-2">
                    <button wire:click="openModalAdmin('edit')" class="lg:w-w100 md:w-w90 p-1 px-8 w-w100 btn bg-primary-500 hover:bg-primary-400 text-whitePrincipal hover:text-whitePrincipal">Editar</button>
                </td>
                <td class="w-w10 text-center px-2 py-2">
                    <span>{{$user->id_usuario}}</span>
                </td>
                <td class="w-w40 px-2 py-2">
                    <span>{{$user->nombre_usuario}} {{$user->apellidos_usuario}}</span>
                </td>
                <td class="w-w30 px-2 py-2">
                    <span>{{$user->login}}</span>
                </td>
                <td class="w-w30 text-center px-2 py-2">
                    @if ($editingUserId == $user->id_usuario)
                        <input type="password" wire:model="password" wire:blur="updatePassword()" placeholder="Ingrese contraseña" class="form-control shadow-md focus:bg-primary-100 border-1px border-solid border-primary-500 focus:border-1px">
                    @else
                        <span wire:click='changePassword({{$user->id_usuario}})' class="cursor-pointer hover:underline decoration-solid" >*********</span>
                    @endif
                    
                </td>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="modal" id="modalAdmin" data-bs-toggle="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
                <div class="lg:flex lg:items-center lg:justify-between  md:flex md:items-center md:justify-between   sm:flex sm:items-center sm:justify-between  md:flex md:items-center md:justify-between ">
                    <div class="min-w-0 flex-1">
                      <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight titleAdminModal"></h2>
                    </div>
                    <div class=" flex lg:ml-4 lg:mt-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                  </div>

              {{-- <h5 class="modal-title">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
              <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="p-1 px-8 btn bg-secondary-500 hover:bg-secondary-400 text-whitePrincipal hover:text-whitePrincipal" data-bs-dismiss="modal">Close</button>
              <button type="button" class="p-1 px-8 btn bg-primary-500 hover:bg-primary-400 text-whitePrincipal hover:text-whitePrincipal">Save changes</button>
            </div>
          </div>
        </div>
      </div>
      @push('js')
      <script>
          // Escucha el evento 'mostrar-alerta'
          Livewire.on('mostrar-alerta', function(data) {
              // Muestra la alerta de SweetAlert
              Swal.fire({
                  title: data.titulo,
                  text: data.mensaje,
                  icon: data.tipo
              });
          });
          Livewire.on('open-modal', function(data) {
            $(".titleAdminModal").html(data.title);
            $("#modalAdmin").modal("show");
          });
      </script>
  @endpush
</div>
