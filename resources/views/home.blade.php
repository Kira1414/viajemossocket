@extends('layouts.app')

@section('content')
<div class="row">
	
	<div class="col-md-2">
		<div class="nav flex-column nav-pills bg-white" id="v-pills-tab" role="tablist" aria-orientation="vertical">
			<a class="nav-link {{ Request::is('editoriales') ? 'active' : '' }}" id="editoriales-tab" href="{{route('editoriales')}}" >Editoriales</a>
			<a class="nav-link {{ Request::is('autores') ? 'active' : '' }}" id="autores-tab" href="{{route('autores')}}" >Autores</a>
			<a class="nav-link {{ Request::is('libros') ? 'active' : '' }}" id="libros-tab" href="{{route('libros')}}" >Libros</a>
		</div>
	</div>
	<div class="col-md-10">
		@yield("componentes")
		<!-- <div v-if="view == 'editoriales'" class="tab-pane active show" id="editoriales">
			<editoriales-component></editoriales-component>
		</div>
		<div v-if="view == 'autores'" class="tab-pane fade" id="autores">
			<autores-component></autores-component>
		</div>
		<div v-if="view == 'libros'" class="tab-pane fade" id="libros">
			<libros-component></libros-component>
		</div> -->
	</div>
</div>
@endsection
