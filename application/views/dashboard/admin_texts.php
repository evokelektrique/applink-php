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
<div class="col-md-10 bg-transparent py-4 admin-stats" id="content">

	<div class="row px-4 py-4 align-items-center text-muted">
		<i class="fas fa-th-large fa-lg"></i>
		<h5 class="m-0 px-2 font-weight-bold">مدیریت</h5>
	</div>

				<div class="d-flex mx-1	">
					<div class="col-3 mt-5 pl-0 align-items-center bg-transparent">
						<ul class="list-group shadow-sm">
							<li class="list-group-item d-flex justify-content-between align-items-center">
								کلیک های متن ماه

								<span class="badge badge-primary badge-pill">{text_clicks_last_month}</span>
							</li>
						</ul>
					</div>


					<div class="col-9 mt-5 align-items-center bg-white rounded shadow-sm">

						<div class="table-responsive pb-2 pt-3">
							<!-- <table id="list_table" class="table table-hover"> -->
								<table data-order='[[ 0, "desc" ]]' id="list_table" class="table table-hover">
									<thead>
										<tr>
											<th><i class="mr-2 fas fa-hashtag"></i></th>
											<th><i class="mr-2 fas fa-external-link-alt"></i>متن اصلی</th>
											<th><i class="mr-2 fas fa-link"></i>آدرس کوتاه شده</th>
											<th><i class="mr-2 fas fa-eye"></i>مشاهده</th>
											<th><i class="mr-2 fas fa-calendar"></i>تاریخ ایجاد</th>
											<th><i class="mr-2 fas fa-tools"></i>عملیات</th>
										</tr>
									</thead>
									<tbody>
										{texts}
										<tr>
											<td>{id}</td>
											<td>{text}</td>
											<td dir="ltr" class="text-right"><a href="{short}" class="btn btn-sm btn-success shadow">{short}</a></td>
											<td>0</td>
											<td>{created_at}</td>
											<td>
												<div class="d-flex">
													<div class="btn-group btn-group-sm col" role="group" aria-label="Basic example">
														<a href="<?=base_url('dashboard')?>/admin/texts/edit/{raw_id}" class="btn btn-outline-secondary"><i class="fas fa-cog align-middle"></i></a>

														<button data-href="<?=base_url('dashboard')?>/texts/qrcode/{qrcode}" type="button" class="btn btn-outline-info openqr"><i class="fas fa-qrcode align-middle"></i></button>


														<a href="<?=base_url('dashboard')?>/admin/texts/delete/{raw_id}" class="btn btn-outline-danger"><i class="fas fa-trash align-middle"></i></a>
													</div>
												</div>
											</td>
										</tr>
										{/texts}
									</tbody>
								</table>
							</div>
						</div>

					</div>
</div>
{footer}