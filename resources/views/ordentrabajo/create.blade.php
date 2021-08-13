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
    <a href="{{ url('/cliente')}}">
        <button type="button" class="btn btn-danger btn-sm">
            <i class="fa fa-arrow-left"></i> Regresar
        </button>
    </a>
    <form action="{{route('ordentrabajo.store')}}" method="POST" enctype="multipart/form-data">
    {{csrf_field()}}
            <br>
            <br>           
            

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
                <div class="col-md-12">
                <div class="form-group">
                <label>Título del artículo</label>
                    <textarea class="form-control" id="titulo_coautoria" name="titulo_coautoria" rows="3" maxlength="250" required></textarea>                       
                </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2">
                    <label class="form-control-label" for="zonaventa">Zona de venta</label>
                    <select class="form-control selectpicker" name="zonaventa" id="zonaventa">
                        <option value="" disabled>Seleccione</option>
                        @foreach($zonaVenta as $item)
                        <option value="{{$item->nombre}}">{{$item->nombre}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-control-label" for="precio">Precio Total</label>
                    <input type="text" id="precio" name="precio" class="form-control" value="0.00" readonly>
                </div>

                <div class="col-md-2">
                    <label class="form-control-label" for="idproducto">Productos</label>
                    <select class="form-control selectpicker" name="idproducto"  id="idproducto">
                        <option value="0" disabled>Seleccione</option>
                        @foreach($productos as $pro)
                        <option {{$pro->id == 2 || $pro->id == 3 ? $pro->class : ''}} value="{{$pro->id}}">{{$pro->nombre}}</option>
                        @endforeach
                    </select>
                </div>

            </div>


            <div class="form-group row">

                <div class="col-md-3">

            <label class="form-control-label" for="nombre">Autor</label>

                <select class="form-control selectpicker autor_select" name="id_autor" id="id_autor" data-live-search="true">

                <option value="0" disabled selected>Seleccione</option>

                @foreach($clientes as $cliente)

                <option value="{{$cliente->id}}">{{$cliente->nombres}} {{$cliente->apellidos}}</option>

                @endforeach

                </select>

            </div>

            <div class="col-md-3">
                <button type="button" id="agregar" class="btn botonagregar btn-primary"><i class="fa fa-plus"></i> Agregar autor</button>
            </div>

            </div>


           <div class="form-group row border">

              <h5>Autores en el artículo</h5>

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

@section('custom-js')
@endsection
@endsection