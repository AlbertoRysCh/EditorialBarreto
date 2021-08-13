<table>
    <tbody>
    <tr>
    <td>Cliente:</td>
    <td align="center">{{$clientes == 'TODOS' ? $clientes : $clientes->nombres_rz.'-'.$clientes->empresa}}</td>
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
        <th align="center">Fecha</th>
        <th align="center">Nombres</th>
        <th align="center">Tip.Doc</th>
        <th align="center">Num.Doc</th>
        <th align="center">Correo</th>
        <th align="center">Teléfono</th>
        <th align="center">Dirección</th>
        <th align="center">Tipo de servicio</th>
        <th align="center">Monto Total  + (Incluye delivery)</th>
        <th align="center">Monto delivery</th>
        <th align="center">Estado</th>
      </tr>
      </thead>
      <tbody>
        @forelse($data as $load)
        <tr>
          <td align="center">{{$load->fecha}}</td>
          <td align="center">{{$load->nombre}}</td>
          <td align="center">{{$load->tipo_documento}}</td>
          <td align="center">{{$load->num_documento}}</td>
          <td align="center">{{$load->correo}}</td>
          <td align="center">{{$load->telefono}}</td>
          <td align="center">{{$load->direccion}}</td>
          <td align="center">{{$load->tipo_servicio_nombre}}</td>
          <td align="right">{{$load->tipo_servicio == 1 ? $load->monto_total : '0.00'}}</td>
          <td align="right">{{$load->tipo_servicio == 0 ? $load->monto_delivery : '0.00'}}</td>
          <td align="center">{{$load->estado_pago_nombre}}</td>
        </tr>
        @empty
        No se encontraron resultados
        @endforelse
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
      <th align="right"><b>Total:</b></th>
      <td align="right">S/. {{$totales[0]->suma_total}}</td>
      <td align="right">S/. {{$totales[0]->suma_delivery}}</td>
    </tr>
  
  </table>
  
  