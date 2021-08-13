@extends('layouts.app')
@section('content')
<main class="main">
            <!-- Breadcrumb -->
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">

                       <h2>Pagos aprobados</h2><br/>


                    </div>
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-md-6">
                                {!!Form::open(array('url'=>'gerencia_aprobados','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!}
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
                              <strong>Total de pagos:</strong>
                              {{count($count)}}
                              </p>
                           </div>
                          </div>
                        </div>
                        <table class="table table-responsive table-xl">
                            <thead>
                                <tr class="bg bordearriba">
                                    <th style="width: 10%">Ver Detalle</th>
                                    <th style="width: 10%">Info. Libro</th>
                                    <th style="width: 10%">Info. Cliente</th>
                                    <th style="width: 10%">Cuota Inicial</th>
                                    <th style="width: 10%">Tip.Contrato</th>
                                    <th style="width: 10%">Fecha de cuota</th>
                                    <th style="width: 10%">Monto</th>
                                    <th style="width: 10%">Estado</th>
                                    <th style="width: 10%">Capture de pago</th>

                                </tr>
                            </thead>
                            <tbody>

                               @forelse($cuotas as $cuo)

                               <tr>
                                  <td>
                                    <a type="button"  href="{{ route('gerencia.show_detail',['id'=>$cuo->idcuota]) }}" class="btn btn-warning btn-sm display">
                                    <i class="fa fa-eye"></i> Ver detalle
                                    </a> &nbsp;
                                  </td>
                                   <td>
                                    {!!"<b>Código:</b> ".$cuo->codigo !!} <br>
                                    {!!"<b>Título:</b> ". $cuo->titulo !!}<br>
                                   </td>
                                    <td>
                                        {{$cuo->num_documento_cliente == null ? 'N° 0' : "N° ".$cuo->num_documento_cliente }}<br>
                                        {{$cuo->nombre_cliente ?? '-'}} {{$cuo->apellido_cliente == "null" ? '' : $cuo->apellido_cliente}} <br>
                                    </td>
                                   <td>
                                    @if($cuo->is_fee_init=="1")
                                         <span class="text-success"> <strong>Sí</strong></span>
                                    @elseif($cuo->is_fee_init=="4")
                                        <span class="text-success"> <strong>Pago único</strong></span>
                                    @else
                                         <span class="text-primary"> -</span>
                                    @endif
                                   </td>
                                   <td>
                                    {{$cuo->tipo_contrato == 0 ? 'Foráneo' : 'Coautoría'}}
                                    </td>
                                   <td>{{date("d-m-Y", strtotime($cuo->fecha_cuota))}}</td>
                                   <td>S/.  {{$cuo->monto}}</td>
                                   <td>
                                    @if($cuo->statu=="1")
                                    <span class="text-success"><i class="fa fa-check"></i> Aprobado</span>
                                    @else
                                    <span class="text-warning"><i class="fa fa-clock-o"></i> En proceso</span>
                                     @endif

                                  </td>
                                    <td>
                                    @if(date("Y-m-d", strtotime($cuo->created_at)) > '2020-08-12')
                                    <a type="button" href="{{ route('downloadpay',[$cuo->idcuota,$cuo->ot_id]) }}" class="btn btn-success btn-sm"><i class="fa fa-cloud-download"></i> Descargar</a>
                                    @else
                                    <span class="text-info"><i class="fa fa-image"></i> Sin archivo</span>
                                    @endif
                                    </td>


                               </tr>
                               @empty
                               <tr>
                                <td></td>
                                <td></td>
                                <td colspan="4" class="font-weight-bold text-danger"><h5>No se encontraron resultados.</h5></td>
                               </tr>
                               @endforelse
                            </tbody>
                        </table>
                        {{$cuotas->appends($data)->links()}}


                    </div>
                </div>
            </div>


</main>
@push('scripts')
@endpush
@endsection
