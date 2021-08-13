<table class="table">
  <thead>
    <tr>
    <th>Fecha de subida</th>
    <th>Código</th>
    <th>Título</th>
    <th>Avance</th>
     <th>Observación</th>
    </tr>
  </thead>
  <tbody>
  @foreach($archivos as $arc)
                               <tr>
                                  <td>{{$arc->created_at}}</td>  
                                   <td>{{$arc->codigo}}</td>
                                   <td>{{$arc->titulo}}</td>
                                   <td>{{$arc->avance}}</td>  
                                   <td>{{$arc->observacion}}</td>  
                               </tr>

                               @endforeach
  </tbody>
</table>