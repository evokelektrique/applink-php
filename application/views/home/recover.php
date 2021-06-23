{header}
			
	<div class="container py-5">
		<div class="align-items-start">
			<div class="col-md-7 col-sm-12 mb-5 mx-auto bg-white shadow-sm text-black p-3 rounded">
				<?php if($this->session->flashdata('success') == 'ok'): ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					ایمیلی   حاوی لینک فعال سازی مجدد اکانت  با موفقیت ارسال شد.
					<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<?php endif; ?>
				<h5 class="font-weight-bold mb-5">فرم بازیابی رمز عبور	</h5>
				<form method="POST" action="{base_url}recover/validate">
				<?php
				$csrf = array(
			        'name' => $this->security->get_csrf_token_name(),
			        'hash' => $this->security->get_csrf_hash()
				);
				?>
				<?php $errors = $this->form_validation->error_array(); ?>
				<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />	
					<div class="form-group row">
						<label for="email" class="col-sm-2 col-form-label">ایمیل</label>
						<div class="col-sm-10">
							<input type="email" class="form-control <?php echo(array_key_exists('email', $errors))?'is-invalid':''; ?>" id="email" name="email"	value="<?=set_value('email', NULL, TRUE);?>" placeholder="ایمیل را وارد کنید">
							<div class="invalid-feedback">
								<?= form_error('email') ?>
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
						<div class="col-sm-2 col-form-label"></div>
						<div class="col-sm-10">
							<?php if($this->session->flashdata('warning')):?>
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?php if($this->session->flashdata('warning') == "bad"): ?>
							ایمیل وارد شده اشتباه می باشد.
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
						<button type="submit" class="btn btn-success mx-3">ثبت</button>
					</div>
				</form>
			</div>
		</div>
	</div>

{footer}