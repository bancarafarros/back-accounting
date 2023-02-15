<div class="row justify-content-md-center min-width:400px;">
	<div class="col-md-5">
		<div class="card">
			<h5 class="card-title m-0 p-2 bg-success text-light"><i class="fa fa-th"></i> Daftar Grup Barang</h5>
			<div class="card-body">
				<div class="row d-flex flex-row-reverse mb-2">
					<button type="button" class="btn btn-success btn-sm" style="min-width: 120px" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-add">
						<i class="fa fa-plus"></i> Grup
					</button>
				</div>
				<div class="row">
					<div class="table-responsive">
						<table class="table table-bordered zero_config">
							<thead class="thead-dark">
								<tr>
									<th width="10p">#</th>
									<th>Grup</th>
									<th width="10%">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$s = 0;
								foreach ($d_grupbarang as $key => $value) { ?>
									<tr>
										<td><?= $value->n_grup ?></td>
										<td><?= $value->grup ?></td>
										<input type="hidden" class="n_grup<?= $s ?>" value="<?= $value->n_grup ?>">
										<input type="hidden" class="grup<?= $s ?>" value="<?= $value->grup ?>">
										<td>
											<div class="btn-group">
												<a href="" class="btn btn-xs btn-warning edit<?= $s ?>" tabindex="1" role="dialog" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-edit" id="btn_edit"><i class="fa fa-edit"></i></a>
												<button type="button" onclick="hapusgrup('<?= $value->n_grup ?>')" href="<?= site_url("barang/grupbarang_hapus/" . $value->n_grup) ?>" class="btn btn-xs btn-danger"><i class="fa fa-eraser"></i></button>
											</div>
										</td>
									</tr>
								<?php $s++;
								} ?>
								<input type="text" class="sum_grup" value="<?= $s ?>" hidden>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-7">
		<div class="card">
			<h5 class="card-title m-0 p-2 bg-success text-light"><i class="fa fa-th"></i> Daftar Departemen Barang</h5>
			<div class="card-body">
				<div class="row d-flex flex-row-reverse mb-2">
					<button type="button" class="btn btn-success btn-sm btn-md" style="min-width: 120px" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-add-depart">
						<i class="fa fa-plus"></i> Departemen
					</button>
				</div>
				<div class="row">
					<div class="table-responsive">
						<table class="table table-bordered zero_config">
							<thead class="thead-dark">
								<tr>
									<th width="40px">#</th>
									<th>Departemen</th>
									<th width="30px">Kode</th>
									<!-- <th width="20px">Margin</th> -->
									<th width="10%">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$t = 0;
								foreach ($d_departemenbarang as $key => $value) {
								?>
									<tr>
										<td><?= $value->n_grup ?></td>
										<td><?= $value->departement ?></td>
										<td align="center"><?= $value->kode ?></td>
										<input type="hidden" class="n_grup2<?= $t ?>" value="<?= $value->n_grup ?>">
										<input type="hidden" class="grup<?= $t ?>" value="<?= $value->grup ?>">
										<td>
											<div class="btn-group">
												<a href="#" class="btn btn-xs btn-warning editdepart<?= $t ?>" tabindex="1" role="dialog" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-edit-depart"><i class="fa fa-edit"></i></a>
												<button type="button" onclick="hapusgrup('<?= $value->n_grup ?>')" href="<?= site_url("barang/grupbarang_hapus/" . $value->n_grup) ?>" class="btn btn-xs btn-danger"><i class="fa fa-eraser"></i></button>
											</div>
										</td>
									</tr>
								<?php $t++;
								} ?>
								<input type="text" class="sum_depart" value="<?= $t ?>" hidden>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ######################################################################## -->
<div class="modal fade" id="modal-add" data-backdrop="static" style="overflow-y: auto;">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Isi Data Grup</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('barang/grupbarang_dosave') ?>" method="POST" id="add_grup" data-parsley-validate>
				<div class="modal-body">
					<div class="form-group">
						<label class="" for="">Nomor grup <?= $requiredLabel ?></label>
						<input class="form-control" placeholder="Nomor grup" type="number" name="n_grup" id="n_grup" value="<?= @$detail->n_grup ?>" maxlength="2" id="" required>
					</div>

					<div class="form-group">
						<label class="" for="">Nama grup <?= $requiredLabel ?></label>
						<input class="form-control capital" type="text" placeholder="Nama grup" name="grup" value="<?= @$detail->grup ?>" maxlength="50" id="" required>
					</div>
					<input type="hidden" name="act" value="insert">
					<input type="hidden" name="id" value="<?= @$detail->n_grup ?>">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
					<button type="submit" class="btn btn-success" value="simpan" id=btn_simpan><i class="fa fa-save"></i> Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- ######################################################################## -->
