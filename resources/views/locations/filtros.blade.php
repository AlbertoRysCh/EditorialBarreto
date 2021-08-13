<div class="row">
    <div class="col-sm-2 margin-top15">
        <div class="form-group">
            <div class="input-group">
                <select  class="form-control select2" name="anio" id="anio">
                    <option value="2022">2022</option>
                    <option value="2021">2021</option>
                    <option value="2020" selected>2020</option>
                </select> 
            </div>
        </div>
    </div>
    <div id="filter-mes" class="col-sm-10 filter-mes margin-top15">
        <button type="button" data-mes="0" data-fin="" class="space-buttons btn btn-primary  btn-mini waves-effect waves-light {{ (date('n')-1 == 0)? 'current-mes':'' }}">Enero</button>
        <button type="button" data-mes="1" class="space-buttons btn btn-primary  btn-mini waves-effect waves-light {{ (date('n')-1 == 1)? 'current-mes':'' }}">Febrero</button>
        <button type="button" data-mes="2" class="space-buttons btn btn-primary  btn-mini waves-effect waves-light {{ (date('n')-1 == 2)? 'current-mes':'' }}">Marzo</button>
        <button type="button" data-mes="3" class="space-buttons btn btn-primary  btn-mini waves-effect waves-light {{ (date('n')-1 == 3)? 'current-mes':'' }}">Abril</button>
        <button type="button" data-mes="4" class="space-buttons btn btn-primary  btn-mini waves-effect waves-light {{ (date('n')-1 == 4)? 'current-mes':'' }}">Mayo</button>
        <button type="button" data-mes="5" class="space-buttons btn btn-primary  btn-mini waves-effect waves-light {{ (date('n')-1 == 5)? 'current-mes':'' }}">Junio</button>
        <button type="button" data-mes="6" class="space-buttons btn btn-primary  btn-mini waves-effect waves-light {{ (date('n')-1 == 6)? 'current-mes':'' }}">Julio</button>
        <button type="button" data-mes="7" class="space-buttons btn btn-primary  btn-mini waves-effect waves-light {{ (date('n')-1 == 7)? 'current-mes':'' }}">Agosto</button>
        <button type="button" data-mes="8" class="space-buttons btn btn-primary  btn-mini waves-effect waves-light {{ (date('n')-1 == 8)? 'current-mes':'' }}">Septiembre</button>
        <button type="button" data-mes="9" class="space-buttons btn btn-primary  btn-mini waves-effect waves-light {{ (date('n')-1 == 9)? 'current-mes':'' }}">Octubre</button>
        <button type="button" data-mes="10" class="space-buttons btn btn-primary  btn-mini waves-effect waves-light {{ (date('n')-1 == 10)? 'current-mes':'' }}">Noviembre</button>
        <button type="button" data-mes="11" class="space-buttons btn btn-primary  btn-mini waves-effect waves-light {{ (date('n')-1 == 11)? 'current-mes':'' }}">Diciembre</button> 
    </div>
</div>

<div class="row">
    <div class="col-sm-3 ajuste-filto {{request()->is('reportes/vendedores') ? 'display_none' : ''}}">
    <div class="input-group">
        <span class="input-group-addon"><i class="feather icon-calendar" aria-hidden="true"></i></span>
        <input type="text" class="form-control form-control-primary" name="filtro-fechas" id="filtro-fechas" >
        </div>
    </div>

    <div class="form-group row display_none">
        <input type="text" class="form-control form-control-primary" name="fecha_ini_hide" id="fecha_ini_hide" value={{ date("Y-m-d") }}>
        <input type="text" class="form-control form-control-primary" name="fecha_fin_hide" id="fecha_fin_hide" value={{ Customize::dateAddDay() }}>
    </div>

    <div class="col-sm-1 margin-top15 {{request()->is('reportes/vendedores') ? 'display_none' : ''}}">
        <button class="btn btn-info " data-filter="search" id="btn_buscar_info"><i class="fa fa-search"></i></button>
    </div>

    <div class="col-sm-4 {{request()->is('reportes/vendedores') ? 'offset-sm-6' : 'offset-sm-3'}} margin-top15">
        <a type="button" href="" class="btn btn-success btn-exportar">
            <i class="feather icon-download-cloud"></i> Exportar excel
        </a>
    </div>
    <form id="{{ $form }}" action="" method="post" target="_self" class="display_none">
        {{csrf_field()}}
    </form>

</div>