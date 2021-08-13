@php
    $cliente = json_decode($data->cliente);
    $fecha = json_decode($fecha);
	$fechaLetras = json_decode($fecha_letras);
	$valoresD = json_decode($valores_dinamicos);
	$cuotas = json_decode($data->num_cuotas,true);
	$arrayGrado = [
        '1' => 'MG.',
        '2' => 'DR.',
        '3' => 'P.DR',
        '4' => 'BR.',
        '5' => '',
        '6' => 'DRA.',
        '7' => 'ING.',
        '8' => 'LIC.',
        '9' => 'MBA.',
        '10' => 'MSC.',
    ];
@endphp
<style>
	.separar{
		height: 50px;
	}
	.separar1{
		height: 10px;
	}
	#container {
    width:100%;
    text-align:center;
	}

	.left {
		float:left;
		width:250px;
		height: 20px;
	}

	.center {
		display: inline-block;
		margin:0 auto;
		width:250;
		height: 20px;
	}
	.left1 {
		float:left;
		width:300px;
		height: 20px;
	}
	.center1 {
		display: inline-block;
		margin:0 auto;
		width:350px;
		height: 20px;
	}
	.separar_coautor{
		height: 30px;
	}
</style>
<p><strong>CONTRATO DE PRESTACIÓN DE SERVICIOS DE ASESORÍA CIENTÍFICA</strong></p>
<p style="text-align: right;"><strong>N&deg; {{$data->codigo}}</strong></p>
<p style="text-align: justify;">Conste por el presente contrato que celebran de una parte <strong>INNOVA SCIENTIFIC S.A.C.</strong> con domicilio en AV. LA MARINA 1453, DISTRITO DE SAN MIGUEL, LIMA, con <strong>RUC. N&ordm; 20603644078,</strong> debidamente representada por su <strong>Gerente Dr. BARRUTIA BARRETO, ISRAEL</strong>, identificado con&nbsp; <strong>DNI. N&ordm; </strong><strong>10614088</strong>, quien en adelante se denominar&aacute; <strong>LA CONSULTORA</strong> y del otro <strong>{{$arrayGrado[$cliente->idgrado]}} {{mb_strtoupper($cliente->nombres.' '.$cliente->apellidos)}}</strong> con<strong> {{mb_strtoupper($cliente->tipo_documento)}} N&deg; {{$cliente->num_documento}} </strong>domiciliado <strong>{{mb_strtoupper($cliente->domicilio ?? '-')}}. </strong>Quien para efectos de este contrato se denominar&aacute; el <strong>CONTRATANTE</strong>, se ha celebrado el siguiente contrato de prestaci&oacute;n de servicios de asesor&iacute;a que se regir&aacute; por las siguientes cl&aacute;usulas:</p>
<p><strong>PRIMERA: OBJETO</strong></p>
<p style="text-align: justify;"><strong>LA CONSULTORA</strong>, se obliga para con el <strong>CONTRATANTE </strong>a prestar&nbsp;los servicios de asesor&iacute;a para la elaboraci&oacute;n de un art&iacute;culo cient&iacute;fico en revista indexada de alto impacto a nivel scopus.
	{{-- del Anexo B: Proyecto de investigaci&oacute;n, conforme a las Bases de la Convocatoria de Proyectos de investigaci&oacute;n a partir de fondos concursables. --}}
</p>
<p><strong>SEGUNDA: PLAZO. </strong></p>
<p style="text-align: justify;"><strong>LA CONSULTORA, </strong>se compromete a realizar la asesor&iacute;a de acompa&ntilde;amiento y orientaci&oacute;n para la elaboraci&oacute;n del art&iacute;culo cient&iacute;fico, a partir de la firma del presente contrato, siendo la entrega previo pago de acuerdo a:</p>
	{{-- Anexo B: Proyecto de investigaci&oacute;n --}}
<p style="text-align: justify;">Hasta 30 d&iacute;as calendario plazo en el cual se enviar&aacute; el art&iacute;culo al <strong>CONTRATANTE</strong> a fin de su aprobaci&oacute;n al art&iacute;culo.
	{{-- y se culminar&aacute; el proyecto Anexo B: Proyecto de investigaci&oacute;n, conforme a las Bases de la Convocatoria de Proyectos de investigaci&oacute;n a partir de fondos concursables. --}}
