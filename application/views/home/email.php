<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<title>{title}</title>

	<!-- Bootstrap 4 -->
	<link rel="stylesheet" type="text/css" href="{base_url}/src/css/bootstrap-grid.min.css">
	<link rel="stylesheet" type="text/css" href="{base_url}/src/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="{base_url}/src/css/bjax.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Core Style -->
	<link rel="stylesheet" type="text/css" href="{base_url}/style.css">
	<link rel="icon" href="{base_url}favicon.ico"> 
</head>
<body>
<header>
	<div class="container-fluid py-5">
		<div class="align-items-start">
			<div class="col-md-7 col-sm-12 mb-5 mx-auto bg-white shadow-sm text-black p-3 rounded">
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<h2>تبریک !</h2>
					<hr>
					محتوای این ایمیل حاوی بازیابی اکانت شما می باشد، <br> تنها با کلیک بر روی دکمه زیر جهت انتقال به صفحه  بازیابی رمز می باشید.
				</div>
					<div class="row my-4 text-center align-items-center">
						<a href="{base_url}recover/token/{token}" class="btn btn-lg btn-outline-primary mx-auto p-4 align-self-center">ورود به صفحه بازیابی رمز عبور</a>
					</div>
				</form>
				<small class="text-muted mt-3">تمامی حقوق محفوظ می باشد {title}</small>
			</div>
		</div>
	</div>
</header>
</body>
</html>