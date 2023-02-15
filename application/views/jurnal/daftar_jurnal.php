<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col mb-3" align="right">
				<button class="btn btn-success btn-sm" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-add" id="addjurnal"><i class="fa fa-plus"></i> Buat Jurnal</button>
			</div>
		</div>
		<div class="row">
			<label class="col-2 col-sm-2 col-md-2 text-right control-label col-form-label">Bulan :</label>
			<div class="col-2 col-sm-2 col-md-2 pr-0">
				<select class="custom-select pr-0 range select2" id="bulanJ">
					<?= $optionBulan ?>
				</select>
			</div>
			<label class="col-2 col-sm-2 col-md-2 text-right pl-0 control-label col-form-label">Tahun :</label>
			<div class="col-2 col-sm-2 col-md-2">
				<select class="custom-select range select2" id="tahunJ">
					<?= $optionTahun ?>
				</select>
			</div>
		</div>
		<div class="table-responsive">
			<table id="table" class="table table-hover" style="width:100%">
				<thead class="thead-dark">
					<tr>
						<th>Opsi</th>
						<th>Nomor</th>
						<th>Tanggal</th>
						<th>Referensi</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			<!-- <input type="text" class="sum_jurnal" value="<?= $s ?>" hidden> -->
		</div>
	</div>
</div>

<!-- ################################################################# -->
<div class="modal fade" id="modal-detail">
	<div class="modal-dialog" style="min-width: 90%; max-width: 90%;">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Detail Jurnal</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="col col-md-12">
					<div class="row justify-content-md-left col-md-12 mt-3">
						<div class="alert alert-success alert-dismissible fade show col-md-12" role="alert" id="highlight" style="display: none">
							<strong id="lbl_detail"></strong>
						</div>
					</div>
				</div>
				<form action="<?= site_url('jurnal/dosaveEdit') ?>" id="jurnalEdit" method="POST">
					<input type="hidden" name="keterangan" id="ket_jurnal">
					<input type="hidden" name="j_jurnal" id="j_jurnal">
					<div class="table-responsive" id="tbl_detail" style="display: none;width: 100%">
						<table class="table table-bordered lookup-djurnal">
							<thead class="thead-light">
								<tr>
									<th width="15%">Akun</th>
									<th width="25%">Nama Akun</th>
									<th width="30%" class="text-right">Debet</th>
									<th width="30%" class="text-right">Kredit</th>
								</tr>
							</thead>
							<tbody id="show_detail">

							</tbody>
						</table>
						<div class="row col-md-12">
							<div class="col-md-8"></div>
							<input type="text" name="total" class="sum_debet form-control col-md-2 bg-success text-light" id="sum_debet" style="text-align: right;" readonly>
							<input type="text" name="total" class="sum_kredit form-control col-md-2 bg-success text-light" id="sum_kredit" style="text-align: right;" readonly>
						</div>
						<div class="row col-md-12">
							<div class="col-md-10">
								<button class="btn btn-warning btn-sm text-light" id="editJurn" type="button"><i class="fa fa-edit"></i> Edit</button>
								<button class="btn btn-success btn-sm" id="editJurnSave" type="button"><i class="fa fa-save"></i> Simpan</button>
								<button class="btn btn-danger btn-sm" id="hpsJurn" type="button"><i class="fa fa-trash"></i> Hapus</button>
							</div>
							<input type="text" name="sum_selisih" class="sum_selisih form-control col-md-2 bg-danger text-light" id="sum_selisih" style="text-align: right; border: none;" readonly>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- ################################################################################################# -->
