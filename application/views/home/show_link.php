{header}


	<div class="container mt-5 py-5">

		<!-- Landing /Start -->
		<div class="row">
			<div class="col-md-12 col-sm-12">
				<blockquote class="blockquote text-center py-5" id="landing-start">
					<h2 class="mb-4 align-middle font-weight-normal">
						<span class="p-4 rocket_icon"><img src="{base_url}/src/images/icons/external-link-64.png"></span>
						برای <span class="font-weight-bold"><?=$info[0]['button']?></span>، کد امنیتی زیر را وارد کنید
					</h2>
					<p class="h4 pb-3 text-muted font-weight-bold"></p>
				</blockquote>
				<!-- ads -->
				<a href="#" title="تبلیغ"><img src="{base_url}src/images/tabligh.png" width="100%" class="mb-5"></a>
				<div class="justify-content-center text-center mb-4">
					<div class="progress mb-4" id="progressbar" style="height: 30px">
						<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" id="timer_progressbar" role="progressbar" style="width:0%">
						<p class="text-center font-weight-bold text-white mt-2 h5">لطفا صبر کنید</p>
						</div>
					</div>
					<form method="post" action="{base_url}redirect/validate/<?=$info[0]['short']?>" class="row">
						<?php
						$csrf = array(
					        'name' => $this->security->get_csrf_token_name(),
					        'hash' => $this->security->get_csrf_hash()
						);
						?>
						<?php $errors = $this->form_validation->error_array(); ?>
						<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
						<div class="col-md-2"><span class="border border-secondary d-inline-block rounded overflow-hidden shadow-sm">{captcha}</span></div>
						<div class="input-group mb-3 col">
						<input type="text" id="captcha" name="captcha" class="form-control <?php echo(array_key_exists('captcha', $errors))?'is-invalid':''; ?>" placeholder="کد امنیتی را وارد کنید" aria-label="کد امنیتی را وارد کنید" aria-describedby="<?=$info[0]['button']?>">
						<div class="input-group-append">
							<button id="submit" type="submit" class="btn btn-outline-success" type="button" id="<?=$info[0]['button'];?>"><?=$info[0]['button'];?></button>
							</div>
						</div>
					</form>
					<div class="text-danger"><?= form_error('captcha'); ?></div>
					<?php if($this->session->flashdata('warning')):?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<?= $this->session->flashdata('warning'); ?>
					<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					</div>
					<?php endif; ?>
				</div>
				<img src="<?=$info['screenshot']?>" class="my-4 rounded shadow-lg"/>
			</div>
		</div>

		<!-- Landing /Control -->
<!-- 		<div class="row">
			<div class="col-md-12 col-sm-12">
				<blockquote class="blockquote text-center mt-5 py-5" id="landing-control">
					<h2 class="mb-4 align-middle font-weight-bold">
						<span class="p-4 rocket_icon"><img src="./src/images/icons/analyze-64.png"></span>
						کنترل کامل بر روی لینک‌های شما
					</h2>
					<p class="blockquote-footer text-muted">با عضویت پرمیوم، شما کنترل کامل را در لینک‌ها خواهید داشت. این به این معنی است که شما می‌توانید مقصد را هر زمان که بخواهید تغییر دهید. اضافه کردن، تغییر یا حذف هر فیلتر در هر زمان.
					</p>
				</blockquote>
			</div>
		</div> -->

		<!-- Features -->
<!-- 		<div class="row text-center features">
			<div class="col-md-4 col-sm-12 col-xs-12 text-left m-auto py-5">
				<div class="d-flex">
					<img width="64" class="d-inline-block pb-4" src="./src/images/icons/user-male-64.png">
					<p class="h5 mb-4 font-weight-bold d-inline-block align-self-center pl-4">
						مشتریان هدف
					</p>
				</div>
				<p class="h6  features-desc text-muted">کاربران خود را براساس مکان و دستگاه، به صفحات تخصصی هدایت کنید تا تبدیل خود را افزایش دهید.</p>
			</div>
			<div class="col-md-4 col-sm-12 col-xs-12 text-left m-auto py-5">
				<div class="d-flex">
					<img width="64" class="d-inline-block pb-4" src="./src/images/icons/paint-64.png">
					<p class="h5 mb-4 font-weight-bold d-inline-block align-self-center pl-4">
						صفحه فرود سفارشی
					</p>
				</div>
				<p class="h6  features-desc text-muted">صفحه اصلی سفارشی خود را برای تبلیغ محصول یا خدمات خود در خط مقدم ایجاد کنید و کاربر را در کمپین بازاریابی خود درگیر کنید.</p>
			</div>
			<div class="w-100"></div>
			<div class="col-md-4 col-sm-12 col-xs-12 text-left m-auto py-5">
				<div class="d-flex">
					<img width="64" class="d-inline-block pb-4" src="./src/images/icons/window-64.png">
					<p class="h5 mb-4 font-weight-bold d-inline-block align-self-center pl-4">
						همپوشانی
					</p>
				</div>
				<p class="h6  features-desc text-muted">از ابزار overlay ما برای نمایش اعلانهای محرمانه در وب سایت هدف استفاده کنید. یک راه عالی برای ارسال پیام به مشتریان خود و یا اجرای یک کمپین تبلیغاتی.</p>
			</div>
			<div class="col-md-4 col-sm-12 col-xs-12 text-left m-auto py-5">
				<div class="d-flex">
					<img width="64" class="d-inline-block pb-4" src="./src/images/icons/pie-chart-64.png">
					<p class="h5 mb-4 font-weight-bold d-inline-block align-self-center pl-4">
						ردیابی رویداد
					</p>
				</div>
				<p class="h6  features-desc text-muted">پیکسل سفارشی خود را از ارائه دهندگان مانند فیس بوک و رویدادهای آهنگ درست زمانی که آنها اتفاق می افتد.</p>
			</div>
		</div> -->
		
	</div>
	<script type="text/javascript">
		document.getElementById("captcha").disabled = true;
		document.getElementById("submit").disabled = true;
		var timeleft = 10;
		var timer = setInterval(function(){
			document.getElementById("timer_progressbar").style.width = 10 + timeleft + "%";
			timeleft += 10;
			if(timeleft >= 100){
				clearInterval(timer);
				document.getElementById("captcha").disabled = false;
				document.getElementById("submit").disabled = false;
				document.getElementById("progressbar").style.display = "none";
			}
		}, 1000);
	</script>
{footer}