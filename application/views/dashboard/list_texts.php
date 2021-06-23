{header}
{sidebar}
			<!-- Modal -->
			<div class="modal fade" id="qrcode" role="dialog" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header align-items-center">
							<h5 class="modal-title" id="exampleModalLabel">کد QR</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body text-center">
						</div>
						<div class="modal-footer text-left" style="justify-content: right">
							<button type="button" class="btn btn-danger" data-dismiss="modal">بستن</button>
						</div>
					</div>
				</div>
			</div>
<!-- Content -->
			<div class="col-md-10 bg-transparent py-4" id="content">

				<!-- <div class="row px-4 py-4 align-items-center text-muted"> -->
					<!-- <i class="align-middle fas fa-link fa-lg"></i> -->
					<!-- <h5 class="m-0 px-2 font-weight-bold">کوتاه کردن لینک</h5> -->
					<!-- </div> -->

					<!-- Chart -->
					<div class="row mx-1 mt-3 align-items-center">
						<div class="col-md-12 px-0">
							<?php if($this->session->flashdata('success') == "ok"): ?>
							<div class="alert alert-success border border-success" role="alert">
							متن با موفقیت کوتاه شد، <a href="<?=$this->session->flashdata('address')?>" class="alert-link">آدرس متن</a> های کوتاه شده در جدول زیر قابل مشاهده می باشند.
							</div>
							<?php endif; ?>
							<?php if($this->session->flashdata('success') == "delete"): ?>
							<div class="alert alert-success border border-success" role="alert">
								متن با موفقیت حذف شد.
							</div>
							<?php endif; ?>
							<div class="card noborder bg-white rounded shadow-sm">
								<div class="card-header bg-white font-weight-bold"><i class="align-middle fas fa-list mr-2"></i>فهرست لینک های شما</div>
								<div class="card-body text-secondary p-4">

									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<button class="btn btn-outline-success" type="button" id="search_button">جستجو</button>
										</div>
										<input type="text" id="search_text" class="form-control text-right" placeholder="آدرس لینک" aria-label="آدرس لینک" dir="ltr">
										<div class="input-group-append">
											<span class="input-group-text" id="basic-addon2" dir="ltr" style="font-family: monospace;">http://</span>
										</div>
									</div>
								</div>
								<form>
									<div class="table-responsive pb-2">
										<!-- <table id="list_table" class="table table-hover"> -->
										<table data-order='[[ 0, "desc" ]]' id="list_table" class="table table-hover">
											<thead>
												<tr>
													<th><i class="mr-2 fas fa-hashtag"></i></th>
													<th><i class="mr-2 fas fa-external-link-alt"></i>متن اصلی</th>
													<th><i class="mr-2 fas fa-link"></i>آدرس کوتاه شده</th>
													<th><i class="mr-2 fas fa-link"></i>نوع</th>
													<th><i class="mr-2 fas fa-eye"></i>مشاهده</th>
													<th><i class="mr-2 fas fa-calendar"></i>تاریخ ایجاد</th>
													<th><i class="mr-2 fas fa-tools"></i>عملیات</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($texts as $text): ?>
												<tr>
													<td><?=$text["id"]?></td>
													<td><?=$text["text"]?></td>
													<td dir="ltr" class="text-right"><a href="<?=$text["short"]?>" class="btn btn-sm btn-success shadow"><?=$text["short"]?></a></td>
													<td dir="ltr" class="text-right align-middle">
														<?php $type = $text["type"] ?>
														<?=($type == 'ptc') ? 'درآمد زا': 'مستقیم'?>
													</td>
													<td>

														<?php 
														$temp_id = intval($text["raw_id"]);
														$views = $this->click_model->text_clicks($temp_id);
														echo count($views);
														?>
													</td>
													<td><?=$text["created_at"]?></td>
													<td>
														<div class="d-flex">
															<div class="btn-group btn-group-sm col" role="group" aria-label="Basic example">
																<a href="<?=base_url('dashboard')?>/texts/edit/<?=$text["raw_id"]?>" class="btn btn-outline-secondary"><i class="fas fa-cog align-middle"></i></a>

																<button data-href="<?=base_url('dashboard')?>/texts/qrcode/<?=$text["qrcode"]?>" type="button" class="btn btn-outline-info openqr"><i class="fas fa-qrcode align-middle"></i></button>

																<a href="<?=base_url('dashboard')?>/texts/delete/<?=$text["raw_id"]?>" class="btn btn-outline-danger"><i class="fas fa-trash align-middle"></i></a>
															</div>
														</div>
													</td>
												</tr>
												<?php endforeach ?>
											</tbody>
										</table>
									</div>
								</form>

							</div>
						</div>
					</div>

				</div>
{footer}