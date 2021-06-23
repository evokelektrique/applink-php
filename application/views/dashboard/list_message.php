
{header}
{sidebar}

			<div class="col-md-10 bg-transparent py-4" id="content">

					<div class="row mx-1 mt-3 align-items-center">
						<div class="col-md-12 px-0">
							<?php if($this->session->flashdata('success') == "ok"): ?>
							<div class="alert alert-success border border-success" role="alert">
								پیام با موفقیت ارسال شد
							</div>
							<?php endif; ?>
							<?php if($this->session->flashdata('success') == "ok_delete"): ?>
							<div class="alert alert-success border border-success" role="alert">
								پیام با موفقیت حذف شد
							</div>
							<?php endif; ?>
							<div class="card noborder bg-white rounded shadow-sm">
								<div class="card-header bg-white font-weight-bold"><i class="align-middle fas fa-list mr-2"></i>لیست پیام ها
									<a href="<?=base_url('dashboard/admin/message/create')?>" class="btn btn-sm btn-success mx-2 text-uppercase border-dark border">
										ایجاد پیام جدید
									</a>
								</div>
								<div class="card-body text-secondary p-4">

									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<button class="btn btn-outline-success" type="button" id="search_button">جستجو</button>
										</div>
										<input type="text" id="search_text" class="form-control text-left" placeholder="متن جستجو را وارد کنید ..." aria-label="متن جستجو را وارد کنید ...">
									</div>
								</div>
								<form>
									<div class="table-responsive pb-2">

										<table data-order='[[ 0, "desc" ]]' id="list_table" class="table">
											<thead>
												<tr>
													<th><i class="mr-2 fas fa-hashtag"></i></th>
													<th><i class="mr-2 fas fa-pen"></i>
														عنوان
													</th>
													<th><i class="mr-2 fas fa-sticky-note"></i>
														توضیحات
													</th>
													<th><i class="mr-2 fas fa-user"></i>
														کاربر
													</th>

													<th><i class="mr-2 fas fa-calendar"></i>
														تاریخ انتشار
													</th>
													<th><i class="mr-2 fas fa-tools"></i>
														تنظیمات
													</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($messages as $message): ?>

												<tr>
													<td><?=$message['id']?></td>
													<td dir="ltr" class="text-right align-middle"><a href="<?=$message['title']?>" class="d-block"><?=$message['title']?></a></td>
													<td dir="ltr" class="text-right align-middle">
														<?=substr($message['text'], 0, 50)."..."?>
													
													</td>
													<td><a href="<?=base_url('dashboard/admin/users/edit/'.$message['user']['id'])?>"><?=$message['user']['username']?></a></td>
													<td class="text-center align-middle"><?=$message['created_at']?></td>
													<td class="text-center align-middle">
														<div class="d-flex">
															<div class="btn-group btn-group-sm col" role="group" aria-label="Basic example">
																<a href="<?=base_url('dashboard')?>/admin/message/edit/<?=$message['raw_id']?>" class="btn btn-outline-secondary"><i class="fas fa-cog align-middle"></i></a>

																<a href="<?=base_url('dashboard')?>/admin/message/delete/<?=$message['raw_id']?>" class="btn btn-outline-danger"><i class="fas fa-trash align-middle"></i></a>
															</div>
														</div>
													</td>
												</tr>
												<?php endforeach; ?>

											</tbody>
										</table>
									</div>
								</form>

							</div>
						</div>
					</div>

				</div>
			</div>


{footer}