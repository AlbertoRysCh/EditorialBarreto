<table>
    <thead>
    <tr>
      <th>Tipo persona</th>
      <th>Nombres</th>
      <th>Empresa</th>
      <th>Tipo Documento</th>
      <th>Número Documento</th>
      <th>Correo</th>
      <th>Teléfono</th>
      <th>Dirección</th>
      <th>Estado</th>
      <th>Estado cliente</th>
      <th>Estado llamada</th>
      <th>Fecha de registro</th>
      <th>Fecha de actualización</th>
      <th>Vendedor</th>
    </tr>
    </thead>

    <tbody>
      @foreach($posiblesClientes as $items)

      <tr>
        <td align="center">{{$items->tipo_persona}}</td>
        <td align="center">{{$items->nombres_rz}}</td>
        <td align="center">{{$items->empresa}}</td>
        <td align="center">{{$items->tipo_documento}}</td>
        <td align="center">{{$items->num_documento}}</td>
        <td align="center">{{$items->correo}}</td>
        <td align="center">{{$items->telefono}}</td>
        <td align="center">{{$items->direccion}}</td>
        <td align="center">{{$items->estado}}</td>
        <td align="center">{{$items->estado_cliente}}</td>
        <td align="center">{{$items->estado_llamada_nombre}}</td>
        <td align="center">{{date("d-m-Y H:i:s", strtotime($items->created_at))}}</td>
        <td align="center">{{date("d-m-Y H:i:s", strtotime($items->updated_at))}}</td>
        <td align="center">{{$items->is_empleado == 0 ? $items->nombre_vendedor : '-'}}</td>
      </tr>

      @endforeach
    </tbody>

</table>

