{header}
{sidebar}

			<!-- Content -->
			<div class="col-md-10 bg-transparent py-4" id="content">

				<!-- <div class="row px-4 py-4 align-items-center text-muted"> -->
					<!-- <i class="align-middle fas fa-link fa-lg"></i> -->
					<!-- <h5 class="m-0 px-2 font-weight-bold">کوتاه کردن لینک</h5> -->
					<!-- </div> -->

					<div class="row mx-1 mt-3 align-items-center">
						<div class="col-md-12 px-0">
							<?php
								$withdraw_available = NULL; 
								$amount = intval($wallet[0]['amount']);
								if($amount >= 100000) {
									$withdraw_available = TRUE; 
								} else {
									$withdraw_available = FALSE; 
								}
							?>
							<?php if($information_status == TRUE): ?>
							<div class="shadow-sm alert alert-warning border-warning" role="alert">
								<strong>هشدار: </strong>کاربر <strong class="badge badge-secondary align-middle font-weight-normal"><?= $user['username']?></strong> گرامی اطلاعات اکانت شما کامل نمی باشد. برای ثبت درخواست واریز باید تمام اطلاعات را درست و کامل وارد کنید.
								<a href="#" class="btn btn-sm btn-secondary border-dark ml-2">ویرایش اطلاعات</a>
							</div>							
							<?php endif; ?>
							<?php if(!$withdraw_available): ?>
							<div class="shadow-sm alert alert-warning border-warning" role="alert">
								<strong>نکته: </strong>حد نصاب پرداخت موجودی در حال حاضر <strong>100000</strong> ريال می باشد
							</div>
							<?php endif; ?>
							<?php if($this->session->flashdata('danger') == 'bad'): ?>
							<div class="shadow-sm alert alert-danger border-danger" role="alert">
								<strong>خطا: </strong> <?=$this->session->flashdata('danger_message');?>
							</div>
							<?php endif; ?>
							<?php if($this->session->flashdata('success') == 'ok'): ?>
							<div class="shadow-sm alert alert-success border-success" role="alert">
								<strong>نکته: </strong> <?=$this->session->flashdata('success_message');?>
							</div>
							<?php endif; ?>
							<div class="card noborder bg-white rounded shadow-sm">
								<div class="card-header bg-white font-weight-bold"><i class="align-middle fas fa-credit-card mr-2"></i>درخواست واریز</div>
								<div class="card-body text-secondary p-4">
									<form method="POST" action="{base_url}dashboard/withdraw/validate">
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
												<div class="input-group mb-3 col-md-3 mx-0 px-0 flex-nowrap">
													<div class="input-group-prepend">
														<span class="input-group-text">مبلغ</span>
													</div>
													<input id="wallet_amount" <?=($withdraw_available == TRUE)?'':'disabled';?> type="text" class="form-control <?=($withdraw_available == TRUE)?'is-valid':'is-invalid';?>" placeholder="<?=$amount;?>" aria-label="<?=$amount;?>" value="<?=$amount;?>" name="wallet_amount" required>
													<div class="input-group-append">
														<span class="input-group-text">ریال</span>
													</div>
												</div>
												<?php if(!empty(form_error('wallet_amount'))): ?>
												<p class="d-block mb-4 text-danger"><strong class="badge badge-danger text-white font-weight-normal align-middle">هشدار</strong> موجودی شما به حد نصاب نرسیده است.</p>
												<?php endif; ?>
												<button type="submit" <?=($withdraw_available == TRUE)?'':'disabled';?> class="btn shadow-sm btn-success">ثبت درخواست واریز</button>
											</div>
										</div>
									</form>
								</div>

							</div>
						</div>
					</div>

				</div>
{footer}