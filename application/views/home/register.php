{header}
	<div class="container py-5">
		<div class="align-items-start">
			<div class="col-md-7 col-sm-12 mb-5 mx-auto bg-white shadow-sm text-black p-3 rounded">
				<h5 class="font-weight-bold mb-4">فرم ثبت نام	</h5>
				<form action="{base_url}register/validate" method="POST">
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
							<input type="text" class="form-control <?php echo(array_key_exists('username', $errors))?'is-invalid':''; ?>" id="username" name="username" placeholder="نام کاربری را وارد کنید" value="<?=set_value('username', NULL, TRUE);?>">
							<small class="form-text text-muted">حداقل 5 کاراکتر باشد</small>
							<div class="invalid-feedback">
								<?= form_error('username') ?>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="email" class="col-sm-2 col-form-label">آدرس ایمیل</label>
						<div class="col-sm-10">
							<input type="email" class="form-control <?php echo(array_key_exists('email', $errors))?'is-invalid':''; ?>" id="email" name="email" placeholder="ایمیل را وارد کنید" value="<?=set_value('email', NULL, TRUE);?>">
							<small class="form-text text-muted">ایمیل شما محفوظ بوده و برای دیگران به اشتراک  گذاشته نخواهد شد.</small>
							<div class="invalid-feedback">
								<?= form_error('email') ?>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="password" class="col-sm-2 col-form-label">رمز عبور</label>
						<div class="col-sm-10">
							<input type="password" class="form-control <?php echo(array_key_exists('password', $errors))?'is-invalid':''; ?>" id="password" name="password" placeholder="رمز عبور را وارد کنید">
							<small class="form-text text-muted">حداقل 8 کاراکتر</small>
							<div class="invalid-feedback">
								<?= form_error('password') ?>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="password_repeat" class="col-sm-2 col-form-label">تکرار رمز عبور</label>
						<div class="col-sm-10">
							<input type="password" class="form-control <?php echo(array_key_exists('password_repeat', $errors))?'is-invalid':''; ?>" id="password_repeat" name="password_repeat" placeholder="تکرار رمز عبور را وارد کنید">
							<small class="form-text text-muted">رمز عبور باید مطابق هم باشند</small>
							<div class="invalid-feedback">
								<?= form_error('password_repeat') ?>
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
					<div class="row">
						<div class="col-sm-2"></div>
						<div class="custom-control custom-checkbox col-sm-10">
							<input class="custom-control-input" name="toscheck" type="checkbox" id="toscheck">
							<label class="custom-control-label" for="toscheck">
								شرایط سرویس را خوانده‌ام و موافق هستم.
							</label>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-2"></div>
						<div class="col-sm-10">
							<?php if($this->session->flashdata('warning') != ''):?>
							<small class="text-danger"><?= $this->session->flashdata('warning') ?></small>
							<?php endif; ?>
						</div>
					</div>
					<div class="row mt-5">
						<button type="submit" class="btn btn-success mx-3">ثبت نام</button>
						<input class="btn btn-light" type="reset" value="پاک کردن">
					</div>
				</form>
			</div>
		</div>
	</div>
{footer}