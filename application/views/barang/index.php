<div class="card shadow">
	<div class="card-body">
		<div class="mb-3" align="right">
			<button type="button" class="btn btn-success btn-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-add">
				<i class="fa fa-plus"></i> Barang Baru
			</button>
		</div>
		<div class="table-responsive">
			<table id="DataBarang" class="table table-hover table-sm table-bordered lookup" style="width: 100%;">
				<thead class="thead-dark">
					<tr>
						<th width="10%">Aksi</th>
						<th width="5%">Kode</th>
						<th width="10%">Barcode</th>
						<th width="40%">Nama Barang</th>
						<th width="15%">Jml. Stok</th>
						<th width="10%">Harga Jual</th>
						<th width="10%">Satuan</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$s = 0;
					foreach ($d_barang as $key => $value) { ?>
						<tr>
							<input type="hidden" class="n_barang<?= $s ?>" value="<?= $value->n_barang ?>">
							<td>
								<div class="btn-group">
									<a role="button" href="#" class="btn btn-xs btn-warning edit<?= $s ?>" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-edit"><i class="fa fa-edit"></i></a>
									<a role="button" href="#" class="btn btn-xs btn-danger delete-btn" onclick="hapusbarang('<?= $value->n_barang ?>')" data-id="<?= $value->n_barang ?>"><i class="fa fa-eraser"></i></a>
								</div>
							</td>
							<td><a href="#" class="text-primary tampilKartu" aria-labelledby="myModalLabel" data-kode="<?= $value->n_barang ?>" data-toggle="modal" data-target="#modal-kartu"><?= $value->n_barang ?></a></td>
							<td><?= $value->barcode ?></td>
							<td><?= $value->nama ?></td>
							<td align="right"><?= number_format($value->stock_gudang, 0, ",", ".") ?></td>
							<td align="right"><a href="#" class="text-info get_hpp" aria-labelledby="myModalLabel" data-toggle="modal" data-hpp="<?= $value->harga_pokok ?>" data-target="#modal-hpp"><?= number_format($value->harga_jual1, 0, ",", ".") ?></a></td>
							<td><?= $value->n_unit ?></td>
						</tr>
					<?php $s++;
					} ?>
					<input type="text" class="sum_barang" value="<?= $s ?>" hidden>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- ####################################################################################### -->
