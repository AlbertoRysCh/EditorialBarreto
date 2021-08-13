@extends('layouts.app')
@section('content')
<main class="main">
            <!-- Breadcrumb -->

            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                       <h2>Listado de libros</h2><br/>
                       @if(Auth::user()->idrol == 1 || Auth::user()->id == 3 || Auth::user()->id == 56 || Auth::user()->id == 10 || Auth::user()->id == 19 || Auth::user()->id == 40 || Auth::user()->id == 57  || Auth::user()->id == 59  || Auth::user()->id == 48 || Auth::user()->id == 46 || Auth::user()->id == 50 || Auth::user()->id == 57 || Auth::user()->id == 59 )                                           
                      <a href="resumen">

                       <button class="btn botonreporte btn-sm" type="button" data-toggle="modal" data-target="#abrirmodal">
                            <i class="fa fa-file-archive-o"></i>&nbsp;&nbsp;Ver Resumen
                        </button>

                      </a>
                      @endif

                      @if(Auth::user()->idrol == 1 || Auth::user()->id == 3  || Auth::user()->id == 56 || Auth::user()->id == 10 || Auth::user()->id == 19 || Auth::user()->id == 40 || Auth::user()->id == 57  || Auth::user()->id == 59  || Auth::user()->id == 48 || Auth::user()->id == 46 || Auth::user()->id == 50 || Auth::user()->id == 57 || Auth::user()->id == 59 )                                           

                      <a href="{{ url('/libros/exportar')}}">
                                       <button type="button" class="btn btn-success btn-sm">
                                         <i class="fa fa-arrow-down"></i> Exportar Excel
                                       </button> &nbsp;
                        </a>
                        @endif
                        @if(Auth::user()->idrol == 1 || Auth::user()->id == 3 || Auth::user()->id == 56  || Auth::user()->id == 10 || Auth::user()->id == 19 || Auth::user()->id == 24  || Auth::user()->id == 57  || Auth::user()->id == 59 || Auth::user()->id == 46 || Auth::user()->id == 40 || Auth::user()->id == 48 || Auth::user()->id == 46 || Auth::user()->id == 50 || Auth::user()->id == 57 || Auth::user()->id == 59 )                                           

                        <a href="{{ url('/pdflibros')}}">
                                       <button type="button" class="btn btn-dark btn-sm">
                                         <i class="fa fa-file-pdf-o"></i>Reporte Estados
                                       </button> &nbsp;
                        </a>
                        @endif

                    </div>
                    <div class="card-body">

                        <div class="form-group row">
                        <div class="col-md-6">
                            {!!Form::open(array('url'=>'articulo','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
                                <div class="input-group">
                                   
                                    <input type="text" name="buscarTexto" class="form-control" placeholder="Buscar texto" value="{{$buscarTexto}}">
                                    <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            {{Form::close()}}
                            </div>
                        </div>

                        <div class="card-body">
                           <div class="row">
                             <div class="col">
                             <p style="margin-bottom: -10px;">
                              <strong>Total Libros:</strong>
                              {{count($contar)}}
                              </p> 
                        </div>
                           <div class="col">
     
                           </div>
                          </div>
                        </div>  
                        <table class="table table-responsive table-xl">
                            <thead>
                                <tr class="bg bordearriba">
                                    
                                    <th>Ver Detalle</th>
                                    <th>Código</th>
                                    <th>Título</th>
                                    <th>Nivel Index</th>
                                    <th>Fecha Orden</th>
                                    <th>Fecha Culminacion</th>
                                    <th>Asesor</th>
                                    <th>Editorial</th>
                                    <th>Estado Libro</th>
                                    @if(Auth::user()->idrol != 9 )

                                    <th>Editar</th>
                                    <th>Estado</th>    
                                    <th>Cambiar Estado</th>                                    
                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                    
                               @foreach($libros as $art)
                               
                               <tr>
                               <td>
                                    <a href="{{URL::action('InvestigacionController@show',$art->codigo)}}">
                                      <button type="button" class="btn btn-warning btn-sm">
                                        <i class="fa fa-eye"></i> Ver detalle
                                      </button> &nbsp;

                                    </a>
                                  </td>
                                   <td>{{$art->codigo}}</td>
                                   <td>{{$art->titulo}}</td>
                                   <td>{{$art->nombreindex}}</td>
                                   <td>{{$art->fechaOrden}}</td> 
                                   <td>{{$art->fechaCulminacion}}</td>                      
                                   <td>{{$art->nombreasesores}}</td>                      
                                   <td>{{$art->nombreeditoriales}}</td>                     
                                   <td>{{$art->nombrestatus}}</td>   
                                   @if(Auth::user()->idrol != 9 )

                                   <td>
                                    <a href="{{URL::action('InvestigacionController@edit',$art->idlibros)}}">
                                      <button type="button" class="btn btn-primary btn-sm">
                                        <i class="fa fa-eye"></i> Editar
                                      </button> &nbsp;

                                    </a>
                                  </td>                   

                                   <td>
                                     
                                     @if($art->condicion=="1")
                                       <button type="button" class="btn btn-success btn-sm">
                                   
                                         <i class="fa fa-check"></i> Activo
                                       </button>
                                     @else
                                       <button type="button" class="btn btn-danger btn-sm">
                                         <i class="fa fa-check"></i> Desactivado
                                       </button>

                                      @endif
                                      
                                   </td>
                                   
                                   <td>

                                      @if($art->condicion)

                                       <button type="button" class="btn btn-danger btn-sm" data-id_libros="{{$art->idlibros}}" data-toggle="modal" data-target="#cambiarEstado">
                                           <i class="fa fa-times"></i> Desactivar
                                       </button>

                                       @else

                                        <button type="button" class="btn btn-success btn-sm" data-id_libros="{{$art->idlibros}}" data-toggle="modal" data-target="#cambiarEstado">
                                           <i class="fa fa-lock"></i> Activar
                                       </button>

                                       @endif
                                      
                                   </td>

                                   @endif

                               </tr>

                               @endforeach
                            </tbody>
                        </table>
                        {{$libros->appends($data)->links()}}

                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
                       
                <!-- Inicio del modal Cambiar Estado del usuario -->
                <div class="modal fade" id="cambiarEstado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-danger" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cambiar Estado de Libros</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>

                    <div class="modal-body">
                        <form action="{{route('librosinvestigacion.destroy','test')}}" method="POST">
                         {{method_field('delete')}}
                         {{csrf_field()}} 

                            <input type="hidden" id="id_libros" name="id_libros" value="">

                                <p>Estas seguro de cambiar el estado?</p>
        

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-2x"></i>Cerrar</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-lock fa-2x"></i>Aceptar</button>
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

@section('custom-js')
<script>
/*INICIO ventana modal para cambiar estado de Artículo*/

$('#cambiarEstado').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget)
    var id_libros = button.data('id_libros')
    var modal = $(this)
    modal.find('.modal-body #id_libros').val(id_libros);
    })

    /*FIN ventana modal para cambiar estado de la Artículo*/

     /*INICIO ventana modal para cambiar estado de Artículo*/

$('#cambiarEstado').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget)
    var id_autores = button.data('id_autores')
    var modal = $(this)
    modal.find('.modal-body #id').val(id_autores);
    })

    /*FIN ventana modal para cambiar estado de la Artículo*/
</script>
@endsection