</p>
<p style="text-align: justify;">
Una vez aprobado el art&iacute;culo por el <strong>CONTRATANTE</strong>  as&iacute; como la aprobaci&oacute;n de la revista, la consultora tendr&aacute; un plazo de 15 d&iacute;as para subir el art&iacute;culo a la revista.
</p>
<p><strong>TERCERA: VALOR Y FORMA DE PAGO</strong></p>
<p style="text-align: justify;">El&nbsp;valor&nbsp;del presente&nbsp;contrato&nbsp;de&nbsp;prestaci&oacute;n de servicios de asesor&iacute;a es de&nbsp;<strong>{{mb_strtoupper($letras_total)}} {!!'S/.'.$data->monto_total!!}</strong> el cual ser&aacute; cancelado de la siguiente manera:</p>
{{-- <p style="text-align: justify;">{{round($valoresD->p_monto_inicial, 1, PHP_ROUND_HALF_EVEN)}}% (S/ {{$data->monto_inicial}}) a la firma de contrato.</p> --}}
<p style="text-align: justify;">{{$valoresD->p_monto_inicial}}% (S/ {{$data->monto_inicial}}) a la firma de contrato.</p>

@forelse ($cuotas as $cuota)
{{'(S/ '.$cuota['monto']}}) a los {{$cuota['fecha_cuota']}} días de la firma del contrato.<br>
@empty
@endforelse
{{-- {{round($valoresD->p_monto_cuotas , 1, PHP_ROUND_HALF_EVEN)}}% <br> --}}
{{$valoresD->p_monto_cuotas}}% <br>
{{-- <p style="text-align: justify;">{{round($valoresD->p_monto_restante , 1, PHP_ROUND_HALF_EVEN)}}% (S/ {{$data->precio_cuotas}}) para subir el art&iacute;culo cient&iacute;fico en una revista indexada de alto impacto a nivel scopus (Submisi&oacute;n).  --}}
<p style="text-align: justify;">{{$valoresD->p_monto_restante}}% (S/ {{$data->precio_cuotas}}) para subir el art&iacute;culo cient&iacute;fico en una revista indexada de alto impacto a nivel scopus (Submisi&oacute;n). 
	{{-- los 15 d&iacute;as para la entrega del Anexo B: Proyecto de Investigaci&oacute;n. --}}
