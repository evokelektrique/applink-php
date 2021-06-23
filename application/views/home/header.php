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
		<?php if($this->router->fetch_class() == 'home'): // Only for Home ?>
		<!-- Header Descriptions -->
		<div class="container" id="header-descriptions">
			<div class="col-md-9 col-sm-12 text-center m-auto">	
				<h1 class="font-weight-bold py-5">
					سیستم یک پارچه  کوتاه کننده لینک
				</h1>
				<h4 class="text-muted my-2">
					با استفاده از سرویس هوشمند کوتاه کننده لینک <span class="font-weight-bold">اپلینک</span> می‌توانید لینک‌های خود را سفارشی سازی کنید و به‌راحتی به اشتراک بگذارید.
				</h4>
			</div>
			<div class="row">
				<div id="header-shorten" class="col-md-12 col-sm-12 m-auto text-center mt-5 py-5">
					<form class="" method="post" name="shorten">
						<button class="py-3 px-4 font-weight-bold  rounded-pill">کوتاه کن</button>
						<input class="p-4 rounded-pill" type="text" name="url">
						<span class="link_icon"></span>
					</form>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<?php if($this->router->fetch_class() == 'home'): // Only Home ?>
		<!-- Header Bg -->
			<div id="header-bg text-center">
				<img class="w-100" src="{base_url}/src/images/header.png">
			</div>
		<?php elseif($this->router->fetch_class() == 'login'): // Only Login ?>
		<!-- Header Bg -->
			<div class="container" id="header-descriptions">
				<div class="col-md-9 col-sm-12 text-center m-auto">	
					<h1 class="font-weight-bold py-5">
						<img src="{base_url}src/images/icons/enter-64.png">
						ورود
					</h1>
				</div>
			</div>
		<?php elseif($this->router->fetch_class() == 'register'): // Only Register ?>
		<!-- Header Bg -->
			<div class="container" id="header-descriptions">
				<div class="col-md-9 col-sm-12 text-center m-auto">	
					<h1 class="font-weight-bold py-5">
						<img src="{base_url}src/images/icons/key-64.png">
						ثبت نام
					</h1>
				</div>
			</div>
		<?php endif; ?>
	</header>
	<!-- Header -->
