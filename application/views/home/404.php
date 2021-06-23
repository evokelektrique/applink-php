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


	<header class="mb-5 pb-5">

		<!-- NAVBAR-->
		<nav class="navbar navbar-light navbar-expand-lg py-5 mb-5 bg-transparent">
			<div class="container-fluid">


				<button type="button" data-toggle="collapse" data-target="#nvabar" aria-controls="nvabar" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div id="nvabar" class="collapse navbar-collapse">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item mr-2">
							<?php if($this->session->userdata('logged_in')): ?>
							<div class="btn-group" role="group" aria-label="Basic example">
								<a href="{base_url}dashboard" class="btn btn-outline-success" data-bjax>ورود به پنل</a>
							</div>
							<?php elseif(empty($this->session->userdata('user')) && !empty(get_cookie('remember_me')) ): ?>
							<div class="btn-group" role="group" aria-label="Basic example">
								<a href="{base_url}dashboard" class="btn btn-outline-success" data-bjax>ورود به پنل</a>
							</div>
							<?php else: ?>
							<div class="btn-group" role="group" aria-label="Basic example">
								<a href="{base_url}register" class="btn btn-info" data-bjax>ثبت نام</a>
								<a href="{base_url}login" class="btn btn-secondary" data-bjax>ورود</a>
							</div>
							<?php endif; ?>
						</li>
						<li class="nav-item"><a href="#" class="nav-link">تماس با ما</a></li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								سرویس ها
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
								<h6 class="dropdown-header">سرویس های  رایگان ما</h6>
								<a class="dropdown-item d-flex justify-content-between align-items-center" href="#">کسب درآمد 
									<span class="dropdown-icons">
										<img class="header_default_icon" src="{base_url}/src/images/alpha_off.png" width="48" alt="" class="img-fluid p-2 align-middle">
										<img class="header_hover_icon" style="display: none;" src="{base_url}/src/images/alpha_on.png" width="48" alt="" class="img-fluid p-2 align-middle">
									</span>
								</a>
								<a class="dropdown-item d-flex justify-content-between align-items-center" href="#">زیرمجموعه گیری
									<span class="dropdown-icons">
										<img class="header_default_icon" src="{base_url}/src/images/click_off.png" width="48" alt="" class="img-fluid p-2 align-middle">
										<img class="header_hover_icon" style="display: none;" src="{base_url}/src/images/click_on.png" width="48" alt="" class="img-fluid p-2 align-middle">
									</span>
								</a>
								<a class="dropdown-item d-flex justify-content-between align-items-center" href="#">پشتیبانی
									<span class="dropdown-icons">
										<img class="header_default_icon" src="{base_url}/src/images/code_off.png" width="48" alt="" class="img-fluid p-2 align-middle">
										<img class="header_hover_icon" style="display: none;" src="{base_url}/src/images/code_on.png" width="48" alt="" class="img-fluid p-2 align-middle">
									</span>
								</a>
							</div>
						</li>
					</ul>
				</div>
				<a href="#" class="navbar-brand pull-right">
					<!-- Logo Text -->
					<div class="bg-white d-inline-block px-2 py-1 h6 rounded shadow-sm text-uppercase">نسخه 1.0</div>
					<!-- Logo Image -->
					<img src="{base_url}/src/images/alpha_on.png" width="45" alt="" class="d-inline-block align-middle mr-2">
				</a>
			</div>
		</nav>

		<!-- Header Descriptions -->
		<div class="container" id="header-descriptions">
			<div class="col-md-9 col-sm-12 text-center m-auto">	
				<h1 class="font-weight-bold py-5">
						<img src="{base_url}src/images/icons/close-window-64.png">
					صفحه مورد نظر پیدا نشد
				</h1>
			</div>
		</div>
	</header>
	<!-- Header -->



{footer}