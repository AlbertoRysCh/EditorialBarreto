<table>
  <tbody>
    <tr>
    <td>Vendedores:</td>
    <td align="center">{{$vendedorSelect == 'TODOS' ? $vendedorSelect : $vendedorSelect->name}}</td>
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
        <th>Vendedor</th>
        <th>Mes</th>
        <th>Semana</th>
        <th>Programadas</th>
        <th>Realizadas</th>
        <th>Pendientes</th>
        <th>Clientes RS</th>
        <th>Clientes Foráneos</th>
    </tr>
    </thead>

    <tbody>
      @foreach($vendedores as $items)

      <tr>
        <td align="center">{{$items->vendedor}}</td>
        <td align="center">{{$items->mes}}</td>
        <td align="center">{{$items->num_semana}}</td>
        <td align="center">{{$items->num_programadas}}</td>
        <td align="center">{{$items->num_realizadas}}</td>
        <td align="center">{{$items->num_pendientes}}</td>
        <td align="center">{{$items->clientes_rs}}</td>
        <td align="center">{{$items->clientes_foraneos}}</td>
      </tr>

      @endforeach
    </tbody>

</table>

<table>
  <tr>
    <th></th>
    <th></th>
    <th align="right"><b>Totales:</b></th>
    <td align="center">{{$totales[0]->numProgramadas}}</td>
    <td align="center">{{$totales[0]->numRealizadas}}</td>
    <td align="center">{{$totales[0]->numPendientes}}</td>
    <td align="center">{{$totales[0]->numClientesRs}}</td>
    <td align="center">{{$totales[0]->numForaneos}}</td>
  </tr>

</table>

