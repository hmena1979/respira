<div class="sidebar shadow">
	<div class="section-top">
		<div class="logo">
			<img src="{{ url('static/images/logo.png') }}" class="img img-fluid">
		</div>
		<div class="user">
			<span class="subtyitle">Hola:</span>
			<div class="name">
				{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}
				<a href=" {{ url('/logout') }} " data-toggle="tooltip" data-placement="top" title = 'Salir'>
					<i class="fas fa-sign-out-alt"></i>
				</a>
			</div>
			{{ Auth::user()->email }}
		</div>
	</div>
	<li class="item">
		<a href="" class="menu-btn">
			<i class="fas fa-desktop"></i><span>Dashboard</span>
		</a>
	</li>
	<li class="item" id="profile">
		<a href="#profile" class="menu-btn">
			<i class="fas fa-user-circle"></i><span>Profile<i class="fas fa-chevron-down dropdown"></i></span>
		</a>
		<div class="sub-menu">
			<a href="#"><i class="fas fa-image"></i><span>Picture</span></a>
			<a href="#"><i class="fas fa-address-card"></i><span>Info</span></a>
		</div>
	</li>
	<li class="item" id="messages">
		<a href="#messages" class="menu-btn">
			<i class="fas fa-envelope"></i><span>Messages<i class="fas fa-chevron-down dropdown"></i></span>
		</a>
		<div class="sub-menu">
			<a href="#"><i class="fas fa-envelope"></i><span>New</span></a>
			<a href="#"><i class="fas fa-envelope-square"></i><span>Sent</span></a>
			<a href="#"><i class="fas fa-exclamation-circle"></i><span>Spam</span></a>
		</div>
	</li>
	<li class="item" id="Setting">
		<a href="#Setting" class="menu-btn">
			<i class="fas fa-cog"></i><span>Setting<i class="fas fa-chevron-down dropdown"></i></span>
		</a>
		<div class="sub-menu">
			<a href="#"><i class="fas fa-lock"></i><span>Password</span></a>
			<a href="#"><i class="fas fa-language"></i><span>Language</span></a>
		</div>
	</li>
	<li class="item">
		<a href="" class="menu-btn">
			<i class="fas fa-info-circle"></i><span>About</span>
		</a>
	</li>
	<div class="main">
		<ul>
			<li>
				<a href="{{ url('/admin/nosotros') }}"><i class="fas fa-chalkboard-teacher"></i> Tareo</a>
			</li>
			<div class="dropdown-divider"></div>
			<li class="dropdown">
				<a href="{{ url('/admin/categorias/0') }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-folder-open"></i> Mantenimiento</a>
				<ul class="dropdown-menu">
					<li>
						<a href="{{ url('/admin/sedes/all') }}"><i class="fas fa-boxes"></i> Sedes</a>
					</li>
					<li>
						<a href="{{ url('/admin/departamentos/all') }}"><i class="fas fa-boxes"></i> Departamentos</a>
					</li>
					<li>
						<a href="{{ url('/admin/areas/all') }}"><i class="fas fa-project-diagram"></i> Areas</a>
					</li>
					<div class="dropdown-divider"></div>
				</ul>
			</li>
			<li>
				<a href="{{ url('/admin/import') }}"><i class="fas fa-file-medical"></i> Importar Aptitud</a>
			</li>
			<div class="dropdown-divider"></div>
			@if(kvfj(Auth::user()->permissions,'usuarios'))			
			<li>
				<a href="{{ url('/admin/usuarios/all') }}" class="lk-usuarios lk-usuario_add"><i class="fas fa-user-friends"></i> Usuarios</a>
			</li>
			@endif
			
		</ul>
	</div>
</div>
