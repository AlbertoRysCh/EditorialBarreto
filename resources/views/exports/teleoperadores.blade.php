<table>
  <tbody>
    <tr>
    <td>Repartidores:</td>
    <td align="center">{{$repartidorSelect == 'TODOS' ? $repartidorSelect : $repartidorSelect->name}}</td>
    </tr>
    <tr>
    <td>Mes:</td>
    <td align="center">{{strtoupper($mes)}}</td>
    </tr>
    <tr>
    <td>Año:</td>
    <td align="center">{{$anio}}</td>
    </tr>
    <tr>
    <td>Período:</td>
    <td align="center">{!!'<b>Inicio:</b> '.date("d-m-Y", strtotime($fecha_inicio)) .' <b>Fin:</b> '. date("d-m-Y", strtotime($fecha_fin))!!}</td>
    </tr>
  </tbody>
</table>
<table>
    <thead>
    <tr>
      <th>Fecha</th>
      <th>Cliente</th>
      <th>Direccion inicio</th>
      <th>Direccion final</th>
      <th>Nombre del cliente</th>
      <th>Nro. Celular</th>
      <th>Motorizado</th>
      <th>Inicio</th>
      <th>Termino</th>
      <th>Total KM</th>
      <th>KM adicional</th>
      <th>Costo Básico</th>
      <th>KM adicional /S</th>
      <th>Total a pagar</th>
      <th>Estado</th>
      <th>Observaciones</th>
    </tr>
    </thead>

    <tbody>
      @foreach($servicios as $items)

      <tr>
        <td align="center">{{$items->fecha}}</td>
        <td align="center">{{$items->cliente}}</td>
        <td align="center">{{$items->direccion_inicio}}</td>
        <td align="center">{{$items->direccion_final}}</td>
        <td align="center">{{$items->nombre_cliente}}</td>
        <td align="center">{{$items->nro_celular}}</td>
        <td align="center">{{$items->repartidor}}</td>
        <td align="center">{{$items->hora_fecha}}</td>
        <td align="center">{{$items->hora_entrega}}</td>
        <td align="center">{{$items->total_km}}</td>
        <td align="center">{{$items->km_adicional}}</td>
        <td align="right">{{$items->costo_basico}}</td>
        <td align="right">{{$items->km_adicional_soles}}</td>
        <td align="right">{{$items->total_a_pagar}}</td>
        <td align="center">{{$items->estado}}</td>
        <td align="center">{{$items->observacion}}</td>
      </tr>

      @endforeach
    </tbody>

</table>

 <table>
  <tr>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th align="right"><b>Totales:</b></th>
    <td align="right">{{$totales[0]->totalServicio}}</td>
  </tr>

</table> 

