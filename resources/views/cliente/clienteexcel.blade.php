<table class="table">
  <thead>
    <tr>
    <th>Código</th>
    <th>N° Documento</th>
    <th>Grado</th>
    <th>Prospecto/Cliente</th>
    <th>Teléfono</th>
    <th>Correo</th>
    <th>Tipo Cliente</th>
    <th>Aviso</th>
    </tr>
  </thead>
  <tbody>
      @foreach($clientes as $cli)
     <tr>
     <td>{{$cli->codigo}}</td>
     <td>{{$cli->num_documento}}</td>
     <td>{{$cli->nombregrado}}</td>
     <td>{{$cli->nombres}} {{$cli->apellidos}}</td>
     <td>{{$cli->telefono}}</td>
     <td>{{$cli->correocontacto}}</td>
     <td>
        @if($cli->autor=="1")
        <span>Cliente</span>
        @elseif($cli->autor=="2")
        <span>En revisión técnica</span>
        @elseif($cli->autor=="3")
        <span> En Gerencia</span>
        @elseif($cli->autor=="4")
        <span >Con contrato</span>
        @else
        <span> Prospecto</span>
        @endif
    </td>     
    <td>
    {{$cli->nombre_aviso}}
     </td>
     </tr>
     @endforeach
  </tbody>
</table>