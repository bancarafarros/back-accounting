<div class="card">
	<div class="card-body">
		<div class="row">
			<label class="col-2 col-sm-2 col-md-2 text-right control-label col-form-label">Bulan :</label>
			<div class="col-2 col-sm-2 col-md-2  pr-0">
				<select class="custom-select pr-0 range" id="bulanJ">
					<?= $optionBulan ?>
				</select>
			</div>
			<label class="col-2 col-sm-2 col-md-2 text-right pl-0 control-label col-form-label">Tahun :</label>
			<div class="col-2 col-sm-2 col-md-2">
				<select class="custom-select range" id="tahunJ">
					<?= $optionTahun ?>
				</select>
			</div>
			<div class="col" align="right">
				<button class="btn btn-sm btn-success" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-add" id="addjurnal"><i class="fa fa-plus"></i> Buat Pengajuan RAB</button>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered list-jurnal" id="daftarJurnal" style="width:100%">
				<thead class="thead-dark">
					<tr>
						<th width="5%">No</th>
						<th width="20%">Mata Anggaran</th>
						<th width="10%">Detail</th>
						<th width="10%">Keterangan</th>
						<th width="10%">Tahun Anggaran</th>
						<th width="15%">Jumlah</th>
						<th width="20%">Status</th>
						<th width="10%">Opsi</th>
					</tr>
				</thead>
				<!-- <tbody id="list_jurnal" style="display:inline-block; width:100%;"> -->
				<tbody id="list_jurnal">
					<?php $s = 1;
					foreach ($rab as $d) : ?>
						<tr>
							<td><?= $s ?></td>
							<td><?= $d->mata_anggaran; ?></td>
							<td><small><?= $d->detail ?></small></td>
							<td><?= $d->keterangan ?></td>
							<td><?= $d->ta ?></td>
							<td class="text-right"><?= currencyIDR($d->total) ?></td>
							<td>
								<?= status_rab($d->status) ?>
								<?= $d->status == 1 ? "<br><small class='text-primary'>Catatan: </small>" : "" ?>
							</td>
							<td>
								<?php if ($d->status == '0') : ?>
									<button type="button" data-id="<?= $d->id ?>" class="btn btn-warning btn-sm ubah_rab"><i class="fa fa-edit"></i></button>
									<button type="button" data-url="<?= site_url('rab/hapus_rab') ?>/<?= $d->id ?>" class="btn btn-danger btn-sm hapus_rab"><i class="fa fa-eraser"></i></button>
								<?php elseif ($d->status == 1) : ?>
									<button type="button" data-id="<?= $d->id ?>" class="btn btn-warning btn-sm ubah_rab"><i class="fa fa-edit"></i></button>
								<?php endif; ?>
							</td>
						</tr>
					<?php $s++;
					endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- ################################################################################################# -->
<div class="modal fade" id="modal-add" data-backdrop="static">
	<div class=" modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Isi Data RAB</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('rab') ?>/dosave" id="formadd" method="POST">
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-6 col-md-4">
							<div class="form-group">
								<label for="akun">Nomor Anggaran <span class="text-danger">*</span></label>
								<input type="text" name="akun" class="form-control akun akun0" id="akun" data-urut="0">
							</div>
						</div>
						<div class="col-sm-6 col-md-8">
							<div class="form-group mt-0">
								<label for="mata_anggaran">Mata Anggaran <span class="text-danger">*</span></label>
								<input type="text" class="form-control mata_anggaran" id="mata_anggaran" name="mata_anggaran" data-urut="0">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="detail">Detail <span class="text-danger">*</span></label>
						<div id="dinamis-detail">
							<div class="input-group mb-3" data-urut="0">
								<input type="text" name="detail[]" class="mr-1 form-control detail" placeholder="Detail">
								<input type="text" name="jumlah[]" class="ml-1 form-control jumlah jumlah0" placeholder="Jumlah" value="0">
								<div class="input-group-append">
									<button class="btn btn-success" id="addfield" data-urut="0" type="button"><i class="fa fa-plus"></i></button>
								</div>
							</div>
						</div>
						<input type="hidden" value="1" id="sum_detail">
					</div>
					<div class="row">
						<div class="col-sm-6 col-md-6">
							<div class="form-group mt-0">
								<label for="keterangan">Keterangan</label>
								<input type="text" name="keterangan" class="form-control keterangan" id="keterangan" data-urut="0" value="-">
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label for="detail">Total <span class="text-danger">*</span></label>
								<input type="text" name="total" value="0" class="form-control total" data-urut="0">
							</div>
						</div>
					</div>
					<input type="hidden" name="act" value="addrab">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
					<button type="button" id="save" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- ######################################################################## -->