<div class="modal fade" id="modal-add" data-backdrop="static" style="overflow-y: auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Isi Data Barang</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('barang/dosave') ?>" id="add_Nbarang" method="POST" data-parsley-validate>
				<div class="modal-body">
					<div class="row mb-0">
						<div class="col-sm-3 form-group mb-0">
							<label class="" for="">Departemen <?= $requiredLabel ?></label>
							<select class="form-control col-md-12 grup" name="n_grup" required>
								<option value="" disabled selected>- Pilih Departemen -</option>
								<?php
								$s = 0;
								foreach ($d_grupbarang as $key => $details) : ?>
									<option value="<?= $details->n_grup ?>" data-value="<?= $details->kode ?>"><?= $details->grup ?> | <?= $details->departement ?></option>
								<?php $s++;
								endforeach; ?>
							</select>
						</div>

						<div class="col-sm-3 form-group mb-0">
							<label class="" for="">Barcode <?= $requiredLabel ?></label>
							<input class="form-control" type="text" name="barcode" value="-" maxlength="14" id="barcode" required><br>
						</div>

						<div class="col-sm-6 form-group mb-0">
							<label class="" for="">Nama Barang <?= $requiredLabel ?></label>
							<input class="form-control capital" type="text" name="nama" value="" maxlength="35" placeholder="Nama Barang" id="nama_barang" required><br>
						</div>
					</div>
					<div class="row">
						<!-- <div class="col-md-3">
							<div class="col col-md-9 form-group mb-0">
								
							</div>
						</div> -->
						<div class="col-md-12 mx-auto">
							<input class="form-control" type="hidden" name="n_barang" value="" id="autonumber" readonly>
							<div class="col col-md-12 form-group">
								<div class="row">
									<label class="col-md-2 text-left control-label col-form-label" for="">Persediaan : <?= $requiredLabel ?></label>
									<input type="text" class="form-control col-md-2 d_akun_persediaan def_namaakun_persediaan" value="" name="akun_persediaan" onkeypress="return false;" required data-parsley-errors-container="#akun-persediaan-errors">
									<input type="text" class="form-control col-md-6 d_namaakun_persediaan" value="" name="namaakun_persediaan" readonly onkeypress="return false;">
									<div class="input-group-append col-md-1">
										<a href="#myModal1" data-toggle="modal">
											<button class="btn btn-success" type="button"><i class="fa fa-search"></i></button>
										</a>
									</div>
								</div>
								<div id="akun-persediaan-errors"></div>
							</div>
							<div class="col col-md-12 form-group">
								<div class="row">
									<label class="col-md-2 text-left control-label col-form-label" for="">HPP : <?= $requiredLabel ?></label>
									<input type="text" class="col-md-2 form-control d_akun_hpp" value="" name="akun_hpp" onkeypress="return false;" required data-parsley-errors-container="#akun-hpp-errors">
									<input type="text" class="form-control col-md-6 d_namaakun_hpp" value="" name="namaakun_hpp" readonly onkeypress="return false;">
									<div class="input-group-append col-md-1">
										<a href="#myModal2" data-toggle="modal">
											<button class="btn btn-success" type="button"><i class="fa fa-search"></i></button>
										</a>
									</div>

								</div>
								<div id="akun-hpp-errors"></div>
							</div>
							<div class="col col-md-12 form-group">
								<div class="row">
									<label class="col-sm-2 text-left control-label col-form-label" for="">Pendapatan : <?= $requiredLabel ?></label>
									<input type="text" class="col-md-2 form-control d_akun_pendapatan" value="" name="akun_pendapatan" onkeypress="return false;" required data-parsley-errors-container="#akun-pendapatan-errors">
									<input type="text" class="form-control col-md-6 d_namaakun_pendapatan" value="" name="namaakun_pendapatan" readonly onkeypress="return false;">
									<div class="input-group-append col-md-1">
										<a href="#myModal3" data-toggle="modal">
											<button class="btn btn-success" type="button" data-value="pendapatan" id="s_pendapatan"><i class="fa fa-search"></i></button>
										</a>
									</div>

								</div>
								<div id="akun-pendapatan-errors"></div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col col-md-4 form-group mb-0">
							<label class="col-sm text-left control-label col-form-label" for="">Harga Beli <?= $requiredLabel ?></label>
							<div class="row col-md-12">
								<input class="form-control money" type="text" name="harga_beli" value="0" id="h_beli" style="float: right;" required><br>
							</div>
						</div>

						<!-- <div class="col col-sm-4 form-group" style="display: none;">
							<label class="col-sm text-left control-label col-form-label" for="">Harga Pokok<?= $requiredLabel ?></label>
							<div class="row col-md-12">
								<input class="form-control" type="text" name="harga_pokok" value="0" id="" required><br>
							</div>
						</div> -->

						<div class="col col-md-4 form-group mb-0">
							<label class="col-sm text-left control-label col-form-label" for="">Harga Jual<?= $requiredLabel ?></label>
							<div class="row col-md-12">
								<input class="form-control money" type="text" name="harga_jual1" value="0" id="h_jual" required><br>
							</div>
						</div>

						<div class="col col-md-4 form-group mb-4">
							<label class="col-sm text-left control-label col-form-label" for="">Stock Minimum<?= $requiredLabel ?></label>
							<div class="row col-md-12">
								<input class="form-control" type="number" name="stock_min" value="0" id="" required><br>
							</div>
						</div>
						<div class="col col-md-3 form-group mb-1" hidden>
							<label class="col-sm text-left control-label col-form-label" for="">Jml. Stok</label>
							<div class="row col-md-12">
								<input class="form-control" type="number" name="stock_gudang" value="0" id=""><br>
							</div>
						</div>

						<div class="col col-md-3 form-group mb-1" id="sEtalase" style="display:none">
							<label class="col-sm text-left control-label col-form-label" for="">S. Etalase</label>
							<div class="row col-md-12">
								<input class="form-control" type="number" name="stock_etalase" value="0" id=""><br>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col col-md-2">
						</div>
						<div class="col col-md-8 form-group">
							<div class="row">
								<label class="col-sm-3 text-left control-label col-form-label" for="">Konversi Satuan <?= $requiredLabel ?> </label>
								<div class="row col-md-2">
									<input class="form-control" type="text" value="1" readonly><br>
								</div>
								<div class="row col-md-2">
									<input class="form-control" type="text" name="b_unit" value="PCS" id="" placeholder="" required><br>
								</div>
								<div class="row col-md-1 m-1">
									<h4> = </h4>
								</div>
								<div class="row col-md-2">
									<input class="form-control" type="number" name="konversi_unit" value="1" id="" required=""><br>
								</div>
								<div class="row col-md-2">
									<input class="form-control" type="text" name="n_unit" value="PCS" id="" placeholder="" required><br>
								</div>
							</div>
						</div>
						<div class="col col-md-3">
							<div class="row col-md-12">
								<!-- <button type="button" class="btn btn-warning btn-md col-md-12" id="btnEtalase">ETALASE</button> -->
							</div>
						</div>
					</div>

					<div class="col alert-warning text-dark" name="fEtalase" id="formEtalase" style="display:none">
						<div class="row mb-0">
							<div class="col col-md-3 form-group mb-0">
								<label class="col-sm-12 text-left control-label col-form-label" for="">Harga Jual 1</label>
								<input class="form-control" type="number" name="harga_jual2" value="0" id=""><br>
							</div>
							<div class="col col-md-3 form-group mb-0">
								<label class="col-md-12 text-left control-label col-form-label" for="">Harga Jual 2</label>
								<input class="form-control" type="number" name="harga_jual3" value="0" id=""><br>
							</div>
							<div class="col col-md-2 form-group mb-0">
								<label class="col-sm-2 text-left control-label col-form-label" for="">Diskon</label>
								<input class="form-control" type="number" name="diskon" value="0" id=""><br>
							</div>
						</div>
						<div class="row mt-0">
							<div class="col col-sm-4 form-group mb-0 mt-0">
								<label class="col-sm text-left control-label col-form-label" for="">Keterangan 1</label>
								<div class="input-group">
									<input type="text" class="form-control" aria-label="Text input with dropdown button" name="keterangan1">
									<div class="input-group-append">
										<button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Keterangan 1</button>
										<div class="dropdown-menu">
											<a class="dropdown-item" href="#">Action</a>
											<a class="dropdown-item" href="#">Another action</a>
											<a class="dropdown-item" href="#">Something else here</a>
										</div>
									</div>
								</div>
							</div>

							<div class="col col-sm-4 form-group mb-0 mt-0">
								<label class="col-sm text-left control-label col-form-label" for="">Keterangan 2</label>
								<div class="input-group mb-2">
									<input type="text" class="form-control" aria-label="Text input with dropdown button" name="keterangan2">
									<div class="input-group-append">
										<button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Keterangan 2</button>
										<div class="dropdown-menu">
											<a class="dropdown-item" href="#">Action</a>
											<a class="dropdown-item" href="#">Another action</a>
											<a class="dropdown-item" href="#">Something else here</a>
										</div>
									</div>
								</div>
							</div>

							<div class="col col-sm-4 form-group mb-0 mt-0">
								<label class="col-sm text-left control-label col-form-label" for="">Keterangan 3</label>
								<div class="input-group">
									<input type="text" class="form-control" aria-label="Text input with dropdown button" name="keterangan3">
									<div class="input-group-append">
										<button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Keterangan 3</button>
										<div class="dropdown-menu">
											<a class="dropdown-item" href="#">Action</a>
											<a class="dropdown-item" href="#">Another action</a>
											<a class="dropdown-item" href="#">Something else here</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<input type="hidden" name="act" value="insert">
					<input type="hidden" name="id" value="<?= @$detail->n_barang ?>">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
					<!-- <button type="button" onclick="simpanbarang()" class="btn btn-success" value="simpan"><i class="fa fa-save"></i> Simpan</button> -->
					<button type="submit" onclick="simpanbarang()" class="btn btn-success" value="simpan"><i class="fa fa-save"></i> Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- ######################################################################################### -->
