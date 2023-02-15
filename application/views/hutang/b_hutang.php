<div class="card">
	<div class="card-body">
		<form action="<?= site_url('hutang/do_pembayaran') ?>" method="POST" id="pembayaranH">
			<div class="row">
				<div class="col-md-6">
					<label class="">Pemasok: <b class="text-danger">*</b></label>
					<div class="input-group">
						<input type="text" class="form-control Pemasok col-3" name="pemasok" value="" placeholder="Kode Pemasok" readonly required>
						<input type="text" class="form-control d_Pemasok col-9 ml-1 mr-1" placeholder="Nama Pemasok" name="n_pemasok" value="" required readonly>
						<div class="input-group-append">
							<a href="#myModalPemasok" data-toggle="modal">
								<button class="btn btn-success" type="button"><i class="fa fa-search"></i></button>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<label class="">Tanggal: <b class="text-danger">*</b></label>
					<div class="input-group">
						<input type="text" class="form-control" name="tgl_transaksi" value="<?= date("Y-m-d") ?>" readonly required>
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-calendar"></i></span>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="table-responsive" style="overflow-y: scroll; height: 200px;">
						<table class="table">
							<thead class="bg-white" style="position: sticky; top: 0; display:block; z-index:2;">
								<tr>
									<th style="width:10%;">Kode</th>
									<th style="width:10%;">Tanggal</th>
									<th style="width:10%;">Keterangan</th>
									<th style="width:10%;">Jumlah hutang</th>
									<th style="width:10%;">Jumlah bayar</th>
									<th style="width:10%;">Sisa Hutang</th>
								</tr>
							</thead>
							<tbody id="list_hutang" style="display:block;">
							</tbody>
						</table>
						<input type="hidden" name="j_hutang" id="sumJ_hutang" value="0">
					</div>
				</div>
				<hr class="border">
				<div class="col-sm-12 col-md-12">
					<div class=" form-group">
						<label>Catatan transaksi <b class="text-danger">*</b></label>
						<textarea name="keterangan" class="form-control" id="keterangan" placeholder="Catatan transaksi" rows="2"></textarea>
					</div>
					<div class="row">
						<div class="col-md-6"></div>
						<div class="col-md-2">
							<label class=""><b>Total Hutang</b></label>
							<input type="text" class="form-control text-right border-0" style="font-size:16px;" name="total_hutang" value="0" id="totalH" readonly>
						</div>
						<div class="col-md-2">
							<label class=""><b>Total Bayar</b></label>
							<input type="text" class="form-control text-right border-0 bg-danger text-light" style="font-size:16px;" id="totalJ_bayar" name="sum_bayar" value="0" readonly>
						</div>
						<div class="col-md-2">
							<label class=""><b>Sisa Hutang</b></label>
							<input type="text" class="form-control text-right border-0" style="font-size:16px;" name="sisa_hutang" value="0" id="totalS_hutang" readonly>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6">
					<label class="text-left control-label col-form-label p-0 m-0">Cara Bayar <b class="text-danger">*</b></label>
					<div class="input-group">
						<div class="btn-group justify-content-md-center" role="group" aria-label="Basic example">
							<button type="button" class="btn btn-success" id="c_kas" value="kas">KAS</button>
							<a href="#myModalBank" data-toggle="modal">
								<button type="button" class="btn btn-default" id="c_bank" value="bank">BANK</button>
							</a>
							<input type="text" class="form-control form-control-sm bank" id="d_Bank" name="no_bank" value="" readonly>
						</div>
					</div>
					<input type="hidden" name="c_bayar" id="c_bayar" value="kas">
					<input type="hidden" name="akun_bank" id="d_akunBank" value="kas">
				</div>
				<div class="col-sm-6 col-md-6">
					<div class="input-group mt-3">
						<button type="button" class="btn btn-success btn-md col-8 ml-auto p-2" id="save" value="SIMPAN & CETAK"><i class="fa fa-save"></i> SIMPAN & CETAK</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<div id="myModalPemasok" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Pilih Pemasok</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table id="lookup" class="table lookup" width="100%">
						<thead class="thead-dark">
							<tr>
								<th>Nomor</th>
								<th>Nama Pemasok</th>
								<th>Pilih</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 0;
							foreach ($d_pemasok as $key => $value) { ?>
								<tr>
									<td><?= $value->n_pemasok ?></td>
									<td><?= $value->nama ?></td>
									<input type="hidden" class="no_pemasok<?= $no ?>" value="<?= $value->n_pemasok ?>">
									<input type="hidden" class="nama_pemasok<?= $no ?>" value="<?= $value->nama ?>">
									<input type="hidden" class="batas_kredit<?= $no ?>" value="<?= $value->batas ?>">
									<td align="center">
										<button type="button" class="btn btn-xs btn-success chs chs_pemasok<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i>
										</button>
									</td>
								</tr>
							<?php $no++;
							} ?>
							<input type="hidden" class="sum_pemasok" value="<?= $no ?>">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="myModalBank" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Pilih Bank</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<div class="table-responsive">
					<table id="lookup" class="table lookup" width="100%">
						<thead class="thead-dark">
							<tr>
								<th>Nomor</th>
								<th>Nama Bank</th>
								<th>Pilih</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 0;
							foreach ($d_bank as $key => $value) { ?>
								<tr>
									<td><?= $value->n_bank ?></td>
									<td><?= $value->nama ?></td>
									<input type="hidden" class="no_bank<?= $no ?>" value="<?= $value->n_bank ?>">
									<input type="hidden" class="nama_bank<?= $no ?>" value="<?= $value->nama ?>">
									<input type="hidden" class="akun_bank<?= $no ?>" value="<?= $value->akun ?>">
									<td align="center">
										<button type="button" class="btn btn-xs btn-success chsBnk chs_bank<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></button>
									</td>
								</tr>
							<?php $no++;
							} ?>
							<input type="hidden" class="sum_bank" value="<?= $no ?>">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('template/bundle/template_scripts'); ?>