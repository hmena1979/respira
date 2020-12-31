<div class="sidebar">
	<div class="sidebar-menu">
		<center class="profile">
			<img src="{{ url('static/images/logosidebar.png') }}" class="img img-fluid">
			<p>{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</p>
			<p>{{ Auth::user()->email }}</p>
		</center>
		<li class="item">
			<a href="{{ url('/admin') }}" class="menu-btn lk-dashboard">
				<i class="fas fa-home"></i><span>Inicio</span>
			</a>
		</li>
		@if(kvfj(Auth::user()->permissions,'pacientes'))
		<li class="item">
			<a href="{{ url('/admin/pacientes') }}" class="menu-btn lk-pacientes lk-paciente_add lk-paciente_edit lk-paciente_delete lk-paciente_past">
				<i class="fas fa-user-circle"></i><span>Pacientes</span>
			</a>
		</li>
		@endif
		<li class="item" id="messages">
			<a href="#messages" class="menu-btn">
				<i class="fas fa-envelope"></i><span>Admisión<i class="fas fa-chevron-down drop-down"></i></span>
			</a>
			<div class="sub-menu">
				@if(kvfj(Auth::user()->permissions,'proveedores'))
				<a href="{{ url('/admin/proveedores') }}" class="lk-proveedores lk-proveedor_add lk-proveedor_edit lk-proveedor_delete" "data-toggle="tooltip" data-placement="top" title = 'Clientes'><i class="fas fa-address-card"></i><span>Clientes</span></a>
				@endif
			</div>
			<div class="sub-menu">
				@if(kvfj(Auth::user()->permissions,'facturas'))
				<a href="{{ url('/admin/facturas/'.session('padmision')) }}" class="lk-facturas lk-factura_add lk-factura_edit lk-factura_delete" "data-toggle="tooltip" data-placement="top" title = 'Facturas admisión'><i class="fas fa-money-check-alt"></i><span>Facturación</span></a>
				@endif
			</div>
			<div class="sub-menu">
				@if(kvfj(Auth::user()->permissions,'notadms'))
				<a href="{{ url('/admin/notadms/'.session('padmision')) }}" class="lk-notadms lk-notadm_add lk-notadm_edit lk-notadm_delete" "data-toggle="tooltip" data-placement="top" title = 'Nota de Débito/Crédito'><i class="fas fa-window-restore"></i><span>Nota de Débito/Crédito</span></a>
				@endif
			</div>
			<div class="sub-menu">
				@if(kvfj(Auth::user()->permissions,'report'))
				<a href="{{ url('/admin/radmision') }}" class="report" "data-toggle="tooltip" data-placement="top" title = 'Reportes'><i class="fas fa-window-restore"></i><span>Reportes</span></a>
				@endif
			</div>
		</li>
		<li class="item" id="farmacia">
			<a href="#farmacia" class="menu-btn">
				<i class="fas fa-prescription-bottle-alt"></i><span>Farmacia<i class="fas fa-chevron-down drop-down"></i></span>
			</a>
			<div class="sub-menu">
				@if(kvfj(Auth::user()->permissions,'productos'))
				<a href="{{ url('/admin/productos/') }}" class="lk-productos lk-producto_add lk-producto_edit lk-producto_delete" "data-toggle="tooltip" data-placement="top" title = 'Productos'><i class="fab fa-product-hunt"></i><span>Productos</span></a>
				@endif
				@if(kvfj(Auth::user()->permissions,'ingresos'))
				<a href="{{ url('/admin/ingresos/'.session('pfarmacia')) }}" class="lk-ingresos lk-ingreso_add lk-ingreso_edit lk-ingreso_delete" "data-toggle="tooltip" data-placement="top" title = 'Compras'><i class="fas fa-cart-plus"></i><span>Compras</span></a>
				@endif
				@if(kvfj(Auth::user()->permissions,'salidas'))
				<a href="{{ url('/admin/salidas/'.session('pfarmacia')) }}" class="lk-salidas lk-salida_add lk-salida_edit lk-salida_delete" "data-toggle="tooltip" data-placement="top" title = 'Venta/Consumo'><i class="fas fa-cart-arrow-down"></i><span>Venta / Consumo</span></a>
				@endif
				@if(kvfj(Auth::user()->permissions,'notfars'))
				<a href="{{ url('/admin/notfars/'.session('pfarmacia')) }}" class="lk-notfars lk-notfar_add lk-notfar_edit lk-notfar_delete" "data-toggle="tooltip" data-placement="top" title = 'Nota de Débito/Crédito'><i class="fas fa-window-restore"></i><span>Nota de Débito/Crédito</span></a>
				@endif
				@if(kvfj(Auth::user()->permissions,'report'))
				<a href="{{ url('/admin/rfarmacia') }}" class="report" "data-toggle="tooltip" data-placement="top" title = 'Reportes'><i class="fas fa-window-restore"></i><span>Reportes</span></a>
				@endif
			</div>
		</li>
		<li class="item" id="sunat">
			<a href="#sunat" class="menu-btn">
				<i class="fas fa-archway"></i><span>Sunat<i class="fas fa-chevron-down drop-down"></i></span>
			</a>
			<div class="sub-menu">
				{{-- <a href="#"><i class="fas fa-lock"></i><span>Anulación</span></a>
				<a href="#"><i class="fas fa-language"></i><span>Envío diario</span></a> --}}
			</div>
		</li>
		<li class="item" id="tablas" "data-toggle="tooltip" data-placement="top" title = 'Tablas del sistema'>
			<a href="#tablas" class="menu-btn">
				<i class="fas fa-folder-open"></i><span>Tablas del sistema<i class="fas fa-chevron-down drop-down"></i></span>
			</a>
			<div class="sub-menu">
				@if(kvfj(Auth::user()->permissions,'categorias'))
				<a href="{{ url('/admin/categorias/0') }}" class="lk-categorias lk-categoria_add lk-categoria_edit lk-categoria_delete" "data-toggle="tooltip" data-placement="top" title = 'Categorias'><i class="fas fa-folder-open"></i><span>Categorías</span></a>
				@endif
				@if(kvfj(Auth::user()->permissions,'servicios'))
				<a href="{{ url('/admin/servicios') }}" class="lk-servicios lk-servicio_add lk-servicio_edit lk-servicio_delete" "data-toggle="tooltip" data-placement="top" title = 'Servicios'><i class="fas fa-hand-holding-medical"></i><span>Servicios</span></a>
				@endif
				@if(kvfj(Auth::user()->permissions,'comprobantes'))
				<a href="{{ url('/admin/comprobantes') }}" class="lk-comprobantes lk-comprobante_add lk-comprobante_edit lk-comprobante_delete" "data-toggle="tooltip" data-placement="top" title = 'Servicios'><i class="fas fa-list-alt"></i><span>Tipo comprobante</span></a>
				@endif
				@if(kvfj(Auth::user()->permissions,'usuarios'))
				<a href="{{ url('/admin/usuarios/all') }}" class="lk-usuarios lk-usuario_add lk-usuario_permissions" "data-toggle="tooltip" data-placement="top" title = 'Usuarios'><i class="fas fa-user-friends"></i><span>Usuarios</span></a>
				@endif
				@if(kvfj(Auth::user()->permissions,'doctores'))
				<a href="{{ url('/admin/doctores/1') }}" class="lk-doctores lk-doctor_add lk-doctor_edit lk-doctor_delete" "data-toggle="tooltip" data-placement="top" title = 'Doctores'><i class="fas fa-user-md"></i><span>Doctores</span></a>
				@endif
				@if(kvfj(Auth::user()->permissions,'cie10'))
				<a href="{{ url('/admin/cie10') }}" class="lk-cie10 lk-cie10_add lk-cie10_edit lk-cie10_delete" "data-toggle="tooltip" data-placement="top" title = 'CIE 10'><i class="fas fa-notes-medical"></i><span>CIE 10</span></a>
				@endif
				@if(kvfj(Auth::user()->permissions,'umedidas'))
				<a href="{{ url('/admin/umedidas') }}" class="lk-umedidas lk-umedida_add lk-umedida_edit lk-umedida_delete" "data-toggle="tooltip" data-placement="top" title = 'Unidad de medida'><i class="fas fa-ruler-combined"></i><span>Unidad medida</span></a>
				@endif
				@if(kvfj(Auth::user()->permissions,'tipmeds'))
				<a href="{{ url('/admin/tipmeds/1') }}" class="lk-tipmeds lk-tipmed_add lk-tipmed_edit lk-tipmed_delete" "data-toggle="tooltip" data-placement="top" title = 'Tipo medicamento'><i class="fas fa-tablets"></i><span>Tipo medicamento</span></a>
				@endif
				@if(kvfj(Auth::user()->permissions,'modrecetas'))
				<a href="{{ url('/admin/modrecetas') }}" class="lk-modrecetas lk-modreceta_add lk-modreceta_edit lk-modreceta_delete" "data-toggle="tooltip" data-placement="top" title = 'Modelo de receta'><i class="fas fa-prescription"></i><span>Modelo de receta</span></a>
				@endif
			</div>
		</li>
		@if(kvfj(Auth::user()->permissions,'import'))
		<li class="item">
			<a href="{{ url('/admin/import') }}" class="menu-btn lk-import">
				<i class="fas fa-file-download"></i><span>Importar</span>
			</a>
		</li>
		@endif
		<li class="item" id="util">
			<a href="#util" class="menu-btn">
				<i class="fas fa-cog"></i><span>Utilitarios<i class="fas fa-chevron-down drop-down"></i></span>
			</a>
			<div class="sub-menu">
				@if(kvfj(Auth::user()->permissions,'parametros'))
				<a href="{{ url('/admin/parametros') }}" class="lk-parametros" "data-toggle="tooltip" data-placement="top" title = 'Parametros'><i class="fas fa-cog"></i><span>Parametros</span></a>
				@endif
				@if(kvfj(Auth::user()->permissions,'saldos'))
				<a href="{{ url('/admin/saldos') }}" class="lk-parametros" "data-toggle="tooltip" data-placement="top" title = 'Regenerar Saldos'><i class="fas fa-cog"></i><span>Regenerar Saldos</span></a>
				@endif
				@if(kvfj(Auth::user()->permissions,'cierre'))
				<a href="{{ url('/admin/cierre') }}" class="lk-cierre" "data-toggle="tooltip" data-placement="top" title = 'Cierre de mes'><i class="fas fa-calendar-check"></i><span>Cierre de mes</span></a>
				@endif
			</div>
		</li>
	</div>
</div>