<div id="myModal1" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true" data-modal-parent="#modal-add">
	<div class="modal-dialog" style="overflow-y: initial !important">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Pilih Akun Perkiraan</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body" style="height: 500px; overflow-y: auto;">
				<div class="table-responsive">
					<table class="table lookup" width="100%" id="lookup">
						<thead class="thead-dark">
							<tr>
								<th>Nomor</th>
								<th>Akun Perkiraan</th>
								<th>Pilih</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 0;
							foreach ($d_akunAktiva as $key => $value) { ?>
								<tr>
									<td><?= $value->akun ?></td>
									<td><?= $value->nama ?></td>
									<td align="right">
										<button type="button" class="btn btn-success btn-sm chs_akun_persediaan<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></button>
									</td>
								</tr>
								<input type="text" class="no_akun_persediaan<?= $no ?>" value="<?= $value->akun ?>" style="display: none">
								<input type="text" class="no_namaakun_persediaan<?= $no ?>" value="<?= $value->nama ?>" style="display: none">
							<?php $no++;
							} ?>
							<input type="text" class="sum_akun_persediaan" value="<?= $no ?>" style="display: none">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ######################################################################################### -->
<div id="myModal2" class="modal modal-child2" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true" data-modal-parent="#modal-add" data-toggle="tab">
	<div class="modal-dialog" style="overflow-y: initial !important">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Pilih Akun Perkiraan</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body" style="height: 500px; overflow-y: auto;">
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
							foreach ($d_akunHpp as $key => $value) { ?>
								<tr>
									<td><?= $value->akun ?></td>
									<td><?= $value->nama ?></td>
									<input type="text" class="no_akun_hpp<?= $no ?>" value="<?= $value->akun ?>" style="display: none">
									<input type="text" class="no_namaakun_hpp<?= $no ?>" value="<?= $value->nama ?>" style="display: none">
									<td align="right"><button type="button" class="btn btn-primary chs_akun_hpp<?= $no ?>" data-dismiss="modal">Pilih</button></td>
								</tr>
							<?php $no++;
							} ?>
							<input type="text" class="sum_akun_hpp" value="<?= $no ?>" style="display: none">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ######################################################################################### -->
