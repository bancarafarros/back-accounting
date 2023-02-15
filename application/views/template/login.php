<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" type="image/png" sizes="16x16"  href="<?php echo base_url('public/sajada-logo-teal.png') ?>">
	<title><?= APP_NAME . ' ' . INSTANSI_NAME ?> &mdash; <?= (!empty($judul_title) ? $judul_title : 'index') ?></title>
	<!-- Core css -->
	<link href="<?= base_url('public/enlink') ?>/assets/css/app.css" rel="stylesheet">
	<!-- Core Vendors JS -->
	<script src="<?= base_url('public/enlink') ?>/assets/js/vendors.min.js"></script>
	<!-- Core JS -->
	<script src="<?= base_url('public/enlink') ?>/assets/js/app.min.js"></script>
</head>

<body>
	<div class="app">
		{CONTENT}
	</div>
</body>

</html>