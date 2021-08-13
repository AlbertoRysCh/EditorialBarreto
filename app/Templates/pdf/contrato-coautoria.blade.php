@php
    $cliente = json_decode($data->cliente);
    $fecha = json_decode($fecha);
	$fechaLetras = json_decode($fecha_letras);
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
		height: 175px;
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
</style>
<p style="text-align: center;"><strong>CONTRATO DE PRESTACI&Oacute;N DE SERVICIOS DE ASESOR&Iacute;A CIENT&Iacute;FICA</strong></p>
<p style="text-align: right;"><strong>N&deg; {{$data->codigo}}</strong></p>
<p style="text-align: justify;">Conste por el presente contrato que celebran de una parte <strong>INNOVA SICENTIFIC S.A.C, </strong>con domicilio en AV. LA MARINA 1453, DISTRITO DE SAN MIGUEL, LIMA, con <strong>RUC, N&deg; 20603644078, </strong>debidamente representada por su <strong>Gerente Dr. BARRUTIA BARRETO, ISRAEL, </strong>identificado con el DNI. N&deg; 10614088, quien en adelante se denominar&aacute; <strong>LA CONSULTORA, </strong>y del otro <strong>{{$arrayGrado[$cliente->idgrado]}} {{mb_strtoupper($cliente->nombres.' '.$cliente->apellidos)}} </strong>Con <strong>{{mb_strtoupper($cliente->tipo_documento)}} N&deg; {{$cliente->num_documento}} </strong>domiciliado en {{mb_strtoupper($cliente->domicilio ?? '-')}}. Quien para efectos de este contrato se denominar&aacute; el <strong>CONTRATANTE,</strong> se ha celebrado el siguiente contrato de prestaci&oacute;n de servicios de asesor&iacute;a que se regir&aacute; por las siguientes cl&aacute;usulas:</p>
<p><strong>PRIMERA: OBJETO</strong></p>
<p style="text-align: justify;"><strong>LA CONSULTORA, </strong>se obliga para con el <strong>CONTRATANTE</strong> a prestar los servicios de asesor&iacute;a para la elaboraci&oacute;n de un art&iacute;culo cient&iacute;fico para ser publicada en revista indexada de alto impacto, siendo el <strong>CONTRATANTE</strong> coautor de este.</p>
<p><strong>SEGUNDA: PLAZO.</strong></p>
<p style="text-align: justify;"><strong>LA CONSULTORA, </strong>se compromete a realizar la asesor&iacute;a de acompa&ntilde;amiento y orientaci&oacute;n para la elaboraci&oacute;n del art&iacute;culo cient&iacute;fico, a partir de la firma del presente contrato de acuerdo a:</p>
<ul>
<li>Hasta 2 d&iacute;as calendario plazo en el cual se subir&aacute; el art&iacute;culo cient&iacute;fico a la revista.</li>
<li>El plazo de publicaci&oacute;n ser&aacute; determinado por la revista a la cual se presentar&aacute; el art&iacute;culo.</li>
</ul>
<p><strong>TERCERA: VALOR Y FORMA DE PAGO</strong></p>
<p style="text-align: justify;">El valor del presente contrato de prestaci&oacute;n de servicios de asesor&iacute;a es de <strong>{{mb_strtoupper($letras_total)}} {!!'S/.'.$data->monto_total!!}, </strong>que ser&aacute; cancelado al contado.</p>
<p><strong>CUARTA: OBLIGACIONES DE LA CONSULTORA</strong></p>
<p><strong>Son obligaciones de LA CONSULTORA</strong></p>
<ol>
<li>Poner el servicio del <strong>CONTRATANTE</strong> todo su conocimiento para cumplir a cabalidad con el trabajo de asesor&iacute;a objeto de este contrato.</li>
<li>Cumplir con los plazos fijados en este contrato.</li>
<li>Enviar al <strong>CONTRATANTE</strong> la asesor&iacute;a del art&iacute;culo cient&iacute;fico de manera virtual.</li>
<li>Revisi&oacute;n del art&iacute;culo por el software anti-plagio.</li>
<li>Traducci&oacute;n del art&iacute;culo cient&iacute;fico, siempre que la revista lo solicite.</li>
<li>Levantamiento de observaciones.</li>
<li>No divulgar, entregar o suministrar total o parcialmente, el resultado de los estudios que son materia de este contrato sin el consentimiento escrito del <strong>CONTRATANTE.</strong></li>
<li>La asesor&iacute;a culmina una vez que el articulo sea aprobado por la revista autorizada.</li>
</ol>
<p><strong>QUINTA: OBLIGACIONES DEL CONTRATANTE</strong></p>
<ul>
<li>Realizar las actividades con <strong>LA CONSULTORA</strong> DENTRO de los plazos programados.</li>
<li>Si <strong>EL CONTRATANTE</strong> por cualquier raz&oacute;n decide no continuar con la asesor&iacute;a, <strong>LA CONSULTORA </strong>no estar&aacute; obligada a devolver lo depositado por el <strong>CONTRATANTE</strong></li>
</ul>
<p><strong>&nbsp;</strong></p>
<p><strong>&nbsp;</strong></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><strong>SEXTA: PROPIEDAD Y RESERVA DEL TRABAJO</strong></p>
<p style="text-align: justify;">Los resultados obtenidos en esta investigaci&oacute;n ser&aacute;n de propiedad como coautor&iacute;a del <strong>{{$arrayGrado[$cliente->idgrado]}} {{mb_strtoupper($cliente->nombres.' '.$cliente->apellidos)}}, </strong>as&iacute; mismo ser&aacute; considerado dentro del equipo de investigadores que desarrollaron el art&iacute;culo cient&iacute;fico, siendo el trabajo de investigaci&oacute;n siguiente:</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>-{{mb_strtoupper($data->titulo_contrato)}}</strong></p>

<p>Para constancia se firma en Lima a los {{rtrim(mb_strtolower($fechaLetras->dia_letras))}} del mes de {{$fecha->mes}} del {{rtrim(mb_strtolower($fechaLetras->anio_letras))}}.</p>
<p>&nbsp;</p>
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
		CONTRATANTE</strong>
	</div>
	{{-- <div id="right"></div> --}}
</div>