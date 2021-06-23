{header}
			
	<div class="container py-5">
		<div class="align-items-start">
			<div class="col-md-7 col-sm-12 mb-5 mx-auto bg-white shadow-sm text-black p-3 rounded">
				<?php if($this->session->flashdata('success') == 'ok'): ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					رمز عبور جدید با موفقیت تغییر کرد.
					<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<?php endif; ?>
				<h5 class="font-weight-bold mb-5">فرم ایجاد رمز جدید</h5>
				<form method="POST" action="{base_url}recover/validate_token/{token}">
				<?php
				$csrf = array(
			        'name' => $this->security->get_csrf_token_name(),
			        'hash' => $this->security->get_csrf_hash()
				);
				?>
				<?php $errors = $this->form_validation->error_array(); ?>
				<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />	
					<div class="form-group row">
						<label for="email" class="col-sm-2 col-form-label">رمز عبور جدید</label>
						<div class="col-sm-10">
							<input type="password" class="form-control <?php echo(array_key_exists('password', $errors))?'is-invalid':''; ?>" id="password" name="password"	value="<?=set_value('password', NULL, TRUE);?>" placeholder="رمز عبور جدید را وارد کنید">
							<div class="invalid-feedback">
								<?= form_error('password') ?>
							</div>
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