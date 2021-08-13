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
        <th>Orden de servicio</th>
        <th>Cliente</th>
        @if($repartidorSelect == 'TODOS')
          <th>Repartidor</th>
        @endif
        <th>Teleoperador</th>
        <th>Persona de contacto</th>
        <th>Punto de recojo(Si aplica)</th>
        <th>Punto de entrega</th>
        <th>Punto de partida</th>
        <th>Hora de notificación OS</th>
        <th>Hora de recojo</th>
        <th>Hora de entrega</th>
        <th>Duración de la entrega</th>
        <th>KM estimado (Google Maps)</th>
        <th>Tiempo programado</th>
        <th>Diferencia tiempo programado/entrega</th>
        <th>OTP</th>
        <th>Monto cobrado por delivery(Si aplica)</th>
    </tr>
    </thead>

    <tbody>
      @foreach($repartidores as $items)

      <tr>
        <td align="center">{{$items->orden_servicio}}</td>
        <td align="center">{{$items->cliente}}</td>
        @if($repartidorSelect == 'TODOS')
          <td align="center">{{$items->repartidor}}</td>
        @endif
        <td align="center">{{$items->teleoperador}}</td>
        <td align="center">{{$items->persona_contacto}}</td>
        <td align="center">{{$items->punto_recojo}}</td>
        <td align="center">{{$items->punto_entrega}}</td>
        <td align="center">{{$items->punto_partida}}</td>
        <td align="center">{{$items->notificacion_os}}</td>
        <td align="center">{{$items->hora_recojo}}</td>
        <td align="center">{{$items->hora_entrega}}</td>
        <td align="center">{{$items->duracion_entrega}}</td>
        <td align="center">{{$items->km_estimado}}</td>
        <td align="center">{{$items->tiempo_programado}}</td>
        <td align="center">{{$items->diferencia_tiempo_entrega}}</td>
        <td align="center">{{$items->otp}}</td>
        <td align="center">{{$items->total_delivery}}</td>
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
    <th></th>
    <th align="right"><b>Totales:</b></th>
    <td align="center">{{$totales[0]->totalDelivery}}</td>
  </tr>

</table>

