<div class="container">
	<form method="POST" id="formKasbank" action="<?= site_url('kasbank/dosave') ?>" target="_blank">
		<div class="row mt-4">
			<div class="col-md-3">
				<div class="row">
					<div class="card col-md-12 p-0">
						<h5 class="text-white bg-success p-2">INFORMASI</h5>
						<div class="card-body shadow" style="padding-top: 0px;">
							<input type="hidden" class="form-control col-md-12" id="n_transaksi" value="<?= $n_kasmasuk ?>" name="n_transaksi" onkeypress="return false;">
							<div class="row mt-2">
								<label for="tgl_transaksi" class="col-sm-12 text-left control-label col-form-label">Tanggal <b class="text-danger">*</b></label>
							</div>
							<div class="row">
								<div class="input-group">
									<input type="text" class="form-control col-md-12" name="tgl_transaksi" value="<?= $tanggal ?>" id="tgl_transaksi" readonly>
									<div class="input-group-append">
										<span class="input-group-text"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
							</div>
							<div class="row mt-3">
								<label for="reff" class="col-sm-12 text-left control-label col-form-label">Referensi</label>
							</div>
							<div class="row">
								<input type="text" class="form-control col-md-12" id="reff" value="-" name="reff">
							</div>
							<div class="row mt-2">
								<label for="keterangan" class="col-sm-12 text-left control-label col-form-label">Keterangan <b class="text-danger">*</b></label>
							</div>
							<div class="row">
								<textarea class="form-control" id="keterangan" name="keterangan" placeholder="Catatan keterangan"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="card col-md-12 p-0">
						<h5 class="text-white bg-success p-2 m-0 inf_trans">TRANSAKSI</h5>
						<div class="card-body shadow">
							<div class="row">
								<label class="col-sm-12 text-left control-label col-form-label">Metode Transaksi</label>
							</div>
							<div class="row">
								<div class="input-group col-md-12">
									<div class="btn-group justify-content-md-center" role="group" aria-label="Basic example">
										<button type="button" class="btn btn-xs btn-success" id="kas" value="kas">KAS</button>
										<a href="#myModalBank" data-toggle="modal">
											<button type="button" class="btn btn-xs btn-default" id="bank" value="bank">BANK</button>
										</a>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 justify-content-md-center">
									<input type="text" class="form-control bank" id="d_Bank" name="no_bank" value="" readonly required>
								</div>
							</div>
							<div class="row">
								<label class="col-sm-12 text-left control-label col-form-label">Jenis Transaksi</label>
							</div>
							<div class="row">
								<div class="input-group col-md-12">
									<div class="btn-group justify-content-md-center" role="group" aria-label="Basic example">
										<button type="button" class="btn btn-xs btn-success" id="masuk">MASUK</button>
										<a href="#" data-toggle="modal">
											<button type="button" class="btn btn-xs btn-default" id="keluar">KELUAR</button>
										</a>
									</div>
								</div>
							</div>
							<input type="hidden" id="status" value="M" name="jenis">
							<input type="hidden" id="bayar" value="KAS" name="bayar">
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-9">
				<div class="card">
					<h5 class="card-title m-b-0 p-2 text-light bg-success">DETAIL TRANSAKSI</h5>
					<div class="card-body shadow p-0">
						<div class="row">
							<div class="table-responsive pl-3" style="overflow-y: scroll; height: 375px;">
								<input type="hidden" name="jml_baris" id="jml_baris" value="0">
								<table class="table" id="isi_detail">
									<thead class="thead-dark">
										<tr>
											<th style="width:15%">Akun <b class="text-danger">*</b></th>

											<th style="width:50%">Perkiraan</th>
											<th style="width:25%">Jumlah</th>
											<th>*</th>
										</tr>
									</thead>
									<tbody>
										<tr id="row0" class="dynamic-added">
											<td><input type="text" class="form-control akun" id="akun0" name="akun0" data-urut="0" required></td>
											<td><input type="text" class="form-control nama0" id="nama0" name="nama0" data-urut="0" required></td>
											<td><input type="text" class="form-control jumlah money" style="text-align: right;" name="jumlah0" id="jumlah0" data-urut="0" required></td>
											<td id="action0"></td>
										</tr>
									</tbody>

								</table>
							</div>
						</div>
						<div class="row mb-3 ml-2">
							<div class="row col-xl-6 col-6">
							</div>
							<div class="row col-xl-2 col-2">

							</div>
							<div class="row col-xl-4 col-md-4 col-sm-4 bg-danger">
								<label class="col-sm-7 col-6 col-md-5 control-label col-form-label pl-0 pr-0">
									<h6 class="text-light"><b><i>TOTAL :</i></b></h6>
								</label>
								<div class="col-sm-6 col-6 col-md-7">
									<input type="text" class="form-control text-right border-0 bg-danger text-light pl-0 pr-0" style="font-size:16px;" id="total" value="0,00" name="sum_bayar" readonly>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-4">
								<!-- <a class="d-none" role="button" target="_blank" id="btn-cetak">Cetak</a> -->
							</div>
							<button type="button" class="form-control btn btn-success text-light mt-5 col-4 mb-3" id="simpan"><i class="fa fa-save"></i> Simpan</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<!-- ######################################################################## -->
<div id="myModalBank" class="modal" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
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
										<button type="button" class="btn btn-sm btn-success btnSelect chsBnk chs_bank<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></button>
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
<!-- ######################################################################## -->
<div id="myModalAkun" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true" data-modal-parent="#modal-add">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Pilih Akun Perkiraan</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="overflow-y: auto;">
				<input type="hidden" id="cekIndex">
				<div class="table-responsive">
					<table id="" class="table lookup" width="100%">
						<thead class="thead-dark">
							<tr>
								<th>Nomor</th>
								<th>Nama Akun</th>
								<th>Pilih</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 0;
							foreach ($d_akunDG as $key => $value) { ?>
								<tr id="row0">
									<td><?= $value->akun ?></td>
									<td><?= $value->nama ?></td>
									<input type="hidden" class="no_akun<?= $no ?>" value="<?= $value->akun ?>">
									<input type="hidden" class="no_namaakun<?= $no ?>" value="<?= $value->nama ?>">
									<td align="center"><a href="" class="btn btn-sm btn-success chsAkn chs_akun<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></a></td>
								</tr>
							<?php $no++;
							} ?>
							<input type="hidden" class="sum_akun" value="<?= $no ?>">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ######################################################################## -->
<?php $this->load->view('template/bundle/template_scripts'); ?>