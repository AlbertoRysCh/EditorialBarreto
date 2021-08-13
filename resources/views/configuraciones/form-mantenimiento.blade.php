@inject('configuracion', 'App\Http\Controllers\ConfiguracionController')
<div class="title" style="display: none">{{$title}}</div>

<div class="row">
    <div class="col-sm-6 offset-md-3">
    <form action="" method="POST">
        {{csrf_field()}}
        <a href="{{route('configuraciones.updateMantenimiento',['value'=>1])}}" type="button" class="btn btn-success btn-block {{$configuracion->verificarMantenimiento() == 1 ? 'disabled': ''}}"><i class="fa fa-eye-slash"></i> Activar mantenimiento</a>
    </div>
    <br>
    <br>
    <br>
    <div class="col-sm-6 offset-md-3">
        <a href="{{route('configuraciones.updateMantenimiento',['value'=>0])}}" type="button" class="btn btn-danger btn-block {{$configuracion->verificarMantenimiento() == 0 ? 'disabled': ''}}"><i class="fa fa-eye"></i> Desactivar mantenimiento</a>
    </form>
    </div>
</div>