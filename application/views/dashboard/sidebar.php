

		<div class="row justify-content-start h-100 dashboard">
			<!-- Sidebar -->
			<div class="col-md-2 menu d-flex flex-direction-column bg-white p-0 shadow-sm position-relative">

				<ul id="menu" class="accordion pb-5 mb-5">
					<?php if($this->session->userdata('admin')): ?>
					<li>
						<div class="collapsed" data-toggle="collapse" href="#menu-admin">
							<a class="menu-header-item d-flex">
								<div class="col-md-10">
									<i class="fas fa-bars pr-2"></i>
									مدیریت
								</div>
								<div class="col">
									<i class="fas fa-caret-down"></i>
								</div>
							</a>
						</div>
						<div id="menu-admin" class="collapse" data-parent="#menu-admin" >
							<div class="submenu">
								<a data-bjax href="<?=base_url('dashboard')?>/admin/stats"><i class="fas fa-cog mr-2"></i>آمار و اطلاعات</a>
								<a data-bjax href="<?=base_url('dashboard')?>/admin/transactions"><i class="fas fa-cog mr-2"></i>پرداختی ها</a>
								<a data-bjax href="<?=base_url('dashboard')?>/admin/links"><i class="fas fa-cog mr-2"></i>لینک ها</a>
								<a data-bjax href="<?=base_url('dashboard')?>/admin/texts"><i class="fas fa-cog mr-2"></i>متن ها</a>
								<a data-bjax href="<?=base_url('dashboard')?>/admin/news"><i class="fas fa-cog mr-2"></i>اخبار</a>
								<a data-bjax href="<?=base_url('dashboard')?>/admin/message"><i class="fas fa-cog mr-2"></i>پیام ها</a>
								<a data-bjax href="<?=base_url('dashboard')?>/admin/users"><i class="fas fa-cog mr-2"></i>کاربران</a>
								<a data-bjax href="<?=base_url('dashboard')?>/admin/settings"><i class="fas fa-cog mr-2"></i>تنظیمات</a>
							</div>
						</div>
					</li>
					<?php endif; ?>
					<li>
						<a data-bjax href="<?=base_url('dashboard')?>" class="menu-header-item d-flex">
							<div class="col-md-10">
							<i class="fas fa-home pr-2"></i>
							داشبورد
							</div>
						</a>

					</li>
					<li>
						<div class="collapsed" data-toggle="collapse" href="#menu-1">
							<a class="menu-header-item d-flex">
								<div class="col-md-10">
									<i class="fas fa-link pr-2"></i>
									لینک کوتاه
								</div>
								<div class="col">
									<i class="fas fa-caret-down"></i>
								</div>
							</a>
						</div>
						<div id="menu-1" class="collapse" data-parent="#menu-1" >
							<div class="submenu">
								<a data-bjax href="<?=base_url('dashboard')?>/shortlink">کوتاه کردن لینک</a>
								<a data-bjax href="<?=base_url('dashboard')?>/links">فهرست لینک های شما</a>
							</div>
						</div>
					</li>
					<li>
						<div class="collapsed" data-toggle="collapse" href="#menu-2">
							<a class="menu-header-item d-flex">
								<div class="col-md-10">
									<i class="fas fa-text-width pr-2"></i>
									متن کوتاه
								</div>
								<div class="col">
									<i class="fas fa-caret-down"></i>

								</div>
							</a>
						</div>
						<div id="menu-2" class="collapse" data-parent="#menu-2" >
							<div class="submenu">
								<a data-bjax href="<?=base_url('dashboard')?>/shorttext">کوتاه کردن متن</a>
								<a data-bjax href="<?=base_url('dashboard')?>/texts">فهرست متن های شما</a>
							</div>
						</div>
					</li>
					<li>
						<div class="collapsed" data-toggle="collapse" href="#menu-3">
							<a class="menu-header-item d-flex">
								<div class="col-md-10">
									<i class="fas fa-money-check-alt pr-2"></i>
									امور مالی
								</div>
								<div class="col">
									<i class="fas fa-caret-down"></i>

								</div>
							</a>
						</div>
						<div id="menu-3" class="collapse" data-parent="#menu-3" >
							<div class="submenu">
								<a data-bjax href="<?=base_url('dashboard')?>/withdraw">درخواست واریز</a>
								<a data-bjax href="<?=base_url('dashboard')?>/withdraw/list">تراکنش های مالی</a>
							</div>
						</div>
					</li>
					<li>
						<div class="collapsed" data-toggle="collapse" href="#menu-4">
							<a class="menu-header-item d-flex">
								<div class="col-md-10">
									<i class="fas fa-users pr-2"></i>
									زیر مجموعه ها
								</div>
								<div class="col">
									<i class="fas fa-caret-down"></i>

								</div>
							</a>
						</div>
						<div id="menu-4" class="collapse" data-parent="#menu-4" >
							<div class="submenu">
								<a href="#">زیرمجموعه های شما</a>
								<a href="#">جذب زیرمجموعه</a>
							</div>
						</div>
					</li>
					<li>
						<div class="collapsed" data-toggle="collapse" href="#menu-5">
							<a class="menu-header-item d-flex">
								<div class="col-md-10">
									<i class="fas fa-user pr-2"></i>
									پروفایل
								</div>
								<div class="col">
									<i class="fas fa-caret-down"></i>
								</div>
							</a>
						</div>
						<div id="menu-5" class="collapse" data-parent="#menu-5" >
							<div class="submenu">
								<a data-bjax href="<?=base_url('dashboard')?>/profile">ویرایش اطلاعات کاربری</a>
								<a data-bjax href="<?=base_url('dashboard')?>/profile/change_password">تغییر کلمه عبور</a>
								<a data-bjax href="<?=base_url('dashboard')?>/logout">خروج</a>
							</div>
						</div>
					</li>
				</ul>
				<div class="col align-self-end copyright text-center">
					<small class="text-muted">&copy;&nbsp;تمامی حقوق  کپی رایت محفوظ می باشد</small>
					<a href="https://t.me/evoke" class="btn btn-sm btn-light w-100 mt-2">طراحی و توسعه توسط EVOKE@</a>
				</div>
			</div>
