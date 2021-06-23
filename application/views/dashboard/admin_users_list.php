{header}
{sidebar}
<!-- Content -->
			<div class="col-md-10 bg-transparent py-4" id="content">

				<!-- <div class="row px-4 py-4 align-items-center text-muted"> -->
					<!-- <i class="align-middle fas fa-link fa-lg"></i> -->
					<!-- <h5 class="m-0 px-2 font-weight-bold">کوتاه کردن لینک</h5> -->
					<!-- </div> -->
					<div class="col-12 px-0 align-items-center bg-transparent my-3">
						<ul class="list-group shadow-sm">
							<li class="list-group-item d-flex justify-content-between align-items-center">
								کاربر های امروز
								<span class="badge badge-primary badge-pill">{users_today}</span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center">
								کاربر های دیروز
								<span class="badge badge-primary badge-pill">{users_yesterday}</span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center">
								کاربر های این ماه
								<span class="badge badge-primary badge-pill">{users_month}</span>
							</li>
						</ul>					
					</div>
					<!-- Chart -->
					<div class="row mx-1 mt-3 align-items-center">
						<div class="col-md-12 px-0">
							<div class="card noborder bg-white rounded shadow-sm">
								<div class="card-header bg-white font-weight-bold"><i class="align-middle fas fa-list mr-2"></i>فهرست کاربران</div>
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
										<table id="list_admin_table" class="table table-hover">
											<thead>
												<tr>
													<th><i class="mr-2 fas fa-hashtag"></i></th>
													<th><i class="mr-2 fas fa-calendar"></i>نام کاربری</th>
													<th><i class="mr-2 fas fa-at"></i>ایمیل</th>
													<th><i class="mr-2 fas fa-user"></i>نام</th>
													<th><i class="mr-2 fas fa-check"></i>وضعیت</th>
													<th><i class="mr-2 fas fa-user-secret"></i>نقش</th>
													<th><i class="mr-2 fas fa-calendar"></i>تاریخ ثبت نام</th>
													<th><i class="mr-2 fas fa-cogs"></i>تنظیمات</th>
												</tr>
											</thead>
											<tbody>
												{users}
												<tr>
													<td>{id}</td>
													<td>{username}</td>
													<td>{email}</td>
													<td>{name}</td>
													<td>{status}</td>
													<td>{role}</td>
													<td>{created_at}</td>
													<td>
														<a href="<?=base_url('dashboard')?>/admin/users/edit/{raw_id}" class="btn btn-sm btn-outline-success border-success"><i class="fas fa-cog align-middle"></i></a>
													</td>

												</tr>
												{/users}
											</tbody>
										</table>
									</div>
								</form>

							</div>
						</div>
					</div>

				</div>
{footer}