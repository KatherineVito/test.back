@extends('layout.main')
@section('content')
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
-->
<h1 class="h3 mb-2 text-gray-800"><b>Relación de DNIS creados</b></h1>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <!--<a href="/admin/dni/imprimir" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-print fa-sm text-white-50"></i>&nbsp; Imprimir registros de dnis del día actual
    </a>-->
    <a href="/admin/dni/csv" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-file fa-sm text-white-50"></i>&nbsp; Descargar Data en formato .csv
    </a>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4 p-5">
    <div class="categoria">
        <button class="seleccion" id="primerizo"  onclick="openCity(event, 'Fecha')">Búsqueda Específica</button>
        <button class="seleccion" onclick="openCity(event, 'Especial')">Búsqueda por Fecha</button>
      </div>

    @if($message = Session::get('True'))
        <!--<div class="col-12 alert alert-success alert-dismissable fade show " role="alert">
            <h5>Mensaje: </h5>
            <span>{{ $message }}</span>
        </div>-->
    @endif


<style>
.categoria{
    text-align: center;
    margin-bottom: 3%;
    font-size: 16px;
}
.categoria button.active {
  background-color: #ccc;
font-weight: bold
}
.seleccion{
 border: none;
 background-color: inherit;
 padding: 14px 28px;
 cursor: pointer;
 display: inline-block;
}
.form_especial{
display: none;
}
.seleccion:hover{
background: #eee;
}
.dataTables_filter {
display: none;
}
    </style>

  <!-- Segundo Tab a Aparecer-->
    <div class="col-xl-12 form_especial" id="Fecha">

            <div class="mb-2">
                <span><b>📋 Si selecciona la opción "Dnis registrados al día" solo tiene que dar click en "Buscar".</b> (*) </span>
            </div>
            <form action="/admin/reports" method="get" class="p-2  my-3">
            <div class="form-row">
                <select class="col-sm-4 form-control my-1 mr-2" name="select" id="specialsearcher" onchange="val()">
                    <option value="default" selected>Seleccione el tipo de búsqueda</option>
                    <option value="dni_number_pet">Número de dni</option>
                    <option value="today">Dnis registrados al día</option>
                    <option value="cellphone_owner">Número de celular</option>
                    <option value="lastname_pet">Apellido de la mascota</option>
                    <option value="name_pet">Nombre de la mascota</option>
                    <option value="date_enrollment_pet">Fecha de inscripción del dni</option>
                    <option value="birthday_pet">Fecha de nacimiento de la mascota</option>
                    <option value="country_code">Código del país</option>
                    <option value="name_owner">Nombre del dueño</option>
                    <option value="lastname_owner">Apellido del dueño</option>
                    <option value="gender_pet">Género de la mascota</option>
                    <option value="specie_type_pet">Tipo de mascota</option>
                    <option value="breed_pet">Especie de mascota</option>
                    <option value="duplicated_pet">Duplicidad de mascota</option>
                  </select>

            <div class="col-sm-4 my-1 mr-2" id="datesearcher">
                    @if(isset($texto))
            <input type="date" class="form-control" type="search"  id="subdatesearcher1" placeholder="Dato a Escribir">        
                    @else
            <input type="date" class="form-control" type="search"  id="subdatesearcher2" placeholder="Dato a Escribir">        
                    @endif
            </div>
            <div class="col-sm-4 my-1 mr-2" id="inputsearcher">
                    @if(isset($texto))
                    <input type="text" class="form-control" type="search" id="searchrequired1" value="{{$texto}}" placeholder="Dato a Escribir">        
                   @else
                    <input type="text" class="form-control" type="search" id="searchrequired2" placeholder="Dato a Escribir">
                    @endif
            </div>
            <div class="col-sm-4 my-1 mr-2" id="selectsearcher1">
                    @if(isset($texto))
                    <select class="form-control" type="search"  id="subselectsearcher1" value="{{$texto}}">
                        <option value="">--Selecciona un tipo---</option>
                        <option value="Gato">Gato</option>
                        <option value="Perro">Perro</option>
                        <option value="Ave">Ave</option>
                        <option value="Lagomorfo">Lagomorfo</option>
                        <option value="Marsupial">Marsupial</option>
                        <option value="Roedor">Roedor</option>
                      </select>
                    @else
                    <select class="form-control" type="search"  id="subselectsearcher2">
                        <option value="">--Selecciona un tipo---</option>
                        <option value="Gato">Gato</option>
                        <option value="Perro">Perro</option>
                        <option value="Ave">Ave</option>
                        <option value="Lagomorfo">Lagomorfo</option>
                        <option value="Marsupial">Marsupial</option>
                        <option value="Roedor">Roedor</option>
                      </select>
                    @endif
            </div>
                <div class="col-auto my-1">
                    <input type="submit" id="firstfilterbutton" class="btn btn-outline-success" value="Buscar">
                </div>
            </div>
        </form>
    </div>
  <!-- Segundo Tab a Aparecer-->
 <!-- Primer Tab a Aparecer-->
 <div class="col-xl-12 form_especial" id="Especial">
    <div class="mb-2">
        <span><b>🗓 Selecciona un rango de la fecha de Inicio y la fecha de Fin</b> (*) </span>
    </div>
    <form action="/admin/reports" method="get" class="p-2 ml-1 my-3">
        <div class="form-row">
            <input type="date" id=start name="first_date" class="col-sm-4 form-control my-1 mr-2" required>

            <input type="date" pattern="yyyy-mm-dd hh:mm:ss.s" id=end name="last_date" class="col-sm-4 form-control my-1 mr-2" required>
            <div class="col-auto my-1">
                <input type="submit" class="btn btn-outline-warning" value="Buscar">
            </div>
        </div>
    </form>
