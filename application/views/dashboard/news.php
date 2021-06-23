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
							<div class="card-header bg-white font-weight-bold"><i class="align-middle fas fa-newspaper mr-2"></i>اخبار</div>
							<div class="card-body text-secondary p-4">
								{news}
									<div class="form-row">
										<div class="col-md-12">
											<div class="d-flex mb-4">
												<div class="input-group">
													<div class="input-group-prepend">
														<label class="input-group-text" for="title">عنوان</label>
													</div>
													<input type="text" disabled="" class="form-control" id="title" name="title" value='{title}' required>
												</div>
												<div class="input-group col-md-3 pr-0">
													<div class="input-group-prepend">
														<div class="input-group-text"style="min-width: 100%">تاریخ انتشار</div>
													</div>
													<input type="text" value="{created_at}" disabled class="form-control" placeholder="تاریخ انتشار">
													<div class="input-group-append">
														<div class="input-group-text"><i class="fas fa-calendar"></i></div>
													</div>
												</div>
											</div>
											<div class="form-row mb-3">
												<div class="col-md-12 mt-3">
													<p class="news_text text-dark text-justify p-4 border rounded shadow-sm">
														{text}
													</p>
												</div>
											</div>


										</div>
									</div>
								{/news}
							</div>

						</div>
					</div>
				</div>

			</div>
			{footer}