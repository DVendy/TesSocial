@extends('app')

@section('body')
	<div class="row">
		<div class="col-md-6">
			<a href="{{ URL('/facebook/login' ) }}">Login with facebook</a>
		</div>
		<div class="col-md-6">
			register
		</div>
	</div>
@stop