<div id="myModal3" class="modal modal-child3" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true" data-modal-parent="#modal-add">
	<div class="modal-dialog" style="overflow-y: initial !important">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Pilih Akun Perkiraan</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body" style="height: 500px; overflow-y: auto;">
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
							foreach ($d_akunPend as $key => $value) { ?>
								<tr>
									<td><?= $value->akun ?></td>
									<td><?= $value->nama ?></td>
									<input type="text" class="no_akun_pendapatan<?= $no ?>" value="<?= $value->akun ?>" style="display: none">
									<input type="text" class="no_namaakun_pendapatan<?= $no ?>" value="<?= $value->nama ?>" style="display: none">
									<td align="right"><button type="button" class="btn btn-primary chs_akun_pendapatan<?= $no ?>" data-dismiss="modal">Pilih</button></td>
								</tr>
							<?php $no++;
							} ?>
							<input type="text" class="sum_akun_pendapatan" value="<?= $no ?>" style="display: none">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ####################################################################################### -->
<div class="modal fade" id="modal-edit" data-backdrop="static" style="overflow-y:auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Edit Data Barang</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="edit_Nbarang" action="<?= site_url('barang/dosave') ?>" method="POST" data-parsley-validate>
				<div class="modal-body">
					<div class="row mb-0">
						<div class="col col-sm-3 form-group mb-0">
							<label class="col-sm text-left control-label col-form-label" for="">Departemen </label>
							<input class="form-control e_n_grup" type="text" name="n_grup" value="" id="" hidden>
							<input class="form-control e_nama_grup" type="text" name="nama_grup" value="" id="" readonly="">
						</div>

						<div class="col col-sm-3 form-group mb-0">
							<label class="col-sm text-left control-label col-form-label" for="">Barcode <?= $requiredLabel ?></label>
							<input class="form-control e_barcode" type="text" name="barcode" value="" maxlength="14" value="-" id="barcode" required><br>
						</div>

						<div class="col col-sm-6 form-group mb-0">
							<label class="col-sm text-left control-label col-form-label" for="">Nama Barang <?= $requiredLabel ?></label>
							<input class="form-control capital e_nama" type="text" name="nama" id="e_nama" value="" maxlength="35" required><br>
						</div>
					</div>

					<div class="row">
						<div class="col col-md-3 form-group">
							<label class="col-sm text-left control-label col-form-label" for="">Kode Barang</label>
							<input class="form-control e_n_barang" type="text" name="n_barang" value="" maxlength="14" readonly required>
						</div>
						<div class="col col-md-9">
							<div class="col col-md-12 form-group">
								<div class="row">
									<label class="col-md-2 text-left control-label col-form-label" for="">Persediaan</label>
									<input type="text" class="form-control col-md-2 e_akun_persediaan d_akun_persediaan" value="" name="akun_persediaan" onkeypress="return false;" readonly required>
									<input type="text" class="form-control col-md-6 e_namaakun_persediaan d_namaakun_persediaan" value="" name="namaakun_persediaan" onkeypress="return false;" readonly required>
									<div class="input-group-append col-md-1">
										<a href="#myModal1-edit" data-toggle="modal">
											<button class="btn btn-success" type="button"><i class="fa fa-search"></i></button>
										</a>
									</div>
								</div>
							</div>
							<div class="col col-md-12 form-group">
								<div class="row">
									<label class="col-md-2 text-left control-label col-form-label" for="">HPP</label>
									<input type="text" class="col-md-2 form-control e_akun_hpp d_akun_hpp" value="" name="akun_hpp" onkeypress="return false;" readonly required>
									<input type="text" class="form-control col-md-6 e_namaakun_hpp d_namaakun_hpp" value="" name="namaakun_hpp" onkeypress="return false;" readonly required>
									<div class="input-group-append col-md-1">
										<a href="#myModal2-edit" data-toggle="modal">
											<button class="btn btn-success" type="button"><i class="fa fa-search"></i></button>
										</a>
									</div>
								</div>
							</div>
							<div class="col col-md-12 form-group">
								<div class="row">
									<label class="col-sm-2 text-left control-label col-form-label" for="">Pendapatan</label>
									<input type="text" class="col-sm-2 form-control e_akun_pendapatan d_akun_pendapatan" value="" name="akun_pendapatan" onkeypress="return false;" readonly required>
									<input type="text" class="form-control col-md-6 e_namaakun_pendapatan d_namaakun_pendapatan" value="" name="namaakun_pendapatan" onkeypress="return false;" readonly required>
									<div class="input-group-append col-md-1">
										<a href="#myModal3-edit" data-toggle="modal">
											<button class="btn btn-success" type="button" data-value="pendapatan" id="s_pendapatan"><i class="fa fa-search"></i></button>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col col-md-4 form-group mb-0">
							<label class="col-sm text-left control-label col-form-label" for="">Harga Beli <?= $requiredLabel ?></label>
							<div class="row col-md-12">
								<input class="form-control e_harga_beli" type="text" name="harga_beli" value="0" id="" required><br>
							</div>
						</div>

						<div class="col col-md-4 form-group d-none" style="display: none;">
							<label class="col-sm text-left control-label col-form-label" for="">Harga Pokok</label>
							<div class="row col-md-12">
								<!--  <input class="form-control" type="number" name="harga_pokok" value="0" id=""><br> -->
							</div>
						</div>

						<div class="col col-md-4 form-group mb-0">
							<label class="col-sm text-left control-label col-form-label" for="">Harga Jual <?= $requiredLabel ?></label>
							<div class="row col-md-12">
								<input class="form-control e_harga_jual1 money" type="text" name="harga_jual1" value="0" id="" required><br>
							</div>
						</div>
						<div class="col col-md-4 form-group mb-4">
							<label class="col-sm text-left control-label col-form-label" for="">Stock Minimum <?= $requiredLabel ?></label>
							<div class="row col-md-12">
								<input class="form-control e_stock_min" type="number" name="stock_min" value="0" id="" required><br>
							</div>
						</div>
						<div class="col col-md-3 form-group mb1" hidden>
							<label class="col-sm text-left control-label col-form-label" for="">Jml. Stok</label>
							<div class="row col-md-12">
								<input class="form-control e_stock_gudang" type="number" name="stock_gudang" value="0" id="" readonly><br>
							</div>
						</div>
						<div class="col col-md-3 form-group mb-1" id="sEtalase-edit" style="display:none">
							<label class="col-sm text-left control-label col-form-label" for="">S. Etalase</label>
							<div class="row col-md-12">
								<input class="form-control e_stock_min" type="number" name="stock_etalase" value="0" id=""><br>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-group">
							<div class="row">
								<label class="text-left" for="">Konversi Satuan<?= $requiredLabel ?></label>
								<div class="col-md-2">
									<input class="form-control" type="text" value="1" readonly><br>
								</div>
								<div class="col-md-2">
									<input class="form-control e_b_unit" type="text" name="b_unit" value="" id="" placeholder="PCS" required><br>
								</div>
								<div class="col-md-1 m-1">
									<h4> = </h4>
								</div>
								<div class="col-md-2">
									<input class="form-control e_konversi_unit" type="number" name="konversi_unit" value="1" id="" required=""><br>
								</div>
								<div class="col-md-2">
									<input class="form-control e_n_unit" type="text" name="n_unit" value="" id="" placeholder="PCS" required><br>
								</div>
							</div>
						</div>
						<!-- <div class="col col-md-3">
							<div class="row col-md-12">
								<button type="button" class="btn btn-warning btn-md col-md-12" id="btnEtalase-edit">UBAH ETALASE</button>
							</div>
						</div> -->
					</div>

					<div class="col alert-warning text-dark" name="fEtalase" id="formEtalase-edit" style="display:none">
						<div class="row mb-0">
							<div class="col col-md-3 form-group mb-0">
								<label class="col-sm-12 text-left control-label col-form-label" for="">Harga Jual 1</label>
								<input class="form-control e_harga_jual2" type="number" name="harga_jual2" value="0" id=""><br>
							</div>
							<div class="col col-md-3 form-group mb-0">
								<label class="col-md-12 text-left control-label col-form-label" for="">Harga Jual 2</label>
								<input class="form-control e_harga_jual3" type="number" name="harga_jual3" value="0" id=""><br>
							</div>
							<div class="col col-md-2 form-group mb-0">
								<label class="col-sm-2 text-left control-label col-form-label" for="">Diskon</label>
								<input class="form-control e_diskon" type="number" name="diskon" value="0" id=""><br>
							</div>
						</div>

						<div class="row mt-0">
							<div class="col col-sm-4 form-group mb-0 mt-0">
								<label class="col-sm text-left control-label col-form-label" for="">Keterangan 1</label>
								<input class="form-control e_keterangan1" type="text" name="keterangan1" value="-" id=""><br>
							</div>

							<div class="col col-sm-4 form-group mb-0 mt-0">
								<label class="col-sm text-left control-label col-form-label" for="">Keterangan 2</label>
								<input class="form-control e_keterangan2" type="text" name="keterangan2" value="-" id=""><br>
							</div>

							<div class="col col-sm-4 form-group mb-0 mt-0">
								<label class="col-sm text-left control-label col-form-label" for="">Keterangan 3</label>
								<input class="form-control e_keterangan3" type="text" name="keterangan3" value="-" id=""><br>
							</div>
						</div>
					</div>

					<input type="hidden" name="act" value="edit">
					<input type="hidden" name="id" value="<?= @$detail->n_barang ?>">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
					<button type="submit" onclick="ubahbarang()" class="btn btn-warning" value="simpan"><i class="fas fa-edit"></i> UPDATE</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- ############################################################################### -->