<div class="modal fade" id="modal-edit" data-backdrop="static" style="overflow-y: auto;">
	<div class=" modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Edit Data Grup</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('barang/grupbarang_dosave') ?>" method="POST" id="edit_grup" data-parsley-validate>
				<div class="modal-body">
					<div class="form-group">
						<label class="" for="">Nomor Grup</label>
						<input class="form-control e_n_grup" placeholder="Nomor grup" type="text" name="n_grup" value="<?= @$detail->n_grup ?>" maxlength="6" id="" readonly>
					</div>
					<div class="form-group">
						<label class="" for="">Nama Grup <?= $requiredLabel ?></label>
						<input class="form-control capital e_grup" placeholder="Nama grup" type="text" name="grup" value="<?= @$detail->grup ?>" maxlength="50" id="" required>
					</div>
					<input type="hidden" name="act" value="edit">
					<input type="hidden" name="id" value="<?= @$detail->n_grup ?>">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
					<button type="submit" class="btn btn-warning" value="simpan"><i class="fa fa-edit"></i> Update</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- ######################################################################## -->
<div class="modal fade" id="modal-add-depart" data-backdrop="static" style="overflow-y: auto;">

	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Isi Data Departemen</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('barang/grupbarang_dosaveDepart') ?>" method="POST" id="add_depart" data-parsley-validate>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Grup Barang <?= $requiredLabel ?></label>
								<select class="col-md-12 custom-select select2 form-control kode" name="" id="sel_grup" required="">
									<option value="" selected disabled>Pilih</option>
									<?php
									$s = 0;
									foreach ($d_grupbarang as $key => $value) {
									?>
										<option value="<?= $value->n_grup ?>" data-value="<?= $value->n_grup ?>"><?= $value->n_grup ?> | <?= $value->grup ?></option>
									<?php $s++;
									} ?>
								</select>
							</div>
							<input type="hidden" name="grup2" id="grup">
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="autonumber">Nomor</label>
								<input class="form-control" type="text" name="n_grup2" value="<?= @$detail->n_grup ?>" maxlength="6" id="autonumber" required readonly>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Departemen <?= $requiredLabel ?></label>
								<input class="form-control capital" type="text" name="departement" maxlength="50" id="" placeholder="Departemen" required>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Kode Barang <?= $requiredLabel ?></label>
								<input class="form-control" type="text" name="kode" maxlength="3" id="" placeholder="Kode Barang" required>
							</div>
						</div>
					</div>
					<input class="form-control col-md-9" type="hidden" name="margin_departement" min="0" max="9999" id="" value="0" required>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="">Persediaan <?= $requiredLabel ?></label>
								<div class="row col-md-12">
									<input type="text" class="col-md-3 form-control d_akun_persediaan" value="" name="akun_persediaan" readonly required data-parsley-errors-container="#akun-persediaan-errors">
									<input type="text" class="form-control col-md-8 d_namaakun_persediaan" value="" name="namaakun_persediaan" readonly>
									<div class="input-group-append col-md-1">
										<a href="#myModal1" data-toggle="modal">
											<button class="btn btn-success" type="button"><i class="fa fa-search"></i></button>
										</a>
									</div>
								</div>
								<div id="akun-persediaan-errors"></div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="">HPP<?= $requiredLabel ?></label>
								<div class="row col-md-12">
									<input type="text" class="col-md-3 form-control d_akun_hpp" value="" name="akun_hpp" readonly required data-parsley-errors-container="#akun-hpp-errors">
									<input type="text" class="form-control col-md-8 d_namaakun_hpp" value="" name="namaakun_hpp" readonly>
									<div class="input-group-append col-md-1">
										<a href="#myModal2" data-toggle="modal">
											<button class="btn btn-success" type="button"><i class="fa fa-search"></i></button>
										</a>
									</div>
								</div>
								<div id="akun-hpp-errors"></div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col col-sm-12">
							<div class="form-group">
								<label for="">Pendapatan<?= $requiredLabel ?></label>
								<div class="row col-md-12">
									<input type="text" class="col-md-3 form-control d_akun_pendapatan" value="" name="akun_pendapatan" readonly required data-parsley-errors-container="#akun-pendapatan-errors">
									<input type="text" class="form-control col-md-8 d_namaakun_pendapatan" value="" name="namaakun_pendapatan" readonly>
									<div class="input-group-append col-sm-1">
										<a href="#myModal3" data-toggle="modal">
											<button class="btn btn-success" type="button" data-value="pendapatan" id="s_pendapatan"><i class="fa fa-search"></i></button>
										</a>
									</div>
								</div>
								<div id="akun-pendapatan-errors"></div>
							</div>
						</div>
					</div>
					<input type="hidden" name="act" value="insert">
					<input type="hidden" name="id" value="<?= @$detail->n_grup ?>">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
					<button type="submit" class="btn btn-success" value="simpan" id=btn_simpan><i class="fa fa-save"></i> SIMPAN</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- ######################################################################################### -->
