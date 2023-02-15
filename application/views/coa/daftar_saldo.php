<!-- Main content -->
<div class="content">
	<div class="justify-content-md-center">
		<div class="card">
			<div class="card-body">
				<div class="col mb-3" align="right">
					<button class="btn btn-sm btn-success" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-add" id="addjurnal"><i class="fa fa-book"></i> Buku Bantu</button>
				</div>
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
				</div>
				<div class="table-responsive">
					<table id="table_saldo" class="table table-sm">
						<thead class="thead-dark">
							<tr>
								<th style="width:5%">Akun</th>
								<th style="width:10%">Nama Perkiraan</th>
								<th style="width:5%">Saldo</th>
							</tr>
						</thead>
						<tbody id="show_saldo">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- ################################################################################################# -->
<div class="modal fade" id="modal-add" data-backdrop="static">
	<div class="modal-dialog" style="min-width: 90%; max-width: 90%;">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Buku Bantu</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="min-height: calc(100vh - 100px); max-height: calc(100vh - 100px); overflow-y: auto;">
				<div class="row">
					<div class="col col-md-3">
						<div class="cardModal" style="min-height: 360px">
							<h5 class="text-white bg-success p-2">Informasi</h5>
							<div class="card-body">
								<div class="row">
									<label class="col-sm-12 text-left control-label col-form-label">Akun Perkiraan</label>
								</div>
								<div class="row">
									<div class="input-group">
										<input type="text" class="form-control d_akun col-md-12" id="d_akun" name="akun" onkeypress="return false;">
										<div class="input-group-append">
											<a href="#myModalAkun" data-toggle="modal">
												<button class="btn btn-success" type="button"><i class="fa fa-search"></i></button>
											</a>
										</div>
									</div>
									
								</div>

								<div class="row mt-2">
									<label class="col-sm-12 text-left control-label col-form-label">Mulai Tanggal</label>
								</div>
								<div class="row">
									<div class="input-group">
										<input type="text" class="form-control col-12 date from_date datepicker" name="tanggal" value="<?= date("Y-m-d") ?>" readonly required>
										<div class="input-group-append">
											<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>

								<div class="row mt-2">
									<label class="col-sm-12 text-left control-label col-form-label">Hingga Tanggal</label>
								</div>
								<div class="row">
									<div class="input-group">
										<input type="text" class="form-control col-12 date to_date datepicker" name="tanggal" value="<?= date("Y-m-d") ?>" id="datepicker-autoclose2" readonly required>
										<div class="input-group-append">
											<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>
								<div class="row d-flex flex-row-reverse mt-4" style="margin-bottom:-10px;">
									<button class="btn btn-success cek" id="tampil" type="button">Tampilkan</button>
								</div>
							</div>
						</div>
					</div>

					<div class="col col-md-9 p-0">
						<div class="cardModal">
							<h5 class="text-white bg-success p-2 mb-0">Detail Buku Bantu</h5>
							<div class="card-body p-0">
								<div class="table-responsive mt-2" style="overflow-y: scroll; height: 360px;">
									<table class="table table-bordered detail-buku-bantu" style="width:100%" id="isi_detail">
										<thead class="" style="position: sticky; top: 0; display:block; z-index:2;background:#fff;">
											<tr>
												<th style="width:5%">Nomor</th>
												<th style="width:8%">Tanggal</th>
												<th style="width:13%">Keterangan</th>
												<th style="width:8%">Debet</th>
												<th style="width:8%">Kredit</th>
												<th style="width:8%">Saldo</th>
											</tr>
										</thead>
										<tbody id="show_bukubantu" style="display:inline-block; width:100%;">

										</tbody>
									</table>
									<div class="row col-md-12">
										<div class="col col-md-6">
										</div>
										<input type="text" class="total_debet form-control col-md-3 bg-success text-light" id="total_debet" value="0" style="text-align: right;" name="">
										<input type="text" class="total_kredit form-control col-md-3 bg-success text-light" id="total_kredit" value="0" style="text-align: right;" name="">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row mt-3">
					<!-- <div class="col col-md-3">

					</div> -->

					<div class="col col-md-8">
						<div class="cardModal">
							<h6 class="text-white bg-success p-2">Detail Jurnal</h6>
							<div class="card-body" style="padding-top:0px;padding-right:0px;padding-left:0px;min-height: 135px;max-height: 135px;overflow-y: auto;">
								<div class="table-responsive col-md-12" id="tbl_detail" style="display: none">
									<table class="table table-bordered lookup-detail" style="width:100%" id="isi_detail">
										<thead class="thead-dark">
											<tr>
												<th style="width:20%">Nomor</th>
												<th style="width:35%">Akun</th>
												<th style="width:22%">Debet</th>
												<th style="width:22%">Kredit</th>
											</tr>
										</thead>
										<tbody id="show_detail">

										</tbody>
									</table>
									<div class="row">
										<div class="col-md-6"></div>
										<input type="text" class="form-control col-md-3 bg-success text-light" id="sum_debet" style="text-align: right;">
										<input type="text" class="form-control col-md-3 bg-success text-light" id="sum_kredit" style="text-align: right;">
									</div>
									<div class="row">
										<div class="col-md-9"></div>
										<input type="text" class="form-control col-md-3 bg-danger text-light" id="sum_selisih" style="text-align: right; display: none;">
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col col-md-4">
						<div class="cardModal">
							<h6 class="text-white bg-success p-2">Hasil</h6>
							<div class="card-body" style="padding-top:0px;padding-right:0px;padding-left:0px;min-height: 135px;max-height: 135;overflow-y: auto;">
								<div class="row col-md-12">
									<label class="col-md-5 text-left control-label col-form-label"><strong>Saldo Awal</strong></label>
									<input type="text" class="form-control col-md-7 bg-success text-light" id="saldo_awal" style="text-align: right;" value="0.00" name="" readonly>
								</div>
								<div class="row col-md-12 mt-1">
									<label class="col-md-5 text-left control-label col-form-label"><strong>Mutasi</strong></label>
									<input type="text" class="form-control col-md-7 bg-success text-light" id="mutasi" style="text-align: right;" value="0.00" name="" readonly>
								</div>
								<div class="row col-md-12 mt-1">
									<label class="col-md-5 text-left control-label col-form-label"><strong>Saldo Akhir</strong></label>
									<input type="text" class="form-control col-md-7 bg-success text-light" id="saldo_akhir" style="text-align: right;" value="0.00" name="" readonly>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<!-- ######################################################################## -->
