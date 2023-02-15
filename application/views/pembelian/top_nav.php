<div class="card card-hover pt-3 pb-3 mt-0 mb-2">
	<div class="col-md-12">
		<div class="float-right">
			<?php if ($judul_title == 'Transaksi Pembelian') : ?>
				<a href="<?= site_url('pembelian') ?>" class="btn btn-primary">Transaksi Pembelian</a>
				<a href="<?= site_url('pembelian/ret_beli') ?>" class="btn btn-outline-danger">Retur Pembelian</a>
			<?php endif; ?>
			<?php if ($judul_title == 'Transaksi Retur Pembelian') : ?>
				<a href="<?= site_url('pembelian') ?>" class="btn btn-outline-primary">Transaksi Pembelian</a>
				<a href="<?= site_url('pembelian/ret_beli') ?>" class="btn btn-danger">Retur Pembelian</a>
			<?php endif; ?>
		</div>
	</div>
</div>