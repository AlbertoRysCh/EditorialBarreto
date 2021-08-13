        <div class="row py-1">
          <div class="col-lg-5 font-medium-3 pt-1">
            Dashboard - <span class="letterDate"></span>
          </div>
          {{-- Fecha dinámica --}}
          <form action="{{ route('inicio.dynamic-date')}}" id="formFilter" method="POST" class="display_none">
            {{csrf_field()}}
          </form>
            <div class="col-lg-3 fecha_search pt-1">
                <input type="text" class="form-control" id="fecha_dia" name="fecha_dia" placeholder="Seleccione el día">  
                <input type="text" class="form-control" id="fecha_mes_anio" name="fecha_mes_anio" placeholder="Seleccione año y mes">  
                <input type="text" class="form-control space_range" id="fecha_ini" name="fecha_ini" placeholder="Fecha inicio">  
                <input type="text" class="form-control" id="fecha_fin" name="fecha_fin" placeholder="Fecha fin">  
            </div>
            <div class="col-lg-1 display_none btn_fecha_range pt-1">
              <button class="btn btn-sm btn-success" id="btn_fecha_range"><i class="fa fa-search"></i></button>
            </div>
          <div class="col-lg-1 div_fill2"></div>
          <div class="col-lg-3 div_fill"></div>
          <div class="col-lg-3">
            <div class="btn-group pt-1">
                <span class="badge btnFilter" onclick="showFilter('D')">Día</span>
                <span class="badge btnFilter" onclick="showFilter('M')">Mes</span>
                <span class="badge btnFilter" onclick="showFilter('R')">Rango</span>
            </div>
          </div>
        </div>