<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col mb-3" align="right">
				<button class="btn btn-success" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-add" id="addpencairan"><i class="fa fa-plus"></i> Ajukan Pencairan RAB</button>
			</div>
		</div>
		<div class="row">
			<label class="col-2 col-sm-2 col-md-2 text-right pl-0 control-label col-form-label">Tahun :</label>
			<div class="col-2 col-sm-2 col-md-2">
				<select class="custom-select range" id="tahunJ">
					<?= $optionTahun ?>
				</select>
			</div>
		</div>
		<div class="table-responsive mt-2">
			<table class="table table-hover list-jurnal" id="list-rab" style="width:100%">
				<thead class="thead-dark">
					<tr>
						<th width="5%">No</th>
						<th width="10%">Mata Anggaran</th>
						<th width="20%">RAB</th>
						<th width="20%">Keterangan</th>
						<th width="10%">Tahun Anggaran</th>
						<th width="10%">Jumlah</th>
						<th width="5%">Tanggal Pengajuan</th>
						<th width="20%">Status</th>
					</tr>
				</thead>
				<tbody>
					<?php $jumlah = 0;
					$s = 1;
					if (isset($pencairan)) :
						foreach ($pencairan as $d) : ?>
							<tr>
								<td>
									<a href="#tbl_detail" class="detail" data-kode="<?= $d->id ?>" data-keterangan="<?= $d->keterangan ?>" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-detail"><?= $s ?></a>
								</td>
								<td><?= $d->mata_anggaran ?></td>
								<td><?= $d->detail ?></td>
								<td><?= $d->keterangan; ?></td>
								<td><?= $d->ta ?></td>
								<td class="text-right"><?= formatRupiah($d->total) ?></td>
								<td><small><?= $d->created_at ?></small></td>
								<td>
									<?php if ($d->warek == 0 && $d->rektor == 0) {
										echo "<small class='text-danger'>Persetujuan Wakil Rektor II</small>";
									} elseif ($d->warek == 1 && $d->rektor == 0) {
										echo "<small class='text-danger'>Persetujuan Rektor</small>";
									} elseif ($d->warek == 1 && $d->rektor == 1 && $d->status ==  0) {
										echo "<small class='text-danger'>Transaksi oleh Bendahara</small>";
									} elseif ($d->warek == 1 && $d->rektor == 1 && $d->status ==  1) {
										echo "<small class='text-success'><b>Selesai</b></small>";
									} else {
										echo "<small class='text-danger'>-</small>";
									} ?>
								</td>
							</tr>
					<?php if ($d->warek == 1 && $d->rektor == 1 && $d->status == 1) {
								$jumlah += $d->total;
							}
							$s++;
						endforeach;
					endif; ?>
				</tbody>
			</table>
		</div>
		<h5 class="mt-3">Total yang sudah dicairkan : Rp. <?= currencyIDR($jumlah) ?></h5>
	</div>
