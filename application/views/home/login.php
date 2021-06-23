{header}
			
	<div class="container py-5">
		<div class="align-items-start">
			<div class="col-md-7 col-sm-12 mb-5 mx-auto bg-white shadow-sm text-black p-3 rounded">
				<?php if($this->session->flashdata('success') == 'ok'): ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					کاربر گرامی ثبت نام شما با موفقیت انجام شد،
					جهت ورود به حساب کاربری از فرم زیر استفاده کنید.
					<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<?php elseif($this->session->flashdata('success') == 'recover'): ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
				رمز عبور جدید با موفقیت تغییر کرد.
					<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<?php endif; ?>
				<h5 class="font-weight-bold mb-4">فرم ورود	</h5>
				<form method="POST" action="{base_url}login/validate">
				<?php
				$csrf = array(
			        'name' => $this->security->get_csrf_token_name(),
			        'hash' => $this->security->get_csrf_hash()
				);
				?>
				<?php $errors = $this->form_validation->error_array(); ?>
				<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />	
					<div class="form-group row">
						<label for="username" class="col-sm-2 col-form-label">نام کاربری</label>
						<div class="col-sm-10">
							<input type="text" class="form-control <?php echo(array_key_exists('username', $errors))?'is-invalid':''; ?>" id="username" name="username"	value="<?=set_value('username', NULL, TRUE);?>" placeholder="نام کاربری را وارد کنید">
							<div class="invalid-feedback">
								<?= form_error('username') ?>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="password" class="col-sm-2 col-form-label">رمز عبور</label>
						<div class="col-sm-10">
							<input type="password" class="form-control <?php echo(array_key_exists('password', $errors))?'is-invalid':''; ?>" id="password" name="password" value="<?=set_value('password', NULL, TRUE);?>" placeholder="رمز عبور را وارد کنید">
							<div class="invalid-feedback">
								<?= form_error('password') ?>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="password" class="col-sm-2 col-form-label">کد امنیتی</label>
						<div class="col-sm-10 d-flex align-items-start pl-0">
							<div class="col-sm-10">
								<input type="text" class="form-control <?php echo(array_key_exists('captcha', $errors))?'is-invalid':''; ?>" id="captcha" name="captcha" value="<?=set_value('captcha', NULL, TRUE);?>" placeholder="کد امنیتی را وارد کنید">
								<div class="invalid-feedback">
									<?= form_error('captcha') ?>
								</div>
							</div>
							<div class="col px-0 mx-0 border border-secondary">
								{captcha}
							</div>

							<div class="invalid-feedback">
								<?= form_error('captcha') ?>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-2"></div>
						<div class="col-sm-10 custom-control custom-checkbox align-items-center">
							<div class="px-3">
							<input type="checkbox" id="remember_me" class="align-middle custom-control-input" name="remember_me">
							<label for="remember_me" class="pt-0 pl-1 col-form-label custom-control-label">
								من را بخاطر بسپار
							</label>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-sm-2 col-form-label"></div>
						<div class="col-sm-10">
							<?php if($this->session->flashdata('warning')):?>
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?php if($this->session->flashdata('warning') == "bad"): ?>
							نام کاربری یا رمز عبور اشتباه می باشد.
							<?php elseif($this->session->flashdata('warning') == "captcha"): ?>
							کد امنیتی نا معتبر
							<?php endif; ?>
							<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							</div>

							<?php endif; ?>
						</div>
					</div>
					<div class="row mt-5">
						<button type="submit" class="btn btn-success mx-3">ورود</button>
						<a href="<?=base_url('recover')?>" class="text-decoration-none btn btn-link">فراموشی رمز عبور؟</a>
					</div>
				</form>
			</div>
		</div>
	</div>

{footer}