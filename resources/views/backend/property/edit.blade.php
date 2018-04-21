@extends('layouts.backend')

@section('title',isset($heading) ? $heading : 'Cập nhật')

@section('page-content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		{!! Form::model($item, ['method' => 'PATCH', 'url' => route('admin.property.update', $item->id), 'files' => true, 'class' => 'form-horizontal', 'autocomplete'=>'off']) !!}
		<div class="col-sm-7">
			@include('backend.property._form')       
		</div>
		{!! Form::close() !!}
		<div class="col-sm-5">
			@include('backend.property._category')       
		</div>
	</div>
</div>
@endsection