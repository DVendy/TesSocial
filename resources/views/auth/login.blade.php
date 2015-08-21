@extends('app')

@section('head')
	<script type="text/javascript">
		
		var newwindow;
		var intId;
		function login(){
			var  screenX    = typeof window.screenX != 'undefined' ? window.screenX : window.screenLeft,
			screenY    = typeof window.screenY != 'undefined' ? window.screenY : window.screenTop,
			outerWidth = typeof window.outerWidth != 'undefined' ? window.outerWidth : document.body.clientWidth,
			outerHeight = typeof window.outerHeight != 'undefined' ? window.outerHeight : (document.body.clientHeight - 25),
			width    = 500,
			height   = 275,
			left     = parseInt(screenX + ((outerWidth - width) / 2), 10),
			top      = parseInt(screenY + ((outerHeight - height) / 2.5), 10),
			features = (
				'width=' + width +
				',height=' + height +
				',left=' + left +
				',top=' + top
				);

			newwindow=window.open('{{ URL('/facebook/login' ) }}','Login_by_facebook',features);

			if (window.focus) {newwindow.focus()}
				return false;
		}

		
	</script>
@stop

@section('body')
<div class="row">
	<div class="col-md-6">
		<a href="#" onclick="login();return false;">Login with facebook</a>
	</div>
	<div class="col-md-6">
		register
	</div>
</div>
@stop