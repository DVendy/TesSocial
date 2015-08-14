@extends('app')

@section('body')
	@foreach($campaigns as $key)
	<div class="panel panel-default">
		<div class="panel-heading">{{ $key->title }}</div>
		<div class="panel-body">
			{{ $key->about }}
		</div>
		<div class="panel-footer text-right">
			<a href="#" class="btn btn-custom">Support</a>
		</div>
	</div>
	@endforeach
	
@stop