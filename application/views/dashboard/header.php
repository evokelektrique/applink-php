<!DOCTYPE html>
<html>
<head>
	<title>{title}</title>

	<!-- Bootstrap 4 -->
	<link rel="stylesheet" type="text/css" href="{base_url}src/css/bootstrap-grid.min.css">
	<link rel="stylesheet" type="text/css" href="{base_url}src/css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Icons -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<!-- Core Style -->
	<link rel="stylesheet" type="text/css" href="{base_url}src/css/apexcharts.css">
	<link rel="stylesheet" type="text/css" href="{base_url}/src/css/bjax.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/r-2.2.3/sl-1.3.1/datatables.min.css"/>

	<link rel="stylesheet" type="text/css" href="{base_url}panel.css">

	<!-- Scripts -->
	<script type="text/javascript" src="{base_url}src/js/jquery.min.js"></script>
	<!-- <script type="text/javascript" src="{base_url}src/js/jquery-migrate-1.2.1.min.js"></script> -->
	<!-- <script type="text/javascript" src="{base_url}src/js/feather.min.js"></script> -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="{base_url}src/js/apexcharts.min.js"></script>
	<script type="text/javascript" src="{base_url}src/js/bjax.min.js"></script>
	<script type="text/javascript" src="{base_url}src/js/jquery.form.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/r-2.2.3/sl-1.3.1/datatables.min.js"></script>
	<script type="text/javascript" src="{base_url}src/js/dashboard.js"></script>

</head>
<body>

	<!-- Nav -->
	<header class="container-fluid position-relative shadow-sm">
		<div class="row">
			<nav class="navbar align-items-stretch p-0 w-100 navbar-light navbar-expand-lg bg-white">

				<a href="{base_url}dashboard" data-bjax class="col m-0 px-4 py-2 navbar-brand pull-left">
					<!-- Logo Text -->
					<img src="{base_url}src/images/alpha_on.png" width="45" alt="" class="d-inline-block align-middle mr-2">
					<span class="font-weight-bold text-black px-1">اﭘﻠﯿﻨﮏ</span>
					<div class="bg-white d-inline-block px-2 py-1 h6 rounded shadow-sm text-uppercase">1.0 نسخه</div>
					<!-- Logo Image -->
				</a>
				<button type="button" data-toggle="collapse" data-target="#nvabar" aria-controls="nvabar" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div id="nvabar" class="col-md-10 px-4 py-2 bg-white collapse navbar-collapse">
					<ul class="col-5 justify-content-center px-0 navbar-nav mr-auto">
						<li class="nav-item cash-stat">
							<div class="mr-2 btn-group" role="group" aria-label="contact">
								<a href="{base_url}contact" data-bjax class="btn btn-dark"><i class="fas fa-phone mr-2 fa-lg align-middle"></i>پشتیبانی</a>
								<a href="{base_url}contact" data-bjax class="btn btn-outline-dark"><?=$this->settings_model->select(1)[0]['site_phone_number']?></a> 
							</div>
						</li>
						<li class="nav-item cash-stat">
							<div class="ml-2 btn-group" role="group" aria-label="wallet">
								<a href="{base_url}dashboard/withdraw" data-bjax class="btn btn-warning"><i class="fas fa-money-check-alt mr-2 fa-lg align-middle"></i>کیف پول</a>
								<a href="{base_url}dashboard/withdraw" data-bjax class="btn btn-outline-warning"><?=number_format($wallet[0]['amount'])?> ریال</a>
							</div>
						</li>
					</ul>
					<form id="quickshort" class="col row" method="POST" action="{base_url}dashboard/shortlink/single">
						<?php
						$csrf = array(
					        'name' => $this->security->get_csrf_token_name(),
					        'hash' => $this->security->get_csrf_hash()
						);
						?>
						<?php $errors = $this->form_validation->error_array(); ?>
						<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
						<div class="input-group px-0">
							<input type="text" value="<?=set_value('url')?>" class="form-control <?php echo(array_key_exists('url', $errors))?'is-invalid':''; ?>" placeholder="<?php echo(array_key_exists('url', $errors))?strip_tags(form_error('url')):'لینکتو کوتاه کن ...'; ?>" aria-label="لینکتو کوتاه کن ..." name="url">
							<div class="input-group-append">
								<button type="submit" class="btn btn-success" type="button" id="button-addon2">کوتاه کن</button>
							</div>
	  					</div>
					</form>
					<script type="text/javascript">

					</script>
				</div>
			</nav>
		</div>
	</header>

	<!-- Wrapper -->
	<div class="container-fluid  h-100">
