{header}
{sidebar}

<?php  




$links_dates 	= array();
$texts_dates 	= array();
$texts_u_dates 	= array();
$links_u_dates 	= array();

foreach($month_text_clicks as $data) {
	array_push($texts_dates, $data["created_at"]);
}
foreach($month_link_clicks as $data) {
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

				<!-- Stats -->
				<div class="row mx-1 align-items-center bg-white rounded shadow-sm">
					<div class="col-md-8">
						<div class="p-4">
							<h6 class="font-weight-bold align-middle my-0 py-2 text-muted"><i class="fas fa-chart-bar pr-2 fa-lg font-weight-normal"></i>آمار  کلیک ها</h6>
							<div id="area_chart"></div>
							<script type="text/javascript">
								var options = {
							        chart: {
							            height: 450,
							            type: 'area',
									    offsetY: 39,
									    stacked: true,
									    zoom: {
									      enabled: false
									    },
							        },
							        fill: {
							        	type: 'gradient',
							        	gradient: {
							        		inverseColors: false,
							        		shade: 'light',
							        		type: "vertical",
							        		opacityFrom: 0.9,
							        		opacityTo: 0.6,
							        		stops: [0, 100, 100, 100]
							        	}
							        },
							        dataLabels: {
							            enabled: false
							        },
							        stroke: {
							            curve: 'smooth'
							        },
							        series: [{
							            name: 'متن',

							            data: [
							            	<?php foreach($text_vals as $key => $value): ?>
							            	{ x: '<?= $key; ?>', y: <?= $value; ?>},
							                <?php endforeach; ?>
							            ]
							        }, {
							            name: 'لینک	',
							            data: [
							            	<?php foreach($link_vals as $key => $value): ?>
							            	{ x: '<?= $key; ?>', y: <?= $value; ?>},
							                <?php endforeach; ?>
							            ]
							        }],
							        grid: {
							        	show: false,
							        	padding: {
							        		left: 0,
							        		right: 0
							        	}
							        },
							        yaxis: {
										show: false,
									},
									legend: {
										show: true,
										showForSingleSeries: false,
										showForNullSeries: true,
										showForZeroSeries: true,
										position: 'top',
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
									},
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
							        // xaxis: {
							        //     type: 'datetime',
							        //     categories: ["2018-09-19T00:00:00", "2018-09-19T01:30:00", "2018-09-19T02:30:00", "2018-09-19T03:30:00", "2018-09-19T04:30:00", "2018-09-19T05:30:00", "2018-09-19T06:30:00"],                
							        // },
									tooltip: {
										x: {show: false},
										style: {
											fontSize: '13px',
											fontFamily: "Vazir-FD",
										},
									},
								}
								var chart = new ApexCharts(
									document.querySelector("#area_chart"),
									options
								);
							    chart.render();
							</script>
						</div>
					</div>

					<div class="col-md-4">
						<div class="p-4">
							<h6 class="font-weight-bold align-middle my-0 py-2 text-muted"><i class="fas fa-chart-bar pr-2 fa-lg font-weight-normal"></i>رادار </h6>
							<div id="radar_chart"></div>
							<script type="text/javascript">
							    var options = {
							        chart: {
							            height: 350,
							            type: 'radar',
							        },
							        series: [{
							            name: 'مقدار',
							            data: [{count_user}, {count_click}, {count_link}, {count_text}, {count_transaction}],
							        }],
							        labels: ['کاربران', 'کلیک ها', 'لینک ها', 'متن ها', 'تراکنش ها',],
									dataLabels: {
										style: {
											fontSize: '13px',
											fontFamily: 'Vazir-FD',
											colors: ["#222"]
										},
									},
							        plotOptions: {
							            radar: {
							                size: 140,
							                polygons: {
							                    strokeColor: '#e9e9e9',
							                    fill: {
							                        colors: ['#f8f8f8', '#fff']
							                    }
							                }
							            }
							        },
							        colors: ['#FF4560'],
							        markers: {
							            size: 4,
							            colors: ['#fff'],
							            strokeColor: '#FF4560',
							            strokeWidth: 2,
							        },
							        tooltip: {
							            y: {
							                formatter: function(val) {
							                    return val
							                }   
							            },
										style: {
											colors: [],
											fontSize: '12px',
											fontFamily: 'Vazir-FD',
											cssClass: 'apexcharts-xaxis-label',
										},
							        },
							        yaxis: {
							            tickAmount: 7,
							            labels: {
							                formatter: function(val, i) {
							                    if(i % 2 === 0) {
							                        return val
							                    } else {
							                        return ''
							                    }
							                },
				    						style: {
				    							colors: [],
				    							fontFamily: 'Vazir-FD',
				    							cssClass: 'apexcharts-xaxis-label',
				    						},
							            },
							        },
							    }
							    var chart = new ApexCharts(
							        document.querySelector("#radar_chart"),
							        options
							    );
							    chart.render();
							</script>
							<small class="text-muted font-weight-bold">-- رادار حاوی کل اطلاعات  می باشد</small>
						</div>
					</div>
				</div>
{footer}