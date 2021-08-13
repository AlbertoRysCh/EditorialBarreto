@extends('layouts.app')
@section('content')

<style>

.bootstrap-select>.dropdown-toggle {
    position: relative;
    width: 100%;
    text-align: right;
    white-space: nowrap;
    display: -webkit-inline-box;
    display: -webkit-inline-flex;
    display: -ms-inline-flexbox;
    display: inline-flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: justify;
    -webkit-justify-content: space-between;
    -ms-flex-pack: justify;
    justify-content: space-between;
    border-color: #0097a7;
}
textarea{
    resize: none;
}
</style>
<main class="main">

 <div class="card-body">
    <a href="{{ url()->previous() }}
">
        <button type="button" class="btn btn-danger btn-sm">
            <i class="fa fa-arrow-left"></i> Regresar
        </button>
    </a>
    <form action="{{route('generate.ordentrabajo')}}" method="POST" enctype="multipart/form-data">
    {{csrf_field()}}
            <br>
            <br>           
            <div  class="form-group row">
                <div class="col-md-12">
                    <p>Detalles de Contrato del Autor:</p> <h6>{{$revisiones->nombres}} {{$revisiones->apellidos}}</h6>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Código Contrato</label>
                        <input type="text" readonly id="contrato" name="nombrecontrato" value="{{$revisiones->codigo_contrato}}" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-control-label" for="fechaorden">Título</label>
                    <input type="text" name="titulo" value="{{$revisiones->titulo}}" class="form-control" readonly >
                    <input type="hidden" name="idrevision" value="{{$revisiones->id}}" class="form-control">
                    <input type="hidden" name="idcontratos" value="{{$revisiones->contratosid}}" class="form-control">
                    <input type="hidden" name="usuario_id" value="{{$revisiones->usuario_id}}" class="form-control">
                    <input type="hidden" name="idtipoeditoriales" value="{{$revisiones->idtipoeditoriales}}" class="form-control">
                    <input type="hidden" name="idclientes" value="{{$revisiones->idclientes}}" class="form-control">

                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Monto Total</label>
                        <input type="text" readonly id="contrato" name="montototal" value="{{$revisiones->monto_total}}" class="form-control">
                    </div>
                </div>
            </div>

            <div  class="form-group row">
                <div class="col-md-6">
                    <h6>Proceso de Generación Orden de Trabajo</h6>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Código</label>
                        <input type="text" id="codigo_ot" name="codigo_ot" class="form-control" placeholder="Código Orden Trabajo"  required>
                    </div>
                </div>
            
                <div class="col-md-2">
                    <label class="form-control-label" for="fechaorden">Fecha de orden</label>
                    <input type="text" class="form-control datepicker" name="fechaorden" id="fechaorden" placeholder="MM/DD/YYYY" value="{{date('Y-m-d')}}" required>

                </div>
                <div class="col-md-2">
                    <div class="form-group">
                    <label class="form-control-label" for="fechaorden">Fecha de Inicio</label>
                    <input type="text" class="form-control datepicker" name="fechainicio" id="fechainicio" placeholder="MM/DD/YYYY" value="{{date('Y-m-d')}}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                    <label class="form-control-label" for="fechaorden">Fecha de Culminación</label>
                    <input type="text" class="form-control datepicker" name="fechaculminacion" id="fechaculminacion" placeholder="MM/DD/YYYY" value="{{date('Y-m-d')}}" required>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-2">
                    <label class="form-control-label" for="zonaventa">Index en la OT</label>
                    <select class="form-control selectpicker" name="index" id="index">                                          
                    <option value="">Seleccione</option>                                                                               
                    @foreach($index as $inde)                                                                                 
                    <option value="{{$inde->nombre}}">{{$inde->nombre}}</option>                                                                                          
                     @endforeach                                                                        
                    </select>  
                </div>
                <div class="col-md-2">
                    <label class="form-control-label" for="zonaventa">Zona de venta</label>
                    <select class="form-control selectpicker" name="zonaventa" id="zonaventa" >
                        <option value="" disabled>Seleccione</option>
                        @foreach($zonas as $item)
                        <option value="{{$item->nombre}}">{{$item->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
        <label class="col-md-2 form-control-label" for="observaciones">Observaciones de la Orden de Trabajo</label>
        <div class="col-md-6">
            <textarea class="form-control" id="obsordentrabajo" name="obsordentrabajo" rows="3" maxlength="250"></textarea>                       
        </div>
    </div>
            <div class="form-group row">
            <div class="col-md-3">
            <label class="form-control-label" for="nombre">Autor</label>
                <select class="form-control selectpicker autor_select" name="id_autor" id="id_autor" data-live-search="true">
                <option value="0" disabled selected>Seleccione</option>
                @foreach($clientes as $au)
                <option value="{{$au->id}}">{{$au->nombres}} {{$au->apellidos}}</option>
                @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="button" id="agregar" class="btn botonagregar btn-primary"><i class="fa fa-plus"></i> Agregar autor</button>
            </div>

            </div>


           <div class="form-group row border">

              <h5>Coautores en el artículo</h5>

              <div class="table-responsive col-md-12">
                <input type="hidden" name="lineas" id="lineas" value="0">
                <table id="detalles" class="table table-bordered table-striped table-sm">
                <thead>
                    <tr class="bg-success">
                        <th>Eliminar</th>
                        <th>Autor</th>
                    </tr>
                </thead>

                <tbody>
                </tbody>

                </table>
              </div>

            </div>

            <div class="modal-footer form-group row" id="guardar">

            <div class="col-md">
               <input type="hidden" name="_token" value="{{csrf_token()}}">

                <button id="btn_registrar_orden" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Registrar</button>

            </div>

            </div>

         </form>

    </div><!--fin del div card body-->
  </main>

@push('custom-js')
<script src="{!! asset('js/ordentrabajo.js') !!}">

$( document ).ready(function() {

    $(function () {
    $('select').selectpicker();
});

});
</script>
@endpush
@endsection
