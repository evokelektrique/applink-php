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
							<div class="card-header bg-white font-weight-bold"><i class="align-middle fas fa-user-cog mr-2"></i>ویرایش تراکنش</div>
							<div class="card-body text-secondary p-4">
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
								<form method="POST" action='<?=base_url("dashboard/admin/transactions/validate_edit/{transaction}{raw_id}{/transaction}")?>'>
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
												<div class="input-group mb-4 col-md-3">
													<div class="input-group-prepend">
														<div class="input-group-text"style="min-width: 100%">نام کاربری</div>
													</div>
													<input type="text" value="{user}{username}{/user}" readonly class="form-control" placeholder="ایمیل">
													<div class="input-group-append">
														<div class="input-group-text"><i class="fas fa-link"></i></div>
													</div>
												</div>
												<div class="input-group mb-4 col-md-3">
													<div class="input-group-prepend">
														<div class="input-group-text"style="min-width: 100%">نام</div>
													</div>
													<input type="text" value="{user}{name}{/user}" readonly class="form-control" placeholder="ایمیل">
													<div class="invalid-feedback order-last ">
														نامعتبر
													</div>
													<div class="input-group-append">
														<div class="input-group-text"><i class="fas fa-link"></i></div>
													</div>
												</div>
												<div class="input-group mb-4 col-md-3">
													<div class="input-group-prepend">
														<div class="input-group-text"style="min-width: 100%">شماره تماس</div>
													</div>
													<input type="text" value="{user}{phone}{/user}" readonly class="form-control" placeholder="ایمیل">
													<div class="invalid-feedback order-last ">
														نامعتبر
													</div>
													<div class="input-group-append">
														<div class="input-group-text"><i class="fas fa-link"></i></div>
													</div>
												</div>
												<div class="input-group mb-4 col-md-3">
													<div class="input-group-prepend">
														<div class="input-group-text"style="min-width: 100%">وضعیت کاربر</div>
													</div>
													<input type="text" value="<?=($user[0]['status'] == 1)?'بدون مشکل':'مسدود';?>" readonly class="form-control" placeholder="ویرایش نشده">
													<div class="input-group-append">
														<div class="input-group-text"><i class="fas fa-link"></i></div>
													</div>
												</div>
											</div>
											<div class="d-flex row">
												<div class="input-group mb-4 col-md-6">
													<div class="input-group-prepend">
														<div class="input-group-text"style="min-width: 100%">مقدار جهت پرداخت (ریال)</div>
													</div>
													<input dir="ltr" type="text" value="{transaction}{amount}{/transaction}" class="form-control roboto" placeholder="ایمیل">
													<div class="input-group-append">
														<div class="input-group-text"><i class="fas fa-money-bill-wave"></i></div>
													</div>
												</div>
												<div class="input-group mb-4 col-md-6">
													<div class="input-group-prepend">
														<div class="input-group-text"style="min-width: 100%">شماره شبا</div>
													</div>
													<input dir="ltr" type="text" value="{user}{bankaddress}{/user}" class="form-control roboto" placeholder="ایمیل">
													<div class="input-group-append">
														<div class="input-group-text"><i class="fas fa-link"></i></div>
													</div>
												</div>
											</div>
											<div class="d-flex row">
												<div class="input-group mb-4 col-md-4">
													<div class="input-group">
														<div class="input-group-prepend">
															<label class="input-group-text" for="pay_status">وضعیت پرداخت</label>
														</div>
														<select class="custom-select <?=($transaction[0]['payed_status'] == 'پرداخت شده')?'border-success':'border-danger';?> <?php echo(array_key_exists('pay_status', $errors))?'is-invalid':''; ?>" id="pay_status" name="pay_status">
															<option <?=($transaction[0]['payed_status'] == 'پرداخت شده')?'selected':'';?> value="پرداخت شده">پرداخت شده</option>
															<option <?=($transaction[0]['payed_status'] == 'پرداخت نشده')?'selected':'';?> value="پرداخت نشده">پرداخت نشده</option>
														</select>
													</div>
												</div>			
											</div>		

											<button type="submit" class="btn shadow-sm btn-success">ثبت تغییرات</button>
										</div>
									</div>
								</form>
							</div>

						</div>
					</div>
				</div>

			</div>
			{footer}