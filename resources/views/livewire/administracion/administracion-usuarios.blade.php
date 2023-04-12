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
            <th scope="col" class="text-left w-w20 px-6 py-3">Nombres y apellidos</th>
            <th scope="col" class="text-left w-w20 px-6 py-3">usuario</th>
            <th scope="col" class="text-center w-w20 px-6 py-3">Contraseña</th>
            <th scope="col" class="text-center w-w20 px-6 py-3">Rol</th>
          </tr>
        </thead>
        <tbody class="">
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
                <td class="w-w20 px-2 py-2">
                    <span>{{$user->nombre_usuario}} {{$user->apellidos_usuario}}</span>
                </td>
                <td class="w-w20 px-2 py-2">
                    <span>{{$user->login}}</span>
                </td>
                <td class="w-w20 text-center px-2 py-2">
                    @if ($editingUserId == $user->id_usuario)
                        <input type="password" wire:model="password" wire:blur="updatePassword()" placeholder="Ingrese contraseña" class="form-control shadow-md focus:bg-primary-100 border-1px border-solid border-primary-500 focus:border-1px">
                    @else
                        <span wire:click='changePassword({{$user->id_usuario}})' class="cursor-pointer hover:underline decoration-solid" >*********</span>
                    @endif
                    
                </td>
                <td class="w-w20 text-center px-2 py-2">
                  <div wire:click="openModalAdmin('rol')"  class="rounded shadow-md btn bg-primary-500 hover:bg-primary-400 text-whitePrincipal hover:text-whitePrincipal">
                    <span>{{$user->roles>1?$user->roles." Roles":$user->roles." Rol"}}</span>
                  </div>
                </td>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="modal fade" id="modalAdmin" data-bs-toggle="modal" tabindex="-1">
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
              @if ($actionNew)
              <div class="row">
                <div class="col-lg-4 col-sm-12">
                  <label for="tipodoc" class="form-label">Tipo Documento</label>
                  <select name="tipodoc" class="form-control  hover:border-darkBtnPrimary focus:border-primary-400" id="tipodoc">
                  </select>
                </div>
                <div class="col-lg-8 col-sm-12">
                  <label for="tipodoc" class="form-label">N&uacute;mero de identificaci&oacute;n</label>
                  <input type="text" class="form-control hover:border-darkBtnPrimary focus:border-primary-400">
                </div>
              
              </div>
           
              {{-- <div class="mb-3 col-lg-12 col-md-6">
                <label for="tipodoc" class="form-label">Tipo Documento</label>
                <select name="tipodoc" class="form-control" id="tipodoc">
                </select>
              </div>
              <div class="mb-3 col-lg-12 col-md-6">
                <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
              </div> --}}
              @endif
             
            </div>
            <div class="modal-footer">
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
