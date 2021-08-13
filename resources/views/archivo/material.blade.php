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

                       <h3>Material asignado a descargar</h3><br/>
                    </div>
                                        <div class="card-body">

                        <div class="form-group row">
                        <div class="col-md-6">
                            {!!Form::open(array('url'=>'material','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!} 
                                <div class="input-group">
                                   
                                    <input type="text" name="buscarTexto" class="form-control" placeholder="Buscar texto" >
                                    <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            {{Form::close()}}
                            </div>
                        </div>

                           <div class="col">
     
                           </div>
                          </div>
                        </div>  

                    <div class="card-body">
                        @if( Auth::user()->idrol == 5)  {{-- Perfil gerencia administradores --}}
                        <table class="table table-responsive table-xl">
                            <thead>
                                <tr class="bg bordearriba">
                                   
                                    <th>Codigo</th>
                                    <th>Articulo</th>
                                    <th>Revista</th>
                                    <th>Material</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($libros as $art)
                                <tr>
                                    
                                    <td>{{$art->codigo}}</td>
                                    <td>{{$art->titulo}}</td>
                                    
                                    <td>
                                    <a href="{{route('downloadarticulo', $art->idarticulos) }}">
                                       <button type="button" class="btn btn-success btn-sm">
                                         <i class="fa fa-download"></i> Material
                                       </button> &nbsp;
                                     </a>
                                    </td>                    

                                </tr>

                                @endforeach
                               
                            </tbody>
                        </table>
                         @endif   
                         @if( Auth::user()->idrol == 1 || Auth::user()->idrol == 3 )  {{-- Perfil gerencia administradores --}}

                         <table class="table table-responsive table-xl">
                            <thead>
                                <tr class="bg bordearriba">
                                   
                                    <th>Codigo</th>
                                    <th>Articulo</th>
                                    <th>Fecha Asignación</th>
                                    <th>Asesor</th>
                                    <th>Revista</th>
                                    <th>Material</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($historiales as $hist)
                                <tr>
                                    
                                    <td>{{$hist->codigo}}</td>
                                    <td>{{$hist->titulo}}</td>
                                    <th>{{$hist->fechaAsignacion}}</th>
                                    <td>{{$hist->nombreasesores}}</td>
                                    
                                    <td>
                                    <a href="{{route('downloadhistorial', $hist->idhistorial) }}">                                       <button type="button" class="btn btn-success btn-sm">
                                         <i class="fa fa-download"></i> Material
                                       </button> &nbsp;
                                       </a>        

                                     </a>
                                    </td>                    

                                </tr>

                                @endforeach
                               
                            </tbody>
                        </table>
                        {{$historiales->render()}}

                        @endif   

                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>    
            
        </main>

@endsection
