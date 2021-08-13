<?php

use Illuminate\Support\Facades\Route;
// INICIO DE SESION
Route::group(['middleware' => ['guest']], function () {
    Route::get('/', 'AuthController@index')->name('login.principal');
    Route::post('/login', 'AuthController@postLogin')->name('login');

    // REESTABLECER CONTRASEÑA
    Route::group([
        'prefix' => 'password'
    ], function () {
        Route::get('reset','ResetPasswordController@showFormReset')->name('password.reset');
        Route::post('email', 'ResetPasswordController@emailReset')->name('password.email');
        Route::get('reset/{token}', 'ResetPasswordController@showResetPassword');
        Route::post('resetpassword', 'ResetPasswordController@resetPassword')->name('resetpassword');
    });
});

Route::group(['middleware' => ['auth']], function () {

    // CIERRE DE SESION
    Route::get('/logout', 'AuthController@logout')->name('logout');

    Route::get('edit-profile/{id}', 'UserController@editProfile')->name('edit.profile');
    Route::post('update-profile/{id}', 'UserController@updateProfile')->name('update.profile');
    Route::post('update-password', 'UserController@updatePassword')->name('update.password');
    // INICIO - PRINCIPAL
    Route::get('/inicio/{fecha_dia?}', 'InicioController@index')->name('inicio');
    Route::post('dynamic-date', 'InicioController@dynamicDate')->name('inicio.dynamic-date');
    // USUARIOS
    Route::resource('usuarios', 'UserController');
    Route::group([
        'prefix' => 'usuarios'
    ], function () {
    Route::post('indexTable', 'UserController@indexTable')->name('usuarios.indexTable');
    Route::get('act-desac/{id}', 'UserController@activarDesactivar')->name('usuarios.act.desac');
    Route::get('search-user-num-doc/{id}', 'UserController@searchUserNumDocumento')->name('search.user.numdoc');
    Route::get('search-username/{id}', 'UserController@searchUserName')->name('search.username');
    Route::get('search-useremail/{id}', 'UserController@searchUserEmail')->name('search.useremail');
    });

    Route::resource('correo', 'CorreoController');
    // POSIBLES CLIENTES
    Route::group([
        'prefix' => 'posibles-clientes'
    ], function () {
    Route::get('/', 'PosibleClienteController@index')->name('posibles.clientes');
    Route::post('indexTable', 'PosibleClienteController@indexTable')->name('posibles.clientes.indexTable');
    Route::get('create', 'PosibleClienteController@create')->name('posibles.clientes.create');
    Route::post('store', 'PosibleClienteController@store')->name('posibles.clientes.store');
    Route::post('update/{id}', 'PosibleClienteController@update')->name('posibles.clientes.update');
    Route::get('edit/{id}', 'PosibleClienteController@edit')->name('posibles.clientes.edit');
    Route::get('gestionar-llamada/{id}', 'PosibleClienteController@gestionarLlamada')->name('gestionar.llamada');
    Route::post('gestionar-llamada', 'PosibleClienteController@actualizarLlamada')->name('actualizar.llamada');
    Route::get('get-vendedor/{distrito}', 'PosibleClienteController@getVendedor')->name('get.vendedor');
    Route::get('show/{id}', 'PosibleClienteController@show')->name('posibles.clientes.show');
    Route::get('search_client/{id}', 'PosibleClienteController@searchClient');
    Route::get('act-desac/{id}', 'PosibleClienteController@activarDesactivar')->name('posibles.clientes.act.desac');
    Route::get('visita/{id}', 'PosibleClienteController@visitaCliente')->name('posibles.clientes.visita');
    Route::post('exportar-excel/{fecha_inicio}/{fecha_fin}/{estado}/{estado_cliente}','PosibleClienteController@exportarExcel');
    });

    // LOGS DEL SISTEMA
    Route::get('log-systems', 'LogSystemController@index')->name('log-systems.index');
    Route::post('log-systems', 'LogSystemController@indexTable')->name('log-systems.indexTable');
    Route::post('log-systems/exportar-excel/{fecha_inicio}/{fecha_fin}/{estado}/{anio}/{search}','LogSystemController@exportarExcel');

    // CONFIGURACIONES
    Route::resource('configuraciones', 'ConfiguracionController');
    Route::group([
        'prefix' => 'configuraciones'
    ], function () {
    Route::post('indexTable', 'ConfiguracionController@indexTable')->name('configuraciones.indexTable');
    Route::get('act-desac/{id}', 'ConfiguracionController@activarDesactivar')->name('configuraciones.act.desac');
    });
    // MANTENIMIENTO
    Route::get('mantenimiento-show', 'ConfiguracionController@showMantenimiento')->name('configuraciones.mantenimiento-show');
    Route::get('mantenimiento-update/{value}', 'ConfiguracionController@updateMantenimiento')->name('configuraciones.updateMantenimiento');

    // REPORTES
    Route::group([
        'prefix' => 'reportes'
    ], function () {
        // VENDEDORES
    Route::get('vendedores', 'ReporteController@reporteVendedor')->name('reportes.vendedores');
    Route::post('vendedoresAjax', 'ReporteController@indexTable');
    Route::post('vendedores/excel/{fecha_inicio}/{fecha_fin}/{vendedor}/{anio}/{search}','ReporteController@exportarVendedores');

    });

    //PROSPECTOS
    Route::resource('cliente', 'ClienteController');
    Route::get('verificar-estado-cliente/{id}', 'ClienteController@verificarEstadoCliente')->name('verificar.estado');
    Route::get('/clientes/exportarexcel','ClienteController@exportarExcel');
    Route::get('cliente/download/contrato/{id}', 'ClienteController@downloadContrato')->name('cliente.download.contrato');
    Route::post('cliente/agregar-contrato', 'ClienteController@storeContrato')->name('agregar.contrato');
    Route::post('cliente/agregar-autor', 'ClienteController@agregarAutor')->name('add.autor');
   

    
    //ASESORES DE VENTAS
    Route::resource('asesorventas','AsesorventaController');

    //ASESORES EDITORIAL
    Route::resource('asesor', 'AsesorController');
    //Reviosiones Técnicas
    Route::resource('revision', 'RevisionController');
    Route::get('revision/download/archivo/{idclientes}/{id}','RevisionController@download')->name('download.revision');
    Route::get('revision/download/resumen/{idclientes}/{id}', 'RevisionController@downloadResumen')->name('download.resumen.revision');
    Route::get('/get_clientes','RevisionController@getClientes');

    //ORDEN DE TRABAJO
    Route::resource('ordentrabajo', 'OrdenTrabajoController');
    Route::get('ordentrabajo/{id}/generar', 'OrdenTrabajoController@generarOrdenTrabajo');

    /**Orden de trabajo */
    Route::post('cliente/agregar-autor', 'ClienteController@agregarAutor')->name('add.autor');
    Route::resource('ordentrabajo', 'OrdenTrabajoController');
    Route::post('/ordentrabajo/guardarcuota', 'OrdenTrabajoController@guardarCuota')->name('guardarcuota');
    Route::post('/ordentrabajo/uploadpay', 'OrdenTrabajoController@uploadPay')->name('uploadpay');
    Route::get('/ordentrabajo/downloadpay/{id}/{ot_id}', 'OrdenTrabajoController@downloadPay')->name('downloadpay');
    Route::get('/ordentrabajo/deletepay/{id}/{ot_id}', 'OrdenTrabajoController@deletePay')->name('deletepay');
    Route::post('/ordentrabajo/verificar', 'OrdenTrabajoController@verificarMontoOt')->name('verificar.monto.ot');
    Route::post('/ordentrabajo/aprobar-ot-coautoria', 'OrdenTrabajoController@aprobarOtCoautoria')->name('aprobar.ot.coautoria');
    Route::post('/ordentrabajo/aprobar', 'OrdenTrabajoController@aprobarOrdenTrabajo')->name('aprobar.ot');
    Route::post('/generateOT', 'OrdenTrabajoController@saveOrdenTrabajo')->name('generate.ordentrabajo');
    Route::post('gestionar-ot/firmaautores', 'AsesorventaController@guardarFirma')->name('guardar.firma');
    Route::get('asesorventa/gestionar-ot/firma/{id}', 'AsesorventaController@downloadFirma')->name('autor.download.firma');

    //CONTRATOS
    Route::get('asesorventa/gestionar-ot/{id}', 'AsesorventaController@gestionarOT')->name('gestionar.ot');


    //GERENCIA 
      Route::resource('gerencia', 'GerenciaController');
      Route::get('gerencia/show_detail/{id}', 'GerenciaController@showDetail')->name('gerencia.show_detail');
      Route::get('gerencia_pendientes', 'GerenciaController@listPendientes')->name('gerencia.pendiente');
      Route::get('gerencia_aprobados', 'GerenciaController@listAprobados');
      Route::post('gerencia_contrato', 'GerenciaController@generarActualizarContrato')->name('gerencia.contrato');
      Route::get('gerencia/download/contrato/{id}', 'GerenciaController@downloadContrato')->name('gerencia.download.contrato');
      Route::get('cliente/download/contrato/{id}', 'ClienteController@downloadContrato')->name('cliente.download.contrato');
      Route::get('gerencia/download/contratocoautoria/{id}', 'GerenciaController@downloadContratoCoautoria')->name('gerencia.download.contratocoautoria');

      /**Coautorias */
      Route::get('coautorias', 'GerenciaController@getCoautores')->name('coautorias');
      Route::post('contrato-coautoria', 'GerenciaController@generarContratoCoautoria')->name('contrato.coautoria');
      Route::get('articulos/gethistorialcuotas/{id}', 'AsesorVentaController@getHistorialCuotas')->name('historialcuotas');
      Route::get('articulos/historialcuotas/{id}', 'AsesorventaController@historialCuotas')->name('historialescuotas');
      Route::get('libros/getpagopendiente/{id}', 'AsesorVentaController@getPagoPendiente')->name('pagopendiente');
      Route::get('validar-autor/{id}/{codigo}', 'AsesorventaController@searchAutor')->name('search_author');
      Route::post('articulos/sustituircuotas', 'AsesorventaController@subirPago')->name('updatepago');

      
      //Referente al PDF del OT
      Route::get('/pdfordentrabajo/{id}', 'AsesorventaController@exportarPDF')->name('ot_pdf');


      Route::get('libros/lista', 'AsesorventaController@getArticles')->name('articulos.lista');
      Route::get('libros/detalles/{id}/{codigo}', 'AsesorventaController@showDetailArticle')->name('articulos.detalles');
      Route::post('articulos/detalles/guardar-autores', 'AsesorventaController@saveAuthors')->name('guardar.autores');
      Route::post('articulos/store-pago-coautor', 'AsesorventaController@storePagoCoautor')->name('store.pago.coautor');
      Route::post('articulos/update-pago-coautor', 'AsesorventaController@updatePagoCoautor')->name('update.pago.coautor');
      Route::post('/contrato-coautoria/pago', 'AsesorventaController@guardarCuotaCoautoria')->name('guardarcuotacoautoria');


      //AUTORES
      Route::resource('autor', 'AutorController');

      //Todo referente a excel
      Route::post('autor/exportarexcel__{id}','AutorController@exportarExcelAutores');
      Route::get('/editoriales/exportarexcel','EditorialController@exportarExcel');


      Route::resource('editoriales', 'EditorialController');
      Route::post('/editoriales/desactivar/{id}','EditorialController@desactivar')->name('editoriales.desactivar');
    

      //Áreas
      Route::resource('area', 'AreaController');

      //Archivo
      Route::resource('archivo', 'ArchivoController');
      Route::get('/archivo/download/{id}','ArchivoController@download')->name('download');
      Route::get('/archivos/exportar','ArchivoController@exportarExcel');


      //Historiales
      Route::resource('historial', 'HistorialController');

      //Actividades
      Route::resource('actividad', 'ActividadController');
    
      //Materiales
      Route::get('/material','ArchivoController@material');

      Route::get('/historial/download/{id}','HistorialController@download')->name('downloadhistorial');
      //Libros
      Route::resource('librosinvestigacion', 'InvestigacionController');

      //Correo Libros
      Route::resource('correolibro', 'CorreoLibroController');
      Route::get('descargar-firma-libro/{id}', 'CorreoLibroController@downloadfirma')->name('descargar.firma.libro');
});
