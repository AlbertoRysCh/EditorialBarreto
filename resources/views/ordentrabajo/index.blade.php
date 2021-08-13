@extends('layouts.app')
@section('content')
<main class="main">
            <!-- Breadcrumb -->
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">

                       <h2>Orden de trabajo</h2><br/>

                    </div>
                    <div class="card-body">

                        <div class="form-group row">
                        <div class="col-md-6">
                            {!!Form::open(array('url'=>'ordentrabajo','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!}
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
                              <strong>Total orden de trabajo:</strong>
                              {{count($count)}}
                              </p>
                           </div>
                          </div>
                        </div>
                        <table class="table table-responsive table-xl">
                            <thead>
                                <tr class="bg bordearriba">
                                    <th>Ver Detalle</th>
                                    <th style="width: 20%">Info. Artículo</th>
                                    <th style="width: 20%">Orden T.</th>
                                    <th style="width: 10%">Asesor</th>
                                    <th style="width: 10%">Zona venta</th>
                                    <th style="width: 10%">Editar</th>
                                    <th style="width: 10%">Cuotas</th>
                                    <th style="width: 15%">Estado Aprobación</th>

                                </tr>
                            </thead>
                            <tbody>

                               @forelse($ordentrabajo as $orden)

                               <tr>
                                  <td>
                                    <a href="{{URL::action('OrdenTrabajoController@show',$orden->idordentrabajo)}}">
                                      <button type="button" class="btn btn-warning btn-sm">
                                        <i class="fa fa-eye"></i> Ver detalle
                                      </button>
                                    </a>
                                  </td>
                                  
                                   <td>
                                    <b>Tipo:</b> {{$orden->tipo_contrato == 0 ? 'Foráneo' : 'Coautoría' }} <br>
                                    {!!"<b>Código:</b> ".$orden->codigo !!} <br>
                                    <b>Título: </b>{{ $orden->tipo_contrato == 0 ? $orden->titulo : $orden->titulo_coautoria }}<br>
                                    <b>Autores: </b>

                                   @foreach($clientes as $au)

                                   @if ($orden->idordentrabajo == $au->idordentrabajo )
                                   <p>{{$au->nombres}} {{$au->apellidos}}</p>
                                   @endif
                                   @endforeach<br> 
                                   
                                   
 
                                  </td>
                                    <td>
                                    @if($orden->tipo_contrato == 0)
                                      <b>Precio total: </b><br>
                                      {!!'<b>S/ </b>'.$orden->precio!!} <br>
                                      @foreach($totalACobrar as $key => $value)
                                        @if($orden->idordentrabajo == $value->idordentrabajo)
                                        {!! $value->precio == '0.00' ? '<span class="text-success"><i class="fa fa-check"></i> Total pendiente:</span>' : '<span class="text-danger"><i class="fa fa-close"></i> Total pendiente:</span>';  !!}<br>
                                        {!!'<b>S/ </b>'.$value->precio!!} <br>
                                        {!!"<b>Fecha:</b> ". date("d-m-Y", strtotime($orden->fechaorden)) !!} <br>

                                        @endif
                                      @endforeach
                                      @else
                                      {!!"<b>Fecha Orden:</b> ". date("d-m-Y", strtotime($orden->fechaorden)) !!} <br>
                                      {!!"<b>Fecha Inicio:</b> ". date("d-m-Y", strtotime($orden->fecha_inicio)) !!} <br>
                                      {!!"<b>Fecha Conclusión:</b> ". date("d-m-Y", strtotime($orden->fecha_conclusion)) !!} <br>
                                    @endif
                                    </td>
                                   <td>{{$orden->nombre}}</td>
                                   <td>{{$orden->zonaventa}}</td>
                                   <td>
                                    <a href="{{URL::action('OrdenTrabajoController@edit',$orden->idordentrabajo)}}">
                                      <button type="button" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i> Editar
                                      </button>

                                    </a>
                                   </td>
                                   <td>
                                    @if($orden->tipo_contrato=="0")
                                      <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                      data-target="#modalCuotas" data-backdrop="static" data-keyboard="false"
                                      data-id="{{$orden->idordentrabajo}}"
                                      data-codigo="{{$orden->codigo}}"
                                      data-precio="{{$orden->precio}}"
                                      data-titulo="{{$orden->titulo}}"
                                      @foreach($totalACobrar as $key => $value)
                                        @if($orden->idordentrabajo == $value->idordentrabajo)
                                        data-total_por_cobrar="{{$value->precio}}"
                                        @endif
                                      @endforeach
                                      ><i class="fa fa-credit-card"></i> Ingresar
                                      </button>
                                    @endif
                                   </td>
                                   <td>
                                    @if($orden->condicion=="1")
                                      <span class="text-success"><i class="fa fa-check"></i> Aprobado por:</span><br>
                                      {{$orden->aprobado_por}}
                                    @elseif($orden->condicion=="2")
                                    <a class="btn btn-{{$orden->condicion == 1 ? 'success' : 'warning'}} btn-md" 
                                      data-id="{{$orden->idordentrabajo}}" data-toggle="modal" data-target="#" data-keyboard="false" data-backdrop="static">
                                    <i class="fa fa-{{$orden->condicion == 1 ? 'check': 'clock-o'}}"></i> {{$orden->condicion == 1 ? 'Aprobado' : 'Pendiente'}}
                                    </a>
                                    @else
                                      <a class="btn btn-{{$orden->condicion == 1 ? 'success' : 'warning'}} btn-md" 
                                        data-id="{{$orden->idordentrabajo}}" data-toggle="modal" data-target="#" data-keyboard="false" data-backdrop="static">
                                      <i class="fa fa-{{$orden->condicion == 1 ? 'check': 'clock-o'}}"></i> {{$orden->condicion == 1 ? 'Aprobado' : 'Pendiente'}}
                                      </a>
                                    @endif
                                   </td>



                               </tr>
                               @empty
                               <tr>
                                   <td></td>
                                   <td></td>
                                   <td colspan="3" class="font-weight-bold text-danger"><h5>No se encontraron resultados.</h5></td>
                                   <td></td>
                                   <td></td>
                               </tr>
                               @endforelse
                            </tbody>
                        </table>
                        @include('ordentrabajo/partials/modal_form')
                        {{$ordentrabajo->appends($data)->links()}}

                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalAprobarOt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
              <div class="modal-dialog modal-danger" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h4 class="modal-title">Estado OT</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                      </div>

                  <div class="modal-body">
                      <form action="{{route('verificar.monto.ot')}}" method="POST" id="formAprobarOt">
                          {{csrf_field()}}
                          <input type="hidden" name="orden_trabajo_id" value="">
                          <p>Estás seguro de <b>APROBAR</b> la OT el cambio es irreversible?</p>
                          <div class="modal-footer">
                            @include('layouts.partials.gif_loading')
                            <div class="actions" style="display: block">
                              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                              <button class="btn btn-success" id="btn-aprobar-ot"><i class="fa fa-check"></i> Aceptar</button>
                            </div>
                        </div>
                       </form>
                  </div>
                  <!-- /.modal-content -->
                 </div>
              <!-- /.modal-dialog -->
           </div>
           </div>
           <div class="modal fade" id="modalAprobarOtCoautoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Estado OT</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                    </div>

                <div class="modal-body">
                    <form action="{{route('aprobar.ot.coautoria')}}" method="POST" id="formAprobarOtCoautoria">
                        {{csrf_field()}}
                        <input type="hidden" name="orden_trabajo_id" value="">
                        <p>Estás seguro de <b>APROBAR</b> la OT de coautoría?</p>
                        <div class="modal-footer">
                          @include('layouts.partials.gif_loading')
                          <div class="actions" style="display: block">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                            <button class="btn btn-success"><i class="fa fa-check"></i> Aceptar</button>
                          </div>
                      </div>
                     </form>
                </div>
                <!-- /.modal-content -->
               </div>
            <!-- /.modal-dialog -->
         </div>
         </div>

</main>
@push('custom-js')
<script src="{!! asset('js/ordentrabajo.js') !!}"></script>
@endpush
@endsection