</div>
<!-- Primer Tab a Aparecer-->
<h4 class="ml-2"><b>Total de registros encontrados: </b>{{ $dni_count }}</h4>
    <div class="card-body ml-1">
        <div class="table-responsive">
            <table cellspacing=0 class="table table-bordered table-hover table-inverse table-striped header_fijo" id=example width=100% data-page-length='100'>
                <thead>
                <tr>
                    <th>Acciones</th>
                    <th>Número de dni</th>
                    <th>Apellido de la mascota</th>
                    <th>Nombre de la mascota</th>
                    <th>Foto de la mascota</th>
                    <th>Fecha de creación del dni</th>
                    <th>Especie de la mascota</th>
                    <th>Apellido del dueño</th>
                    <th>Nombre del dueño</th>
                </tr>
                </thead>
                <tbody>
                @if(count($dnis)<=0)
                    <tr>
                        <td colspan="17"><b>No hay resultados, intentelo nuevamente</b></td>
                    </tr>
                @endif
                <div hidden>
                {{ $counter = 0 }}
                </div>
                @foreach($dnis as $dni)
                <tr id="row_{{$dni->dni_number_pet}}">
                    <td>
              {{--  @if(Auth::user()->rol == 'superadmin')
                        
                            <a href="javascript:void(0)" data-id="{{ $dni->dni_number_pet }}" class="btn btn-danger" onclick="DeleteAlert(event.target)">Borrar</a>
                        
                        @endif
                       
                            <a href="javascript:void(0)" data-id="{{ $dni->dni_number_pet }}" onclick="editPost(event.target)" class="btn btn-info">Mirar</a>
                    
                            <!--<a href="javascript:void(0)" data-id="" onclick="editPost(event.target)" data-toggle="modal" data-target="#post-modal" class="btn btn-info">Mostrar</a>
                            -->
                            <button class="btn btn-round">
                            <a href="javascript:void(0)" data-id="{{ $dni->dni_number_pet }}" data-pet="{{ $dni->breed_pet }}" 
                              @if($dni->specie_type_pet == 'Perro')
                              data-specie="1"
                              @elseif($dni->specie_type_pet == 'Gato')
                              data-specie="0"
                              @elseif($dni->specie_type_pet == 'Ave')
                              data-specie="2"
                              @elseif($dni->specie_type_pet == 'Lagomorfo')
                              data-specie="3"
                              @elseif($dni->specie_type_pet == 'Marsupial')
                              data-specie="4"
                             @else
                             data-specie="5"
                             @endif
                             onclick="Editar(event.target); SelectSpecie(event.target);" 
                             class="i fas fa-edit fa-2x" style="color:gray"></a>
                            </button>

                        <button class="btn btn-round">
                        <!-- Also the "dni_back" as a download's route API link is working... -->
                        <!-- https://fontawesome.com/v5.15/icons/money-check?style=solid -->
                        <a href="https://back.peid.pet/api/download/certipeid/{{ $dni->dni_number_pet }}" download> <i class="fas fa-file-download fa-2x" style="color:green"></i></a>
                        </button>
                        <button class="btn btn-round">
                            <a href="https://back.peid.pet/api/download/dni_front/{{ $dni->dni_number_pet }}" download> <i class="fas fa-address-card fa-2x" style="color:purple"></i></a>
                            </button>
                            <button class="btn btn-round">
                              <a href="https://back.peid.pet/api/download/dni_back/{{ $dni->dni_number_pet }}" download> <i class="fas fa-money-check fa-2x" style="color:orange"></i></a>
                              </button>
                            <button class="btn btn-round">
                            <a href="https://peid.pet/dni/{{$dni->dni_number_pet}}" target="_blank"><i class="fas fa-eye fa-2x"></i></a>
                            </button>--}}

                           <div class="btn-group dropright">
                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Opciones
                              </button>
                              <div class="dropdown-menu" >
                                  <a class="dropdown-item" href="javascript:void(0)" data-id="{{ $dni->dni_number_pet }}" onclick="editPost(event.target)" >Visualizar datos de dni<i class="fas fa-address-card fa-1x ml-2" style="color:orange"></i></a>
                                  <a class="dropdown-item" href="javascript:void(0)"data-id="{{ $dni->dni_number_pet }}" data-pet="{{ $dni->breed_pet }}" 
                                    @if($dni->specie_type_pet == 'Perro')
                                    data-specie="1"
                                    @elseif($dni->specie_type_pet == 'Gato')
                                    data-specie="0"
                                    @elseif($dni->specie_type_pet == 'Ave')
                                    data-specie="2"
                                    @elseif($dni->specie_type_pet == 'Lagomorfo')
                                    data-specie="3"
                                    @elseif($dni->specie_type_pet == 'Marsupial')
                                    data-specie="4"
                                   @else
                                   data-specie="5"
                                   @endif
                                   onclick="Editar(event.target); SelectSpecie(event.target);">Editar dni<i class="fas fa-edit fa-1x ml-2" style="color:blue"></i></a>
                                  @if(Auth::user()->rol == 'superadmin')
                                  <a class="dropdown-item" href="javascript:void(0)" data-id="{{ $dni->dni_number_pet }}" onclick="DeleteAlert(event.target)">Eliminar dni<i class="fas fa-trash fa-1x ml-2" style="color:red"></i></a>
                                  @endif
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item" href="https://peid.pet/dni/{{$dni->dni_number_pet}}" target="_blank">Visualizar dni<i class="fas fa-eye fa-1x ml-2" style="color:purple"></i></a>
                                  <a class="dropdown-item" href="https://back.peid.pet/api/download/certipeid/{{ $dni->dni_number_pet }}" download>Descargar certificado<i class="fas fa-file-download fa-1x ml-2" style="color:green"></i></a>
                                  <a class="dropdown-item" href="https://back.peid.pet/api/download/dni_front/{{ $dni->dni_number_pet }}" download >Descargar DNI frontal<i class="fas fa-money-check fa-1x ml-2" style="color:cyan"></i></a>
                                  <a class="dropdown-item" href="https://back.peid.pet/api/download/dni_back/{{ $dni->dni_number_pet }}" download >Descargar DNI trasero <i class="fas fa-money-check fa-1x ml-2" style="color:cyan"></i></a>
                                  <a class="dropdown-item" href="https://back.peid.pet/api/qr/{{ $dni->dni_number_pet }}" download >Descargar Código QR <i class="fas fa-qrcode fa-1x ml-2" style="color:black"></i></a>
                                  <a class="dropdown-item" href="https://back.peid.pet/api/download_image/{{ $dni->dni_number_pet }}" download >Descargar Código Imagen <i class="fas fa-file-image fa-1x ml-2" style="color:brown"></i></a>                         
                                </div>
                          </div>

                        <form action="{{ url('/admin/dni/delete', ['id'=>$dni->dni_number_pet ]) }}" method="post" id="formDelete_{{ $dni->dni_number_pet }}" >
                            @csrf
                            <input type="hidden" name="id" value="{{ $dni->dni_number_pet }}">
                            <input type="hidden" name="_method" value="delete">
                        </form>
                    </td>
                    <td>{{ $dni->dni_number_pet }}</td>
                    <td>{{ $dni->lastname_pet }}</td>
                    <td>{{ $dni->name_pet }}</td>
                    <td>  <img class="profile-id" src="data:image/png;base64,{{ $array_image[$counter++] }}" alt=""></td>
                    <td>{{ $dni->date_enrollment_pet }}</td>
                    <td>{{ $dni->specie_type_pet }}</td>
                    <td>{{ $dni->lastname_owner }}</td>
                    <td>{{ $dni->name_owner }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>


         @if(isset($texto))
        {{ $dnis->appends(['select' => $select,'texto' => $texto])->links() }}
         @else
            @if(isset($select))
                {{ $dnis->appends(['select' => $select])->links() }}
             @else
                {{ $dnis->links() }}
             @endif
         @endif


        </div>
    </div>
</div>


<!-- Modal Detalla de Datos -->

<div class="modal fade" id="post-modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title"><b>Visualización del Dni de mascota</b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            
              <form name="userForm" class="form-horizontal">

          
                 <input type="hidden" name="post_id" id="post_id">

                 <style>
                   .seleccion:hover .show{
                        border-top-style: hidden;
                      border-right-style: hidden;
                      border-left-style: hidden;
                      border-bottom-style: groove;
                    }
                    </style>
                    
                  <div class="form-group">
                      
                      <div class="col-sm-12">
<div class="col-sm-6">
    <label for="name">Dni de la mascota
    <input type="text" class="form-control show" id="dnumpet"  placeholder="Enter title" disabled></label>
</div>   
<div class="col-sm-6">
    <label for="name">Apellido de la mascota
    <input type="text" class="form-control show" id="apemas"  placeholder="Enter title" disabled></label>
</div>   
                </div>
                  </div>
                <div class="form-group">    
<div class="col-sm-12">
<div class="col-sm-6">
  <label for="name">Cumpleaños de la mascota
 <input type="text" class="form-control show" id="cumplepet" disabled></label>
</div>   
<div class="col-sm-6">
  <label for="name">Género de la mascota
  <input type="text" class="form-control show" id="genpet"  disabled></label>
</div>   
                    </div>
                </div>
<div class="form-group">    
<div class="col-sm-12">
<div class="col-sm-6">
<label for="name">Nombre del dueño
<input type="text" class="form-control show" id="nomdue" disabled></label>
</div>   
 <div class="col-sm-6">
<label for="name">Apellido del dueño
<input type="text" class="form-control show" id="apedue"  disabled></label>
</div>   
            </div>
            </div>
     <div class="form-group">    
<div class="col-sm-12">
<div class="col-sm-6">
  <label for="name">Fecha de Inscripción DNI
 <input type="text" class="form-control show" id="sss" disabled></label>
</div>   
<div class="col-sm-6">
  <label for="name">Especie de la mascota
  <input type="text" class="form-control show" id="esppet"  disabled></label>
</div>   
                    </div>
                </div>

     <div class="form-group">    
<div class="col-sm-12">
<div class="col-sm-6">
  <label for="name">Dirección IP
 <input type="text" class="form-control show" id="dirip" disabled></label>
</div>   
<div class="col-sm-6">
  <label for="name">Nombre del País
  <input type="text" class="form-control show" id="nompais"  disabled></label>
</div>   
                    </div>
                </div>
<div class="form-group">    
<div class="col-sm-12">
     <div class="col-sm-6">
    <label for="name">Región/Departamento/Estado
 <input type="text" class="form-control show" id="redees" disabled></label>
    </div>   
    <div class="col-sm-6">
    <label for="name">Provincia
    <input type="text" class="form-control show" id="provin"  disabled></label>
    </div>   
    </div>
    </div>

              </form>
          </div>
          <div>
           <!--<center><a href="javascript:void(0)" id="borrapet" data-id="" class="btn btn-danger rounded-0 btn-lg btn-block" onclick="deletePost(event.target)" data-dismiss="modal" aria-label="Close">Eliminar Dni</a>
          </center> -->
          </div>
     </div>
    </div>
  </div>

 <!-- Modal Detalla de Datos -->



<!-- Modal Eliminar-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar dni</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>¿Desea eliminar el dni?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger btnModalEliminar">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editamos-->
<div class="modal fade" id="editar-modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title"></h4>
          </div>
          <form action="/admin/dni/edit" method="post">
            @csrf
          <div class="modal-body">      
               <input type="hidden" name="id" id="dnumpet2">
               
               <style>
                 .seleccion:hover .show{
                      border-top-style: hidden;
                    border-right-style: hidden;
                    border-left-style: hidden;
                    border-bottom-style: groove;
                  }
                  </style>
                  
                <div class="form-group">
                    
                    <div class="col-sm-12">
<div class="col-sm-6">
  <label for="name">Nombre de la mascota
  <input type="text" name="name_pet" class="form-control show" id="name_pet2" placeholder="Enter title" required></label>
</div>   
<div class="col-sm-6">
  <label for="name">Apellido de la mascota
  <input type="text" name="lastname_pet" class="form-control show" id="lastname_pet2"  placeholder="Enter title" required></label>
</div>   
              </div>
                </div>
              <div class="form-group">    
<div class="col-sm-12">
<div class="col-sm-6">
<label for="name">Género de la mascota
    <select id="gender_pet2" name="gender_pet" class="form-control show">
        <option value="macho">Macho</option>
        <option value="hembra">Hembra</option>
      </select>
</label>
</div>   
<div class="col-sm-6">
<label for="name">Especie de la mascota
      <select id="specie_type_pet2" name="specie_type_pet" class="form-control show" required>
       <!-- <option  value="" selected>--Selecciona--</option>-->
        <option  value="">--Selecciona--</option>
        <option data-id="0" value="Gato">Gato</option>
        <option data-id="1" value="Perro">Perro</option>
        <option data-id="2" value="Ave">Ave</option>
        <option data-id="3" value="Lagomorfo">Lagomorfo</option>
        <option data-id="4" value="Marsupial">Marsupial</option>
        <option data-id="5" value="Roedor">Roedor</option>
      </select>
</label>
</div>   
                  </div>
              </div>
<div class="form-group">    
<div class="col-sm-12">
<div class="col-sm-6">
<label for="name">Raza de la mascota
  
    {{-- <select id="breed_pet2" name="breed_pet" class="form-control show" required>
        <option value="">-</option>
     @foreach ($json3 as $select_option)
          <option value="{{ $select_option['name'] }}">{{ $select_option['name'] }}</option>
  @endforeach
      </select>--}}
   {{--   <select id="breed_pet2" name="breed_pet" class="form-control show" required>
      </select>--}}
      <select name="breed_pet" id="breed_pet2" class="form-control show" required>
        <option value="">-- Select Sub Category --</option>
    </select>
</div>   
<div class="col-sm-6">
<label for="name">Apellido del dueño
<input type="text" name="lastname_owner" class="form-control show" id="lastname_owner2" required></label>
</div>   
          </div>
          </div>
   <div class="form-group">    
<div class="col-sm-12">
<div class="col-sm-6">
<label for="name">Nombre del dueño
<input type="text" name="name_owner" class="form-control show" id="name_owner2" required></label>
</div>   
<div class="col-sm-6">
<label for="name">Celular del dueño
<input type="text"  name="cellphone_owner" class="form-control show" id="cellphone_owner2" required></label>
</div>   
                  </div>
   </div>
   <div class="form-group">   
<div class="col-sm-12">
<div class="col-sm-6">
<label for="name">Email del dueño
<input type="email" name="email_owner" class="form-control show" id="email_owner2"></label>
</div>   
</div>
              </div>
            
        </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          </div>
        </form>
      </div>
    </div>
  </div>
    
<!-- Modal Editar-->

<!-- Modal Alerta Borrar-->
<div class="modal fade" id="alertdelete-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><b>¿Desea eliminar este DNI?</b></h4>
        </div>
        <div class="modal-body">
          
   
<center>
            <p class = "tpbutton btn-toolbar" style="text-align:center">
              <a class = "btn navbar-btn btn-lg btn-default" data-dismiss="modal" style="width: 100%;">No</a>
              <a href="javascript:void(0)" id="borrapet" data-id="" data-dismiss="modal" class = "btn navbar-btn btn-lg btn-danger" style="width: 100%;" onclick="deletePost(event.target)">Sí, Eliminar</a>
            </p>
</center>
             <input type="hidden" name="post_id" id="alertaid">

             <style>
               .seleccion:hover .show{
                    border-top-style: hidden;
                  border-right-style: hidden;
                  border-left-style: hidden;
                  border-bottom-style: groove;
                }
                </style>
                
      </div>

    </div>
  </div>
</div>
  
<!-- Modal Alerta Borrar-->
@endsection
@section('scripts')
    <!-- To change languaje to datatables: https://datatables.net/plug-ins/i18n/Spanish -->
    <!--<script src=https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/js/jquery.dataTables.min.js></script>
    <script src=https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/js/dataTables.bootstrap4.min.js></script>
    -->
    <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>-->
   <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>-->
  <!--<script src="https://code.jquery.com/jquery-3.5.0.js"></script>-->
  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
  
  
  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->
 <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script> -->


  <script src=https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/js/jquery.dataTables.min.js></script>
  <script src=https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/js/dataTables.bootstrap4.min.js></script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>-->
  <!-- <script src="https://code.jquery.com/jquery-3.5.0.js"></script> -->


    
        <script>
      var idEliminar = 0;
      $(document).ready(function() {
          $('#example').DataTable( {
              "language": {
                  "sProcessing": "Procesando...",
                  "sLengthMenu": "     _MENU_ ",
                  "sZeroRecords": "No se encontraron resultados",
                  "sEmptyTable": "Ningún dato disponible en esta tabla",
                  "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                  "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                  "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                  "sSearch": "Búsqueda rápida:",
                  "sInfoThousands": ",",
                  "sLoadingRecords": "Cargando...",
                  "oPaginate": {
                      "sFirst": "Primero",
                      "sLast": "Último",
                      "sNext": "Siguiente",
                      "sPrevious": "Anterior"
                  },
                  "oAria": {
                      "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                      "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                  },
                  "buttons": {
                      "copy": "Copiar",
                      "colvis": "Visibilidad"
                  },
              }
          }
      );
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
          $(".btnModalEditar").click(function() {
              idEliminar = $(this).data('id');
          });
          $(".btnEditar").click(function(){
              $("#idEdit").val($(this).data('id'));
              $("#namePetEdit").val($(this).data('namepet'));
              $("#lastnamePetEdit").val($(this).data('lastnamepet'));
              $("#genderPetEdit").val($(this).data('genderpet'));
              $("#specieTypePetEdit").val($(this).data('specietypepet'));
              $("#lastNameOwnerEdit").val($(this).data('lastnameowner'));
              $("#nameOwnerEdit").val($(this).data('nameowner'));
              $("#cellphoneOwnerEdit").val($(this).data('cellphoneowner'));
              $("#emailOwnerEdit").val($(this).data('emailowner'));
              $("#breedPetEdit").val($(this).data('breedpet'));
          });
      })
      /* Block Filtration to Range for FirstDate and LastDate from HTML input's */
    var start = document.getElementById('start');
    var end = document.getElementById('end');
    start.addEventListener('change', function() {
        if (start.value)
            end.min = start.value;
    }, false);
    end.addEventListener('change', function() {
        if (end.value)
            start.max = end.value;
    }, false);
    /**
    *
    * Function for clicks the selected box in every filter input type
    *
    **/
    function SelectedBox() {
    document.getElementById("primerizo").click();
    document.getElementById('inputsearcher').style.display = "none";
    document.getElementById("firstfilterbutton").disabled = true;
    document.getElementById('selectsearcher1').style.display = "none";
    document.getElementById('datesearcher').style.display = "none";
    }
    window.onpaint = SelectedBox();
    /* For https://stackoverflow.com/questions/4388248/disable-alert*/
    window.alert = function() {};

    /**
    *
    * Function for change view with Tabs for to select special search or search for date
    *
    */
    function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("form_especial");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("seleccion");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace("active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
    }
    /**
    *
    * Function for to change display for specialist searcher to selecting..
    *
    */
    function val() {
    d = document.getElementById("specialsearcher").value;
    if(d == 'today' || d == 'duplicated_pet'){
        document.getElementById('inputsearcher').style.display = "none";
        document.getElementById('selectsearcher1').style.display = "none";
        document.getElementById('datesearcher').style.display = "none";
        $('#searchrequired1').val('');
        $('#subselectsearcher1').val('');
        $('#subselectsearcher2').val('');
        $('#searchrequired2').val('');
        document.getElementById("firstfilterbutton").disabled = false;
    }else if(d == 'specie_type_pet'){
        document.getElementById('selectsearcher1').style.display = "block";
        document.getElementById('inputsearcher').style.display = "none";
        document.getElementById("firstfilterbutton").disabled = false;
        $("#selectsearcher1")
    .replaceWith('<div class="col-sm-4 my-1 mr-2" id="selectsearcher1">'+
                '@if(isset($texto))'+
                '<select class="form-control" type="search"  id="subselectsearcher1" name="texto">'+
                '<option value="">--Selecciona un tipo---</option>'+
                '<option value="Gato">Gato</option>'+
                '<option value="Perro">Perro</option>'+
                '<option value="Ave">Ave</option>'+
                '<option value="Lagomorfo">Lagomorfo</option>'+
                '<option value="Marsupial">Marsupial</option>'+
                '<option value="Roedor">Roedor</option>'+
                '</select>'+
                '@else'+
                '<select class="form-control" type="search"  id="subselectsearcher2" name="texto">'+
                '<option value="">--Selecciona un tipo---</option>'+
                '<option value="Gato">Gato</option>'+
                '<option value="Perro">Perro</option>'+
                '<option value="Ave">Ave</option>'+
                '<option value="Lagomorfo">Lagomorfo</option>'+
                '<option value="Marsupial">Marsupial</option>'+
                '<option value="Roedor">Roedor</option>'+
                '</select>'+
                '@endif'+
                '</div>');
    }else if(d == "date_enrollment_pet" || d == "birthday_pet"){
        document.getElementById('selectsearcher1').style.display = "none";
        document.getElementById('inputsearcher').style.display = "none";
        document.getElementById("firstfilterbutton").disabled = false;
        document.getElementById('datesearcher').style.display = "block";
        document.getElementById("firstfilterbutton").disabled = false;
        $("#datesearcher")
    .replaceWith('<div class="col-sm-4 my-1 mr-2" id="datesearcher">'+
    '@if(isset($texto))'+
    '<input type="date" class="form-control" type="search"  id="subdatesearcher1" name="texto" placeholder="Dato a Escribir">'+
    '@else'+
    '<input type="date" class="form-control" type="search"  id="subdatesearcher2" name="texto" placeholder="Dato a Escribir">'+   
    '@endif'+
    '</div>');
    }else if(d == 'default'){
        document.getElementById('selectsearcher1').style.display = "none";
        document.getElementById('inputsearcher').style.display = "none";
        document.getElementById('datesearcher').style.display = "none";
        document.getElementById("firstfilterbutton").disabled = true;
    }else{
        document.getElementById('selectsearcher1').style.display = "none";
        document.getElementById('inputsearcher').style.display = "block";
        document.getElementById('datesearcher').style.display = "none";
        document.getElementById("firstfilterbutton").disabled = false;
        $("#inputsearcher")
    .replaceWith('<div class="col-sm-4 my-1 mr-2" id="inputsearcher">'+
    '@if(isset($texto))'+
    '<input type="text" class="form-control" type="search" id="searchrequired1" name="texto" value="{{$texto}}" placeholder="Dato a Escribir">'+
    '@else'+
    '<input type="text" class="form-control" type="search" id="searchrequired2" name="texto" placeholder="Dato a Escribir">'+
    '@endif'+
    '</div>');
    }
    }

    /**
    * 
    * Function with Ajax for do an automatic delete in a row
    * 
    * @param event
    * @return with success a response for to delete a row in a specific DNI
    */ 
    function deletePost(event) {
      var id  = $(event).data("id");
      let _url = `/admin/dnis/${id}`;
      let _token   = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
          url: _url,
          type: 'DELETE',
          data: {
            _token: _token
          },
          success: function(response) {
            $("#row_"+id).remove();
          }
        });
    }

    /*
    *
    * Function for show of dymanic way the data of a specific Pet license with his Location apllying Inner JOIN from the Controller
    *
    * @param event
    * @return to Edit the DNI´s table
    */
    function editPost(event) {
      var id  = $(event).data("id");  
      let _url = `/admin/dnis/${id}`;
      $.ajax({
        url: _url,
        type: "GET",
        success: function(response) {
            if(response) {
              $("#dnumpet").val(response.dni_number_pet);
              $("#apemas").val(response.lastname_pet);
              $("#cumplepet").val(response.birthday_pet);
              $("#genpet").val(response.gender_pet);
              $("#nomdue").val(response.name_owner);
              $("#apedue").val(response.lastname_owner);
              $("#sss").val(response.date_enrollment_pet);
              $("#esppet").val(response.specie_type_pet);
              $("#dirip").val(response.ip_extra_information);
              $("#nompais").val(response.country_name_extra_information);
              $("#redees").val(response.region_department_or_state_extra_information);
              $("#provin").val(response.province_extra_information);
              $("#borrapet").data('id',response.dni_number_pet);
              $('#post-modal').modal('show');
            }
        }
      });
    }

    /**
    *
    * Delete DNI from Ajax with a event
    * 
    * @param  event
    * @return to Open Delete Alert as a warning to delete a specific DNI with its Certipeid and QR code
    **/
    function DeleteAlert(event) {
      var id = $(event).data("id");
              $("#alertaid").val(id);
              $("#borrapet").data('id',id);
              $('#alertdelete-modal').modal('show');

    }

    /** 
    *
    * Open a modal for Edit a specific Dni
    *  
    * @param event
    * @return to show Table DNI with Location's camps
    **/
    function Editar(event) {

   var id  = $(event).data("id");
      let _url = `/admin/dnis/${id}`;
      $.ajax({
        url: _url,
        type: "GET",
        success: function(response) {
            if(response) {
              $("#dnumpet2").val(response.dni_number_pet);
              $("#lastname_pet2").val(response.lastname_pet);
              $("#name_pet2").val(response.name_pet);
              $("#cumplepet").val(response.birthday_pet);
              $("#gender_pet2").val(response.gender_pet);
              $("#name_owner2").val(response.name_owner);
              $("#lastname_owner2").val(response.lastname_owner); 
              $("#cellphone_owner2").val(response.cellphone_owner);
              $("#email_owner2").val(response.email_owner);
              $("#sss").val(response.date_enrollment_pet);
              $("#specie_type_pet2").val(response.specie_type_pet);
              $("#breed_pet2").val(response.breed_pet);
              $("#ipe2").val(response.ip_extra_information);
              $("#cnepp2").val(response.country_name_extra_information);
              $("#ccepp2").val(response.country_code_extra_information);
              $("#redees2").val(response.region_department_or_state_extra_information);
              $("#pei2").val(response.province_extra_information);
              $("#dei2").val(response.district_extra_information)
              $('#editar-modal').modal('show');

            }
        }
   
      });
  }

   /** 
    *
    * Open a modal for to Charge the SpecieSelect when Model fot Edit is ready from json
    *  
    * @param event
    * @return to show the specific specie of the pet
    **/
  function SelectSpecie(event) {
      var id = $(event).data("specie");
    var mascota = $(event).data("pet");
     $("#breed_pet2").find('option').not(':first').remove();
   
   $.ajax({
        url:'searchYourBreed/'+id,
        type:'get',
        dataType:'json',
        success:function (response) {
          
          var len = 0;
          if (response['data'] != null) {
            len = response['data'].length;
          }
          if (len>0) {  
            for (var i = 0; i<len; i++) {
              $("#breed_pet2").val(mascota);
              var name = response['data'][i].name;
                var option = "<option value='"+name+"'>"+name+"</option>";   
                $("#breed_pet2").append(option);
            }
          }
        }
      })
 
  }
 
  $(document).ready(function() {
    $("#specie_type_pet2").change(function() {

        var id = $(this).find(':selected').data('id')
     $("#breed_pet2").find('option').not(':first').remove();
      $.ajax({
        url:'searchYourBreed/'+id,
        type:'get',
        dataType:'json',
        success:function (response) {
          var len = 0;
          if (response['data'] != null) {
            len = response['data'].length;
          }
          if (len>0) {  
            for (var i = 0; i<len; i++) {
              var name = response['data'][i].name;
                var option = "<option value='"+name+"'>"+name+"</option>";   
                $("#breed_pet2").append(option);
            }
          }
        }
      })
    });
  });


  </script>
@endsection