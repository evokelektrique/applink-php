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
						<?php if($this->session->flashdata('danger') == "badgroup"): ?>
						<div class="alert alert-danger border border-danger" role="alert">
							<strong>هشدار: </strong>لینک های نامعتبر.
						</div>
						<?php endif; ?>
						<div class="card noborder bg-white rounded shadow-sm">
							<div class="card-header bg-white font-weight-bold"><i class="align-middle fas fa-link mr-2"></i>کوتاه کردن لینک</div>
							<div class="card-body text-secondary p-4">
								<p class="card-text">
									برای کوتاه کردن لینک، کافیست آدرس (URL) مورد نظر را در باکس زیر وارد کرده و بر روی دکمه "کوتاه کن" کلیک کنید.
									<br>
									برای کوتاه کردن گروهی لینک ها کافیست هر لینک را در یک خط وارد کنید.
								</p>
								<form method="POST" action="<?=base_url('shortlink/group')?>">
									<?php
									$csrf = array(
								        'name' => $this->security->get_csrf_token_name(),
								        'hash' => $this->security->get_csrf_hash()
									);
									?>
									<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
									<?php $errors = $this->form_validation->error_array(); ?>
									<div class="form-row">
										<div class="col-md-12 mt-3">
											<label for="links" class="font-weight-bold">فرم لینک ها</label>
											<textarea rows="6" class="form-control text-right <?php echo(array_key_exists('links', $errors))?'is-invalid':''; ?>" style="font-family: monospace;" dir="ltr" name="links" id="links" placeholder="http://" required></textarea>
											<div class="invalid-feedback">
												<?= form_error('links') ?>
											</div>
										</div>

									</div>
									<div class="form-row">
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
									<button type="submit" class="btn mt-3 shadow-sm btn-success">کوتاه کن</button>
								</form>
							</div>

						</div>
					</div>
				</div>

			</div>

			{footer}