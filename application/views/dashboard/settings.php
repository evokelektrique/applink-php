{header}
{sidebar}
<!-- Content -->
<div class="col-md-10 bg-transparent py-4" id="content">

	<div class="row mx-1 mt-3 align-items-center">
		<div class="col-md-12 px-0">

			<div class="card noborder bg-white rounded shadow-sm">
				<div class="card-header bg-white font-weight-bold"><i class="align-middle 	 mr-2"></i>تنظیمات سایت</div>
				<div class="card-body text-secondary p-4">


					<?php if($this->session->flashdata('success') == 'ok'): ?>
						<div class="alert alert-success border-success" role="alert">
							تغییرات با موفقیت انجام شد.
						</div>
					<?php endif; ?>
					<?php if($this->session->flashdata('danger') == 'bad'): ?>
						<div class="alert alert-danger border-danger" role="alert">
							مشکل در ثبت تغییرات.
						</div>
					<?php endif; ?>					
					<?php if($this->session->flashdata('danger') == 'empty'): ?>
						<div class="alert alert-warning border-warning" role="alert">
							تغییری ایجاد نشد
						</div>
					<?php endif; ?>

					<form method="post" action="{base_url}dashboard/admin/settings/validate_edit" enctype="multipart/form-data">
						<?php $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>
						<?php $errors = $this->form_validation->error_array();?>
						<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

						{settings}
						<div class="form-row">
							<div class="col-md-12">
								<br>
								<br>
								<h5 class="font-weight-bold">اطلاعات </h5>
								<hr>
								<div class="input-group mb-4 col-md-12 mx-auto px-0">
									<div class="input-group-prepend">
										<label class="input-group-text" style="min-width: 140px">عنوان سایت</label>
									</div>
									<input type="text" name="site_name" value="{site_name}" class="<?php echo(array_key_exists('site_name', $errors))?'is-invalid':''; ?> form-control" placeholder="عنوان سایت *">
									<div class="invalid-feedback order-last ">
										<?= form_error('site_name') ?>
									</div>
									<div class="input-group-append">
										<label class="input-group-text"><i class="fas fa-cog"></i></label>
									</div>
								</div>


								<div class="input-group mb-4 col-md-12 mx-auto px-0">
									<div class="input-group-prepend">
										<label class="input-group-text" style="min-width: 140px">توضیحات سایت</label>
									</div>
									<textarea rows="7" style="min-height: 50px" name="site_description" class="text-justify <?php echo(array_key_exists('site_description', $errors))?'is-invalid':''; ?> form-control" placeholder="عنوان سایت *">{site_description}</textarea>
									<div class="invalid-feedback order-last ">
										<?= form_error('site_description') ?>
									</div>
									<div class="input-group-append">
										<label class="input-group-text"><i class="fas fa-cog"></i></label>
									</div>
								</div>								

								<div class="input-group mb-4 col-md-12 mx-auto px-0">
									<div class="input-group-prepend">
										<label class="input-group-text" style="min-width: 140px">برچسب های سایت</label>
									</div>
									<textarea rows="5" style="min-height: 50px" name="site_tags" class="text-justify <?php echo(array_key_exists('site_tags', $errors))?'is-invalid':''; ?> form-control" placeholder="عنوان سایت *">{site_tags}</textarea>
									<div class="invalid-feedback order-last ">
										<?= form_error('site_tags') ?>
									</div>
									<div class="input-group-append">
										<label class="input-group-text"><i class="fas fa-cog"></i></label>
									</div>
								</div>



								<div class="input-group mb-4 col-md-12 mx-auto px-0">
									<div class="input-group-prepend">
										<label class="input-group-text" style="min-width: 140px">انتخاب لوگو سایت *</label>
									</div>
									<div class="custom-file">
									  <label class="custom-file-label" for="select_logo">انتخاب فایل ...</label>
									  <input type="file" name="logo" value="{site_logo_address}" class="custom-file-input" id="select_logo">
									</div>
									<div class="invalid-feedback order-last ">
										<?= form_error('site_logo_address') ?>
									</div>
									<div class="input-group-append">
										<label class="input-group-text"><i class="fas fa-cog"></i></label>
									</div>
								</div>
								<?php if(!empty($settings[0]['site_logo_address'])): ?>
									<div class="shadow-sm rounded image_preview_dashboard" style="background-image: url(<?=base_url("src/images/logo/{site_logo_address}")?>);"></div>
								<?php endif; ?>




								<br>
								<br>
								<h5 class="font-weight-bold">اطلاعات تماس</h5>
								<hr>
								<div class="form-row">
									<div class="input-group mb-4 col-md-4 mx-auto">
										<div class="input-group-prepend">
											<label class="input-group-text" style="min-width: 140px">فضای مجازی سایت</label>
										</div>
										<input type="text" name="site_social" value="{site_social}" class="<?php echo(array_key_exists('site_social', $errors))?'is-invalid':''; ?> form-control" placeholder="عنوان سایت *">
										<div class="invalid-feedback order-last ">
											<?= form_error('site_social') ?>
										</div>
										<div class="input-group-append">
											<label class="input-group-text"><i class="fas fa-cog"></i></label>
										</div>
									</div>
										
									<div class="input-group mb-4 col-md-4 mx-auto">
										<div class="input-group-prepend">
											<label class="input-group-text" style="min-width: 140px">آدرس سایت</label>
										</div>
										<input type="text" name="site_location" value="{site_location}" class="<?php echo(array_key_exists('site_location', $errors))?'is-invalid':''; ?> form-control" placeholder="عنوان سایت *">
										<div class="invalid-feedback order-last ">
											<?= form_error('site_location') ?>
										</div>
										<div class="input-group-append">
											<label class="input-group-text"><i class="fas fa-cog"></i></label>
										</div>
									</div>

									<div class="input-group mb-4 col-md-4 mx-auto">
										<div class="input-group-prepend">
											<label class="input-group-text" style="min-width: 140px">شماره تماس سایت</label>
										</div>
										<input type="text" name="site_phone_number" value="{site_phone_number}" class="<?php echo(array_key_exists('site_phone_number', $errors))?'is-invalid':''; ?> form-control" placeholder="عنوان سایت *">
										<div class="invalid-feedback order-last ">
											<?= form_error('site_phone_number') ?>
										</div>
										<div class="input-group-append">
											<label class="input-group-text"><i class="fas fa-cog"></i></label>
										</div>
									</div>
										
								</div>



								<br>
								<br>
								<h5 class="font-weight-bold">قیمت</h5>
								<hr>
								<div class="form-row mb-4">

									<div class="col-md-12">
										<div class="custom-control custom-checkbox">
										  <input type="checkbox" <?=($settings[0]['site_ptc_mode'] > 0) ? 'checked="checked"' : '';?> class="custom-control-input" id="ptc_module">
										  <input type="hidden" name="site_ptc_mode" id="site_ptc_mode" value="{site_ptc_mode}">
										  <label class="custom-control-label font-weight-bold" for="ptc_module">فعال سازی ماژول درآمد سازی</label>
										</div>
									</div>

								</div>
								<div class="form-row">
									<div class="col-md-6">
										<small class="form-text text-muted d-block mb-2" style="clear: both;">
											<span class="badge badge-warning border border-dark font-weight-normal mr-1" style="font-size: 11px;">نکته</span>
											قیمت ها با <b class="text-underline cursor-help">ریال</b> حساب میشوند
										</small>
									</div>
									<div class="col-md-6">
										<small class="form-text text-muted d-block mb-2" style="clear: both;">
											<span class="badge badge-warning border border-dark font-weight-normal mr-1" style="font-size: 11px;">نکته</span>
											قیمت ها با <b class="text-underline cursor-help">ریال</b> حساب میشوند
										</small>
									</div>
								</div>
								<div class="form-row ptc_prices">
									<div class="input-group mb-4 col-md-6 mx-auto">
										<div class="input-group-prepend">
											<label class="input-group-text" style="min-width: 140px">مقدار هر کلیک لینک</label>
										</div>
										<input type="text" name="site_ptc_link_amount" value="{site_ptc_link_amount}" class="<?php echo(array_key_exists('site_ptc_link_amount', $errors))?'is-invalid':''; ?> form-control" <?=($settings[0]['site_ptc_mode'] == 0) ? 'disabled="disabled"' : '';?> placeholder="عنوان سایت *">
										<div class="invalid-feedback order-last ">
											<?= form_error('site_ptc_link_amount') ?>
										</div>
										<div class="input-group-append">
											<label class="input-group-text"><i class="fas fa-cog"></i></label>
										</div>
									</div>

									<div class="input-group mb-4 col-md-6 mx-auto">
										<div class="input-group-prepend">
											<label class="input-group-text" style="min-width: 140px">مقدار هر کلیک متن</label>
										</div>
										<input type="text" name="site_ptc_text_amount" value="{site_ptc_text_amount}" class="<?php echo(array_key_exists('site_ptc_text_amount', $errors))?'is-invalid':''; ?> form-control" <?=($settings[0]['site_ptc_mode'] == 0) ? 'disabled="disabled"' : '';?> placeholder="عنوان سایت *">
										<div class="invalid-feedback order-last ">
										<?= form_error('site_ptc_text_amount') ?>
										</div>
										<div class="input-group-append">
											<label class="input-group-text"><i class="fas fa-cog"></i></label>
										</div>
									</div>
										
								</div>



								<br>
								<br>
								<h5 class="font-weight-bold">ظاهر</h5>
								<hr>
								<?php if($settings[0]['site_template'] == 'default_template'): ?>
								<small class="form-text text-muted d-block mb-2" style="clear: both;">
									<span class="badge badge-warning border border-dark font-weight-normal mr-1" style="font-size: 11px;">نکته</span>
									قالب سایت پیشفرض می باشد
								</small>
								<?php endif; ?>
								<div class="input-group mb-4 col-md-12 mx-auto px-0">
									<div class="input-group-prepend">
										<label class="input-group-text" style="min-width: 140px">قالب سایت</label>
									</div>
									<select readonly class="form-control">
									  <option>{site_template}</option>
									</select>
									<div class="invalid-feedback order-last ">
										<?= form_error('site_template') ?>
									</div>
									<div class="input-group-append">
										<label class="input-group-text"><i class="fas fa-cog"></i></label>
									</div>
								</div>




	


								<br>
								<button type="submit" class="btn shadow-sm btn-success">ثبت تغییرات</button>
							</div>
						</div>
						{/settings}
					</form>
				</div>

			</div>
		</div>
	</div>

</div>
{footer}
