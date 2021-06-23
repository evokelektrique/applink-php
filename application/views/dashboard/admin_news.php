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
								<div class="card-header bg-white font-weight-bold"><i class="align-middle fas fa-list mr-2"></i>فهرست لینک های شما <span class="alert-warning border border-warning px-2 ml-2 font-weight-normal rounded"><b>{not_payed_transactions}</b> تراکنش پرداخت نشده</span></div>
								<div class="card-body text-secondary p-4">
									<div class="input-group mb-3">
										<input type="text" id="search_text" class="form-control" placeholder="مقدار مورد نظر" aria-label="مقدار مورد نظر">
										<div class="input-group-append">
											<button class="btn btn-outline-success" type="button" id="search_button">جستجو</button>
										</div>
									</div>
								</div>
								<form>
									<div class="table-responsive pb-2">
										<table id="list_table" class="table table-hover">
											<thead>
												<tr>
													<th><i class="mr-2 fas fa-hashtag"></i></th>
													<th><i class="mr-2 fas fa-coins"></i>عنوان</th>
													<th><i class="mr-2 fas fa-question"></i>تاریخ انتشار</th>
													<th><i class="mr-2 fas fa-cogs"></i>تنظیمات</th>
												</tr>
											</thead>
											<tbody>
												{news}
												<tr>
													<td>{id}</td>
													<td>{title}</td>
													<td>{created_at}</td>
													<td>
														<a href="<?=base_url('dashboard')?>/admin/news/edit/{raw_id}" class="btn btn-sm btn-outline-success border-success"><i class="fas fa-cog align-middle"></i></a>
													</td>

												</tr>
												{/news}
											</tbody>
										</table>
									</div>
								</form>

							</div>
						</div>
					</div>

				</div>
{footer}