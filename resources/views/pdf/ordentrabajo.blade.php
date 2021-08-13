<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
</head>

<style>
.contenidoprincipal {
  border: 1px solid black;
  margin-top: 0px;
  margin-bottom:  10px;
  margin-right: 50px;
  margin-left: 50px;
}
.contenido {
  margin-top: 0px;
  margin-bottom:  0px;
  margin-right: 50px;
  margin-left: 50px;
}

.contenidotitulo {
    border: 1px solid black;
  margin-top: 15px;
  margin-bottom:  0px;
  margin-right: 50px;
  margin-left: 50px;
}

.contenidoautores {
  margin-top: 15px;
  margin-bottom:  0px;
  margin-right: 50px;
  margin-left: 50px;
}

.contenidofirma {
  margin-top: 30px;
  margin-bottom:  0px;
  margin-right: 50px;
  margin-left: 50px;
}

.column {
  float: left;
  padding: 10px;
}

.left, .right {
  width: 25%;
}

.middle {
  width: 25%;
}

.tablaautores, .thtabla, .tdtabla{
      border: 1px solid black;
}

.container {
  margin-top: 50px;
  margin-bottom:  10px;
  margin-right: 50px;
  margin-left: 50px;
}

.contenidoobservaciones{
  margin-top: 50px;
  margin-bottom:  10px;
  margin-right: 50px;
  margin-left: 50px;
}

</style>
        <body>
            <div class="contenidoprincipal">
                <table style="height: 39px; width: 948px;">
                <tbody>
                <tr>
                <td style="width: 271px;"><img src="{{public_path('images/logoorden.png')}}" class="images-responsive"></td>
                <td style="width: 334px; text-align: center;">ORDEN DE TRABAJO</td>
                <td style="width: 321px; text-align: rigth;"><img src="{{public_path('images/logoarticulo.png')}}" class="img-responsive"></td>
                </tr>
                </tbody>
                </table>
            </div>

            <div class="contenido">
            <table style="height: 31px;" width="948px">
                <tbody>
                <tr>
                <td style="width: 100px; font-size:14px"> <p><span style="font-weight: bold;">Código OT:</span>{{$ordentrabajo->codigoorden}}</p> </td>
                <td style="width: 50px; font-size:14px"> <p> <span style="font-weight: bold;">Fecha Elab. OT: </span> {{\Carbon\Carbon::parse($ordentrabajo->fechaorden)->format('d/m/Y')}} </p> </td>
                @if($exist == 0)
                <td  style=" width: 100px;  font-size:12px;  text-align: center;"> <p> - </p> </td>
                @else
                <td style="width: 100px; font-size:14px"> <p> <span style="font-weight: bold;">Fecha de envío a Producción:</span>  {{\Carbon\Carbon::parse($exist)->format('d/m/Y')}}</p></td>
                @endif
                <td style="width: 100px; font-size:14px"> <p> <span style="font-weight: bold;"> Zona: </span>{{$ordentrabajo->zonaventa}}</p></td>
                </tr>
                </tbody>
                </table>
            </div>

            <div class="contenidotitulo">
            <table  style="height: 31px;" width="860px">
                <tbody>
                    <tr>
                        <td style="width: 50px; text-align: right; font-size:14px font-weight: bold;">Título:</td>
                        <td style="width: 502px; text-align: center; font-size:14px">{{$ordentrabajo->titulorevisiones}}</td>
                    </tr>
                </tbody>
            </table>
            </div> 

            <div class="contenidoautores"> 
                <table class="tablaautores" style="height: 31px;" width="865px">
                            <thead>
                                <tr class="">
                                    <th class="thtabla" style=" font-size:12px;  text-align: center;">-</th>
                                    <th class="thtabla" style=" font-size:12px;  text-align: center; font-weight: bold;">Ext</th>
                                    <th class="thtabla" style=" font-size:12px;  text-align: center; font-weight: bold;">Apellidos y Nombres</th>
                                    <th class="thtabla" style=" font-size:12px;  text-align: center; font-weight: bold;">DNI</th>
                                    <th class="thtabla" style=" font-size:12px;  text-align: center; font-weight: bold;">Correo</th>
                                    <th class="thtabla" style=" font-size:12px;  text-align: center; font-weight: bold;">Celular</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($coautores as $au)
                                <tr>
                                    @if ($loop->iteration == 1)
                                    <td class="tdtabla" style="font-size:12px; text-align: center; font-weight: bold;">Autor(a)</td>
                                    @else
                                    <td  class="tdtabla" style=" font-size:12px; text-align: center; font-weight: bold;">Coautor(a)</td>
                                    @endif
                                    <td class="tdtabla" style=" font-size:12px;  text-align: center;">{{$au->nombregrados}}</td>
                                    <td class="tdtabla" style=" font-size:12px;  text-align: center;">{{$au->nombres}} {{$au->apellidos}}</td>
                                    <td class="tdtabla" style=" font-size:12px;  text-align: center;">{{$au->num_documento}}</td>
                                    <td class="tdtabla" style=" font-size:12px;  text-align: center;">{{$au->correocontacto}}</td>
                                    <td class="tdtabla" style=" font-size:12px;  text-align: center;">{{$au->telefono}}</td>           
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>  


                <div class="contenidoautores"> 
                <table class="tablaautores" style="height: 50px;" width="400px">
                            <thead>
                                <tr class="">
                                    <td class="thtabla" style=" font-size:12px;  text-align: center; height:20px;   font-weight: bold;
">INDEX</td>
                                    <td class="thtabla" style=" font-size:12px;  text-align: center; height: 20px;">{{$ordentrabajo->inde}}</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="tdtabla" style=" font-size:12px;  text-align: center; font-weight: bold;">Fecha Inicio:</td>
                                    @if($exist == 0)
                                    <td class="tdtabla" style=" font-size:12px;  text-align: center;">-</td>
                                    @else
                                    <td class="tdtabla" style=" font-size:12px;  text-align: center;">{{\Carbon\Carbon::parse($exist)->format('d/m/Y')}}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="tdtabla" style=" font-size:12px;  text-align: center; font-weight: bold;">Fecha Culminación:</td>
                                    <td class="tdtabla" style=" font-size:12px;  text-align: center;">{{\Carbon\Carbon::parse($ordentrabajo->fecha_conclusion)->format('d/m/Y')}}</td>
                                </tr>
                            </tbody>
                        </table>
                </div>  
               
                <div class="contenidofirma"> 
                <table width="865px">
                    <tbody>
                    <tr>
                        <td style="width: 278px;"> 
                        <p style=" font-size:14px; text-align: center; ">	
                    __________________________________________________
                      Firma Jefe de Departamento Artículos </p>
                      
                      </td>
                        <td style="width: 128px;">&nbsp;</td>
                        <td style="width: 256px;">          <br>    <p style=" font-size:14px; text-align: center; ">
                    _________________________________________________
                        Dr. ISRAEL BARRUTIA BARRETO</p>
                        <p style=" font-size:14px; text-align: center; margin-top:-5px; "> GERENTE
                        INNOVA SCIENTIFIC S.A.C</p></td>
                    </tr>
                    </tbody>
                </table>
                </div>  

                <div class="contenidoobservaciones">
                <table style="width: 600px;">
                    <tbody>
                        <tr>
                        <td style="width: 94px; font-size:14px;  text-align: center;  font-weight: bold;"><p>Observaciones: </p></td>
                        <td style="width: 481px; text-align: left; font-size:12px;"> <p  style="margin-left:10px;">{{$ordentrabajo->observaciones}}</p> </td>
                        </tr>
                    </tbody>
                </table>
                </div>

        </body>
</html>