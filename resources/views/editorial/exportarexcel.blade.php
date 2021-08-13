<table class="table">
    <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Línea Investigación</th>
            <th>Idioma</th>
            <th>País</th>
            <th>Enlace</th>
            <th>Periodicidad</th>
            <th>Nivel Index</th>
        </tr>
    </thead>
  <tbody>
    @foreach($editoriales as $arc)
        <tr>
            <td>{{$arc->codigo}}</td>  
            <td>{{$arc->nombre}}</td>
            <td>{{$arc->descripcion}}</td>
            <td>{{$arc->lineaInvestigacion}}</td>  
            <td>{{$arc->idioma}}</td>  
            <td>{{$arc->pais}}</td>  
            <td>{{$arc->enlace}}</td>  
            <td>{{$arc->nombreperiocidad}}</td>  
            <td>{{$arc->nivelesnombre}}</td>  
        </tr>
    @endforeach
  </tbody>
</table>