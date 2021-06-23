{header}
{sidebar}
			<!-- Content -->
			<div class="col-md-10 bg-transparent py-4" id="content">

				<!-- <div class="row px-4 py-4 align-items-center text-muted"> -->
					<!-- <i class="align-middle fas fa-link fa-lg"></i> -->
					<!-- <h5 class="m-0 px-2 font-weight-bold">کوتاه کردن لینک</h5> -->
				<!-- </div> -->

				<!-- Chart -->
				<div class="row mx-1 mt-3 align-items-center">
					<div class="col-md-12 px-0">
						<div class="card noborder bg-white rounded shadow-sm">
							<div class="card-header bg-white font-weight-bold"><i class="align-middle fas fa-link mr-2"></i>پیام جدید</div>
							<div class="card-body text-secondary p-4">
								<p class="card-text">
									در این بخش شما میتوانید برای همه کاربران و عده ای از کاربران پیام شخصی ارسال کنید
								</p>
								<form method="POST" action="{base_url}/dashboard/admin/message/validate" enctype="multipart/form-data">

									<?php if($this->session->flashdata('danger') == "bad"): ?>
									<div class="alert alert-danger" role="alert">
										<strong class="pb-2">هشدار: </strong>
										خطا در ثبت تغییرات
									</div>
									<?php endif; ?>
									<?php if($this->session->flashdata('success') == "ok"): ?>
									<div class="alert alert-success" role="alert">
										تغییرات با موفقیت ثبت شد
									</div>
									<?php endif; ?>

									<?php
									$csrf = array(
								        'name' => $this->security->get_csrf_token_name(),
								        'hash' => $this->security->get_csrf_hash()
									);
									?>
									<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
									<?php $errors = $this->form_validation->error_array(); ?>

									<div class="row">
										<div class="col-md-12 mt-3">
											<div class="input-group mb-3">
											  <div class="input-group-prepend">
											    <label class="input-group-text" for="title">عنوان</label>
											  </div>
												<input type="text" name="title" class="form-control <?php echo(array_key_exists('title', $errors))?'is-invalid':''; ?>" id="title" placeholder="عنوان را وارد کنید..." required>
											</div>
										</div>
									</div>

									<div class="form-row mb-3 px-2">
										<div class="custom-control custom-radio">
											<input type="radio" id="by_list" name="mode" checked="checked" value='0' checked="checked" class="custom-control-input">
											<label class="custom-control-label" for="by_list">ارسال توسط لیست</label>
										</div>
									</div>
									<div class="form-row mb-3 px-2">
										<div class="custom-control custom-radio">
											<input type="radio" id="by_users" name="mode" value='1' checked="checked" class="custom-control-input">
											<label class="custom-control-label" for="by_users">ارسال برای همه کاربران</label>
										</div>
									</div>

									<div class="form-row mb-3 by_users">
										<div class="col-md-12 mt-3">
											<label for="users" class="font-weight-bold">کاربران</label>
											<textarea rows="2" class="form-control <?php echo(array_key_exists('users', $errors))?'is-invalid':''; ?>" name="users" id="users" placeholder="" required></textarea>
											<div class="invalid-feedback">
												<?= form_error('users') ?>
											</div>
										</div>
									</div> 

									<div class="form-row mb-3">
										<div class="col-md-12 mt-3">
											<label for="description" class="font-weight-bold">توضیحات</label>
											<textarea rows="6" class="form-control <?php echo(array_key_exists('description', $errors))?'is-invalid':''; ?>" name="text" id="description" placeholder="" required></textarea>
											<div class="invalid-feedback">
												<?= form_error('description') ?>
											</div>
										</div>
									</div> 
									
									<button type="submit" class="btn shadow-sm btn-success">ثبت</button>
									<button type="reset" class="btn btn-outline-secondary">پاک کردن</button>
								</form>
							</div>

						</div>
					</div>
				</div>

			</div>
	<script type="text/javascript">
	$('#users').prop("disabled", true);
	$('.by_users').hide();
	$("#by_list").click(function() {
		$('#users').prop("disabled", false);
		$('#users').fadeIn(500);
		$('.by_users').fadeIn(500);
	});
	$("#by_users").click(function() {
		$('#users').prop("disabled", true);
		$('#users').fadeOut(500);
		$('.by_users').fadeOut(500);
	});
	</script>
{footer}