<div id="myModalAkun" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true" data-modal-parent="#modal-add">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Pilih Akun Perkiraan</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body" style=" max-height: calc(100vh - 150px); overflow-y: auto;">
				<div class="table-responsive">
					<table id="" class="table lookup-akun" width="100%">
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
									<td align="right"><a href="" class="btn btn-sm btn-success chs_akun<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></a></td>
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

	var from_date = '';
	var to_date = '';

	tampil_detail = function() {
		var table = $('#isi_detail').DataTable({
			"paging": false,
			"retrieve": true,
		});
		var n_akun = $('#d_akun').data("value");
		var from_date = $('.from_date').val();
		var to_date = $('.to_date').val();
		var saldo_awal = 0;

		$.getJSON("<?= site_url('Coa/getSaldobyAkun?') ?>" + "from_date=" + from_date + "&n_akun=" + n_akun, function(json) {
			var saldo_awal = (parseFloat(json[0].t_debet) || 0) - (parseFloat(json[0].t_kredit) || 0);
			$('#saldo_awal').val(number_format(saldo_awal, 2, '.', ','));
		});

		$.getJSON("<?= site_url('Coa/saldo_getDataRange?') ?>" + "from_date=" + from_date + "&to_date=" + to_date + "&n_akun=" + n_akun, function(json) {
			table.clear().draw();
			var html = '';
			var i;
			var saldo_awal = ($('#saldo_awal').val().replace(/,/g, "") || 0);
			var saldo_akhir = 0;
			var saldo = 0;
			var total_kredit = 0;
			var total_debet = 0;
			for (i = 0; i < json.length; i++) {
				var dbt = parseFloat(json[i].debet);
				var krd = parseFloat(json[i].kredit);
				var debet = number_format(parseFloat(dbt), 2, '.', ',');
				var kredit = number_format(parseFloat(krd), 2, '.', ',');
				var saldo = number_format(parseFloat(0), 2, '.', ',');
				total_debet += parseFloat(dbt);
				total_kredit += parseFloat(krd);
				saldo = number_format((total_debet - total_kredit + parseFloat(saldo_awal)), 2, '.', ',');
				table.row.add(['<a href="#tbl_detail" class="detail" data-kode="' + json[i].n_jurnal + '" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-detail">' + json[i].n_jurnal + '</a>', json[i].tanggal, json[i].keterangan, debet, kredit, saldo]);
			}

			mutasi = total_debet - total_kredit;
			saldo_akhir = (parseFloat($('#saldo_awal').val().replace(/,/g, "") || 0) + mutasi) || 0;
			// console.log(json, total_debet, total_kredit, mutasi);
			$('#show_bukubantu').html(html);
			$('#total_debet').val(number_format(total_debet, 2, '.', ','));
			$('#total_kredit').val(number_format(total_kredit, 2, '.', ','));
			$('#mutasi').val(number_format(mutasi, 2, '.', ','));
			$('#saldo_akhir').val(number_format(saldo_akhir, 2, '.', ','));
			table.columns.adjust().draw();
			// table.draw();
			$('#show_bukubantu tr td:nth-child(1)').css('width', '0.1%');
			$('#show_bukubantu tr td:nth-child(1)').css('padding', '7px 3px');
			$('#show_bukubantu tr td:nth-child(2)').css('width', '6%');
			$('#show_bukubantu tr td:nth-child(3)').css('width', '10%');
			$('#show_bukubantu tr td:nth-child(4)').css('width', '3%');
			$('#show_bukubantu tr td:nth-child(5)').css('width', '3% ');
			$('#show_bukubantu tr td:nth-child(6)').css('width', '3% ');
			$('#show_bukubantu tr td:nth-child(4)').css('text-align', 'right');
			$('#show_bukubantu tr td:nth-child(5)').css('text-align', 'right');
			$('#show_bukubantu tr td:nth-child(6)').css('text-align', 'right');

			if (json.length == 0) {
				Swal.fire('Buku Bantu', "Tidak ada transaksi di tanggal tersebut", 'warning')
			};
		});
	}