<div id="myModal1-edit" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true" data-modal-parent="#modal-edit">
	<div class="modal-dialog" style="overflow-y: initial !important">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Pilih Akun Perkiraan</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body" style="height: 500px; overflow-y: auto;">
				<div class="table-responsive">
					<table class="table lookup" width="100%" id="lookup">
						<thead class="thead-dark">
							<tr>
								<th>Nomor</th>
								<th>Akun Perkiraan</th>
								<th>Pilih</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 0;
							foreach ($d_akunAktiva as $key => $value) { ?>
								<tr>
									<td><?= $value->akun ?></td>
									<td><?= $value->nama ?></td>
									<td align="right"><button type="button" class="btn btn-primary chs_akun_persediaan<?= $no ?>" data-dismiss="modal">Pilih</button></td>
								</tr>
								<input type="text" class="no_akun_persediaan<?= $no ?>" value="<?= $value->akun ?>" style="display: none">
								<input type="text" class="no_namaakun_persediaan<?= $no ?>" value="<?= $value->nama ?>" style="display: none">
							<?php $no++;
							} ?>
							<input type="text" class="sum_akun_persediaan" value="<?= $no ?>" style="display: none">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ######################################################################################### -->
<div id="myModal2-edit" class="modal modal-child2" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true" data-modal-parent="#modal-edit" data-toggle="tab">
	<div class="modal-dialog" style="overflow-y: initial !important">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Pilih Akun Perkiraan</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="height: 500px; overflow-y: auto;">
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
							foreach ($d_akunHpp as $key => $value) { ?>
								<tr>
									<td><?= $value->akun ?></td>
									<td><?= $value->nama ?></td>
									<input type="text" class="no_akun_hpp<?= $no ?>" value="<?= $value->akun ?>" style="display: none">
									<input type="text" class="no_namaakun_hpp<?= $no ?>" value="<?= $value->nama ?>" style="display: none">
									<td align="right"><button type="button" class="btn btn-primary chs_akun_hpp<?= $no ?>" data-dismiss="modal">Pilih</button></td>
								</tr>
							<?php $no++;
							} ?>
							<input type="text" class="sum_akun_hpp" value="<?= $no ?>" style="display: none">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ######################################################################################### -->