<div class="modal fade" id="modal-add" data-backdrop="static">
	<div class="modal-dialog" style="min-width: 90%; max-width: 90%;">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Isi Data Jurnal</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="min-height: calc(100vh - 100px); max-height: calc(100vh - 100px); overflow-y: auto;">
				<form action="<?= site_url('jurnal/dosave') ?>" id="formAddjurnal" method="POST">
					<div class="row">
						<div class="col col-md-3">
							<div class="cardModal" style="min-height: 400px">
								<h5 class="text-white bg-success p-2">INFORMASI</h5>
								<div class="card-body">
									<div class="row">
										<label class="col-sm-12 text-left control-label col-form-label">Tanggal</label>
									</div>
									<div class="row">
										<input type="hidden" class="form-control col-md-9" id="tanggal" name="tanggal" value="<?= $tanggal ?>">
										<input type="text" class="form-control col-md-9" value="<?= $tanggal_indo ?>" id="datepicker-autoclose1" readonly required>
										<div class="input-group-append">
											<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
									<div class="row">
										<label for="reff" class="col-sm-12 text-left control-label col-form-label">Referensi</label>
									</div>
									<div class="row">
										<input type="text" class="form-control reff col-md-12" name="reff" id="reff" value="-">
									</div>
									<div class="row">
										<label for="keterangan" class="col-sm-12 text-left control-label col-form-label">Keterangan <b class="text-danger">*</b></label>
									</div>
									<div class="row">
										<textarea class="form-control keterangan col-md-12" name="keterangan" id="keterangan" placeholder="Catatan transaksi" required></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="col col-md-9">
							<div class="cardModal">
								<h5 class="card-title m-b-0 p-2 text-white bg-success">DETAIL JURNAL</h5>
								<div class="card-body pl-2 pr-2 pb-2 pt-0">
									<input type="hidden" name="jml_baris" id="jml_baris" value="0">
									<div class="row" style="min-height: 300px;max-height: 300px;overflow-y: auto;">
										<div class="table-responsive">
											<table class="table table-bordered" style="width:100%" id="isi_detail">
												<thead class="thead-dark">
													<tr>
														<th style="width:18%">Akun <b class="text-danger">*</b></th>
														<th style="width:40%">Perkiraan</th>
														<th style="width:21%">Debet</th>
														<th style="width:21%">Kredit</th>
														<th>*</th>
													</tr>
												</thead>
												<tbody>
													<tr id="row0" class="dynamic-added">
														<td><input type="text" class="form-control akun" id="akun0" name="akun0" data-urut="0"></td>
														<td><input type="text" class="form-control nama0" name="nama0" data-urut="0"></td>
														<td><input type="text" class="form-control adddebet adddebet0 money" id="adddebet0" style="text-align: right;" name="adddebet0" data-urut="0"></td>
														<td><input type="text" class="form-control addkredit addkredit0 money" id="addkredit0" style="text-align: right;" name="addkredit0" data-urut="0"></td>
														<td id="action0"></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<div class="row col-md-12">
										<div class="col col-md-6">
										</div>
										<input type="text" class="total_debet form-control col-md-3 bg-success text-light" style="text-align: right;" id="total_debet" value="0" name="total" readonly>
										<input type="text" class="total_kredit form-control col-md-3 bg-success text-light" style="text-align: right;" id="total_kredit" value="0" name="total" readonly>
									</div>
									<div class="row col-md-12">
										<div class="col col-md-6">
										</div>
										<label class="col-md-3 text-right control-label col-form-label">Selisih</label>
										<input type="text" class="selisih form-control col-md-3 bg-danger text-light" style="text-align: right;" value="0" name="" readonly>
									</div>
								</div>
								<div class="row col-md-12 justify-content-md-center mt-5 pb-3">
									<button type="button" id="save" class="btn btn-success"><i class="fa fa-save"></i> SIMPAN & CETAK</button>
								</div>
							</div>
						</div>
					</div>
				</form>
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
								<tr>
									<td><?= $value->akun ?></td>
									<td><?= $value->nama ?></td>
									<input type="hidden" class="no_akun<?= $no ?>" value="<?= $value->akun ?>">
									<input type="hidden" class="no_namaakun<?= $no ?>" value="<?= $value->nama ?>">
									<td align="center">
										<a href="" class="btn btn-sm btn-success chsAkn chs_akun<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></a>
									</td>
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
<?php $this->load->view("template/bundle/template_scripts"); ?>