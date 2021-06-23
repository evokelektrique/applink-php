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
			<div class="col-md-10 bg-transparent py-4" id="content">

					<div class="row mx-1 mt-3 align-items-center">
						<div class="col-md-12 px-0">
							<?php if($this->session->flashdata('success') == "ok"): ?>
							<div class="alert alert-success border border-success" role="alert">
							لینک با موفقیت کوتاه شد، <a href="<?=$this->session->flashdata('address')?>" class="alert-link">آدرس لینک</a> های کوتاه شده در جدول زیر قابل مشاهده می باشند.
							</div>
							<?php endif; ?>
							<?php if($this->session->flashdata('success') == "okgroup"): ?>
							<div class="alert alert-success border border-success" role="alert">
								لینک ها با موفقیت کوتاه شدند.
							</div>
							<?php endif; ?>
							<?php if($this->session->flashdata('success') == "delete"): ?>
							<div class="alert alert-success border border-success" role="alert">
								لینک با موفقیت حذف شد.
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

										<table data-order='[[ 0, "desc" ]]' id="list_table" class="table">
											<thead>
												<tr>
													<th><i class="mr-2 fas fa-hashtag"></i></th>
													<th><i class="mr-2 fas fa-external-link-alt"></i>آدرس اصلی</th>
													<th><i class="mr-2 fas fa-link"></i>آدرس کوتاه شده</th>
													<th><i class="mr-2 fas fa-link"></i>نوع</th>
													<th><i class="mr-2 fas fa-mouse-pointer"></i>کلیک</th>
													<th><i class="mr-2 fas fa-calendar"></i>تاریخ ایجاد</th>
													<th><i class="mr-2 fas fa-tools"></i>عملیات</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($links as $link): ?>
												<?php 
												$dates 		= array();
												$u_dates 	= array();

												foreach($link['chartdata'] as $data) {
													array_push($dates, $data["created_at"]);
												}

												$uniqe_dates = array_unique($dates);

												foreach ($uniqe_dates as $ud) {
													$time = strtotime($ud);
													$newformat = date('Y-m-d',$time);
													array_push($u_dates, $newformat);
												}

												$vals = array_count_values($u_dates);
												?>
												<tr>
													<td><?=$link['id']?></td>
													
													<td dir="ltr" class="text-right align-middle"><a href="<?=$link['address']?>" class="d-block"><span class="d-inline-block text-truncate" style="max-width: 150px;"><?=$link['address']?></span></a></td>

													<td dir="ltr" class="text-right align-middle"><a href="<?=$link['short']?>" class="btn btn-sm btn-success shadow"><span class="d-inline-block text-truncate" style="max-width: 150px;" dir="rtl"><?=$link['short']?></span></a>
													
													<td dir="ltr" class="text-right align-middle">
														<?=($link['type'] == 'ptc') ? 'درآمد زا': 'مستقیم'?>
													</td>
													
													<!-- Chart -->
													<td class="text-center">
													<?php if(is_array($link['clicks'])): ?>
													<div id="chart-<?=$link['id']?>" style="max-height: 100px; display: inline-table;"></div>
													<script type="text/javascript">
													var options = {
													chart: {height: 140, width: '160px', type: 'area', toolbar: {show: false, }, }, dataLabels: {enabled: false }, stroke: {curve: 'smooth'}, fill: {type: 'gradient', gradient: {shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.9, stops: [0, 100] }, }, theme: {palette: 'palette4'}, series: [{name: 'کلیک ', data: [<?php foreach($vals as $val): ?> <?= $val; ?>, <?php endforeach; ?> ] }], yaxis: {show: false, }, grid: {show: false, }, xaxis: {categories: [<?php foreach($u_dates as $date): ?> "<?= $date; ?>", <?php endforeach; ?> ], labels: {show: false, }, axisBorder: {show: false, }, }, dataLabels: {enabled: false, offsetX: 0, offsetY: -20, style: {fontSize: '13px', fontFamily: 'Vazir-FD', colors: ["#000"] }, }, plotOptions: {bar: {columnWidth: "66%", dataLabels: {position: 'top', } }, dataLabels: {enabled: true, dropShadow: {enabled: true, left: 0, top: 0, opacity: 0.5 } }, }, stroke: {show: true, curve: 'smooth', lineCap: 'butt', colors: undefined, width: 2, dashArray: 0, }, tooltip: {x: {show: false}, style: {fontSize: '13px', fontFamily: "Vazir-FD", }, }, legend: {show: true, showForSingleSeries: false, showForNullSeries: true, showForZeroSeries: true, position: 'bottom', horizontalAlign: 'center', floating: false, fontSize: '13px', fontFamily: 'Vazir-FD', formatter: undefined, inverseOrder: false, width: undefined, height: undefined, tooltipHoverFormatter: undefined, offsetX: 0, offsetY: 0, labels: {colors: undefined, useSeriesColors: false }, markers: {width: 12, height: 12, strokeWidth: 0, strokeColor: '#f00', fillColors: undefined, radius: 0, customHTML: undefined, onClick: undefined, offsetX: 0, offsetY: 0 }, itemMargin: {horizontal: 20, vertical: 5 }, onItemClick: {toggleDataSeries: true }, onItemHover: {highlightDataSeries: true }, } }
													var chart = new ApexCharts(document.querySelector("#chart-<?=$link['id']?>"), options);
													chart.render();
													</script>
													<?php else: ?>
													0
													<?php endif; ?>
													</td>

													<td class="text-center align-middle"><?=$link['created_at']?></td>

													<td class="text-center align-middle">
														<div class="d-flex">
															<div class="btn-group btn-group-sm col" role="group" aria-label="Basic example">
																<a href="<?=base_url('dashboard')?>/links/edit/<?=$link['raw_id']?>" class="btn btn-outline-secondary"><i class="fas fa-cog align-middle"></i></a>

																<button data-href="<?=base_url('dashboard')?>/links/qrcode/<?=$link['qrcode']?>" type="button" class="btn btn-outline-info openqr"><i class="fas fa-qrcode align-middle"></i></button>

																<a href="<?=base_url('dashboard')?>/links/delete/<?=$link['raw_id']?>" class="btn btn-outline-danger"><i class="fas fa-trash align-middle"></i></a>
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