</script>

<script>
	$('#tampil').on('keypress click', function() {		
		var akun = $('#d_akun').val();
		from_date = $('.from_date').val();
		to_date = $('.to_date').val();
		if(akun === ''){
			Swal.fire('Buku Bantu', "Masukan Akun Perkiraan Terlebih dahulu", 'warning');
		}else if(from_date > to_date){
			Swal.fire('Buku Bantu', "Tanggal akhir tidak boleh kurang dari tanggal mulai", 'warning');
		}else{
			tampil_detail();
		}
	});


	$("body").on("click", ".detail", function() {
		var text = $(this).data('kode');
		var keterangan = $(this).data('keterangan');
		$("#tbl_detail").show();
		$("#lbl_detail").text(text + " - " + keterangan);
		$("#highlight").show();
		//tampil ajax jurnal
		$.getJSON("<?= site_url('Jurnal/getDetail?n_jurnal=') ?>" + text, function(json) {
			console.log(json);
			var html = '';
			var i;
			sum_debet = 0;
			sum_kredit = 0;
			sum_selisih = 0;
			for (i = 0; i < json.length; i++) {
				dbt = parseFloat(json[i].debet);
				krd = parseFloat(json[i].kredit);
				debet = number_format(parseFloat(dbt), 2, '.', ',');
				kredit = number_format(parseFloat(krd), 2, '.', ',');
				sum_debet = sum_debet + parseFloat(dbt);
				sum_kredit = sum_kredit + parseFloat(krd);
				sum_selisih = sum_debet - sum_kredit;
				$('#sum_debet').val(number_format(sum_debet, 2, '.', ','));
				$('#sum_kredit').val(number_format(sum_kredit, 2, '.', ','));
				$('#sum_selisih').val(number_format(sum_selisih, 2, '.', ','));
				html += '<tr>' +
					'<td>' + json[i].akun + '</td>' +
					'<td>' + json[i].nama_akun + '</td>' +
					'<td style="text-align:right">' + debet + '</td>' +
					'<td style="text-align:right">' + kredit + '</td>' +
					'</tr>';
			}
			sum_selisih = sum_debet - sum_kredit;
			console.log(sum_selisih);
			if (sum_selisih != 0) {
				$('#sum_selisih').show();
			} else if (sum_selisih == 0) {
				$('#sum_selisih').hide();
			};
			$('#show_detail').html(html);
		});
	});
