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
 -->
      <div class="card noborder bg-white rounded shadow-sm">
        <div class="card-header bg-white font-weight-bold"><i class="align-middle fas fa-user-cog mr-2"></i>ویرایش تنظیمات و اطلاعات کاربری</div>
        <div class="card-body text-secondary p-4">
          <div class="alert alert-warning border-warning" role="alert">
            <strong class="d-block pb-2">هشدار: </strong>
            حساب بانکی باید به نام خود شما باشد، در غیر اینصورت تسویه حساب انجام نخواهد شد. <br>
            در صورتی که نمیدانید شبا چیست و یا شبای حساب خود را چگونه میتوانید دریافت کنید، <a href="#" class="alert-link">اینجا</a> کلیک کنید. <br>
            در صورت لزوم میتوانید شبای حساب خود را بعدا وارد نمایید.
          </div>
          <?php if($this->session->flashdata('success') == 'ok'): ?>
          <div class="alert alert-success border-success" role="alert">
            تغییرات با موفقیت انجام شد.
          </div>
          <?php endif; ?>
          <?php if($this->session->flashdata('danger') == 'bad'): ?>
          <div class="alert alert-danger border-danger" role="alert">
            مشکل در ثبت تغییرات.
          </div>
          <?php endif; ?>

          <form method="post" action="{base_url}dashboard/profile/validate">
            <?php $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>
            <?php $errors = $this->form_validation->error_array(); ?>
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
            {user}
            <div class="form-row">
              <div class="col-md-12">
                <div class="input-group mb-4 col-md-12 mx-auto px-0">
                  <div class="input-group-prepend">
                    <div class="input-group-text" style="min-width: 140px">ایمیل</div>
                  </div>
                  <input type="text" name="email" value="{email}" disabled class="form-control" placeholder="ایمیل">
                  <div class="invalid-feedback order-last ">
                    نامعتبر
                  </div>
                  <div class="input-group-append">
                    <div class="input-group-text" style="font-family: roboto;"><i class="fas fa-at"></i></div>
                  </div>
                </div>
                <small class="form-text text-muted d-block mb-2" style="clear: both;">
                  <span class="badge badge-warning border border-dark font-weight-normal mr-1" style="font-size: 11px;">نکته</span> نام و نام خانوادگی فارسی و کامل صاحب حساب(در صورت ارسال نام به انگلیسی یا بصورت ناقص ، پرداخت با مشکل روبرو خواهد شد)
                </small>
                <div class="input-group mb-4 col-md-12 mx-auto px-0">
                  <div class="input-group-prepend">
                    <div class="input-group-text" style="min-width: 140px">نام و نام خانوادگی</div>
                  </div>
                  <input type="text" name="name" value="{name}" class="<?php echo(array_key_exists('name', $errors))?'is-invalid':''; ?> form-control" placeholder="نام و نام خانوادگی *">
                  <div class="invalid-feedback order-last ">
                    نامعتبر
                  </div>
                  <div class="input-group-append">
                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                  </div>
                </div>

                <small class="form-text text-muted d-block mb-2" style="clear: both;">
                  <span class="badge badge-info border border-primary font-weight-normal mr-1" style="font-size: 11px;">مثال</span>09101234567
                </small>
                <div class="input-group mb-4 col-md-12 mx-auto px-0">
                  <div class="input-group-prepend">
                    <div class="input-group-text" style="min-width: 140px">تلفن همراه</div>
                  </div>
                  <input type="text" name="phone" value="{phone}" class="<?php echo(array_key_exists('phone', $errors))?'is-invalid':''; ?> form-control" placeholder="تلفن همراه *">
                  <div class="invalid-feedback order-last ">
                    نامعتبر
                  </div>
                  <div class="input-group-append">
                    <div class="input-group-text"><i class="fas fa-mobile-alt"></i></div>
                  </div>
                </div>

                <small class="form-text text-muted d-block mb-2" style="clear: both;">
                  <span class="badge badge-info border border-primary font-weight-normal mr-1" style="font-size: 11px;">مثال</span><span class="roboto">IR01 1234 5678 0123 4567 8901 23</span>
                </small>
                <div class="input-group mb-4 col-md-12 mx-auto px-0">
                  <div class="input-group-prepend">
                    <div class="input-group-text" style="min-width: 140px">شماره حساب بانکی</div>
                  </div>
                  <input dir="ltr" type="text" name="bankaddress" value="{bankaddress}" style="font-family: roboto;" class=" <?php echo(array_key_exists('bankaddress', $errors))?'is-invalid':''; ?> form-control text-right">
                  <div class="invalid-feedback order-last ">
                    نامعتبر
                  </div>
                  <div class="input-group-append">
                    <div class="input-group-text roboto">IR</div>
                  </div>
                </div>
                <button type="submit" class="btn shadow-sm btn-success">ثبت تغییرات</button>
              </div>
            </div>
            {/user}
          </form>
        </div>

      </div>
    </div>
  </div>

</div>
{footer}
