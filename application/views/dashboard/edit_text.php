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
<!-- 							<div class="shadow-sm alert alert-warning border-warning" role="alert">
								<strong>هشدار: </strong> اطلاعات اکانت شما کامل نمی باشد. برای ثبت درخواست واریز باید تمام اطلاعات را درست و کامل وارد کنید.
								<a href="#" class="btn btn-sm btn-secondary border-dark ml-2">ویرایش اطلاعات</a>
							</div>							
						-->							<div class="card noborder bg-white rounded shadow-sm">
							<div class="card-header bg-white font-weight-bold"><i class="align-middle fas fa-user-cog mr-2"></i>ویرایش تنظیمات و اطلاعات کاربری</div>
							<div class="card-body text-secondary p-4">
								<?php if($this->session->userdata('admin')): ?>
								<div class="alert alert-warning" role="alert">
									ویرایش <a href="{text}{shortaddress}{/text}" class="font-weight-bold">متن</a> در حالت مدیریت
								</div>
								<?php endif; ?>

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
								{text}
								<?php if($this->session->userdata('admin')): ?>
								<form method="POST" action='<?=base_url("dashboard/admin/texts/validate_edit/{id}")?>'>
								<?php endif; ?>
								<form method="POST" action='<?=base_url("dashboard/texts/validate_edit/{id}")?>'>
									<?php
									$csrf = array(
										'name' => $this->security->get_csrf_token_name(),
										'hash' => $this->security->get_csrf_hash()
									);
									?>
									<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
									<?php $errors = $this->form_validation->error_array(); ?>

									<div class="form-row">
										<div class="col-md-12">
											<div class="d-flex row">

												<div class="input-group mb-4 col-md-6">
													<div class="input-group-prepend">
														<div class="input-group-text"style="min-width: 100%">آدرس کوتاه شده</div>
													</div>
													<input dir="ltr" type="text" value="{shortaddress}" disabled class="form-control" placeholder="ایمیل">
													<div class="invalid-feedback order-last ">
														نامعتبر
													</div>
													<div class="input-group-append">
														<div class="input-group-text"><i class="fas fa-link"></i></div>
													</div>
												</div>

												<div class="input-group mb-4 col-md-3">
													<div class="input-group-prepend">
														<div class="input-group-text"style="min-width: 100%">تاریخ ایجاد</div>
													</div>
													<input type="text" value="{created_at}" disabled class="form-control" placeholder="ایمیل">
													<div class="invalid-feedback order-last ">
														نامعتبر
													</div>
													<div class="input-group-append">
														<div class="input-group-text"><i class="fas fa-link"></i></div>
													</div>
												</div>
												<div class="input-group mb-4 col-md-3">
													<div class="input-group-prepend">
														<div class="input-group-text"style="min-width: 100%">تاریخ ویرایش</div>
													</div>
													<input type="text" value="{modified_at}" disabled class="form-control" placeholder="ویرایش نشده">
													<div class="invalid-feedback order-last ">
														نامعتبر
													</div>
													<div class="input-group-append">
														<div class="input-group-text"><i class="fas fa-link"></i></div>
													</div>
												</div>
											</div>
											<div class="text-danger">
												<?= form_error('title') ?>
											</div>
											<div class="d-flex mb-4">
												<div class="input-group mb-3 pr-3">
													<div class="input-group-prepend">
														<label class="input-group-text" for="title">عنوان</label>
													</div>
													<input type="text" class="form-control <?php echo(array_key_exists('title', $errors))?'is-invalid':''; ?>" id="title" name="title" value='{title}' required>
												</div>
												<div class="input-group mb-3 pl-3">
													<div class="input-group-prepend">
														<label class="input-group-text" for="text_mode">حالت نمایش</label>
													</div>
													<select class="custom-select <?php echo(array_key_exists('links', $errors))?'is-invalid':''; ?>" id="text_mode" name="text_mode">
														<option <?=($text[0]['text_mode'] == 'plain')?'selected':'';?> value="plain">متن خام</option>
														<option <?=($text[0]['text_mode'] == 'code')?'selected':'';?> value="code">کد</option>
													</select>
												</div>
											</div>
											<div class="form-row mb-3">
												<div class="col-md-12 mt-3">
													<label for="text" class="font-weight-bold">متن</label>
													<textarea rows="6" class="form-control <?php echo(array_key_exists('text', $errors))?'is-invalid':''; ?>" name="text" id="text" placeholder="" required='متن'>{text}</textarea>
													<div class="invalid-feedback">
														<?= form_error('text') ?>
													</div>
												</div>
											</div>
											<div class="d-flex row mb-4">
												<div class="col-md-3">
													<img src="<?=base_url('./src/images/qrcodes/{qrcode}.png')?>" alt="QR کد">
												</div>
												<div class="col align-self-center text-justify">
													<h4 class="font-weight-bold mb-4">کد های QR چیست؟</h4>
													<p>
														کدهای QR را‌ می‌توان به کمک تلفن‌های هوشمند اسکن کرد. این کدها می‌توانند حاوی اطلاعاتی نظیر آدرس اینترنتی، نام، نشانی، تلفن، متن دلخواه یا هر اطلاعات دیگری باشند. و در صورتی که این کد حاوی نشانی اینترنتی خاصی باشد، پس از نشانه‌روی و اسکن آن توسط گوشی هوشمند، نشانی رمزگشایی شده و صفحه مورد نظر باز می‌شود.
													</p>
												</div>
											</div>
 <div class="row">
	<div class="input-group mb-4 col-md-6">
		<div class="input-group">
		  <div class="input-group-prepend">
		    <label class="input-group-text" for="button_name">دکمه ادامه</label>
		  </div>
		  <select class="custom-select <?php echo(array_key_exists('button_name', $errors))?'is-invalid':''; ?>" id="button_name" name="button_name">
		        <option selected value="{button}">{button}</option>
		        <option value="رد تبلیغ">رد تبلیغ</option>
		        <option value="مشاهده لینک دانلود">مشاهده لینک دانلود</option>
		        <option value="مشاهده صفحه">مشاهده صفحه</option>
		        <option value="مشاهده موضوع">مشاهده لینک دانلود</option>
		        <option value="مشاهده مطلب">مشاهده مطلب</option>
		        <option value="مشاهده لینک دانلود فایل">مشاهده لینک دانلود فایل</option>
		        <option value="مشاهده لینک دانلود آهنگ">مشاهده لینک دانلود آهنگ</option>
		        <option value="مشاهده لینک دانلود فیلم">مشاهده لینک دانلود فیلم</option>
		        <option value="مشاهده لینک کانال">مشاهده لینک کانال</option>
		  </select>
		</div>
	</div>			
	<div class="input-group mb-4 col-md-6">
		<div class="input-group-prepend">
			<label class="input-group-text" for="button_name">حالت لینک</label>
		</div>
		<select class="custom-select <?php echo(array_key_exists('type', $errors))?'is-invalid':''; ?>" id="type" name="type">
			<option value="direct" <?=($text[0]['type'] == 'direct') ? 'selected' : '';?>>مستقیم</option>
			<option value="ptc" <?=($text[0]['type'] == 'ptc') ? 'selected' : '';?>>درآمد زا</option>
		</select>
	</div>
</div> 	

											<div class="mb-4 d-flex row">
												<div class="col-md-4 mb-2 mt-2 align-self-center">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" name="private_status" <?php echo($text[0]['private_status'] == 1) ? 'checked' : '';?>  class="custom-control-input" id="password_status">
														<label class="custom-control-label" for="password_status">برای خصوصی (رمز دار) کردن لینک کلیک کنید</label>
													</div>
												</div>
												<div class="col" id="password" style="display: <?php echo($text[0]['private_status'] == 1) ? 'block' : 'none';?> ;">
													<input name="private_password" type="text" value="{private_password}" class="form-control  <?php echo(array_key_exists('private_password', $errors))?'is-invalid':''; ?>" placeholder="رمز">
												</div>
											</div>			

											<button type="submit" class="btn shadow-sm btn-success">ثبت تغییرات</button>
										</div>
									</div>
								</form>
								{/text}
							</div>

						</div>
					</div>
				</div>

			</div>
			{footer}