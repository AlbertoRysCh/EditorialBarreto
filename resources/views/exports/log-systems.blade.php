<table>
    <thead>
    <tr>
      <th>Fecha</th>
      <th>Descripción</th>
      <th>Ip</th>
      <th>Explorador</th>
      <th>Usuario</th>
      <th>Correo</th>
      <th>Estado</th>
    </tr>
    </thead>

    <tbody>
      @foreach($logSystems as $items)

      <tr>
        <td align="center">{{date("d-m-Y H:i:s", strtotime($items->created_at))}}</td>
        <td>{{$items->description}}</td>
        <td align="center">{{$items->ip}}</td>
        <td align="center">{{$items->agent}}</td>
        <td align="center">{{$items->usuario}}</td>
        <td align="center">{{$items->user_email}}</td>
        <td align="center">{{$items->error == 1 ? 'Correcto' : 'Error'}}</td>
      </tr>

      @endforeach
    </tbody>

</table>