<div id="myModal3-edit" class="modal modal-child3" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true" data-modal-parent="#modal-edit">
	<div class="modal-dialog" style="overflow-y: initial !important">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Pilih Akun Perkiraan</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="height: 500px; overflow-y: auto;">
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
							foreach ($d_akunPend as $key => $value) { ?>
								<tr>
									<td><?= $value->akun ?></td>
									<td><?= $value->nama ?></td>
									<input type="text" class="no_akun_pendapatan<?= $no ?>" value="<?= $value->akun ?>" style="display: none">
									<input type="text" class="no_namaakun_pendapatan<?= $no ?>" value="<?= $value->nama ?>" style="display: none">
									<td align="right"><button type="button" class="btn btn-primary chs_akun_pendapatan<?= $no ?>" data-dismiss="modal">Pilih</button></td>
								</tr>
							<?php $no++;
							} ?>
							<input type="text" class="sum_akun_pendapatan" value="<?= $no ?>" style="display: none">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- modal kartu -->
<!-- ------------------------------------------------------------- -->
<div class="modal fade" id="modal-kartu" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Kartu Barang</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row mb-3">
					<input type="hidden" name="" class="kode_barang">
					<div class="form-group col-3">
						<label>Tanggal Mulai</label>
						<div class="input-group">
							<input type="text" class="form-control from_date datepicker" id="datepicker-autoclose1" name="tanggal" value="<?= date("Y-m-d") ?>" readonly required>
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group col-3">
						<label>Tanggal Sampai</label>
						<div class="input-group">
							<input type="text" class="form-control to_date datepicker" id="datepicker-autoclose2" name="tanggal" value="<?= date("Y-m-d") ?>" readonly required>
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group col-3 mt-4">
						<button class="btn btn-success set_kartu" type="button">Tampilkan</button>
					</div>
				</div>
				<div class="table-responsive">
					<table id="detailkartu" class="table" width="100%">
						<thead class="thead-dark">
							<tr>
								<th>Tanggal</th>
								<th>Reff</th>
								<th>Keluar</th>
								<th>Masuk</th>
								<th>Satuan</th>
								<th>Sisa</th>
								<th>Harga</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ####################################################################################### -->
<div class="modal fade" id="modal-hpp">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4>HPP Barang</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row justify-content-md-center">
					<label class="col-sm-2 text-left control-label col-form-label" for="">HPP</label>
					<div class="row col-md-6">
						<input class="form-control text-dark" type="text" value="" id="n_hpp" name="" readonly>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ######################################################################################## -->
<?php $this->load->view("template/bundle/template_scripts") ?>