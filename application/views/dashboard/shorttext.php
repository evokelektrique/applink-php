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
							<div class="card-header bg-white font-weight-bold"><i class="align-middle fas fa-link mr-2"></i>کوتاه کردن متن</div>
							<div class="card-body text-secondary p-4">
								<p class="card-text">
								به کمک کوتاه کننده متن، این امکان را خواهید داشت، تا متن ها، کدها و ... را به یک آدرس اینترنتی تبدیل کنید و آن را در اختیار دیگران قرار دهید.
								<br>
								<?php if(intval($this->settings_model->select(1)[0]['site_ptc_mode']) == 1):?>
									<span class="text-success font-weight-bold">کسب درآمد از متن های کوتاه شده نیز وجود دارد.</span>
								<?php endif; ?>
								<br>
								می توانید با انتخاب ویرایشگر پیشرفته متن، شکل و ظاهر متن خود را نیز ویرایش کنید.
								</p>
								<form method="POST" action="{base_url}/shorttext/validate">
									<?php if($this->session->flashdata('danger') == "bad"): ?>
									<div class="alert alert-danger border border-danger" role="alert">
										<strong>هشدار: </strong> کوتاه کننده متن به مشکل مواجه شد.
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
										<div class="col-md-8 mt-3">
											<div class="input-group mb-3">
											  <div class="input-group-prepend">
											    <label class="input-group-text" for="title">عنوان</label>
											  </div>
												<input type="text" name="title" class="form-control <?php echo(array_key_exists('title', $errors))?'is-invalid':''; ?>" id="title" placeholder="عنوان متن را وارد کنید ..." required>
											</div>
										</div>
										<div class="col-md-4 mt-3">
											<div class="input-group mb-3">
											  <div class="input-group-prepend">
											    <label class="input-group-text" for="text_mode">حالت نمایش</label>
											  </div>
											  <select class="custom-select <?php echo(array_key_exists('links', $errors))?'is-invalid':''; ?>" id="text_mode" name="text_mode">
											    <option selected value="plain">متن خام</option>
											    <option value="code">کد</option>
											  </select>
											</div>
										</div>
									</div>
									<div class="form-row mb-3">
										<div class="col-md-12 mt-3">
											<label for="text" class="font-weight-bold">متن</label>
											<textarea rows="6" class="form-control <?php echo(array_key_exists('text', $errors))?'is-invalid':''; ?>" name="text" id="text" placeholder="" required></textarea>
											<div class="invalid-feedback">
												<?= form_error('text') ?>
											</div>
										</div>
									</div>
									<div class="form-row mb-3">
										<div class="col-12 mt-3">
											<label for="type" class="font-weight-bold">حالت لینک</label>
											<select class="custom-select <?php echo(array_key_exists('type', $errors))?'is-invalid':''; ?>" id="type" name="type">
												<option value="direct">مستقیم</option>
												<option value="ptc">درآمد زا</option>
											</select>
											<div class="invalid-feedback">
												<?= form_error('type') ?>
											</div>
										</div>
									</div>
									<button type="submit" class="btn shadow-sm btn-success">کوتاه کن</button>
									<button type="reset" class="btn btn-outline-secondary">پاک کردن</button>
								</form>
							</div>

						</div>
					</div>
				</div>

			</div>
{footer}