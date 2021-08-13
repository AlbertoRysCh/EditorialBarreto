@extends('layouts.app')
@section('content')
<main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                       <h3>Asesores Ventas</h3><br/>
                    
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'asesorventas','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
                                <div class="input-group">
                                   
                                    <input type="text" name="buscarTexto" class="form-control" placeholder="Buscar texto" value="{{$buscarTexto}}">
                                    <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            {{Form::close()}}
                            </div>
                        </div>
                        <table class="table table-responsive table-lg">
                            <thead>
                                <tr class="bg bordearriba">
                                    {{-- <th>Ver</th> --}}
                                    <th>Documento</th>
                                    <th>nombres</th>
                                    <th>Teléfono</th>
                                    <th>correo</th>
                                    <th>Estado</th>
                                    <th>Cambiar Estado</th>
                                </tr>
                            </thead>
                            <tbody>

                               @foreach($asesoresventas as $ase)
                                <tr>
                                    <td>{{$ase->num_documento}}</td>
                                    <td>{{$ase->nombres}}</td>
                                    <td>{{$ase->telefono}}</td>
                                    <td>{{$ase->correo}}</td>                      
                                    <td>
                                      @if($ase->condicion=="1")
                                        <button type="button" class="btn btn-success btn-md">
                                    
                                          <i class="fa fa-check"></i> Activo
                                        </button>
                                      @else
                                        <button type="button" class="btn btn-danger btn-md">
                                          <i class="fa fa-check"></i> Desactivado
                                        </button>
                                       @endif
                                    </td>
                                    
                                    <td>
                                        <button class="btn btn-{{$ase->condicion == 1 ? 'danger' : 'success'}} btn-md" data-id="{{$ase->id}}" data-idusuario="{{$ase->usuario_id}}" data-toggle="modal" data-target="#cambiarEstado" data-keyboard="false" data-backdrop="static">
                                        <i class="fa fa-{{$ase->condicion == 1 ? 'times': 'lock'}}"></i> {{$ase->condicion == 1 ? 'Desactivar' : 'Activar'}}
                                        </button>
                                    </td>

                                    
                                </tr>

                                @endforeach
                               
                            </tbody>
                        </table>
                            
                            {{$asesoresventas->render()}}

                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            
             <!-- Inicio del modal Cambiar Estado del usuario -->
             <div class="modal fade" id="cambiarEstado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-danger" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cambiar Estado del Asesor de venta</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>

                    <div class="modal-body">
                        <form action="" method="POST" id="formAsesorVentas">
                            {{csrf_field()}}
                            @method('DELETE')

                         <input type="hidden" id="asesor_usuario_id" name="asesor_usuario_id" value="">
                         <input type="hidden" id="idusuario" name="idusuario" value="">

                                <p>Estas seguro de cambiar el estado?</p>
        

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>Cerrar</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-lock"></i>Aceptar</button>
                            </div>

                         </form>
                    </div>
                    <!-- /.modal-content -->
                   </div>
                <!-- /.modal-dialog -->
             </div>
            <!-- Fin del modal Eliminar -->
           
        </main>

        @endsection
@push('scripts')
    
<script>
    // Cambiar de estado del prospecto
    $("#cambiarEstado").on("show.bs.modal", function (e) {
        var btn = $(e.relatedTarget);
        var id = btn.data('id');
        $("#asesor_usuario_id").val(btn.attr('data-id'));
        $("#idusuario").val(btn.attr('data-idusuario'));
        if (id > 0) {
          var action = '{{route('asesorventas.destroy',"@id")}}';
          action = action.replace("@id", id);
          $("#formAsesorVentas").prop("action", action);
        }
    });
</script>
 @endpush