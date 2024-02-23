@extends('layout.main')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><b>Usuarios Admin</b></h1>
   <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addModal"><i
            class="fas fa-user fa-sm text-white-50"></i> Agregar Usuario Admin</a>
</div>

<div class="row">
  @if($message = Session::get('True'))
  <div class="col-12 alert alert-success alert-dismissable fade show" role="alert">
      <h5>Mensaje: </h5>
      <span>{{ $message }}</span>
  </div>
@endif

<div class="card-body">
  <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
          <tr>
            <td>Id</td>
            <td>Nombre</td>
            <td>Email</td>
            <td>Rol</td>
            <td>Acciones</td>
          <!--  <td>&nbsp;</td> -->
          </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <!--<td>{{ $user->password }}</td>-->
                <td>{{ $user->rol }}</td>
                <td>
                  @if(Auth::user()->rol == 'superadmin')
                    <button class="btn btn-round btnEliminar"
                            data-id="{{ $user->id }}"
                            data-toggle="modal"
                            data-target="#deleteModal" >
                      <i class="fa fa-trash"></i>
                    </button>
                  @endif
                  <button class="btn btn-round btnEditar"
                          data-id="{{ $user->id }}"
                          data-name="{{ $user->name }}"
                          data-email="{{ $user->email }}"
                          data-toggle="modal" data-target="#editModal" >
                        <i class="fa fa-edit"></i>
                  </button>
                  <form action="{{ url('/admin/usuarios', ['id'=>$user->id ]) }}" method="post" id="formDelete_{{ $user->id }}" >
                      @csrf
                      <input type="hidden" name="id" value="{{ $user->id }}">
                      <input type="hidden" name="_method" value="delete">
                  </form>
                </td>
            </tr>
            @endforeach
          </tbody>

      </table>
  </div>
</div>
</div>
<!-- Modal Agregar-->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregar Usuario Admin</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="/admin/usuarios" method="post">
            @csrf
            <div class="modal-body">
              @if($message = Session::get('ErrorInsert'))
              <div class="col-12 alert alert-danger alert-dismissable fade show" role="alert">
                  <h5>Errores:</h5>
                  <ul>
                      @foreach($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
            @endif
            <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="Ingresar Nombre" value="{{ old('nombre') }}">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Ingresar Email" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="pass1" placeholder="Ingresar contraseña">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="pass2" placeholder="Repetir contraseña">
            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
       </form>
      </div>
    </div>
  </div>

<!-- Modal Eliminar-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar Usuario Admin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
          <div class="modal-body">
              <h5>¿Desea eliminar el usuario?</h5>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger btnModalEliminar">Eliminar</button>
          </div>
    </div>
  </div>
</div>

<!-- Modal Editar-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Usuario Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/admin/usuarios/edit" method="post">
                @csrf
                <div class="modal-body">
                    @if($message = Session::get('ErrorEdit'))
                        <div class="col-12 alert alert-danger alert-dismissable fade show" role="alert">
                            <h5>Errores:</h5>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <input type="text" name="id" id="idEdit" value="{{ old('id') }}" hidden>
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" placeholder="Ingresar Nombre" value="{{ old('nombre') }}" id="nameEdit">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Ingresar Email" value="{{ old('email') }}" id="emailEdit">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="pass1" placeholder="Ingresar contraseña">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="pass2" placeholder="Repetir contraseña">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
  @endsection

@section('scripts')
<script>
  var idEliminar = 0;
   $(document).ready(function() {
      @if($message = Session::get('ErrorInsert'))
        $('#addModal').modal('show');
      @endif
      @if($message = Session::get('ErrorEdit'))
      $('#editModal').modal('show');
       @endif
      $(".btnEliminar").click(function(){
        idEliminar = $(this).data('id');
         // alert(id);
      });
      $(".btnModalEliminar").click(function(){
        $("#formDelete_"+idEliminar).submit();
      });
       $(".btnModalEditar").click(function(){
           idEliminar = $(this).data('id');
       });
       $(".btnEditar").click(function(){
           $("#idEdit").val($(this).data('id'));
           $("#nameEdit").val($(this).data('name'));
           $("#emailEdit").val($(this).data('email'));
       });
   })
</script>
@endsection
