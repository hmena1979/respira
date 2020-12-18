@extends('admin.master')
@section('title','Proveedores')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/proveedores') }}"><i class="fas fa-address-card"></i> Proveedores</a>
	</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel shadow">
                    {{dd($abc["\x00*\x00message"])}}
                </div>
            </div>
        </div>
    </div>
@endsection