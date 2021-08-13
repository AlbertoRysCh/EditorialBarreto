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
    <a href="{{ url('/ordentrabajo')}}">
        <button type="button" class="btn btn-danger btn-sm">
            <i class="fa fa-arrow-left"></i> Regresar
        </button>
    </a>
    <form action="{{route('ordentrabajo.update',$ordentrabajo)}}" method="POST" enctype="multipart/form-data">
                {{method_field('patch')}}
                {{csrf_field()}}
            <div class="col-md-2">
                <input type="hidden" id="idordentrabajo" name="idordentrabajo" class="form-control" value="{{$Listarordentrabajo->idordentrabajo}}">
            </div>
            <div class="form-group row">
                <div class="col-md-2">
                    <label class="form-control-label" for="codigo">Código</label>
                    <input type="text" id="codigo" name="codigo" class="form-control" placeholder="Ingrese código" value="{{$Listarordentrabajo->codigo}}" readonly>
                </div>
                @if($Listarordentrabajo->tipo_contrato == 0)
                <div class="col-md-4">
                    <label class="form-control-label" for="idrevision">Título de Revisión</label>
                    <select class="form-control selectpicker" name="idrevision" id="idrevision" data-live-search="true" required disabled>
                    <option value="0" disabled>Seleccione</option>
                    @foreach($revisiones as $rev)
                    <option {{$Listarordentrabajo->idrevision == $rev->id ? 'selected' : '' }} value="{{$rev->id}}">{{$rev->revisionestitulos}}</option>
                    @endforeach
                    </select>
                </div>
                @else
                    <div class="col-md-4">
                    <div class="form-group">
                    <label>Título del artículo</label>
                        <textarea class="form-control" id="titulo_coautoria" name="titulo_coautoria" rows="3" maxlength="250" required>{{$Listarordentrabajo->titulo_coautoria}}</textarea>                       
                    </div>
                    </div>
                @endif



            </div>

            <div class="form-group row">

                <div class="col-md-2">
                    <label class="form-control-label" for="zonaventa">Zona de venta</label>
                    <select class="form-control selectpicker" name="zonaventa" id="zonaventa">
                        <option value="" disabled>Seleccione</option>
                        @foreach($zonaVenta as $item)
                        <option {{$item->nombre == $Listarordentrabajo->zonaventa ? 'selected' : ''}} value="{{$item->nombre}}">{{$item->nombre}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-control-label" for="fechaorden">Fecha de orden</label>
                    <input type="text" class="form-control datepicker" name="fechaorden" id="fechaorden" value="{{$Listarordentrabajo->fechaorden}}" placeholder="MM/DD/YYYY" required disabled>

                </div>
                <div class="col-md-2">
                    <label class="form-control-label" for="precio">Precio Total</label>
                    <input type="text" id="precio" name="precio" class="form-control" placeholder="Ingrese precio" value="{{$Listarordentrabajo->precio}}" required onkeypress="return validarDecimales(event, this)" maxlength="15" readonly>
                </div>

                <div class="col-md-2">
                    <label class="form-control-label" for="idproducto">Productos</label>
                    <select class="form-control selectpicker" name="idproducto"  id="idproducto" disabled>
                        <option value="0" disabled>Seleccione</option>
                        @foreach($productos as $pro)
                        <option {{$pro->id == 2 || $pro->id == 3 ? $pro->class : ''}}  value="{{$pro->id}}" {{$pro->id == $Listarordentrabajo->idtipoeditoriales ? 'selected' : '' }}>{{$pro->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="form-group row border">

            <h5 style="margin-left: 20px">Autores en Artículos</h5>

            <div class="table-responsive col-md-12">
            <table id="detalles" class="table table-bordered table-striped table-sm">
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

            <div class="modal-footer form-group row" id="guardar">
            <div class="col-md">
               <input type="hidden" name="_token" value="{{csrf_token()}}">
               <button id="btn_registrar_orden" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Actualizar</button>
            </div>
            </div>

         </form>

    </div><!--fin del div card body-->
  </main>

@push('custom-js')
<script src="{!! asset('js/ordentrabajo.js') !!}"></script>
@endpush
@endsection
