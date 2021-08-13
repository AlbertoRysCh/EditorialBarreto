@extends('layouts.app')
@section('content')
<style>
    td {
    white-space: normal !important;
    word-wrap: break-word;
    }
</style>

<main class="main">

 <div class="card-body">

    <a href="{{ url('/ordentrabajo')}}">
        <button type="button" class="btn btn-danger btn-sm">
            <i class="fa fa-arrow-left"></i> Regresar
        </button>
    </a>
    @if($ordentrabajo->tipo_contrato == 0)
    <a href="{{ route('ot_pdf',['id'=>$ordentrabajo->contrato_id]) }}">
        <button class="btn btn-danger btn-sm">
        <i class="fa fa-file-pdf-o"></i> Generar PDF OT
        </button>
    </a>
    @else
    
    @endif
    <br><br><br>
            <input class="form-control" type="hidden" name="idordentrabajo" value="{{$idordentrabajo}}">
            <div class="form-group row">

                <div class="col-md-2">
                    <label class="form-control-label labeldetalles" for="codigo">Código</label>
                    <input type="text" id="codigo" name="codigo" readonly class="form-control-plaintext" value="{{$ordentrabajo->codigo}}">
                 </div>

                 <div class="col-md-4">
                    <label class="form-control-label labeldetalles" for="titulo">Título de revisión</label>
                    <input  readonly class="form-control-plaintext" id="idrevision" name="idrevision" value="{{$ordentrabajo->tipo_contrato == 0 ? $ordentrabajo->titulo : $ordentrabajo->titulo_coautoria}}">
                </div>

                <div class="col-md-2" style="display: {{$ordentrabajo->tipo_contrato == 0 ? 'block' : 'none'}}">
                    <label class="form-control-label labeldetalles" for="precio">Precio Total</label>
                    <input type="text" id="precio" name="precio" readonly class="form-control-plaintext" value="S/. {{$ordentrabajo->precio}}">
                </div>

                <div class="col-md-4">
                    <label class="form-control-label labeldetalles " for="idproducto">Producto</label>
                    @foreach ($productos as $item)
                    @if($ordentrabajo->idtipoeditoriales == $item->id)
                        <input type="text" id="idproducto" name="idproducto" readonly class="form-control-plaintext" value="{{$item->nombre}}">
                    @endif
                    @endforeach
                </div>

            </div>
            <div class="form-group row">
                <div class="col-md-2">
                    <label class="form-control-label labeldetalles" for="zonaventa">Zona de venta</label>
                    <input type="text" id="zonaventa" name="zonaventa" readonly class="form-control-plaintext" value="{{$ordentrabajo->zonaventa}}">
                </div>

                <div class="col-md-2">
                    <label class="form-control-label labeldetalles" for="fechaorden">Fecha de orden</label>
                    <input type="text" id="fechaorden" name="fechaorden" readonly class="form-control-plaintext" value="{{date("d-m-Y", strtotime($ordentrabajo->fechaorden))}}">
                </div>
                <div class="col-md-2">
                    <label class="form-control-label labeldetalles" for="fechaorden">Fecha de Inicio</label>
                    <input type="text" id="fechainicio" name="fechainicio" readonly class="form-control-plaintext" value="{{date("d-m-Y", strtotime($ordentrabajo->fecha_inicio))}}">
                </div>
                <div class="col-md-2">
                    <label class="form-control-label labeldetalles" for="fechaorden">Fecha de Conclusión</label>
                    <input type="text" id="fechaconclusion" name="fechaconclusion" readonly class="form-control-plaintext" value="{{date("d-m-Y", strtotime($ordentrabajo->fecha_conclusion))}}">
                </div>
                <div class="col-md-2" style="display: {{$ordentrabajo->tipo_contrato == 0 ? 'block' : 'none'}}">
                    <label class="form-control-label labeldetalles" for="total_por_cobrar">Total por cobrar</label>
                    <input type="text" id="total_por_cobrar" name="total_por_cobrar" readonly class="form-control-plaintext" value="S/. {{$cuota_por_cobrar->precio}}">
                </div>
            </div>

            <div class="form-group row border">

                <h5 style="margin-left: 20px">Autores en Artículos</h5>

                <div class="table-responsive col-md-12">
                <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr class="bordearriba">
                        <th>Especialidad</th>
                        <th>Apellidos Nombres</th>
                        <th>DNI/C.C</th>
                        <th>Afiliación</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Orcid ID</th>
                        <th>Correo Gmail</th>
                        <th>Contraseña</th>

                    </tr>
                </thead>

                <tbody>
                @foreach($clientes as $aut)
                <tr>
                <td>{{$aut->especialidad}}</td>
                <td>{{$aut->nombres}} {{$aut->apellidos}}</td>
                <td>{{$aut->num_documento}}</td>
                <td>{{$aut->universidad}}</td>
                <td>{{$aut->correocontacto}}</td>
                <td>{{$aut->telefono}}</td>
                <td>{{$aut->orcid}}</td>
                <td>{{$aut->correogmail}}</td>
                <td>{{$aut->contrasena}}</td>
                </tr>
                @endforeach
                </tbody>

                </table>
                </div>

                </div>

           <div class="form-group row border">

           <h5 style="margin-left: 20px">{{$ordentrabajo->tipo_contrato == 0 ? 'Listado de cuotas registradas' : 'Listado de pagos aprobados' }}</h5>&nbsp;&nbsp;
            <a href="#"  class="btn btn-info actualizar" ><i class="fa fa-refresh"></i>Actualizar</a>

              {{-- <div class="col-md-12" style="height: 400px; overflow-y: scroll"> --}}
              <div class="table-responsive col-md-12">
                <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr class="bordearriba">
                        <th class="text-center">#</th>
                        @if($ordentrabajo->tipo_contrato == 1)
                        <th class="text-center">Cliente</th>
                        @endif
                        <th class="text-center">{{$ordentrabajo->tipo_contrato == 0 ? 'Fecha de cuota' : 'Fecha'}}</th>
                        <th class="text-center">Monto</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Capture Pago</th>
                    </tr>
                </thead>

                <tbody>
                @if(count($cuotas) > 0)
                @foreach($cuotas as $cuo)
                    <tr>
                    <td class="text-center">{{$loop->iteration}}</td>
                    @if($ordentrabajo->tipo_contrato == 1)
                    <td> 
                        {{$cuo->num_documento_cliente == null ? 'N° 0' : "N° ".$cuo->num_documento_cliente }}<br>
                        {{$cuo->nombre_cliente ?? '-'}} {{$cuo->apellido_cliente == 'null' ? ' ' : $cuo->apellido_cliente}} <br>
                    </td>
                    @endif
                    <td class="text-center">{{date("d-m-Y", strtotime($cuo->fecha_cuota))}}</td>
                    <td class="text-right">{{$cuo->monto}}</td>
                    <td class="text-center">
                        @if($cuo->statu=="1")
                        <span class="text-success"><i class="fa fa-check"></i> Aprobado</span>
                        @elseif($cuo->statu=="0")
                        <span class="text-warning"><i class="fa fa-clock-o"></i> En proceso</span>
                        @elseif($cuo->statu=="3")
                        <span class="text-primary"><i class="fa fa-clock-o"></i> En verificación</span>
                        @else
                        <span class="text-danger"><i class="fa fa-close"></i> Rechazado</span>
                        @endif
                    </td>


                    <td class="text-right">
                        @if($cuo->capturepago == null)
                            <form action="{{ route('uploadpay') }}" method="POST" role="form" enctype="multipart/form-data" onsubmit="return ValidateFile(this);">
                                {{csrf_field()}}
                            <input value="{{$cuo->idcuota}}" type="hidden" class="form-control" name="idcuota">
                            <input value="{{$idordentrabajo}}" type="hidden" class="form-control" name="ot_id">
                            <div class="col-md-8">
                            <input type="file" class="form-control capturepago" name="capturepago" onchange="ValidateImage(this);">
                            </div>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary btn-sm btn_capture"><i class="fa fa-cloud-upload"></i> Subir pago</button>
                            </div>
                            </form>
                        @else
                            <div class="col-md-8">
                            <a type="button" href="{{ route('downloadpay',[$cuo->idcuota,$idordentrabajo]) }}" class="btn btn-success btn-sm"><i class="fa fa-cloud-download"></i> Descargar</a>
                            <a type="button" href="{{ route('deletepay',[$cuo->idcuota,$idordentrabajo]) }}" class="btn btn-danger btn-sm delete"><i class="fa fa-close"></i> Eliminar</a>
                            </div>
                        @endif
                    </td>
                    </tr>
                @endforeach
                @else
                <tr>
                <td></td>
                <td></td>
                <td class="text-center text-font font-weight-bold">
                    <i class="fa fa-info-circle"></i>  {{$ordentrabajo->tipo_contrato == 0 ? 'SIN CUOTAS AGREGADAS' : 'SIN PAGOS REGISTRADOS' }} 
                </td>
                <td></td>
                <td></td>
                @if($ordentrabajo->tipo_contrato == 1)
                <td></td>
                @endif
                </tr>
                @endif
                </tbody>

                </table>
              </div>
              {{-- </div> --}}

            </div>

  </main>
@push('custom-js')
<script src="{!! asset('js/ordentrabajo.js') !!}"></script>
@endpush
@endsection

