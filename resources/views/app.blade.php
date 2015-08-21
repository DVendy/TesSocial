<html>
<head>
	<title>Iconster</title>
	<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	<style>
		body {
			margin: 0;
			padding: 0;
			width: 100%;
			height: 100%;
			display: table;
		}

		

		.header {
			color: #B0BEC5;
			font-weight: 100;
			font-family: 'Lato';
			display: inline-block;
			margin-bottom: 10px;
		}

		.container {
			text-align: center;
			color: #253657;
		}

		.title {
			font-size: 96px;
			margin-bottom: 20px;
		}

		.quote {
			font-size: 24px;
		}

		.panel {
			text-align: left;
		}

		.panel-default > .panel-heading {
			color: #B6BDCA;
			background-color: #253657;
			border-color: #DDD;
		}

		.panel-default > .panel-footer {
			background-color: #FFFFFF;
		}

		.upper {
			height: 10px;
			width: 100%;
			background-color: #253657;
		}

		* {
			border-radius: 0px !important;
		}

		.navigation {
			list-style-type: none;
		    margin: 0;
		    padding: 0;
			margin-bottom: 20px;
			font-size: 16;
		}

		.navigation li{
			display: inline;
			margin: 1px 5px;
		}

		.navigation li a{
			color: #7F8BA1;
			transition: all .1s ease-in;
			text-decoration: none;
		}

		.navigation li a:hover{
			color: #253657;
		}

		.btn-custom {
		    color: #fff;
		    background-color: #6C934A;
		    border-color: #6C934A;
		    transition: all .1s ease-in;
		}

		.btn-custom:hover {
		    color: #fff;
		    background-color: #4D742A;
		}

		.btn-custom:focus {
		    color: #fff;
		    background-color: #4D742A;
		}
	</style>
	@yield('head')
</head>
<body>
	<div class="upper"></div>
	<div class="container">
		<div class="header">
			<div class="title">Iconster</div>
			<div class="quote">{{ Inspiring::quote() }}</div>
		</div>
		<ul class="navigation">
			<li><a href="{{ URL('/' ) }}">Home</a></li>
			<li><a href="{{ URL('account' ) }}">Account</a></li>
			@if (Auth::check())
			<li><a href="{{ URL('/auth/logout' ) }}">Logout</a></li>
			@endif
		</ul>

		@yield('body')

	</div>
</body>
</html>