<div class="modal fade" id="modal-edit-depart" data-backdrop="static" style="overflow-y: auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Edit Data Departemen</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('barang/grupbarang_dosaveDepart') ?>" method="POST" id="edit_depart" data-parsley-validate>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Grup Barang</label>
								<input class="form-control e_grup" type="text" name="grup2" id="grup" readonly>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Nomor</label>
								<input class="form-control e_n_grup" type="text" name="n_grup2" value="" id="autonumber" required readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Departemen</label>
								<input class="form-control capital e_departement" type="text" name="departement" maxlength="50" id="" required>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Kode</label>
								<input class="form-control e_kode" type="text" name="kode" maxlength="6" readonly>
							</div>
						</div>
					</div>
					<input class="form-control col-md-8 e_margin_departement" type="hidden" name="margin_departement" min="0" max="999" id="" required>
					<div class="row">
						<div class="col col-sm-12 form-group">
							<label class="" for="">Persediaan</label>
							<div class="row col-md-12">
								<input type="text" class="col-md-3 form-control e_akun_persediaan" value="" name="akun_persediaan" onkeypress="return false;" required>
								<input type="text" class="form-control col-md-8 e_namaakun_persediaan" value="" name="namaakun_persediaan" onkeypress="return false;" required>
								<div class="input-group-append col-md-1">
									<a href="#myModal1-edit" data-toggle="modal">
										<button class="btn btn-success" type="button"><i class="fa fa-search"></i></button>
									</a>
								</div>
							</div>
						</div>
						<div class="col-sm-12 form-group">
							<label class="" for="">HPP</label>
							<div class="row col-md-12">
								<input type="text" class="col-md-3 form-control e_akun_hpp" value="" name="akun_hpp" onkeypress="return false;" required>
								<input type="text" class="form-control col-md-8 e_namaakun_hpp" value="" name="namaakun_hpp" onkeypress="return false;" required>
								<div class="input-group-append col-md-1">
									<a href="#myModal2-edit" data-toggle="modal">
										<button class="btn btn-success" type="button"><i class="fa fa-search"></i></button>
									</a>
								</div>
							</div>
						</div>
						<div class="col-sm-12 form-group">
							<label class="" for="">Pendapatan</label>
							<div class="row col-md-12">
								<input type="text" class="col-md-3 form-control e_akun_pendapatan" value="" name="akun_pendapatan" onkeypress="return false;" required>
								<input type="text" class="form-control col-md-8 e_namaakun_pendapatan" value="" name="namaakun_pendapatan" onkeypress="return false;" required>
								<div class="input-group-append col-sm-1">
									<a href="#myModal3-edit" data-toggle="modal">
										<button class="btn btn-success" type="button" data-value="pendapatan" id="s_pendapatan"><i class="fa fa-search"></i></button>
									</a>
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" name="act" value="edit">
					<input type="hidden" name="id" value="">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
					<button type="submit" class="btn btn-warning" value="simpan" id=btn_simpan><i class="fa fa-edit"></i> Update</button>
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
									<td align="center">
										<button type="button" class="btn btn-success chs_akun_persediaan<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></button>
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
									<td align="center"><button type="button" class="btn btn-success chs_akun_hpp<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></button></td>
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
									<td align="center"><button type="button" class="btn btn-success chs_akun_pendapatan<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></button></td>
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
<!-- ######################################################################## -->
<div id="myModal1-edit" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true" data-modal-parent="#modal-add">
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
							foreach ($d_akun as $key => $value) { ?>
								<tr>
									<td><?= $value->akun ?></td>
									<td><?= $value->nama ?></td>
									<td align="center">
										<button type="button" class="btn btn-success chs_akun_persediaan<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></button>
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
<div id="myModal2-edit" class="modal modal-child2" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true" data-modal-parent="#modal-add" data-toggle="tab">
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
							foreach ($d_akun as $key => $value) { ?>
								<tr>
									<td><?= $value->akun ?></td>
									<td><?= $value->nama ?></td>
									<input type="text" class="no_akun_hpp<?= $no ?>" value="<?= $value->akun ?>" style="display: none">
									<input type="text" class="no_namaakun_hpp<?= $no ?>" value="<?= $value->nama ?>" style="display: none">
									<td align="center"><button type="button" class="btn btn-success chs_akun_hpp<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></button></td>
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
<div id="myModal3-edit" class="modal modal-child3" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true" data-modal-parent="#modal-add">
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
							foreach ($d_akun as $key => $value) { ?>
								<tr>
									<td><?= $value->akun ?></td>
									<td><?= $value->nama ?></td>
									<input type="text" class="no_akun_pendapatan<?= $no ?>" value="<?= $value->akun ?>" style="display: none">
									<input type="text" class="no_namaakun_pendapatan<?= $no ?>" value="<?= $value->nama ?>" style="display: none">
									<td align="center"><button type="button" class="btn btn-success chs_akun_pendapatan<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></button></td>
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
<?php $this->load->view("template/bundle/template_scripts") ?>