</script>
<!-- <script>
	$(document).ready(function() {
		var to_date = $("#tahunJ").val() + '-' + $("#bulanJ").val();
		tampilSaldo(to_date);

		$('.lookup-saldo').DataTable({
			"info": false,
			"paging": false,
			"ordering": false,
			"searching": true
		});
		$('#lookup_filter input').focus()
		$('#lookup_filter [type="search"]').focus()
		
	});
</script> -->

<script>
	$(document).ready(function(){
		var to_date = $("#tahunJ").val() + '-' + $("#bulanJ").val();
		
		$('.range').on('change', function() {
			var to_date = $("#tahunJ").val() + '-' + $("#bulanJ").val();
			tampil_saldo(to_date);
		});

		tampil_saldo(to_date);

		$('#table_saldo').dataTable({
			"paging" : false
		});
		$('#lookup_filter input').focus()
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
		$('.lookup-akun').DataTable({
			"info": false,
			"paging": true,
			"searching": true,
			"ordering": true,
			"order": [
				[2, 'asc'],
				[0, 'asc']
			]
		});
		$('#lookup_filter input').focus()

		function tampil_saldo(to_date){
			$.ajax({
				type 	 : 'GET',
				url		 : "<?= site_url('Coa/getSaldo?to_date=') ?>" + to_date,
				async	 : false,
				dataType : 'json',
				success	 : function(json){
					var html = '';
					var i;
					var saldo = 0;
					for (i = 0; i < json.length; i++) {
						var spliter = json[i].akun.substr(0, 1);
						let vsaldo = 0;
						if (spliter == "1" || spliter == "5") {
							saldo = parseFloat(json[i].t_debet) - parseFloat(json[i].t_kredit);
						} else if (spliter == "2" || spliter == "3" || spliter == "4") {
							saldo = parseFloat(json[i].t_kredit) - parseFloat(json[i].t_debet);
						}

						if (saldo >= 0) {
							vsaldo = number_format(saldo, 2, '.', ',');
						} else {
							vsaldo = '(' + number_format((saldo * -1), 2, '.', ',') + ')';
						}
						html += '<tr>' +
							'<td>' + json[i].akun + '</td>' +
							'<td>' + json[i].nama + '</td>' +
							'<td style="text-align: right;">' + vsaldo + '</td>' +
							'</tr>';
					}

					$('#show_saldo').html(html);
				}
			});

			for (let s = 0; s < $(".sum_akun").val(); s++) {
				$(".chs_akun" + s).click(function() {
					index = $('#cekIndex').val();
					$('.d_akun').val($('.no_akun' + s).val() + " | " + $('.no_namaakun' + s).val());
					$('#d_akun').data("value", $('.no_akun' + s).val());
				});
			}
		}
	});
</script>