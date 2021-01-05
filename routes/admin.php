<?php
//Route::get('/admin', function(){return('Hola');});
Route::prefix('/admin')->group(function(){
    //Route::get('/', 'Admin\DashboardController@getDashboard')->name('dashboard');
    Route::get('/', 'Admin\DashboardController@getDashboard')->name('dashboard');
    Route::post('/cambio', 'Admin\DashboardController@postDashboardCambio')->name('dashboard');

    //Modulo de parametros
    Route::get('/parametros', 'Admin\ParamController@getParametroHome')->name('parametros');
    Route::post('/parametros', 'Admin\ParamController@postParametroHome')->name('parametros');
    Route::get('/saldos', 'Admin\ParamController@getParametroSaldos')->name('saldos');
    Route::post('/saldos', 'Admin\ParamController@postParametroSaldos')->name('saldos');
    
    //Usuarios
    Route::get('/usuarios/{status}','Admin\UsuarioController@getUsuarioHome')->name('usuarios');
    Route::get('/usuario/add','Admin\UsuarioController@getUsuarioAdd')->name('usuario_add');
    Route::post('/usuario/add','Admin\UsuarioController@postUsuarioAdd')->name('usuario_add');
    Route::get('/usuario/{id}/edit','Admin\UsuarioController@getUsuarioEdit')->name('usuario_edit');
    Route::post('/usuario/{id}/edit','Admin\UsuarioController@postUsuarioEdit')->name('usuario_edit');
    Route::get('/usuario/{id}/password','Admin\UsuarioController@getUsuarioPassword')->name('usuario_password');
    Route::post('/usuario/{id}/password','Admin\UsuarioController@postUsuarioPassword')->name('usuario_password');
    Route::get('/usuario/{id}/permissions','Admin\UsuarioController@getUsuarioPermissions')->name('usuario_permissions');
    Route::post('/usuario/{id}/permissions','Admin\UsuarioController@postUsuarioPermissions')->name('usuario_permissions');

    //Modulo de categorias
    Route::get('/categorias/{module}', 'Admin\CategoriaController@getCategoriaHome')->name('categorias');
    Route::get('/categoria/add/{module}', 'Admin\CategoriaController@getCategoriaAdd')->name('categoria_add');
	Route::post('/categoria/add/{module}', 'Admin\CategoriaController@postCategoriaAdd')->name('categoria_add');
	Route::get('/categoria/{id}/edit', 'Admin\CategoriaController@getCategoriaEdit')->name('categoria_edit');
	Route::post('/categoria/{id}/edit', 'Admin\CategoriaController@postCategoriaEdit')->name('categoria_edit');
    Route::get('/categoria/{id}/borrar', 'Admin\CategoriaController@getCategoriaDelete')->name('categoria_delete');

    //Modulo de pacientes
    Route::get('/pacientes', 'Admin\PacienteController@getPacienteHome')->name('pacientes');
    Route::get('/paciente/registro', 'Admin\PacienteController@getPacienteRegistro')->name('pacientes');
    Route::get('/paciente/add', 'Admin\PacienteController@getPacienteAdd')->name('paciente_add');    
    Route::post('/paciente/add', 'Admin\PacienteController@postPacienteAdd')->name('paciente_add');
    Route::get('/paciente/{id}/edit', 'Admin\PacienteController@getPacienteEdit')->name('paciente_edit');
    Route::post('/paciente/{id}/edit', 'Admin\PacienteController@postPacienteEdit')->name('paciente_edit');
    Route::post('/paciente/{id}/{item}/past', 'Admin\PacienteController@postPacientePast')->name('pacientes');
    Route::get('/paciente/{id}/convert', 'Admin\PacienteController@getPacienteConvert')->name('pacientes');
    Route::get('/paciente/{id}/appointment', 'Admin\PacienteController@getPacienteAppointment')->name('paciente_appointment');
    Route::post('/paciente/{id}/appointment', 'Admin\PacienteController@postPacienteAppointment')->name('paciente_appointment');
    Route::get('/paciente/{id}/delete', 'Admin\PacienteController@getPacienteDelete')->name('paciente_delete');
    Route::get('/paciente/{tipo}/{numero}/busdni', 'Admin\PacienteController@getPacienteBusDNI')->name('pacientes');
    Route::get('/paciente/{tipo}/{numero}/busapi', 'Admin\PacienteController@getPacienteBusApi')->name('pacientes');


    //Modulo de proveedor - cliente
    Route::get('/proveedores', 'Admin\ProveedorController@getProveedorHome')->name('proveedores');
    Route::get('/proveedor/registro', 'Admin\ProveedorController@getProveedorRegistro')->name('proveedores');
    Route::get('/proveedor/add', 'Admin\ProveedorController@getProveedorAdd')->name('proveedor_add');
    Route::post('/proveedor/add', 'Admin\ProveedorController@postProveedorAdd')->name('proveedor_add');
    Route::get('/proveedor/{id}/edit', 'Admin\ProveedorController@getProveedorEdit')->name('proveedor_edit');
    Route::post('/proveedor/{id}/edit', 'Admin\ProveedorController@postProveedorEdit')->name('proveedor_edit');
    Route::get('/proveedor/{id}/delete', 'Admin\ProveedorController@getProveedorDelete')->name('proveedor_delete');
    //Busqueda por Número de documento
    Route::get('/proveedor/{bus}/busnumdoc', 'Admin\ProveedorController@getBusProvNumdoc')->name('proveedores');
    Route::get('/proveedor/{bus}/busrazsoc', 'Admin\ProveedorController@getBusProvRazsoc')->name('proveedores');

    //Modulo de Historia
    Route::get('/historias/{id}/{item}/home', 'Admin\HistoriaController@getHistoriaHome')->name('historias');
    Route::post('/historia/{id}/new', 'Admin\HistoriaController@postHistoriaNew')->name('historia_add');
    Route::post('/historia/{id}/edit', 'Admin\HistoriaController@postHistoriaEdit')->name('historia_edit');
    Route::post('/historia/{id}/plan', 'Admin\HistoriaController@postHistoriaPlan')->name('historia_plan');
    Route::post('/historia/{id}/diagnosisadd', 'Admin\HistoriaController@postHistoriaDiagnosisAdd')->name('historia_diagnosis');
    Route::get('/historia/{id}/diagnosisdelete', 'Admin\HistoriaController@getHistoriaDiagnosisDelete')->name('historia_diagnosis');
    Route::post('/historia/{id}/{item}/cita', 'Admin\HistoriaController@postHistoriaCita')->name('historia_cita');
    Route::get('/historia/{id}/triage', 'Admin\HistoriaController@getHistoriaTriage')->name('historia_triage');
    Route::post('/historia/{id}/triage', 'Admin\HistoriaController@postHistoriaTriage')->name('historia_triage');
    Route::get('/historia/{id}/change', 'Admin\HistoriaController@getHistoriaChange')->name('historia_edit');
    Route::post('/historia/{id}/change', 'Admin\HistoriaController@postHistoriaChange')->name('historia_edit');
    Route::post('/historia/{id}/prescriptionadd', 'Admin\HistoriaController@postHistoriaPrescriptionAdd')->name('historia_prescription');
    Route::post('/historia/{id}/prescriptiongen', 'Admin\HistoriaController@postHistoriaPrescriptionGen')->name('historia_prescription');
    Route::get('/historia/{id}/searchprescription', 'Admin\HistoriaController@getHistoriaSearchPrescription')->name('historia_prescription');
    Route::post('/historia/{id}/prescriptionfooter', 'Admin\HistoriaController@postHistoriaPrescriptionFooter')->name('historia_prescription');
    Route::get('/historia/{id}/prescriptiondelete', 'Admin\HistoriaController@getHistoriaPrescriptionDelete')->name('historia_prescription');

    //Modulo de doctores
    Route::get('/doctores/{status}', 'Admin\DoctorController@getDoctorHome')->name('doctores');
    Route::get('/doctor/add', 'Admin\DoctorController@getDoctorAdd')->name('doctor_add');
    Route::post('/doctor/add', 'Admin\DoctorController@postDoctorAdd')->name('doctor_add');
    Route::get('/doctor/{id}/edit', 'Admin\DoctorController@getDoctorEdit')->name('doctor_edit');
    Route::post('/doctor/{id}/edit', 'Admin\DoctorController@postDoctorEdit')->name('doctor_edit');
    Route::get('/doctor/{id}/delete', 'Admin\DoctorController@getDoctorDelete')->name('doctor_delete');

    //Modulo de CIE10
    Route::get('/cie10', 'Admin\Cie10Controller@getCie10Home')->name('cie10');
    Route::get('/cie10/registro', 'Admin\Cie10Controller@getCie10Registro')->name('cie10');
    Route::get('/cie10/add', 'Admin\Cie10Controller@getCie10Add')->name('cie10_add');
    Route::post('/cie10/add', 'Admin\Cie10Controller@postCie10Add')->name('cie10_add');
    Route::get('/cie10/{id}/edit', 'Admin\Cie10Controller@getCie10Edit')->name('cie10_edit');
    Route::post('/cie10/{id}/edit', 'Admin\Cie10Controller@postCie10Edit')->name('cie10_edit');
    Route::get('/cie10/{id}/delete', 'Admin\Cie10Controller@getCie10Delete')->name('cie10_delete');
    //Busqueda Modal - Cie10 x Nombre
    Route::get('/cie10/buscie10/{bus}', 'Admin\Cie10Controller@getBusCie10')->name('cie10');
    Route::get('/cie10/buscie10codigo/{bus}', 'Admin\Cie10Controller@getBusCie10Codigo')->name('cie10');

    //Modulo de Unidad Medida
    Route::get('/umedidas', 'Admin\UMedidaController@getUMedidaHome')->name('umedidas');
    Route::get('/umedida/add', 'Admin\UMedidaController@getUMedidaAdd')->name('umedida_add');
    Route::post('/umedida/add', 'Admin\UMedidaController@postUMedidaAdd')->name('umedida_add');
    Route::get('/umedida/{id}/edit', 'Admin\UMedidaController@getUMedidaEdit')->name('umedida_edit');
    Route::post('/umedida/{id}/edit', 'Admin\UMedidaController@postUMedidaEdit')->name('umedida_edit');
    Route::get('/umedida/{id}/delete', 'Admin\UMedidaController@getUMedidaDelete')->name('umedida_delete');
    
    //Modulo de Servicios
    Route::get('/servicios', 'Admin\ServicioController@getServicioHome')->name('servicios');
    Route::get('/servicio/registro', 'Admin\ServicioController@getServicioRegistro')->name('servicios');
    Route::get('/servicio/add', 'Admin\ServicioController@getServicioAdd')->name('servicio_add');
    Route::post('/servicio/add', 'Admin\ServicioController@postServicioAdd')->name('servicio_add');
    Route::get('/servicio/{id}/edit', 'Admin\ServicioController@getServicioEdit')->name('servicio_edit');
    Route::post('/servicio/{id}/edit', 'Admin\ServicioController@postServicioEdit')->name('servicio_edit');
    Route::get('/servicio/{id}/delete', 'Admin\ServicioController@getServicioDelete')->name('servicio_delete');
    //Busqueda
    Route::get('/servicio/{bus}/find', 'Admin\ServicioController@getServicioFind')->name('servicios');
    Route::get('/servicio/{bus}/findid', 'Admin\ServicioController@getServicioFindId')->name('servicios');


    //Modulo de tipo de comprobantes de pago
    Route::get('/comprobantes', 'Admin\ComprobanteController@getComprobanteHome')->name('comprobantes');
    Route::get('/comprobante/add', 'Admin\ComprobanteController@getComprobanteAdd')->name('comprobante_add');
    Route::post('/comprobante/add', 'Admin\ComprobanteController@postComprobanteAdd')->name('comprobante_add');
    Route::get('/comprobante/{id}/edit', 'Admin\ComprobanteController@getComprobanteEdit')->name('comprobante_edit');
    Route::post('/comprobante/{id}/edit', 'Admin\ComprobanteController@postComprobanteEdit')->name('comprobante_edit');
    Route::get('/comprobante/{id}/delete', 'Admin\ComprobanteController@getComprobanteDelete')->name('comprobante_delete');

    //Modulo de Facturación Admisión
    Route::get('/facturas/{periodo}', 'Admin\FacturaController@getFacturaHome')->name('facturas');
    Route::post('/factura/cambio', 'Admin\FacturaController@postFacturaCambio')->name('facturas');
    Route::get('/factura/{td}/numero', 'Admin\FacturaController@getFacturaNumero')->name('facturas');
    Route::get('/factura/add', 'Admin\FacturaController@getFacturaAdd')->name('factura_add');
    Route::post('/factura/add', 'Admin\FacturaController@postFacturaAdd')->name('factura_add');
    Route::get('/factura/{id}/edit', 'Admin\FacturaController@getFacturaEdit')->name('factura_edit');
    Route::post('/factura/{id}/edit', 'Admin\FacturaController@postFacturaEdit')->name('factura_edit');
    Route::get('/factura/{id}/detraccion', 'Admin\FacturaController@getFacturaDetraccion')->name('factura_edit');
    Route::post('/factura/{id}/detraccion', 'Admin\FacturaController@postFacturaDetraccion')->name('factura_edit');
    Route::get('/factura/{id}/delete', 'Admin\FacturaController@getFacturaDelete')->name('factura_delete');
    Route::get('/factura/{id}/print', 'Admin\FacturaController@getFacturaPrint')->name('facturas');
    Route::get('/factura/{id}/deta', 'Admin\FacturaController@getFacturaDetAdd')->name('factura_add');
    Route::post('/factura/{id}/deta', 'Admin\FacturaController@postFacturaDetAdd')->name('factura_add');
    Route::get('/factura/{id}/dete', 'Admin\FacturaController@getFacturaDetEdit')->name('factura_add');
    Route::post('/factura/{id}/dete', 'Admin\FacturaController@postFacturaDetEdit')->name('factura_add');
    Route::get('/factura/{id}/detd', 'Admin\FacturaController@getFacturaDetDelete')->name('factura_add');
    Route::get('/factura/{id}/end', 'Admin\FacturaController@getFacturaEnd')->name('factura_edit');
    Route::get('/factura/{id}/bdetrac', 'Admin\FacturaController@getFacturaBuscaDetraccion')->name('factura_edit');
    Route::get('/factura/{id}/{doctor_id}/cambiadr', 'Admin\FacturaController@getFacturaCambiaDoctor')->name('factura_edit');
    //Route::get('/factura/{id}/xml', 'Admin\FacturaController@getFacturaXML')->name('factura_edit');

    //Modulo de Ingresos
    Route::get('/ingresos/{periodo}', 'Admin\IngresoController@getIngresoHome')->name('ingresos');
    Route::post('/ingreso/cambio', 'Admin\IngresoController@postIngresoCambio')->name('ingresos');
    Route::get('/ingreso/add', 'Admin\IngresoController@getIngresoAdd')->name('ingreso_add');
    Route::post('/ingreso/add', 'Admin\IngresoController@postIngresoAdd')->name('ingreso_add');
    Route::get('/ingreso/{id}/deta', 'Admin\IngresoController@getIngresoDetAdd')->name('ingreso_add');
    Route::post('/ingreso/{id}/deta', 'Admin\IngresoController@postIngresoDetAdd')->name('ingreso_add');
    Route::get('/ingreso/{id}/detd', 'Admin\IngresoController@getIngresosDetDelete')->name('ingreso_add');
    Route::get('/ingreso/{id}/edit', 'Admin\IngresoController@getIngresoEdit')->name('ingreso_edit');
    Route::post('/ingreso/{id}/edit', 'Admin\IngresoController@postIngresoEdit')->name('ingreso_edit');
    Route::get('/ingreso/{id}/delete', 'Admin\IngresoController@getIngresoDelete')->name('ingreso_delete');
    //Busquedas
    Route::get('/ingreso/{producto}/{bus}/findlote', 'Admin\IngresoController@getIngresoFindLote')->name('ingreso_add');
    Route::get('/ingreso/{id}/findlotid', 'Admin\IngresoController@getIngresoFindLoteId')->name('ingreso_add');

    //Modulo de Salidas(Venta y consumo farmacia)
    Route::get('/salidas/{periodo}', 'Admin\SalidaController@getSalidaHome')->name('salidas');
    Route::post('/salida/cambio', 'Admin\SalidaController@postSalidaCambio')->name('salidas');
    Route::get('/salida/{td}/numero', 'Admin\SalidaController@getSalidaNumero')->name('salidas');
    Route::get('/salida/add', 'Admin\SalidaController@getSalidaAdd')->name('salida_add');
    Route::post('/salida/add', 'Admin\SalidaController@postSalidaAdd')->name('salida_add');
    Route::get('/salida/{id}/deta', 'Admin\SalidaController@getSalidaDetAdd')->name('salida_add');
    Route::post('/salida/{id}/deta', 'Admin\SalidaController@postSalidaDetAdd')->name('salida_add');
    Route::get('/salida/{id}/detd', 'Admin\SalidaController@getSalidaDetDelete')->name('salida_add');
    Route::get('/salida/{id}/edit', 'Admin\SalidaController@getSalidaEdit')->name('salida_edit');
    Route::post('/salida/{id}/edit', 'Admin\SalidaController@postSalidaEdit')->name('salida_edit');
    Route::get('/salida/{id}/delete', 'Admin\SalidaController@getSalidaDelete')->name('salida_delete');
    Route::get('/salida/{id}/end', 'Admin\SalidaController@getSalidaEnd')->name('salida_edit');
    Route::get('/salida/{id}/{fp}/{nope}/cambiafp', 'Admin\SalidaController@getSalidaCambiaFPago')->name('salida_edit');

    //Modulo Kardex
    //Route::get('/kardex/{periodo}/{producto}', 'Admin\KardexController@getKardexRegenerate')->name('ingresos');

    //Modulo Tipo de medicamento
    Route::get('/tipmeds/{id}', 'Admin\TipMedController@getTipMedHome')->name('tipmeds');
    Route::get('/tipmeds/{id}/selcomp', 'Admin\TipMedController@getTipMedSelComposicion')->name('tipmeds');

    //Modulo importaciones
    Route::get('/import', 'Admin\ImportController@getImportHome')->name('import');
    Route::post('/import/categoria', 'Admin\ImportController@postImportCategoria')->name('import');
    Route::post('/import/cie10', 'Admin\ImportController@postImportCie10')->name('import');
    Route::get('/import/umedida', 'Admin\ImportController@getImportUMedida')->name('import');
    Route::post('/import/tipmed', 'Admin\ImportController@postImportTipMed')->name('import');
    Route::post('/import/composicion', 'Admin\ImportController@postImportComposicion')->name('import');
    Route::post('/import/producto', 'Admin\ImportController@postImportProducto')->name('import');
    Route::post('/import/laboratorio', 'Admin\ImportController@postImportLaboratorio')->name('import');
    Route::post('/import/doctor', 'Admin\ImportController@postImportDoctor')->name('import');
    Route::post('/import/paciente', 'Admin\ImportController@postImportPaciente')->name('import');
    Route::post('/import/proveedor', 'Admin\ImportController@postImportProveedor')->name('import');
    Route::post('/import/servicio', 'Admin\ImportController@postImportServicio')->name('import');
    Route::post('/import/comprobantes', 'Admin\ImportController@postImportComprobante')->name('import');
    Route::post('/import/afectacion', 'Admin\ImportController@postImportAfectacion')->name('import');
    Route::post('/import/tiponota', 'Admin\ImportController@postImportTipoNota')->name('import');
    Route::post('/import/detraccion', 'Admin\ImportController@postImportDetraccion')->name('import');
    Route::post('/import/saldo', 'Admin\ImportController@postImportSaldo')->name('import');
    Route::post('/import/vence', 'Admin\ImportController@postImportVence')->name('import');
    Route::post('/import/historia', 'Admin\ImportController@postImportHistoria')->name('import');


    //Modulo de Productos
    Route::get('/productos', 'Admin\ProductoController@getProductoHome')->name('productos');
    Route::get('/producto/add', 'Admin\ProductoController@getProductoAdd')->name('producto_add');
    Route::post('/producto/add', 'Admin\ProductoController@postProductoAdd')->name('producto_add');
    Route::get('/producto/{id}/edit', 'Admin\ProductoController@getProductoEdit')->name('producto_edit');
    Route::post('/producto/{id}/edit', 'Admin\ProductoController@postProductoEdit')->name('producto_edit');
    Route::get('/producto/{id}/delete', 'Admin\ProductoController@getProductoDelete')->name('producto_delete');
    //Busqueda Modal - Productos x Nombre o Composición
    Route::get('/producto/{bus}/search', 'Admin\ProductoController@getProductoSearch')->name('cie10');
    Route::get('/producto/{bus}/searchid', 'Admin\ProductoController@getProductoSearchId')->name('cie10');

    //Modulo de Notas de Débito y Crédito Admision
    Route::get('/notadms/{periodo}', 'Admin\NotAdmController@getNotAdmHome')->name('notadms');
    Route::post('/notadm/cambio', 'Admin\NotAdmController@postNotAdmCambio')->name('notadms');
    Route::get('/notadm/{td}/{dmtd}/numero', 'Admin\NotAdmController@getNotAdmNumero')->name('notadms');
    Route::get('/notadm/{td}/seltipo', 'Admin\NotAdmController@getNotAdmSelectTipo')->name('notadms');
    Route::get('/notadm/add', 'Admin\NotAdmController@getNotAdmAdd')->name('notadm_add');
    Route::post('/notadm/add', 'Admin\NotAdmController@postNotAdmAdd')->name('notadm_add');
    Route::get('/notadm/{id}/edit', 'Admin\NotAdmController@getNotAdmEdit')->name('notadm_edit');
    Route::post('/notadm/{id}/edit', 'Admin\NotAdmController@postNotAdmEdit')->name('notadm_edit');
    Route::get('/notadm/{id}/delete', 'Admin\NotAdmController@getNotAdmDelete')->name('notadm_delete');
    Route::get('/notadm/{id}/print', 'Admin\NotAdmController@getNotAdmPrint')->name('notadms');
    Route::get('/notadm/{id}/deta', 'Admin\NotAdmController@getNotAdmDetAdd')->name('notadm_add');
    Route::post('/notadm/{id}/deta', 'Admin\NotAdmController@postNotAdmDetAdd')->name('notadm_add');
    Route::get('/notadm/{id}/dete', 'Admin\NotAdmController@getNotAdmDetEdit')->name('notadm_add');
    Route::post('/notadm/{id}/dete', 'Admin\NotAdmController@postNotAdmDetEdit')->name('notadm_add');
    Route::get('/notadm/{id}/detd', 'Admin\NotAdmController@getNotAdmDetDelete')->name('notadm_add');
    Route::get('/notadm/{id}/end', 'Admin\NotAdmController@getNotAdmEnd')->name('notadm_edit');

    //Modulo de Notas de Débito y Crédito Farmacia
    Route::get('/notfars/{periodo}', 'Admin\NotFarController@getNotFarHome')->name('notfars');
    Route::post('/notfar/cambio', 'Admin\NotFarController@postNotFarCambio')->name('notfars');
    Route::get('/notfar/{td}/{dmtd}/numero', 'Admin\NotFarController@getNotFarNumero')->name('notfars');
    Route::get('/notfar/{td}/seltipo', 'Admin\NotFarController@getNotFarSelectTipo')->name('notfars');
    Route::get('/notfar/add', 'Admin\NotFarController@getNotFarAdd')->name('notfar_add');
    Route::post('/notfar/add', 'Admin\NotFarController@postNotFarAdd')->name('notfar_add');
    Route::get('/notfar/{id}/edit', 'Admin\NotFarController@getNotFarEdit')->name('notfar_edit');
    Route::post('/notfar/{id}/edit', 'Admin\NotFarController@postNotFarEdit')->name('notfar_edit');
    Route::get('/notfar/{id}/delete', 'Admin\NotFarController@getNotFarDelete')->name('notfar_delete');
    Route::get('/notfar/{id}/print', 'Admin\NotFarController@getNotFarPrint')->name('notfars');
    Route::get('/notfar/{id}/deta', 'Admin\NotFarController@getNotFarDetAdd')->name('notfar_add');
    Route::post('/notfar/{id}/deta', 'Admin\NotFarController@postNotFarDetAdd')->name('notfar_add');
    Route::get('/notfarm/{id}/dete', 'Admin\NotFarController@getNotFarDetEdit')->name('notfar_add');
    Route::post('/notfar/{id}/dete', 'Admin\NotFarController@postNotFarDetEdit')->name('notfar_add');
    Route::get('/notfar/{id}/detd', 'Admin\NotFarController@getNotFarDetDelete')->name('notfar_add');
    Route::get('/notfar/{id}/end', 'Admin\NotFarController@getNotFarEnd')->name('notfar_edit');

    //Modulo Modelo de Recetas
    Route::get('/modrecetas', 'Admin\ModRecetaController@getModRecetaHome')->name('modrecetas');
    Route::get('/modreceta/add', 'Admin\ModRecetaController@getModRecetaAdd')->name('modreceta_add');
    Route::post('/modreceta/add', 'Admin\ModRecetaController@postModRecetaAdd')->name('modreceta_add');
    Route::get('/modreceta/{id}/deta', 'Admin\ModRecetaController@getModRecetaDetAdd')->name('modreceta_edit');
    Route::post('/modreceta/{id}/deta', 'Admin\ModRecetaController@postModRecetaDetAdd')->name('modreceta_edit');
    Route::get('/modreceta/{id}/dete', 'Admin\ModRecetaController@getModRecetaDetEdit')->name('modreceta_edit');
    Route::post('/modreceta/{id}/dete', 'Admin\ModRecetaController@postModRecetaDetEdit')->name('modreceta_edit');
    Route::get('/modreceta/{id}/detdelete', 'Admin\ModRecetaController@getModRecetaDetDelete')->name('modreceta_edit');
    Route::get('/modreceta/{id}/edit', 'Admin\ModRecetaController@getModRecetaEdit')->name('modreceta_edit');
    Route::post('/modreceta/{id}/edit', 'Admin\ModRecetaController@postModRecetaEdit')->name('modreceta_edit');
    Route::get('/modreceta/{id}/delete', 'Admin\ModRecetaController@getModRecetaDelete')->name('modreceta_delete');

    //Cierre de mes
    Route::get('/cierre', 'Admin\CierreController@getCierreHome')->name('cierre');
    Route::post('/cierre/cadmision', 'Admin\CierreController@postCierreAdmision')->name('cadmision');
    Route::post('/cierre/cfarmacia', 'Admin\CierreController@postCierreFarmacia')->name('cfarmacia');

    //PDF's
    Route::get('/pdf/{id}/receta', 'Admin\PDFController@getReceta')->name('pdf');
    Route::get('/pdf/{id}/recetav', 'Admin\PDFController@getRecetaV')->name('pdf');
    Route::get('/pdf/{id}/recetaplan', 'Admin\PDFController@getRecetaPlan')->name('pdf');
    Route::get('/pdf/{id}/admfact', 'Admin\PDFController@getAdmFacturacion')->name('pdf');
    Route::get('/pdf/{id}/admnota', 'Admin\PDFController@getAdmNotas')->name('pdf');
    Route::get('/pdf/{id}/farmfact', 'Admin\PDFController@getFarmFacturacion')->name('pdf');
    Route::get('/pdf/{id}/farmnota', 'Admin\PDFController@getFarmNotas')->name('pdf');

    //Modulo Reportes
    Route::get('/radmision', 'Admin\ReporteController@getReporteAdmision')->name('report');
    Route::get('/rfarmacia', 'Admin\ReporteController@getReporteFarmacia')->name('report');
    Route::post('/radmision/pacientes', 'Admin\ReporteController@postReportePaciente')->name('report');
    Route::post('/radmision/servicios', 'Admin\ReporteController@postReporteServicio')->name('report');
    Route::post('/rfarmacia/productos', 'Admin\ReporteController@postReporteProducto')->name('report');
    Route::post('/rfarmacia/movprod', 'Admin\ReporteController@postReporteMovProducto')->name('report');
    Route::post('/rfarmacia/movcomp', 'Admin\ReporteController@postReporteMovComprobantes')->name('report');
    Route::post('/rfarmacia/utilidad', 'Admin\ReporteController@postReporteUtilidad')->name('report');
    Route::post('/rfarmacia/saldos', 'Admin\ReporteController@postReporteSaldos')->name('report');

    //SUNAT - Geberación de XML y envio a SUNAT
    Route::get('/sunat/{id}/xml', 'Admin\SunatController@getSunatAdmision')->name('pdf');
    Route::get('/sunat/{id}/notaxmla', 'Admin\SunatController@getSunatNotaAdmision')->name('pdf');
    Route::get('/sunat/{id}/xmlf', 'Admin\SunatController@getSunatFarmacia')->name('pdf');
    Route::get('/sunat/{id}/notaxmlf', 'Admin\SunatController@getSunatNotaFarmacia')->name('pdf');
    Route::get('/sunat/certificado', 'Admin\SunatController@getSunatCertificado')->name('pdf');
    Route::get('/sunat/certificadocer', 'Admin\SunatController@getSunatCertificadoCer')->name('pdf');
    //SUNAT - REPORTES
    Route::get('/sunat/wincontall', 'Admin\SunatController@getSunatWinContall')->name('sunat');
    Route::post('/sunat/wincontall', 'Admin\SunatController@postSunatWinContall')->name('sunat');
    Route::get('/sunat/comprobantes', 'Admin\SunatController@getSunatComprobantes')->name('sunat');
    Route::post('/sunat/comprobantes', 'Admin\SunatController@postSunatComprobantes')->name('sunat');


    //Pruebas
    // Route::get('/pruebas', 'Admin\SunatController@getSunat')->name('pdf');


    
});