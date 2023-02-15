<form action="<?= site_url('pembelian/do_pembelian') ?>" id="formPemb" method="POST" target="_blank">
	<div class="row justify-content-md-center">
		<div class="container col-md-12 col-lg-12 col-xlg-12 col-12">
			<div class="card shadow border-success mb-2">
				<div class="row ml-1">
					<div class="col-1 col-xl-1 p-0" style="margin-left:-5px;">
						<i class="fa fa-cubes h3 text-light p-3 bg-success m-0"></i>
					</div>
					<div class="col-9 col-xl-10 pr-0" style="margin-top:1%;">
						<div class="row pb-2">
							<div class="input-group-append">
								<a href="#myModalBarang" data-toggle="modal">
									<button class="btn btn-sm btn-success" type="button"><i class="fa fa-search"></i></button>
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
							</div>
						</div>
					</div>
					<div class="col-1" style="margin-top:1%;">
						<button class="btn btn-sm btn-success barang_add" id="add_barang" type="button"><i class="fa fa-cart-plus h6 m-0"></i></button>
					</div>
				</div>
			</div>
		</div>
		<div class="container col-md-12 col-lg-12 col-xlg-12 col-12">
			<div class="row justify-content-md-center">
				<div class="col-lg-12">
					<h6 class="card-title m-b-0 p-2 text-light bg-success">Detail Pembelian</h6>
					<div class="card shadow">
						<div class="card-body pt-0 pl-2 pr-2">
							<div class="row">
								<div class="table-responsive" style="overflow-y: scroll; height: 300px;">
									<table class="table" id="dynamic_field">
										<thead class="bg-white" style="position: sticky; top: 0; display:block; z-index:2;">
											<tr>
												<th scope="col" style="width:10%;">Kode</th>
												<th scope="col" style="width:21%;">Nama Barang</th>
												<th scope="col" style="width:8%;">Qty</th>
												<th scope="col" style="width:11%;">Satuan</th>
												<th scope="col" style="width:12%;">Harga</th>
												<th scope="col" style="width:6%;">Diskon(%)</th>
												<th scope="col" style="width:12%;">Total</th>
												<th scope="col" style="width:5%;">*</th>
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
										<input type="text" class="form-control text-right border-0 bg-danger text-light pl-0 pr-0" style="font-size:16px;" id="total_beli" name="totalBelibrg" value="0.00" readonly>
									</div>
								</div>
							</div>
							<div class="row">
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
										<input type="hidden" class="akun_pemasok<?= $no ?>" value="<?= $value->akun ?>">
										<input type="hidden" class="batas_kredit<?= $no ?>" value="<?= $value->batas ?>">
										<td align="center"><button type="button" class="btn btn-sm btn-success chs_pem chs_pemasok<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></button></td>
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
										<td align="center"><button type="button" class="btn btn-sm btn-success chs_bnk chs_bank<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></button></td>
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
	<div id="myModalBarang" class="modal" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
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
					<div class="">
						<table class="table lookup">
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
										<td align="center"><button type="button" class="btn btn-sm btn-success chs_brg chs_barang<?= $no ?>" data-id="<?= $value->n_barang ?>" data-dismiss="modal"><i class="fa fa-check"></i></button></td>
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
	<div id="myModalOrder" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width:auto;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4>Pilih Data Order</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-6">
							<div class="table-responsive">
								<table id="lookup" class="table lookup" width="100%">
									<thead class="thead-dark">
										<tr>
											<th>Kode Order</th>
											<th>Tanggal</th>
											<th>Pemasok</th>
											<th>Pilih</th>
										</tr>
									</thead>
									<tbody>
										<?php $no = 0;
										foreach ($d_order as $key => $value) { ?>
											<tr>
												<td><?= $value->n_opembelian ?></td>
												<td><?= date_format(date_create($value->tanggal), "d-M-y") ?></td>
												<td><?= $value->namaPemasok ?></td>
												<td align="right"><button type="button" class="btn btn-sm btn-success<?= $no ?> detail_order" data-order="<?= $value->n_opembelian ?>"><i class="fa fa-check"></i></button></td>
											</tr>
										<?php $no++;
										} ?>
										<input type="hidden" class="sum_barang" value="<?= $no ?>">
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-6">
							<label class="col-2 text-left control-label col-form-label">Detail</label>
							<table id="lookup" class="table" width="100%">
								<thead class="thead-dark">
									<tr>
										<th>Kode</th>
										<th>Barang</th>
										<th>Qty</th>
										<th>Terkirim</th>
									</tr>
								</thead>
								<tbody id="show_detail">

								</tbody>
							</table>
							<label class="col-2 text-left control-label col-form-label">Total</label>
							<div class="row col-lg-6">
								<input type="text" class="form-control" id="totalOrder" value="0" readonly>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="myModalProses" tabindex="-1" role="dialog" aria-hidden="true" style="overflow-y:auto;z-index:1045;" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="">Proses Pembelian</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="row hide" data-step="1" data-title="Detail Database">
						<div class="container">
							<div class="form-group m-0">
								<label class="col-12 col-sm-12 col-md-6 p-0">Pemasok <b class="text-danger">*</b></label>
								<label class="col-1"></label>
								<label class="col-12 col-sm-12 col-md-4 p-0">Referensi</label>
							</div>
							<div class="form-group form-row mb-3">
								<div class="input-group col-12 col-sm-12 col-md-6 p-0">
									<input type="text" class="form-control d_Pemasok" name="n_pemasok" value="" required>
									<div class="input-group-append">
										<a href="#myModalPemasok" data-toggle="modal">
											<button class="btn btn-success" type="button"><i class="fa fa-search"></i></button>
										</a>
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
								<label class="col-12 col-sm-12 col-md-5 p-0">Tanggal Transaksi</label>
								<label class="col-2"></label>
								<label class="col-12 col-sm-12 col-md-5 p-0"> Tanggal Jatuh Tempo</label>
							</div>
							<div class="form-group form-row m-0 pb-3 mb-3 border-bottom border-success">
								<div class="input-group col-12 col-sm-12 col-md-5 p-0">
									<input type="text" class="form-control datepicker tanggal" id="datepicker-autoclose1 tanggal" name="tanggal" value="<?= date("Y-m-d") ?>">
									<div class="input-group-append">
										<span class="input-group-text"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
								<label class="col-2"></label>
								<div class="input-group col-12 col-sm-12 col-md-5 p-0">
									<input type="text" class="form-control datepicker jatuh_tempo" name="jatuh_tempo" id="datepicker-autoclose2 jatuh_tempo" value="<?= date("Y-m-d") ?>" placeholder="mm/dd/yyyy">
									<div class="input-group-append">
										<span class="input-group-text"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
							</div>
							<div class="form-group form-row m-0">
								<label class="col-12 col-sm-12 col-md-5 p-0">PPN</label>
								<label class="col-2"></label>
								<label class="col-12 col-sm-12 col-md-5 p-0">Biaya Kirim</label>
							</div>
							<div class="form-group form-row">
								<div class="input-group col-12 col-sm-12 col-md-5 p-0">
									<input type="text" class="form-control text-right" id="ppn_beli" name="biaya_ppn" value="0.00">
								</div>
								<label class="col-2"></label>
								<div class="input-group col-12 col-sm-12 col-md-5 p-0">
									<input type="text" class="form-control text-right" id="biaya_kirim" name="biaya_kirim" value="0.00">
								</div>
							</div>
							<div class="form-group form-row m-0">
								<label>Total Seluruhnya</label>
							</div>
							<div class="input-group">
								<input type="text" class="form-control text-right total_all" id="" name="total_all" value="0.00" readonly>
							</div>
						</div>
					</div>
					<div class="row hide" data-step="2" data-title="Detail Perusahaan">
						<div class="container ml-3">
							<div class="form-group form-row mb-1">
								<div class="col-4"></div>
								<label class="pt-2 col-3">Total Pembelian</label>
								<div class="input-group col-5">
									<input type="text" class="form-control text-right" id="set_total" value="0.00" readonly>
								</div>
							</div>
							<div class="form-group form-row mb-1">
								<div class="col-4"></div>
								<label class="pt-2 col-3">PPN</label>
								<div class="input-group col-5">
									<input type="text" class="form-control text-right" id="set_ppn" value="0.00" readonly>
								</div>
							</div>
							<div class="form-group form-row mb-1">
								<div class="col-4"></div>
								<label class="pt-2 col-3">Biaya Kirim</label>
								<div class="input-group col-5">
									<input type="text" class="form-control text-right" id="set_kirim" value="0.00" readonly>
								</div>
							</div>
							<div class="form-group form-row mb-1 pb-3 border-bottom border-success">
								<div class="col-4"></div>
								<label class="pt-3 col-3 border-top border-secondary">Total Tagihan</label>
								<div class="input-group col-5 border-top border-secondary pt-1">
									<input type="text" class="form-control text-right total_all" id="" value="0.00" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="badge badge-success">Pembayaran</label>
								<div class="input-group">
									<div class="btn-group justify-content-md-center" role="group" aria-label="Basic example">
										<button type="button" class="btn btn-success" style="min-width:65px; max-width:65px" id="c_kas" value="kas">KAS</button>
										<a href="#myModalBank" data-toggle="modal">
											<button type="button" class="btn btn-default" style="min-width:65px; max-width:65px" id="c_bank" value="bank">BANK</button>
										</a>
										<input type="text" class="form-control bank" id="d_Bank" name="no_bank" value="" readonly>
										<div class="input-group-append">
											<a href="#myModalBank" data-toggle="modal">
												<button class="btn btn-success bank" type="button"><i class="fa fa-search"></i></button>
											</a>
										</div>
									</div>
									<input type="hidden" name="c_bayar" id="c_bayar" value="kas">
									<input type="hidden" name="akun_bank" id="d_akunBank" value="kas">
								</div>
								<div class="form-group mt-3 mb-2">
									<label>Jumlah Bayar</label>
									<div class="input-group">
										<input type="text" class="form-control uang text-right" id="jml_bayar" name="jml_bayar" value="0.00">
									</div>
								</div>
								<div class="form-group">
									<label>Sisa Bayar</label>
									<div class="input-group">
										<input type="text" class="form-control text-right" id="sisa_bayar" name="sisa_bayar" value="0.00" readonly>
										<input type="hidden" class="form-control" id="uang_muka" value="0" name="uang_muka" readonly>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default js-btn-step pull-left" data-orientation="cancel" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
						<!-- <button type="button" class="btn btn-warning js-btn-step" data-orientation="previous"></button> -->
						<button type="button" class="btn btn-success js-btn-step" id="proses" onclick="prosesbeli()" data-orientation="next">Proses</button>
						<!-- <button type="button" class="btn btn-default js-btn-step pull-left" data-orientation="cancel" data-dismiss="modal"></button>
						<button type="button" class="btn btn-warning js-btn-step" data-orientation="previous"></button>
						<button type="button" class="btn btn-success js-btn-step" data-orientation="next"></button> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<?php $this->load->view("template/bundle/template_scripts") ?>