</div>
<!-- Modal --->
<div class="modal fade" id="modal-add">
	<div class="modal-dialog" style="min-width: 90%; max-width: 90%;">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Tambah Pengajuan Pencairan RAB</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" id="formKasbank" action="<?= site_url('rab') ?>/pencairan_save">
					<div class="row mt-0">
						<div class="col-md-3">
							<div class="row">
								<div class="card col-md-12 p-0">
									<h5 class="text-white bg-primary p-2">INFORMASI</h5>
									<div class="card-body shadow" style="padding-top: 0px;">
										<input type="hidden" class="form-control col-md-12" id="n_transaksi" value="<?= $n_kasmasuk ?>" name="n_transaksi" onkeypress="return false;">
										<div class="row mt-2">
											<label class="col-sm-12 text-left control-label col-form-label">Tanggal</label>
										</div>
										<div class="row">
											<div class="input-group">
												<input type="text" class="form-control col-md-12" name="tgl_transaksi" value="<?= date("d-M-Y") ?>" id="datepicker-autoclose1" readonly required>
												<div class="input-group-append">
													<span class="input-group-text"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</div>
										<div class="row mt-2">
											<label class="col-sm-12 text-left control-label col-form-label">Keterangan</label>
										</div>
										<div class="row">
											<input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Catatan pencairan (Jika Ada)" shadow>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-9">
							<div class="card">
								<h6 class="card-title m-b-0 p-2 text-light bg-primary">Detail Transaksi</h6>
								<div class="card-body shadow p-0">
									<div class="row">
										<div class="table-responsive">
											<input type="hidden" name="jml_baris" id="jml_baris" value="0">
											<table class="table" id="isi_detail">
												<thead class="thead-dark">
													<tr>
														<th style="width:15%;">Akun</th>
														<th style="width:15%;">Mata Anggaran</th>
														<th style="width:40%;">RAB</th>
														<th style="width:20%;">Jumlah</th>
														<th>*</th>
													</tr>
												</thead>
												<tbody>
													<tr id="row0" class="dynamic-added">
														<input type="hidden" name="id_rab[]" id="id_rab0">
														<td>
															<input type="text" class="form-control akun" id="akun0" name="akun[]" data-urut="0">
														</td>
														<td>
															<input type="tex" class="form-control mata_anggaran" name="mata_anggaran[]" id="mata_anggaran0" data-urut="0">
														</td>
														<td>
															<input type="text" class="form-control detail" id="detail0" name="detail[]" data-urut="0">
														</td>
														<td>
															<input type="text" class="form-control jumlah money" style="text-align: right;" name="jumlah[]" id="jumlah0" data-urut="0" required>
														</td>
														<td id="action0"></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<div class="row mb-3 ml-2">
										<div class="row col-xl-6 col-6"></div>
										<div class="row col-xl-2 col-2"></div>
										<div class="row col-xl-4 col-md-4 col-sm-4 bg-danger">
											<label class="col-sm-7 col-6 col-md-5 control-label col-form-label pl-0 pr-0 text-light">
												<h6><b><i>TOTAL :</i></b></h6>
											</label>
											<div class="col-sm-6 col-6 col-md-7">
												<input type="text" class="form-control text-right border-0 bg-danger text-light pl-0 pr-0" style="font-size:16px;" id="total" value="0,00" name="sum_bayar" readonly>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-4"></div>
										<button type="button" class="form-control btn btn-primary mt-5 col-4 mb-3" id="simpan">Simpan</button>
									</div>
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
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Pilih RAB</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style=" max-height: calc(100vh - 150px); overflow-y: auto;">
				<input type="hidden" id="cekIndex">
				<div class="table-responsive">
					<table id="" class="table lookup" width="100%">
						<thead class="thead-dark">
							<tr>
								<th>Mata Anggaran</th>
								<th>Detail</th>
								<th>Pilih</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 0;
							foreach ($d_rabDG as $key => $value) { ?>
								<tr id="row0">
									<td><?= $value->mata_anggaran ?></td>
									<td><?= $value->detail ?></td>
									<input type="hidden" class="no_detail<?= $no ?>" value="<?= $value->detail ?>">
									<input type="hidden" class="no_id_rab<?= $no ?>" value="<?= $value->id ?>">
									<input type="hidden" class="no_mata_anggaran<?= $no ?>" value="<?= $value->mata_anggaran ?>">
									<input type="hidden" class="no_nama<?= $no ?>" value="<?= $value->nama ?>">
									<input type="hidden" class="no_ta<?= $no ?>" value="<?= $value->ta ?>">
									<td align="center">
										<a href="" class="badge badge-primary chsAkn chs_akun<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></a>
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
<?php $this->load->view('template/bundle/template_scripts'); ?>
<script>
	number_format = function(numbers, decimals, dec_point, thousands_sep) {
		var number = parseFloat(numbers)
		number = number.toFixed(decimals);
		var nstr = number.toString();
		nstr += '';
		x = nstr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? dec_point + x[1] : '';
		var rgx = /(\d+)(\d{3})/;

		while (rgx.test(x1))
			x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

		return x1 + x2;
	}

	function formatRupiah(angka, prefix) {
		var number_string = angka.replace(/[^-.\d]/g, '').toString(),
			split = number_string.split('.'),
			sisa = split[0].length % 3,
			rupiah = split[0].substr(0, sisa),
			ribuan = split[0].substr(sisa).match(/[-\d]{3}/gi);
		// tambahkan titik jika yang di input sudah menjadi angka ribuan
		if (ribuan) {
			separator = sisa ? ',' : '';
			rupiah += separator + ribuan.join(',');
		}

		rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
	}

	//hitung total
	function hitungTotal(totalB) {
		var _jumlah = 0
		var total = (parseFloat($('#total').val().replace(/,/g, "") || 0));
		for (let q = 0; q < parseFloat($('#jml_baris').val()) + 1; q++) {
			if ($('#jumlah' + q).val()) {
				_jumlah += parseFloat($('#jumlah' + q).val().replace(/,/g, "") || 0);
			}
			$('#total').val(number_format(_jumlah, 2, '.', ','));
		}
	}
</script>

<script>
	$(document).ready(function() {
		$(".bank").hide();
		$("#simpan").on('click keypress', function() {
			var baris = $('#jml_baris').val();
			if ($('#jml_baris').val() > 0) {
				if ($('#keterangan').val()) {
					for (p = 0; p < baris; p++) {
						if ($('#akun' + p).val()) {
							$("#jumlah" + p).val($("#jumlah" + p).val().replace(/[^-.\d]/g, ''));
						}
					}
					$('#total').val($('#total').val().replace(/[^-.\d]/g, ''))
					$('#row' + baris).remove();
					$('#formKasbank').submit();
					setTimeout(function() {
						location.reload();
					}, 1000)
				} else {
					alert('Data Keterangan Masih Masih Kosong');
				}
			} else {
				alert('Data Masih Kosong');
			}
		});

		for (let s = 0; s < $(".sum_akun").val(); s++) {
			$(".chs_akun" + s).click(function() {
				index = $('#cekIndex').val();
				$('#id_rab' + index).val($('.no_id_rab' + s).val());
				$('#akun' + index).val($('.no_mata_anggaran' + s).val());
				$('#mata_anggaran' + index).val($('.no_nama' + s).val());
				$('#detail' + index).val($('.no_detail' + s).val());
			});
		}

		$(document).on('keypress', '.akun', function(event) {
			// $('.nama'+i).val("");
			var akun = $(this).val();
			console.log(akun);
			var i = $(this).data('urut');
			if (event.keyCode == 13) {
				$.getJSON("<?= site_url('rab/getAnggaran?id_rab=') ?>" + akun, function(json) {
					if (json.length > 0) {
						$('#akun' + i).val(json[0].akun);
						$('#jumlah' + i).focus();
					}
					if (json.length == 0) {
						$('#cekIndex').val(i);
						$('#myModalAkun').modal('show');
					}
				});
			}
		});
		$(document).ready(function() {
			$('.lookup').DataTable({
				"responsive": true
			});
			$('.lookup_filter input').focus()
			//$('.lookup_filter [type="search"]').focus()
			$('.lookup-edit').DataTable({
				"responsive": true
			});
			$('.lookup_filter input').focus()
			//$('#lookup_filter [type="search"]').focus()
		});
		var a = 1;
		$(document).on('keyup', '.jumlah', function(event) {
			$(this).val(formatRupiah(this.value))
			harga = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
			var i = $(this).data('urut')
			if (event.keyCode == 13) {
				if ($("#jumlah" + i).val() == 0) {
					if (a > 1) {
						alert("Isi nominal terlebih dahulu!");
					}
					a += 1;
				} else if ($("#jumlah" + i).val() != 0 && $(".akun" + i).val() != "" && $(".nama" + i).val() != "") {
					var j = i + 1;
					z = parseFloat($('#jumlah' + i).val().replace(/,/g, ''));
					$('#jumlah' + i).val(number_format(z, 2, '.', ','));
					if (i == $('#jml_baris').val()) {
						html = '<tr id="row' + j + '" class="dynamic-added">' +
							'<input type="hidden" name="id_rab[]" id="id_rab' + j + '">' +
							'<td>' + '<input type="text" class="form-control akun" name="akun[]" id="akun' + j + '" data-urut="' + j + '">' + '</td>' +
							'<td>' + '<input type="text" class="form-control mata_anggaran" name="mata_anggaran[]" id="mata_anggaran' + j + '" data-urut="' + j + '">' + '</td>' +
							'<td>' + '<input type="text" class="form-control detail" name="detail[]" id="detail' + j + '" data-urut="' + j + '">' + '</td>' +
							'<td>' + '<input type="text" class="form-control jumlah money" style="text-align: right;" id="jumlah' + j + '" name="jumlah[]" data-urut="' + j + '">' + '</td>' +
							'<td id="action' + j + '">' + '' + '</td>' +
							'</tr>';
						$('#isi_detail tbody').append(html);
						$('#akun' + i).prop('readonly', true);
						$('#mata_anggaran' + i).prop('readonly', true);
						$('#detail' + i).prop('readonly', true);
						$("#jumlah" + i).prop('required', true);
						$('#jml_baris').val(parseFloat($('#jml_baris').val()) + 1);
						$('#action' + i).html('<a href="#" class="badge badge-danger btn_remove" id="' + i + '">x</a>')
						a = 1;
						$('#akun' + j).focus();
					}
				} else {
					alert("Harap pilih perkiraan terlebih dahulu!");
				}
			}
			hitungTotal();
		});

		$('body').on('click', '.btn_remove', function() {
			var id = $(this).attr("id");
			total = parseFloat($('#total').val().replace(/,/g, "")) - parseFloat($('#jumlah' + id).val().replace(/,/g, ""));
			$('#total').val(number_format(total, 2, ".", ","));
			$('#row' + id).remove();
		});
	});

	$('#formKasbank').on('keyup keypress', function(e) {
		if (e.which == 13) {
			e.preventDefault();
		}
	});
	$('.inf_trans').on('keyup keypress', function(e) {
		if (e.which == 32) {
			e.preventDefault();
		}
	});
	//focus
	$(document).ready(function() {
		$('#reff').focus();
		$('.modal').on('shown.bs.modal', function() {
			$('input[type="search"]').val("");
			$('input[type="search"]').focus();
		});
		$('#myModalBank').on('hidden.bs.modal', function() {
			$('#masuk').focus();
		});

		$('#myModalAkun').on('hidden.bs.modal', function() {
			$('#jumlah' + $('#cekIndex').val()).focus();
		});
		$('#myModalBank').on('keyup', 'input[type="search"]', function(e) {
			if (e.which == 13) {
				$('.chsBnk:first').focus();
			}
		});
		$('#myModalAkun').on('keydown', 'input[type="search"]', function(ev) {
			if (ev.keyCode == 13) {
				$('.chsAkn:first').focus();
			}
		});

	});
	$('#reff').on('keypress', function(e) {
		if (e.which == 13) {
			$("#keterangan").focus();
		}
	});
	$('#keterangan').on('keypress', function(e) {
		if (e.which == 13) {
			$('#kas').focus();
		}
	});
	$('#kas').keypress(function(e) {
		if (e.which == 13) {
			$("#masuk").focus();
		}
		if (e.which == 32) {
			$("#kas").removeClass('btn-success');
			$("#kas").addClass('btn-secondary');
			$('#bank').removeClass('btn-secondary');
			$('#bank').addClass('btn-success');
			$(".bank").show();
			$('#myModalBank').modal('show');
			if ($('#masuk').hasClass('btn-success')) {
				$('#n_transaksi').val('<?= $n_bankmasuk ?>');
				$('#status').val('M');
			} else if ($('#keluar').hasClass('btn-success')) {
				$('#n_transaksi').val('<?= $n_bankkeluar ?>');
				$('#status').val('K');
			}
		}
	});
	$('#masuk').keypress(function(e) {
		if (e.which == 13) {
			$("#akun0").focus();
		}
		if (e.which == 32) {
			$("#masuk").removeClass('btn-success');
			$("#masuk").addClass('btn-secondary');
			$('#keluar').removeClass('btn-secondary');
			$('#keluar').addClass('btn-success');
			$('#akun0').focus()
			if ($('#kas').hasClass('btn-success')) {
				$('#n_transaksi').val('<?= $n_kaskeluar ?>');
				$('#status').val('K');
				$('#bayar').val('KAS');
			} else if ($('#bank').hasClass('btn-success')) {
				$('#n_transaksi').val('<?= $n_bankkeluar ?>');
				$('#status').val('K');
			}
		}
	});
	$(document).on('keypress', '.akun', function(e) {
		if (e.which == 32) {
			$('#simpan').focus();
		}
	});
</script>