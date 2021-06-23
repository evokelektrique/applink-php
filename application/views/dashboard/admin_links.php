{header}
{sidebar}

<!-- Content -->
<div class="col-md-10 bg-transparent py-4 admin-stats" id="content">

	<div class="row px-4 py-4 align-items-center text-muted">
		<i class="fas fa-th-large fa-lg"></i>
		<h5 class="m-0 px-2 font-weight-bold">مدیریت</h5>
	</div>

	<div class="d-flex mx-1	">
		<div class="col-3 pl-0 align-items-center bg-transparent">
			<ul class="list-group shadow-sm">
				<li class="list-group-item d-flex justify-content-between align-items-center">
					کلیک های امروز
					<span class="badge badge-primary badge-pill">{total_clicks_today}</span>
				</li>
				<li class="list-group-item d-flex justify-content-between align-items-center">
					کلیک های دیروز
					<span class="badge badge-primary badge-pill">{total_clicks_yesterday}</span>
				</li>
				<li class="list-group-item d-flex justify-content-between align-items-center">
					کلیک های این ماه
					<span class="badge badge-primary badge-pill">{clicks_last_month}</span>
				</li>
				<li class="list-group-item d-flex justify-content-between align-items-center">
					نسبت به دیروز
					<span class="badge badge-primary badge-pill">%{from_yesterday_percentage}</span>
				</li>
			</ul>					
		</div>

		<div class="col-9 align-items-center bg-white rounded shadow-sm">

			<div class="table-responsive pb-2">

				<table data-order='[[ 0, "desc" ]]' id="list_table" class="table">
					<thead>
						<tr>
							<th><i class="mr-2 fas fa-hashtag"></i></th>
							<th><i class="mr-2 fas fa-external-link-alt"></i>آدرس اصلی</th>
							<th><i class="mr-2 fas fa-link"></i>آدرس کوتاه شده</th>
							<th><i class="mr-2 fas fa-mouse-pointer"></i>کلیک</th>
							<th><i class="mr-2 fas fa-calendar"></i>تاریخ ایجاد</th>
							<th><i class="mr-2 fas fa-tools"></i>عملیات</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($links as $link): ?>
						<tr>
							<td><?=$link['id']?></td>
							<td dir="ltr" class="text-right align-middle"><a href="<?=$link['address']?>" class="d-block"><?=$link['address']?></a></td>
							<td dir="ltr" class="text-right align-middle"><a href="<?=$link['short']?>" class="btn btn-sm btn-success shadow"><?=$link['short']?></a>
							</td>
							<!-- Chart -->
							<td class="text-center">
							<?php if(is_array($link['clicks'])): ?>
								<?=count($link['clicks']);?>
							<?php else: ?>
							0
							<?php endif; ?>
							</td>
							<td class="text-center align-middle"><?=$link['created_at']?></td>
							<td class="text-center align-middle">
								<div class="d-flex">
									<div class="btn-group btn-group-sm col" role="group" aria-label="Basic example">
										<a href="<?=base_url('dashboard')?>/admin/links/edit/<?=$link['raw_id']?>" class="btn btn-outline-secondary"><i class="fas fa-cog align-middle"></i></a>

										<button data-href="<?=base_url('dashboard')?>/links/qrcode/<?=$link['qrcode']?>" type="button" class="btn btn-outline-info openqr"><i class="fas fa-qrcode align-middle"></i></button>

										<a href="<?=base_url('dashboard')?>/admin/links/delete/<?=$link['raw_id']?>" class="btn btn-outline-danger"><i class="fas fa-trash align-middle"></i></a>
									</div>
								</div>
							</td>
						</tr>
						<?php endforeach; ?>

					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>
{footer}