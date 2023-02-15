<div class="container-fluid p-0 h-100">
	<div class="row no-gutters h-100 full-height">
		<div class="col-lg-6 d-none d-lg-flex bg" style="background-image:url('<?= base_url('public') ?>/Login.png')">
			<div class="d-flex h-100 p-h-40 p-v-15 flex-column justify-content-between">
				<a href="<?= site_url() ?>">
					<div>
						<img style="max-width: 50px;" class="img-fluid" src="<?= base_url('public') ?>/sajada-white.png" alt="logo-sajada">
					</div>
				</a>
				<!-- <div>
					<h1 class="text-white m-b-20 font-weight-bold"><?= APP_NAME . '<br>' . INSTANSI_NAME  ?></h1>
					<p class="text-white font-size-16 lh-2 w-80 opacity-09">Climb leg rub face on everything give attitude nap all day for under the bed. Chase mice attack feet but rub face on everything hopped up.</p>
				</div> -->
				<div class="d-flex justify-content-between">
					<span class="text-white">&copy; 2022 - <?= date('Y') ?> &mdash; <a href="<?= site_url() ?>" class="text-white"><?= APP_NAME?> <?= INSTANSI_NAME?></a></span>
				</div>
			</div>
		</div>
		<div class="col-lg-6 bg-white">
			<div class="container h-75">
				<div class="row no-gutters h-100 align-items-center">
					<div class="col-md-8 col-lg-7 col-xl-6 mx-auto">
						<?php if (isset($successMessage)) : ?>
							<div class="alert alert-danger">
								<?= $successMessage ?>
							</div>
						<?php elseif (isset($errorMessage)) : ?>
							<div class="alert alert-danger">
								<?= $errorMessage ?>
							</div>
						<?php endif; ?>
						<h2>Login</h2>
						<p class="m-b-30">Silahkan login ke dashboard Anda.</p>
						<form action="<?= site_url() ?>" id="login-form" class="form-horizontal m-t-20" method="post">
							<div class="form-group">
								<label class="font-weight-semibold" for="username">Username:</label>
								<div class="input-affix">
									<i class="prefix-icon anticon anticon-user"></i>
									<input type="text" class="form-control" name="username" id="username" placeholder="Username" autofocus>
								</div>
							</div>
							<div class="form-group">
								<label class="font-weight-semibold" for="password">Password:</label>
								<div class="input-affix m-b-10">
									<i class="prefix-icon anticon anticon-lock"></i>
									<input type="password" name="password" class="form-control" id="password" placeholder="Password">
								</div>
							</div>
							<div class="form-group">
								<div class="row d-flex justify-content-around align-items-center">
									<div id="container-captcha"></div>
									<button class="btn rounded-sm py-2 px-4 text-light" style="background-color: #008080!important;" type="button" onclick="loadCaptcha()"><i class="fas fa-sync"></i></button>
								</div>
							</div>
							<div class="form-group">
								<input class="form-control" type="number" name="captcha" placeholder="Masukkan Captcha" required>
							</div>
							<div class="form-group">
								<div class="d-flex align-items-center justify-content-between">
									<button type="submit" name="btn-login" value="login" class=" btn text-light" style="background-color: #008080!important;"><i class="anticon anticon-login "></i> Login</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var site_url = '<?php echo site_url() ?>';
	$(function() {
		loadCaptcha();
	})

	function loadCaptcha() {
		$.ajax({
			type: 'ajax',
			url: site_url + '/index/fetchCaptha',
			dataType: 'json',
			success: function(response) {
				$('#container-captcha').html(response.data);
			},
			error: function(xmlresponse) {
				console.log(xmlresponse);
			},
		});
	}
</script>