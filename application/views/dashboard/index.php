<?php  
$links_dates 	= array();
$texts_dates 	= array();
$texts_u_dates 	= array();
$links_u_dates 	= array();

foreach($text_clicks_last_month as $data) {
	array_push($texts_dates, $data["created_at"]);
}
foreach($clicks_last_month as $data) {
	array_push($links_dates, $data["created_at"]);
}

$texts_uniqe_dates = array_unique($texts_dates);
$links_uniqe_dates = array_unique($links_dates);

foreach ($texts_uniqe_dates as $ud) {
	$time = strtotime($ud);
	$newformat = date('Y-m-d',$time);
	array_push($texts_u_dates, $newformat);
}

foreach ($links_uniqe_dates as $ud) {
	$time = strtotime($ud);
	$newformat = date('Y-m-d',$time);
	array_push($links_u_dates, $newformat);
}

$text_vals = array_count_values($texts_u_dates);
$link_vals = array_count_values($links_u_dates);


?>


{header}
{sidebar}

			<!-- Content -->
			<div class="col-md-10 bg-transparent py-4" id="content">

				<div class="row px-4 py-4 align-items-center text-muted">
					<i class="fas fa-th-large fa-lg"></i>
					<h5 class="m-0 px-2 font-weight-bold">داشبورد</h5>
				</div>

				<!-- Stats -->
				<div class="container-fluid">
					<div class="row px-0 justify-content-center dashboard-stats">
						<div class="col-md-3 col-sm-6 col-xs-12 mb-2 m-0 px-1">
							<div class="text-white text-center light px-4 py-2 rounded dashboard-stat-box bg-white shadow-lg">
								<h5 class="py-2 pt-4">موجودی حساب</h5>
								<h4 class="py-2 font-weight-bold"><?=number_format($wallet[0]['amount'])?> ریال</h4>
								<a href="{base_url}dashboard/withdraw" class="text-white pt-2 pb-1 d-block">+ درخواست واریزوجه</a>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12 mb-2 m-0 px-1">
							<div class="text-white text-center px-4 py-2 rounded dashboard-stat-box dark bg-white shadow-lg">
								<h5 class="py-2 pt-4">بازدید امروز</h5>
								<h4 class="py-2 font-weight-bold"><?=number_format($total_clicks_today)?></h4>
								<span class="position-relative text-white pt-2 pb-1 d-block">
									نسبت به دیروز &nbsp;
									<?=round($from_yesterday_percentage);?>%
									<?=($from_yesterday_percentage > 0)?'<i class="text-success fas fa-long-arrow-alt-up"></i>':'<i class="text-danger fas fa-long-arrow-alt-down"></i>';?>
									&nbsp;

									
									
								</span>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12 mb-2 m-0 px-1">
							<div class="text-white text-center px-4 py-2 rounded dashboard-stat-box dark bg-white shadow-lg">
								<h5 class="py-2 pt-4">بازدید دیروز</h5>
								<h4 class="py-2 font-weight-bold"><?=number_format($total_clicks_yesterday)?></h4>
								<span class="text-white pt-2 pb-1 d-block">&nbsp;</span>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12 mb-2 m-0 px-1">
							<div class="text-white text-center px-4 py-2 rounded dashboard-stat-box dark bg-white shadow-lg">
								<h5 class="py-2 pt-4">بازدید 30 روز قبل</h5>
								<h4 class="py-2 font-weight-bold"><?=number_format(count($clicks_last_month)+count($text_clicks_last_month))?></h4>
								<span class="text-white pt-2 pb-1 d-block">&nbsp;</span>	
							</div>
						</div>
					</div>
				</div>
				<!-- Chart -->
				<div class="row mx-1 align-items-center">
					<div class="col-md-12 px-0">
						<div class=" p-4 bg-white rounded shadow-lg">
							<h6 class="font-weight-bold align-middle my-0 py-2 text-muted"><i class="fas fa-chart-bar pr-2 fa-lg font-weight-normal"></i>درآمد این ماه شما</h6>
							<div id="chart" style="direction: ltr; width: 100%; height: 100px;"></div>
							<script type="text/javascript">
							var options = {
								chart: {
									type: 'bar',
							    		// stacked: true,
							    		height: 250,
							    		toolbar: {
							    			show: false,
							    		},
							    		// foreColor: '#373d3f'

							    	},

							    	series: [
							    	{
							    		name: 'بازدید لینک',
							    		data: [
							    			<?php foreach($link_vals as $key => $val): ?> 
							    			{ x: '<?= $key; ?>', y: <?= $val; ?>},
							    			<?php endforeach; ?>
							    		]
							    	},
							    	{
						    			name: 'بازدید متن',
						    			data: [
							    			<?php foreach($text_vals as $key => $val): ?> 
							    			{ x: '<?= $key; ?>', y: <?= $val; ?>},
							    			<?php endforeach; ?>
						    			]
						    		},
						    		// {
					    			// 	name: 'بازدید زیرمجموعه',
					    			// 	data: [
					    			// 		{ x: '05/01/2014', y: 11 }, 	
					    			// 	]
					    			// },
					    			],

							    				xaxis: {
							    					type:'datetime',
							    					labels: {
							    						formatter: function (value, timestamp) {
							    							return new Date(timestamp).getDate();
							    						}, 
							    						style: {
							    							colors: [],
							    							fontSize: '12px',
							    							fontFamily: 'Vazir-FD',
							    							cssClass: 'apexcharts-xaxis-label',
							    						},
							    					},
							    					axisBorder: {
							    						show: true,
							    						color: '#aaa',
							    						height: 0.3,
							    						width: '100%',
							    						opacity: 1,
							    						offsetX: 0,
							    						offsetY: 0
							    					},
							    				},
							    				colors: ["#2dcaab", "#73eba1", "#ff9c1d"],
							yaxis: {
							show: false,
							    		// labels: {
							    			// formatter: function (value, timestamp) {
							  // return new Date(timestamp).getDate(); // The formatter function overrides format property

							},

							grid: {
								show: false,
							},
							dataLabels: {
								enabled: false,
								offsetX: 0,
								offsetY: -20,
								style: {
									fontSize: '13px',
									fontFamily: 'Vazir-FD',
									colors: ["#000"]
								},
							},
							plotOptions: {

								bar: {
									columnWidth: "66%",
									dataLabels: {
										position: 'top',
									}
								},
								dataLabels: {
									enabled: true,
									dropShadow: {
										enabled: true,
										left: 0,
										top: 0,
										opacity: 0.5
									}
								},
							},
							stroke: {
								show: true,
								curve: 'smooth',
								lineCap: 'butt',
								colors: undefined,
								width: 0,
								dashArray: 0,      
							},
							tooltip: {
								x: {show: false},
								style: {
									fontSize: '13px',
									fontFamily: "Vazir-FD",
								},
							},
							legend: {
								show: true,
								showForSingleSeries: false,
								showForNullSeries: true,
								showForZeroSeries: true,
								position: 'bottom',
								horizontalAlign: 'center', 
								floating: false,
								fontSize: '13px',
								fontFamily: 'Vazir-FD',
								formatter: undefined,
								inverseOrder: false,
								width: undefined,
								height: undefined,
								tooltipHoverFormatter: undefined,
								offsetX: 0,
								offsetY: 0,
								labels: {
									colors: undefined,
									useSeriesColors: false
								},
								markers: {
									width: 12,
									height: 12,
									strokeWidth: 0,
									strokeColor: '#fff',
									fillColors: undefined,
									radius: 4,
									customHTML: undefined,
									onClick: undefined,
									offsetX: 0,
									offsetY: 0
								},
								itemMargin: {
									horizontal: 20,
									vertical: 5
								},
								onItemClick: {
									toggleDataSeries: true
								},
								onItemHover: {
									highlightDataSeries: true
								},
							}
							}
							var chart = new ApexCharts(document.querySelector("#chart"), options);
							chart.render();
							</script>
						</div>
					</div>
				</div>

				<div class="container-fluid">
					<!-- Messages -->
					<div class="row px-0 mt-2 justify-content-center dashboard-stats text-center">
						<div class="col-md-4 col-sm-12 col-xs-12 mb-2 m-0 px-1">
							<div class="text-black bg-white shadow-sm text-left px-4 py-2 rounded">
								<h6 class="font-weight-bold my-0 py-2"><i class="fas fa-bolt
									fa-lg pr-2"></i>دسترسی سریع</h6>
									<div class="btn-group-vertical mt-3  w-100" role="group" aria-label="Basic example">
										<a href="{base_url}pages/earning" class="btn text-secondary text-left px-3 py-2"><i class="fas fa-hand-holding-usd mr-2"></i>کسب درآمد</a>
										<a href="{base_url}dashboard/links" class="btn text-secondary text-left px-3 py-2"><i class="fas fa-list-ul mr-2"></i>فهرست لینک ها</a>
										<a href="{base_url}dashboard/shortlink" class="btn text-secondary text-left px-3 py-2"><i class="fas fa-layer-group mr-2"></i>کوتاه کردن گروهی لینک ها</a>
										<a href="{base_url}dashboard/profile" class="btn text-secondary text-left px-3 py-2"><i class="fas fa-user-cog mr-2"></i>ویرایش اطلاعات کاربری</a>

									</div>
									<a href="{base_url}dashboard/logout" class="btn btn-danger text-left px-3 py-1 w-100"><i class="fas fa-sign-out-alt mr-2"></i>خروج</a>
							</div>
						</div>

						<div class="col-md-4 col-sm-12 col-xs-12 mb-2 m-0 px-1">
							<div class="text-white bg-dark shadow-sm text-left px-3 py-2 rounded">
								<h6 class="font-weight-bold my-0 py-2"><i class="fas fa-newspaper fa-lg font-weight-normal pr-2"></i>آخرین اخبار</h6>
								<div class="table-responsive">
									<table class="table table-lg table-dark rounded mt-2 table-borderless table-hover">
										<thead>
											<tr>
												<th scope="col" class="font-weight-bold">عنوان</th>
												<th scope="col" class="font-weight-bold">تاریخ</th>
											</tr>
										</thead>
										<tbody>
											{news}
											<tr>
												<th scope="row" class="font-weight-normal"><a class="text-white" href="<?=base_url()?>dashboard/news/{id}">{title}</a></th>
												<td>{created_at}</td>
											</tr>
											{/news}
										</tbody>
									</table>
								</div>
							</div>
						</div>

						<div class="col-md-4 col-sm-12 col-xs-12 mb-2 m-0 px-1">
							<div class="text-black bg-white shadow-sm text-left px-3 py-2 rounded">
								<h6 class="font-weight-bold my-0 py-2"><i class="fas fa-envelope fa-lg font-weight-normal pr-2"></i>آخرین پیام ها <a href="#" class="badge display-inline badge-info"><?php if(!empty($notifications)): ?>{notifications}<?php else: ?>0<?php endif; ?></a></h6>
								<div class="table-responsive">
									<table class="table table-lg table-light rounded mt-2 table-borderless table-hover">
										<thead>
											<tr>
												<th scope="col" class="font-weight-bold">عنوان</th>
												<th scope="col" class="font-weight-bold">تاریخ</th>
											</tr>
										</thead>
										<tbody>
											<?php if(!empty($messages)): ?>
											{messages}
											<tr>
												<th scope="row" class="font-weight-normal"><a class="" href="<?=base_url('dashboard/messages/{id}');?>">{title}</a></th>
												<td>{created_at}</td>
											</tr>
											{/messages}
											<?php else: ?>
											<tr>
												<th scope="row" colspan="2" class="text-center font-weight-normal">بدون خبر</th>
											</tr>
												
											<?php endif; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>


					</div>
				</div>


			</div>
{footer}