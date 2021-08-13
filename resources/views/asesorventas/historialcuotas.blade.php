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

    <a href="{{ URL::previous() }}">
        <button type="button" class="btn btn-danger btn-sm">
            <i class="fa fa-arrow-left"></i> Regresar
        </button>
    </a> 
    <br>
    <br>
    <br>

           <h3 style="margin-left: 20px">Datos Clientes</h3>

    <br>
                @foreach($cliente as $co)

                               

            <div class="form-group row">

                <div class="col-md-2">
                    <label class="form-control-label labeldetalles" for="codigo">Numero Documento</label>
                    <input type="text" id="num_documento" name="num_documento" readonly class="form-control-plaintext" value="{{$co->num_documento_cliente}}">
                 </div>

                 <div class="col-md-4">
                    <label class="form-control-label labeldetalles" for="titulo">Nombres</label>
                    <input  readonly class="form-control-plaintext" id="nombres" name="nombres" value="{{$co->nombre_cliente}}">
                </div>
                
                <div class="col-md-4">
                    <label class="form-control-label labeldetalles" for="titulo">Apellidos</label>
                    <input  readonly class="form-control-plaintext" id="apellidos" name="apellidos" value="{{$co->apellido_cliente}}">
                </div>
   
            </div>
            @endforeach           
    <br>
    <br>
    <br>
           <div class="form-group row border">

           <h3 style="margin-left: 20px">Listado de Cuotas Registradas</h3>
  
              {{-- <div class="col-md-12" style="height: 400px; overflow-y: scroll"> --}}
              <div class="table-responsive col-md-12">
                <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr class="bordearriba">
                        <th class="text-center">#</th>
                        <th class="text-center">Fecha de cuota</th>
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
                        @if($cuo->statu=="1")
                            <div class="col-md-8">
                            <a type="button" href="{{ route('downloadpay',[$cuo->idcuota,$cuo->idordentrabajo]) }}" class="btn btn-success btn-sm"><i class="fa fa-cloud-download"></i> Descargar</a>
                            </div>
                        @elseif($cuo->statu=="0")
                        <span class="text-warning"><i class="fa fa-clock-o"></i> En proceso</span>   
                        @elseif($cuo->statu=="3")
                        <span class="text-primary"><i class="fa fa-clock-o"></i> En verificación</span>
                        @else

                        <form action="{{ route('updatepago') }}" method="post" class="form-horizontal" enctype="multipart/form-data" >
                        {{csrf_field()}}
                                <div class="form-group row">
                                    <div class="col-md-9">
                                        <input type="file" id="capturepago" name="capturepago" class="form-control">
                                        <input type="hidden" id="id_cuota" name="id_cuota" value="{{$cuo->idcuota}}"class="form-control">              
                                        <input value="{{$cuo->idordentrabajo}}" type="hidden" class="form-control" name="ot_id">

                                        <button type="submit" class="btn btn-success"><i class="fa fa-save fa-1x"></i> Guardar</button>

                                    </div>
                                 </div>  
                                    
                            </form>
                        @endif
                    </td>
                    </tr>
                @endforeach
                @else
                <tr>
                <td></td>
                <td></td>
                <td class="text-center text-font font-weight-bold">
                    <i class="fa fa-info-circle"></i>'SIN PAGOS REGISTRADOS' }} 
                </td>
                <td></td>
                <td></td>
                <td></td>
                </tr>
                @endif
                </tbody>

                </table>
              </div>
              {{-- </div> --}}

            </div>

  </main>
@push('scripts')
<script src="{!! asset('js/ordentrabajo.js') !!}"></script>
@endpush
@endsection

