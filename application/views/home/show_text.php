{header}

	<div class="container mt-5 py-5">

		<!-- Landing /Start -->
		<div class="row">
			<div class="col-md-12 col-sm-12">
				<blockquote class="blockquote text-center py-5" id="landing-start">
					<h2 class="align-middle font-weight-bold">
						{text}{title}{/text}
					</h2>
				</blockquote>
				<!-- ads --><!-- 
				<a href="#" title="تبلیغ"><img src="{base_url}src/images/tabligh.png" width="100%" class="mb-5"></a> -->
<?php if($text[0]['private_status'] == 1): ?>
	<?php if($this->session->flashdata('password_confirmed_true')): ?>
				<div class="justify-content-center mb-5">
					<div class="text_box p-3 border rounded shadow-sm <?=($text[0]['text_mode'] == 'code')?'text_box_code':'';?>">
						<?php if($text[0]['text_mode'] == 'code'): ?>
							<?php 
								$i = 1;
								foreach(preg_split("/((\r?\n)|(\r\n?))/", $text[0]['text']) as $line){
								    echo "<span class='text_box_code_line_numbers'>$i</span>"."<span class='text_box_code_line_codes'>$line</span>".'<br>';
									$i++;
								} 
							?>
						<?php else: ?>
							<?php echo(nl2br($text[0]['text'])); ?>
						<?php endif; ?>
					</div>
				</div>
	<?php endif; ?>
<?php else: ?>
	<?php if(empty($this->session->flashdata('pay_status'))): ?>
		<?php if($text[0]['type'] == 'ptc'): ?>
		<div class="progress mb-4" id="progressbar" style="height: 30px">
			<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" id="timer_progressbar" role="progressbar" style="width:0%">
			<p class="text-center font-weight-bold text-white mt-2 h5">لطفا صبر کنید</p>
			</div>
		</div>
		<form method="post" action="{base_url}redirect/validate/<?=$info[0]['short']?>" class="row">
			<?php
			$csrf = array(
		        'name' => $this->security->get_csrf_token_name(),
		        'hash' => $this->security->get_csrf_hash()
			);
			?>
			<?php $errors = $this->form_validation->error_array(); ?>
			<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
			<div class="col-md-2"><span class="border border-secondary d-inline-block rounded overflow-hidden shadow-sm">{captcha}</span></div>
			<div class="input-group mb-3 col">
			<input type="text" id="captcha" name="captcha" class="form-control <?php echo(array_key_exists('captcha', $errors))?'is-invalid':''; ?>" placeholder="کد امنیتی را وارد کنید" aria-label="کد امنیتی را وارد کنید" aria-describedby="<?=$info[0]['button']?>">
			<div class="input-group-append">
				<button id="submit" type="submit" class="btn btn-outline-success" type="button" id="<?=$info[0]['button'];?>"><?=$info[0]['button'];?></button>
				</div>
			</div>
		</form>
		<?php else: ?>
		<div class="justify-content-center mb-5">
			<div class="text_box p-3 border rounded shadow-sm <?=($text[0]['text_mode'] == 'code')?'text_box_code':'';?>">
				<?php if($text[0]['text_mode'] == 'code'): ?>
					<?php 
						$i = 1;
						foreach(preg_split("/((\r?\n)|(\r\n?))/", $text[0]['text']) as $line){
						    echo "<span class='text_box_code_line_numbers'>$i</span>"."<span class='text_box_code_line_codes'>$line</span>".'<br>';
							$i++;
						} 
					?>
				<?php else: ?>
					<?php echo(nl2br($text[0]['text'])); ?>
				<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>
	<?php else: ?>
	<div class="justify-content-center mb-5">
		<div class="text_box p-3 border rounded shadow-sm <?=($text[0]['text_mode'] == 'code')?'text_box_code':'';?>">
			<?php if($text[0]['text_mode'] == 'code'): ?>
				<?php 
					$i = 1;
					foreach(preg_split("/((\r?\n)|(\r\n?))/", $text[0]['text']) as $line){
					    echo "<span class='text_box_code_line_numbers'>$i</span>"."<span class='text_box_code_line_codes'>$line</span>".'<br>';
						$i++;
					} 
				?>
			<?php else: ?>
				<?php echo(nl2br($text[0]['text'])); ?>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>
<?php endif; ?>

<?php if($text[0]['private_status'] == 1): ?>
	<?php if(!$this->session->flashdata('password_confirmed_true')): ?>
				<div class="justify-content-center text-center mb-4">

					<form method="post" action="{base_url}redirect/validate_password/<?=$info[0]['short']?>" class="row">
						<?php
						$csrf = array(
					        'name' => $this->security->get_csrf_token_name(),
					        'hash' => $this->security->get_csrf_hash()
						);
						?>
						<?php $errors = $this->form_validation->error_array(); ?>
						<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
						<div class="input-group mb-3 col">
						<input type="password" id="password" name="password" class="form-control <?php echo(array_key_exists('password', $errors))?'is-invalid':''; ?>" placeholder="برای <?=$info[0]['button']?> رمز عبور را وارد کنید" aria-label="برای <?=$info[0]['button']?> رمز عبور را وارد کنید" aria-describedby="<?=$info[0]['button']?>">
						<div class="input-group-append">
							<button id="submit" type="submit" class="btn btn-outline-success" type="button" id="<?=$info[0]['button'];?>"><?=$info[0]['button'];?></button>
							</div>
						</div>
					</form>
					<div class="text-danger"><?= form_error('password'); ?></div>
					<?php if($this->session->flashdata('warning')):?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<?= $this->session->flashdata('warning'); ?>
					<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					</div>
					<?php endif; ?>
				</div>
	<?php endif; ?>
<?php endif; ?>

			</div>
		</div>


		
	</div>
	<script type="text/javascript">
		document.getElementById("captcha").disabled = true;
		document.getElementById("submit").disabled = true;
		var timeleft = 10;
		var timer = setInterval(function(){
			document.getElementById("timer_progressbar").style.width = 10 + timeleft + "%";
			timeleft += 10;
			if(timeleft >= 100){
				clearInterval(timer);
				document.getElementById("captcha").disabled = false;
				document.getElementById("submit").disabled = false;
				document.getElementById("progressbar").style.display = "none";
			}
		}, 1000);
	</script>
{footer}