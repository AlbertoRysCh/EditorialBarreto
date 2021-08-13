@extends('layouts.app')
@section('content')
<main class="main">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                       <h3>Libros</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            {!!Form::open(array('url'=>'articulos/lista','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
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
                               {{count($count)}}
                               </p> 
                            </div>
                            <div class="col">
      
                            </div>
                           </div>
                         </div>  
                        <table class="table table-responsive table-sm">
                            <thead>
                                <tr class="bg bordearriba">
                                    <th style="width: 30%">Código</th>
                                    <th style="width: 30%">Título</th>
                                    {{-- <th style="width: 20%">Revista</th> --}}
                                    <th style="width: 10%">Estado</th>    
                                    <th style="width: 10%">Coautores</th>    
                                    <th style="width: 10%">Gestionar</th>

                                </tr>
                            </thead>
                            <tbody>
                               @forelse($ordenTrabajo as $items)
                               
                                <tr>
                                <td>{{$items->codigo}}</td>
                                <td>{{$items->titulo_coautoria}}</td>
                                {{-- <td>{{$items->nombrerevistas}}</td>                      --}}
                                <td>
                                <span class="text-{{$items->condicion=="1" ? 'success' : 'warning'}}">{{$items->condicion=="1" ? 'En producción' : 'Agregando coautores..'}}</span>
                                </td>
                                <td>

                                    @forelse($coautores as $key => $value)
                                        @if($items->codigo == $value->codigo_articulo)
                                        {!! 'Pendientes: '.'<b>'.$value->count_pendientes.'</b>'!!}
                                        @endif
                                    @empty
                                    @endforelse
                                </td>
                                <td>
                                    <a href="{{route('articulos.detalles',[$items->idordentrabajo,$items->codigo])}}">
                                        <button type="button" class="btn btn-primary btn-sm">
                                        <i class="fa fa-user"></i> Coautores
                                        </button>
                                    </a>
                                </td>


                                    
                                </tr>
                                @empty
                                <tr>
                                    <td></td>
                                    <td colspan="3" class="font-weight-bold text-danger"><h5>No se encontraron resultados.</h5></td>
                                </tr>
                                @endforelse
                               
                            </tbody>
                        </table>
                        {{$ordenTrabajo->appends($data)->links()}}
                            

                    </div>
                </div>
            </div>
           

            
        </main>

@endsection
@push('scripts')

@endpush