</p>
<div class="separar1"></div>
<p><strong>CUARTA: OBLIGACIONES DE LA CONSULTORA&nbsp;</strong></p>
<p>Son obligaciones de <strong>LA CONSULTORA</strong></p>
<ol>
<li>Poner al servicio del <strong>CONTRATANTE </strong>todo su conocimiento para cumplir a cabalidad con el trabajo de asesor&iacute;a objeto de este contrato.</li>
<li>Cumplir con los plazos fijados en este contrato.</li>
<li>Enviar al <strong>CONTRATANTE </strong>la asesor&iacute;a del art&iacute;culo cient&iacute;fico de manera virtual.</li>
<li>Revisi&oacute;n del art&iacute;culo por el software anti-plagio.</li>
<li>Traducci&oacute;n del art&iacute;culo cient&iacute;fico, siempre que la revista lo solicitara.</li>
<li>Levantamiento de observaciones.</li>
{{-- <li>En el caso se requiera la traducci&oacute;n del Anexo B: Proyecto de Investigaci&oacute;n, este tendr&aacute; un costo adicional establecido por <strong>LA CONSULTORA</strong>.</li> --}}
<li>No divulgar, entregar o suministrar total o parcialmente, el resultado de los estudios que son materia de este contrato sin el consentimiento escrito del <strong>CONTRATANTE.</strong></li>
<li>La asesor&iacute;a culmina una vez que el art&iacute;culo sea aprobado por la revista autorizada.</li>
<li>La consultora se exime de responsabilidad asumida en el presente contrato, si el <strong>CONTRATANTE</strong> designa m&aacute;s de un coautor, sin autorizaci&oacute;n de esta.</li>
</ol>
<br>
<p><strong>QUINTA: OBLIGACIONES DEL CONTRATANTE</strong></p>
<ol>
<li>Suministrar la informaci&oacute;n veraz y oportuna requerida por <strong>LA CONSULTORA.</strong></li>
<li>Realizar las actividades con <strong>LA CONSULTORA</strong> dentro de los plazos programados.</li>
{{-- <li>Si el cliente solicitara factura, se le calcular&aacute; el IGV correspondiente sobre el valor establecido en la cl&aacute;usula</li> --}}
<li>Una vez aprobado el art&iacute;culo, no se podr&aacute; modificar, salvo la realizaci&oacute;n de un pago adicional el cual ser&aacute; determinado por <strong>LA CONSULTORA.</strong></li>
{{-- <li>Es responsabilidad del <strong>CONTRATANTE</strong> revisar y cumplir con los requisitos de la convocatoria a la cual postula.</li> --}}
<li>Si se aumentara el n&uacute;mero de coautores por el <strong>EL CONTRATANTE </strong>tendr&aacute; un costo adicional, determinado por <strong>LA CONSULTORA</strong>, solo se aceptar&aacute; un autor y un coautor.</li>
<li>Si <strong>EL CONTRATANTE </strong>por cualquier raz&oacute;n decide no continuar con la asesor&iacute;a, <strong>LA CONSULTORA </strong>no estar&aacute; obligada a devolver lo depositado por <strong>EL CONTRATANTE.</strong></li>
<li>El retraso originado por entrega inoportuna de la informaci&oacute;n por parte del <strong>CONTRATANTE </strong>modificar&iacute;a los plazos de entrega bajo responsabilidad del mismo.</li>
{{-- <li>Si <strong>EL CONTRATANTE</strong>, enviara sin conocimiento de <strong>LA CONSULTORA</strong> el Anexo B: Proyecto de investigaci&oacute;n a otra convocatoria, <strong>LA CONSULTORA</strong> queda eximida de toda responsabilidad.</li> --}}
</ol>
<p><strong>SEXTA: PROPIEDAD Y RESERVA DEL TRABAJO</strong></p>
	<p>Los resultados obtenidos en esta investigaci&oacute;n ser&aacute;n propiedad de <strong>{{$arrayGrado[$cliente->idgrado]}} {{mb_strtoupper($cliente->nombres.' '.$cliente->apellidos)}}, </strong>con el T&iacute;tulo: <strong>{{mb_strtoupper($data->titulo_contrato)}}</strong></p>
	@if(count($coautores) >= 1)
	<p><strong>Siendo los coautores:</strong></p>
	@endif
	<p>
		@if($temp == 1)
			@forelse (array_slice($coautores->toArray(),1) as $key => $item)
			<div class="left1">{!! $arrayGrado[$item['idgrado']].' '.$item['nombres'].' '.$item['apellidos']!!}</div> <div class="center1">{!!'<b>IDENTIFICADO(A) CON '.$item['tipo_documento'].'</b>'.': '.$item['num_documento'] !!}</div>
			@empty
			@endforelse
		@else
			@forelse ($coautores as $item)
			<div class="left1">{!! $arrayGrado[$item->idgrado].' '.$item->nombres.' '.$item->apellidos!!}</div> <div class="center1">{!!'<b>IDENTIFICADO(A) CON '.$item->tipo_documento.'</b>'.': '.$item->num_documento !!}</div>
			@empty
			@endforelse
		@endif
	</p>
<p>Para constancia se firma en Lima a los {{rtrim(mb_strtolower($fechaLetras->dia_letras))}} del mes de {{$fecha->mes}} del {{rtrim(mb_strtolower($fechaLetras->anio_letras))}}.</p>
<p>Lima {{$fecha->dia}} de {{$fecha->mes}} de {{$fecha->anio}}.</p>
<div class="separar"></div>

<div id="container">
	<div class="left">	
	<strong>	
	___________________________________
		Dr. ISRAEL BARRUTIA BARRETO
		GERENTE
		INNOVA SCIENTIFIC S.A.C</strong>
	</div>
	<div class="center">
		<strong>
	___________________________________
	{{$arrayGrado[$cliente->idgrado]}} {{mb_strtoupper($cliente->nombres.' '.$cliente->apellidos)}}<br>
		AUTOR</strong>
	</div>
	{{-- <div id="right"></div> --}}
</div>
<div class="separar"></div>
<div id="container">
	
	@if($temp == 1)
		@forelse (array_slice($coautores->toArray(),1) as $key => $item)
		<div class="left1">
			<strong>
			___________________________________
				<br>
				{{$arrayGrado[$item['idgrado']]}} {{mb_strtoupper($item['nombres'].' '.$item['apellidos'])}}
				<br>
				COAUTOR
				<div class="separar_coautor"></div>
			</div>
			</strong>
		@empty
		@endforelse
	@else
		@forelse ($coautores as $item)
			<div class="left1">
			<strong>
			___________________________________
				<br>
				{{$arrayGrado[$item->idgrado]}} {{mb_strtoupper($item->nombres.' '.$item->apellidos)}}
				<br>
				COAUTOR
				<div class="separar_coautor"></div>
			</div>
			</strong>
		@empty
		@endforelse
	@endif	


</div>