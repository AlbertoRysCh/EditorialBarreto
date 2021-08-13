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

                       <h3>Prospectos/Clientes</h3><br/>
                        
                      
                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="">
                            <i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar prospecto
                        </button>
                        
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                         
                                <div class="input-group">
                                   
                                    <input type="text" name="buscarTexto" class="form-control" placeholder="Buscar texto" value="{{buscartexto}}">
                                    <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                              <div class="col">
                              <p style="margin-bottom: -10px;">
                               <strong>Total Prospectos:</strong>
                    
                               </p> 
                            </div>
                            <div class="col">
      
                            </div>
                           </div>
                         </div>
                        <table class="table table-responsive table-sm">
                            <thead>
                                <tr class="bg nuevo">
                                   
                                    <th style="width: 10%">Código</th>
                                    <th style="width: 15%">Prospecto</th>
                                    <th style="width: 10%">Asesor Venta</th>
                                    <th style="width: 10%">Aviso</th>
                                    <th style="width: 15%">Tipo de Cliente</th>
                                    <th style="width: 10%">Estado</th>
                                   
                                    <th style="width: 10%">Editar</th>
                                    <th style="width: 10%">Cambiar Estado</th>
                                    
                                </tr>
                            </thead>
                            </table>
                            
                        
                            

                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar-->
            <div class="modal fade" id="modalProspecto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header cabeceramodal">
                            <h4 class="modal-title"></h4>
                            <span class="show_wait_load" style="font-size: small;display: none">
                                <div class="text-center">
                                <button class="btn btn-success" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </button>
                                </div> 
                    
                            </span>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                             
                            <form action="" method="post" class="form-horizontal" id="formCreateUpdate">
                                <input type="hidden" name="_method" value="PUT" id="PUTMETHOD"/>
                                <input type="hidden" name="editando" value="0" id="editando"/>
                                <input type="hidden" id="cliente_update_id" name="cliente_id" value="">
                                <input type="hidden" name="location" value="0">
                               
                            </form>
                        </div>
                        
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            
             <!-- Inicio del modal Cambiar Estado del usuario -->
             <div class="modal fade" id="cambiarEstado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-danger" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cambiar Estado del Prospecto</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>

                    <div class="modal-body">
                        <form action="" method="POST" id="formProspectos">
                            

                            <input type="hidden" id="cliente_delete_id" name="cliente_id" value="">

                                <p>Estás seguro de cambiar el estado?</p>
        

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
