<div class="col justify-content-md-center p-0">
	<form action="<?= site_url('Costing/do_costing') ?>" id="formCost" method="POST" target="_blank">
		<div class="row justify-content-md-center">
			<div class="container col-md-12 col-lg-12 col-xlg-12 col-12">
				<div class="card shadow mb-3">
					<div class="row ml-1 ">
						<div class="col-1 col-xl-1 p-0" style="margin-left:-5px;">
							<i class="fa fa-cubes h3 text-light p-3 bg-success m-0"></i>
						</div>
						<div class="col-9 col-xl-10 pr-0" style="margin-top:1%;">
							<div class="row">
								<div class="input-group-append">
									<a href="#myModalBarang" data-toggle="modal">
										<button class="btn btn-success" type="button"><i class="fa fa-search"></i></button>
									</a>
								</div>
								<div class="col-2 pr-1 pl-1">
									<input type="text" class="form-control sn_barang" id="kd_barang" placeholder="Kode Barang">
								</div>
								<div class="col-9 pl-0 pr-0">
									<input type="text" class="form-control" id="nm_barang" readonly placeholder="Nama Barang">
									<input type="hidden" id="h_barang">
									<input type="hidden" id="bunit_barang">
									<input type="hidden" id="unit_barang">
									<input type="hidden" id="unit_conv">
									<input type="hidden" id="hpp_barang">
									<input type="hidden" id="akun_barang">
									<input type="hidden" id="stock_gudang">
								</div>
							</div>
						</div>
						<div class="col-1" style="margin-top:1%;">
							<button class="btn btn-success barang_add" id="add_barang" type="button"><i class="fa fa-cart-plus h6 m-0"></i></button>
						</div>
					</div>
				</div>
			</div>
			<div class="container col-md-12 col-lg-12 col-xlg-12 col-12">
				<div class="row justify-content-md-center">
					<div class="col-lg-12">
						<h6 class="card-title m-b-0 p-2 text-light bg-success">Detail Costing Barang</h6>
						<div class="card shadow">
							<div class="card-body pt-0 pl-2 pr-2">
								<div class="row">
									<div class="table-responsive" style="overflow-y: scroll; height: 300px;">
										<table class="table" id="dynamic_field">
											<thead class="bg-white" style="position: sticky; top: 0; display:block; z-index:2;">
												<tr>
													<th scope="col" style="width:10%; text-align:center;">Kode</th>
													<th scope="col" style="width:22%; text-align:center;">Nama Barang</th>
													<th scope="col" style="width:6%; text-align:center;">Qty</th>
													<th scope="col" style="width:6%; text-align:center;">Satuan</th>
													<th scope="col" style="width:11%; text-align:center;">Harga</th>
													<th scope="col" style="width:11%; text-align:center;">Total</th>
													<th scope="col" style="width:5%; text-align:center;">*</th>
												</tr>
											</thead>
											<input type="hidden" name="sum_barang" class="sum_baris" value="0" readonly>
											<tbody style="display:block;">

											</tbody>
										</table>
										<hr>
									</div>
								</div>
								<div class="row mb-3">
									<div class="row col-lg-6 col-6">

									</div>
									<div class="row col-xl-3 col-md-2 col-2">

									</div>
									<div class="row col-xl-3 col-md-4 col-sm-4 bg-danger">
										<label class="col-sm-7 col-6 col-md-5 control-label col-form-label pl-0 pr-0 text-light">
											<h5 class="text-light"><b><i>TOTAL :</i></b></h5>
										</label>
										<div class="col-sm-6 col-6 col-md-7">
											<input type="text" class="form-control text-right border-0 bg-danger text-light pl-0 pr-0" style="font-size:16px;" id="total_costing" name="totalCosting" value="0.00" readonly>
										</div>
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-lg-12">
										<button class="btn btn-success btn-md" style="margin:0 40%;" id="bt_proses" type="button"><i class="fa fa-check"></i> PROSES</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" class="form-control text-right" id="total_diskon" name="total_diskon" value="0" readonly>
				</div>
			</div>
		</div>
</div>
</section>
<div id="myModalBarang" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Pilih Data Barang</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<input type="hidden" id="urut_barang">
			<div class="modal-body">
				<div class="table-responsive">
					<table id="lookup" class="table lookup" width="100%">
						<thead class="thead-dark">
							<tr>
								<th>Kode Barang</th>
								<th>Nama</th>
								<th>Stok</th>
								<th>Pilih</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 0;
							foreach ($d_barang as $key => $value) { ?>
								<tr>
									<td><?= $value->n_barang ?></td>
									<td><?= $value->nama ?></td>
									<td><?= $value->stock_gudang ?></td>
									<td align="center">
										<button type="button" class="btn btn-xs btn-success chs_brg chs_barang<?= $no ?>" data-id="<?= $value->n_barang ?>" data-dismiss="modal"><i class="fa fa-check"></i></button>
									</td>
								</tr>
							<?php $no++;
							} ?>
							<input type="hidden" class="sum_barang" value="<?= $no ?>">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModalProses" tabindex="-1" role="dialog" aria-hidden="true" style="z-index:1045;" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="">Proses Costing</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="form-group m-0">
						<label class="col-12 col-sm-12 col-md-6 p-0">Tanggal Transaksi</label>
						<label class="col-1"></label>
						<label class="col-12 col-sm-12 col-md-4 p-0">Refferensi</label>
					</div>
					<div class="form-group form-row mb-3">
						<div class="input-group col-12 col-sm-12 col-md-6 p-0">
							<input type="text" class="form-control" name="tanggal" id="datepicker-autoclose2" value="<?= date("d-M-Y") ?>" placeholder="mm/dd/yyyy">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
						<div class="col-1"></div>
						<div class="input-group col-12 col-sm-12 col-md-5 p-0 text-right">
							<input type="text" class="form-control" name="reff" id="reff" placeholder="Reff" value="-">
						</div>
					</div>
					<div class="form-group mb-3">
						<label>Catatan</label>
						<div class="input-group">
							<input type="textarea" class="form-control" id="ketr" name="keterangan" placeholder="Catatan Transaksi (Jika Ada)">
						</div>
					</div>
					<div class="form-group form-row m-0">
						<label>Perkiraan Biaya</label>
					</div>
					<div class="input-group">
						<input type="text" class="form-control d_akun col-3" name="akun" placeholder="No. Akun" onkeypress="return false;" required>
						<input type="text" class="form-control d_namaakun" name="namaakun" placeholder="Nama Akun" onkeypress="return false;">
						<div class="input-group-append col-sm-1 pt-1">
							<button class="btn btn-success" type="button" id="bt_akun" data-toggle="modal" data-target="#myModalAkun"><i class="fa fa-search"></i></button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success btsave" id="saveCost"><i class="fa fa-save"></i> Simpan</button>
			</div>
		</div>
	</div>
</div>
</form>
<div id="myModalAkun" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true" data-modal-parent="#modal-add">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Pilih Akun Perkiraan</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table lookup" width="100%">
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
									<input type="hidden" class="no_akun<?= $no ?>" value="<?= $value->akun ?>">
									<input type="hidden" class="n_akun<?= $no ?>" value="<?= $value->nama ?>">
									<td align="center"><button type="button" class="btn btn-sm btn-success chs_akun chs_akun<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></button></td>
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
<?php $this->load->view('template/bundle/template_scripts'); ?>