<div id="myModalAkun" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true" data-modal-parent="#modal-add">
	<div class="modal-dialog" style="min-width:550px;">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Pilih Mata Anggaran</h4>
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
								<th>Nomor</th>
								<th>Nama Akun</th>
								<th>Pilih</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 0;
							foreach ($mata_anggaran as $key => $value) { ?>
								<tr>
									<td><?= $value->akun ?></td>
									<td><?= $value->nama ?></td>
									<input type="hidden" class="no_akun<?= $no ?>" value="<?= $value->akun ?>">
									<input type="hidden" class="no_namaakun<?= $no ?>" value="<?= $value->nama ?>">
									<td align="right"><a href="" class="badge badge-primary chsAkn chs_akun<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></a></td>
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
	$(function() {
		$('#addfield').click(function(e) {
			e.preventDefault();
			var urut = $(this).attr('data-urut');
			var next = parseInt(urut) + 1;
			var html = '<div class="input-group mb-3 dinamis-detail' + next + '" id="dinamis-detail"><input type="text" name="detail[]" class="mr-1 form-control detail" placeholder="Detail"><input valu="0" type="text" name="jumlah[]" class="ml-1 form-control jumlah jumlah' + next + '" placeholder="Jumlah"><div class="input-group-append"><button class="btn btn-danger removefield remove' + next + '" data-urut="' + next + '" type="button"><i class="fa fa-times"></i></button></div></div>';
			$(this).attr('data-urut', next);
			$('.remove' + urut).prop('disabled', true);
			var jumlah = parseInt($('#sum_detail').val());
			// console.log(jumlah);
			$('#sum_detail').val(jumlah + 1);
			$('#dinamis-detail').append(html);
		});

		$('body').on('click', '.removefield', function(e) {
			e.preventDefault();
			var urut = $(this).attr('data-urut');
			var prev = parseInt(urut) - 1;
			$('#addfield').attr('data-urut', prev);
			$('.remove' + prev).prop('disabled', false);
			var jumlah = parseInt($('#sum_detail').val());
			$('#sum_detail').val(jumlah - 1);
			$('.dinamis-detail' + urut).remove();
		});

		$('body').on('keyup', '.jumlah', function() {
			var jumlah = parseInt($('#sum_detail').val());
			var total = 0;
			for (let index = 0; index < jumlah; index++) {
				total += parseInt($('.jumlah' + index).val());
			}
			console.log(total)
			$('[name=total]').val(total);
		})
	})

	//form tambah Jurnal
	$('#formAddjurnal').on('keyup keypress', function(e) {
		if (e.which == 13) {
			e.preventDefault();
		}
	});
	$("#save").on('click keypress', function(e) {
		e.preventDefault();
		$.ajax({
			url: $('#formadd').attr('action'),
			type: "POST",
			data: $('#formadd').serialize(),
			dataType: "JSON",
			beforeSend: () => {
				showLoading()
			},
			success: function(response) {
				hideLoading()
				if (response.status) {
					$('body').append('<a class="d-none" role="button" target="_blank" id="btn-cetak">Cetak</a>');
					$('#btn-cetak').attr('href', (site_url + '/jurnal/cetak_nota/' + response.n_transaksi + '?download=false'));
					Swal.fire('Jurnal!', response.message, 'success').then((result) => {
						// document.getElementById("btn-cetak").click();
						// $('#modal-detail').modal('hide');
						// location.reload();
					});
				} else {
					Swal.fire('Jurnal', response.message, 'error').then((result) => {
						// location.reload();
					});
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				hideLoading()
				Swal.fire('Error!', 'Error Tambah/Update Data ', 'error').then((result) => {
					// location.reload();
				});
			}
		});
	});

	number_format = function(number, decimals, dec_point, thousands_sep) {
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
		var _debet = 0
		var _kredit = 0;
		var total_debet = (parseFloat($('.total_debet').val().replace(/,/g, "") || 0));
		var total_kredit = (parseFloat($('.total_kredit').val().replace(/,/g, "") || 0));
		var selisih = (parseFloat($('.selisih').val() || 0));
		for (let q = 0; q <= $('#sum_baris').val(); q++) {
			if ($('.adddebet' + q).val()) {
				_debet += parseFloat($('.adddebet' + q).val().replace(/,/g, "") || 0);
			}
			if ($('.addkredit' + q).val()) {
				_kredit += parseFloat($('.addkredit' + q).val().replace(/,/g, "") || 0);
			}
			selisih = _debet - _kredit;
			console.log(selisih);
			$('.total_debet').val(number_format(_debet, 2, '.', ','));
			$('.total_kredit').val(number_format(_kredit, 2, '.', ','));
			$('.selisih').val(number_format(selisih, 2, '.', ','));

		}
	}

	// start focus awal
	$(document).ready(function() {
		$("#modal-add").on('shown.bs.modal', function() {
			$(this).find('#reff').focus();
			$(this).find('#reff').select();
			$('#sum_baris').val(0)
		});
		$('#editJurnSave').hide()
		//focus modal

		$('#myModalAkun').on('shown.bs.modal', function() {
			$('input[type="search"]').val("");
			$('input[type="search"]').focus();
		});
		$('#myModalAkun').on('keydown', 'input[type="search"]', function(e) {
			if (e.which == 13) {
				$('.chsAkn:first').focus();
			}
		});
		$('#myModalAkun').on('hidden.bs.modal', function() {
			$('#adddebet' + $('#cekIndex').val()).focus();
		});

		$('.lookup').DataTable({
			"info": false,
			"paging": false,
		});
		$('.list-jurnal').DataTable({
			"info": false,
			"paging": false,
			"order": [
				[0, 'desc']
			]

		});
		$('#lookup_filter input').focus()
		//$('#lookup_filter [type="search"]').focus()
		$('.lookup-djurnal').DataTable({
			"info": false,
			"paging": false,
			"searching": false,
			"ordering": false,
			"order": [
				[2, 'asc'],
				[0, 'asc']
			]
		});
		$('#lookup_filter input').focus()
		//$('#lookup_filter [type="search"]').focus()
	});

	for (let s = 0; s < $(".sum_akun").val(); s++) {
		$(".chs_akun" + s).click(function() {
			//index = $('#cekIndex').val();
			$('#akun').val($('.no_akun' + s).val());
			$('.mata_anggaran').val($('.no_namaakun' + s).val());
			$('.mata_anggaran').prop('readonly', true);
		});
	}

	$(document).on('keypress', '.akun', function(event) {
		// $('.nama'+i).val("");
		var a = $(this).data('urut');
		akun = $('#akun').val();
		if (event.keyCode == 13) {
			$.getJSON("<?= site_url('rab/getAkun?akun=') ?>" + akun, function(json) {
				if (json.length > 0) {
					$('.mata_anggaran' + a).val(json[0].nama);
					event.preventDefault();
					return false;
				}
				if (json.length == 0) {
					$('#cekIndex').val(a);
					$('#myModalAkun').modal('show');
				}
			});
		}
	});
</script>