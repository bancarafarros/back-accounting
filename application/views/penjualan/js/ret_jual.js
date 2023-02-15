//btn-proses
$('#bt_proses').on('click keypress', function() {
		if ($('#total_jual').val().replace(/[^-.\d]/g, '') != 0) {
			$('#myModalProses').modal('show');
		} else {
			Swal.fire('Retur Penjualan', 'Data Masih belum diisi dan total tidak boleh 0', 'warning')
		}
	});

	//modalproses
	$(document).ready(function() {
		$('#myModalProses').modalSteps({
			btnCancelHtml: "Cancel",
			btnPreviousHtml: "Kembali",
			btnNextHtml: "Pembayaran",
			btnLastStepHtml: "Simpan",
			disableNextButton: false,
			completeCallback: function() {
				var sel = $('.sum_baris').val();
				if ($('.d_Pelanggan').val()) {
					if ($('#sisa_bayar').val() == 0 || $('#sisa_bayar').val() == 0.00) {
						for (let br = 0; br < sel; br++) {
							parseFloat($('#harga_barang' + br).val($('#harga_barang' + br).val().replace(/[^-.\d]/g, '')));
							parseFloat($('#total' + br).val($('#total' + br).val().replace(/[^-.\d]/g, '')));
							parseFloat($('#qty_barang' + br).val($('#qty_barang' + br).val().replace(/[^-.\d]/g, '')));
						}
						$('#total_jual').val($('#total_jual').val().replace(/[^-.\d]/g, ''));
						$('#jml_bayar').val($('#jml_bayar').val().replace(/[^-.\d]/g, ''));
						$('#sisa_bayar').val($('#sisa_bayar').val().replace(/[^-.\d]/g, ''));
						$('#biaya_kirim').val($('#biaya_kirim').val().replace(/[^-.\d]/g, ''));
						$('#ppn_jual').val($('#ppn_jual').val().replace(/[^-.\d]/g, ''));
						$('.total_all').val($('.total_all').val().replace(/[^-.\d]/g, ''));
						$('.total_hppall').val($('.total_hppall').val().replace(/[^-.\d]/g, ''));
						$('#formPenj').submit();
						setTimeout(function() {
							location.reload();
						}, 1000)
					} else {
						Swal.fire('Retur Penjualan', 'Transaksi Retur barang tidak dapat melalui pembayaran kredit', 'warning');
					}
				} else {
					Swal.fire('Retur Penjualan', "Data Pelanggan Belum diisi", 'warning');
					$('.d_Pelanggan').focus()
				}
			},
			callbacks: {},
			getTitleAndStep: function() {
				$("#n_db").text($("#i_database").val());
				$("#n_perusahaan").text($("#i_perusahaan").val());
				$("#n_alamat").text($("#i_alamat").val());
				$("#n_telp").text($("#i_telp").val());
				$("#c_kas").focus();
			}
		});
	});

	function hitungTotal(totalB) {
		var totalB = 0
		var total = 0;
		var totalD = 0;
		var totalJual = $('#total_jual').val();
		var ppn = parseFloat($("#ppn_jual").val().replace(/[^-.\d]/g, ''));
		var kirim = parseFloat($("#biaya_kirim").val().replace(/[^-.\d]/g, ''));
		var bayar = parseFloat($("#jml_bayar").val().replace(/[^-.\d]/g, ''));
		var uangMuka = parseFloat($("#uang_muka").val());
		for (let q = 0; q < $('.sum_baris').val(); q++) {
			if ($('#total' + q).val()) {
				total += parseFloat($('#total' + q).val().replace(/[^-.\d]/g, ''));
				totalD += parseFloat($('#totDiskon' + q).val());
			}
			$('#set_total').val(number_format(total, 2, '.', ','));
			$('#set_ppn').val(number_format(ppn, 2, '.', ','));
			$('#set_kirim').val(number_format(kirim, 2, '.', ','));
			$('#total_jual').val(number_format(total, 2, '.', ','));
			$('#total_diskon').val(totalD);
			$('.total_all').val(number_format(parseFloat(total + ppn + kirim), 2, '.', ','));
			$('#sisa_bayar').val(number_format(parseFloat(total + ppn + kirim - bayar - uangMuka), 2, '.', ','));
		}
	}

	function hitungTotalHpp(totalhpp) {
		var totalhpp = 0;
		for (let q = 0; q < $('.sum_baris').val(); q++) {
			if ($('#total_hpp' + q).val()) {
				totalhpp += parseFloat($('#total_hpp' + q).val());
			}
			$('.total_hppall').val(totalhpp);
		}
	}

	//format angka select
	$(".money").on("click", function() {
		$(this).select();
	});

	// Format mata uang	
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

	/* Fungsi formatRupiah */
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

	// get data hutang pemasok
	function getPiutang(pelanggan) {
		$.getJSON("<?= site_url('Piutang/getKartu?no_pelanggan=') ?>" + pelanggan, function(json) {
			var html = '';
			var i;
			sum_sisa = 0;
			for (i = 0; i < json.length; i++) {
				sum_sisa = sum_sisa + parseFloat(json[i].sisa);
				$(".sum_sisa").val(number_format(sum_sisa, 2, '.', ','));
			}
		});
	}
	// pilih sales & pelanggan
	for (let s = 0; s < $(".sum_pelanggan").val(); s++) {
		$(".chs_pelanggan" + s).on('click keypress', function() {
			$(".d_Pelanggan").val($('.no_pelanggan' + s).val() + " | " + $('.nama_pelanggan' + s).val());
			$(".d_Sales").val($('.nama_sales' + s).val());
			$(".d_nSales").val($('.n_sales' + s).val());
			$(".d_Batas").val(number_format(parseFloat($('.batas_kredit' + s).val()), 2, '.', ','));
			getPiutang($('.no_pelanggan' + s).val());
			$("#ketr").val("Retur Penjualan a/n " + $('.nama_pelanggan' + s).val())
		});
	}

	for (let s = 0; s < $(".sum_sales").val(); s++) {
		$(".chs_sales" + s).click(function() {
			$(".d_Sales").val($('.nama_sales' + s).val());
			$(".d_nSales").val($('.n_sales' + s).val());
		});
	}

	$(document).on('keypress', '.d_Pelanggan', function(e) {
		if (e.keyCode == 13) {
			var detail = $(this).val();
			//tampil ajax barang
			$.getJSON("<?= site_url('Pelanggan/getPelanggan?n_pelanggan=') ?>" + detail, function(json) {
				var value = json.n_pelanggan + " | " + json.nama;
				$(".d_Pelanggan").val(value);
				$(".d_Batas").val(number_format(parseFloat(parseFloat(json.batas)), 2, '.', ','));
				if (json == false) {
					$(".d_Pelanggan").val("");
					$('#myModalPelanggan').modal('show');
				}
				if (json != false) {
					getPiutang(detail);
					$('#n_barang0').focus();
					$("#ketr").val("Retur Barang ke " + json.nama)
				}
			});
		}
	});

	// cara bayar
	$('.bank').hide();
	$('.bank').attr("disabled");
	$("#c_kas").click(function() {
		$("#c_bank").removeClass('btn-success');
		$("#c_bank").addClass('btn-secondary');
		$(this).removeClass('btn-secondary');
		$(this).addClass('btn-success');
		$("#c_bayar").val($(this).val());
		$('.bank').hide();
		$('.bank').attr("disabled");
		$("#d_Bank").val("");
	});
	$("#c_bank").click(function() {
		$("#c_kas").removeClass('btn-success');
		$("#c_kas").addClass('btn-secondary');
		$(this).removeClass('btn-secondary');
		$(this).addClass('btn-success');
		$("#c_bayar").val($(this).val());
		$('.bank').show();
		$('.bank').removeAttr("disabled");
	});
	for (let s = 0; s < $(".sum_bank").val(); s++) {
		$(".chs_bank" + s).click(function() {
			$("#d_Bank").val($('.no_bank' + s).val() + " | " + $('.nama_bank' + s).val());
			$("#d_akunBank").val($('.akun_bank' + s).val());
		});
	}

	// tambah baris daftar barang
	var total_all = 0;
	$(document).on('keypress', '.sn_barang1', function(e) {
		// var index = $(this).data('index');
		var keyCode = (event.keyCode ? event.keyCode : event.which);
		if (keyCode == 13) {
			// if (index == $('.sum_baris').val()) {
			var detail = $(this).val();
			//tampil ajax barang
			$.getJSON("<?= site_url('Barang/getDetailMulti?n_barang=') ?>" + detail, function(json) {
				$("#kd_barang").val(json.n_barang);
				$("#nm_barang").val(json.nama);
				$("#unit_barang").val(json.n_unit);
				$("#bunit_barang").val(json.b_unit);
				$("#unit_conv").val(json.konversi_unit);
				$("#hpp_barang").val(json.harga_pokok);
				$("#h_barang").val(json.harga_jual1);
				$("#akun_psd").val(json.akun_persediaan);
				$("#akun_hpp").val(json.akun_hpp);
				$("#akun_pdpt").val(json.akun_pendapatan);

				if (json == false) {
					$('#myModalBarang').modal('show');
				}

			});
		}
		if (e.which == 32) {
			$("#ketr").focus();
		}
	});

	//isi data barang dengan modal
	for (let b = 0; b < $(".sum_barang").val(); b++) {
		$(".chs_barang" + b).click(function() {
			$.getJSON("<?= site_url('Barang/getDetailMulti?n_barang=') ?>" + $(this).data('id'), function(json) {
				$("#kd_barang").val(json.n_barang);
				$("#nm_barang").val(json.nama);
				$("#unit_barang").val(json.n_unit);
				$("#bunit_barang").val(json.b_unit);
				$("#unit_conv").val(json.konversi_unit);
				$("#hpp_barang").val(json.harga_pokok);
				$("#h_barang").val(json.harga_jual1);
				$("#akun_psd").val(json.akun_persediaan);
				$("#akun_hpp").val(json.akun_hpp);
				$("#akun_pdpt").val(json.akun_pendapatan);

			});
		});
	}

	$("#add_barang").on('click keypress', function() {
		if ($('#nm_barang').val()) {
			var u = $('.sum_baris').val();
			$('#dynamic_field').append('<tr id="row' + u + '" "class="dynamic-added">' +
				'<input type="hidden" id="conv_unit' + u + '" name="conversiUnit' + u + '" value="1" readonly>' +
				'<input type="hidden" name="h_diskon' + u + '" id="totDiskon' + u + '" value="0" readonly>' +
				'<input type="hidden" name="akunpersediaan' + u + '" id="akunpersediaan' + u + '" value="' + $("#akun_psd").val() + '" readonly>' +
				'<input type="hidden" name="akunhpp' + u + '" id="akunhpp' + u + '" value="' + $("#akun_hpp").val() + '" readonly>' +
				'<input type="hidden" name="akunpendapatan' + u + '" id="akunpendapatan' + u + '" value="' + $("#akun_pdpt").val() + '" readonly>' +
				'<input type="hidden" name="harga_diskon' + u + '" id="harga_diskon' + u + '" value="' + $("#h_barang").val() + '" readonly>' +
				'<input type="hidden" id="hargaT_asli' + u + '" name="hargaT_asli' + u + '" value="' + $("#h_barang").val() + '" readonly>' +
				'<input type="hidden" id="harga' + u + '" name="harga' + u + '" value="' + $("#h_barang").val() + '" readonly>' +
				'<td class="p-2" style="width:10%;">' +
				'<input type="text" class="form-control m-0 p-2 bg-white col sn_barang" name="n_barang' + u + '" id="n_barang' + u + '" data-index="' + u + '" value="' + $("#kd_barang").val() + '" readonly>' +
				'</td>' +
				'<td class="p-2" style="width:25%;">' +
				'<input type="text" class="form-control m-0 p-2 bg-white col" name="nama_barang' + u + '" id="nama_barang' + u + '" value="' + $("#nm_barang").val() + '" readonly>' +
				'</td>' +
				'<td class="p-2" style="width:7%;">' +
				'<input type="text" class="form-control m-0 p-2 bg-white col qtyB text-center" name="qty_barang' + u + '" data-index="' + u + '" id="qty_barang' + u + '" value="1">' +
				'</td>' +
				'<td class="p-2" style="width:13%;">' +
				'<select class="form-control convUnit" name="satuan_barang' + u + '" id="satuan_barang' + u + '" data-index="' + u + '">' +
				'<option value="1" id="e_nUnit' + u + '">' + $("#unit_barang").val() + '</option>' +
				'<option value="' + $("#unit_conv").val() + '" id="e_bUnit' + u + '">' + $("#bunit_barang").val() + '</option>' +
				'</select>' +
				'</td>' +
				'<td class="p-2" style="width:16%;">' +
				'<input type="text" class="form-control m-0 p-2 bg-white col h_barang text-right" name="harga_barang' + u + '" id="harga_barang' + u + '" value="' + number_format($("#h_barang").val(), 2, '.', ',') + '" data-index="' + u + '">' +
				'<input type="hidden" name="harga_hpp' + u + '" id="harga_hpp' + u + '" data-index="' + u + '" value="' + $("#hpp_barang").val() + '" readonly>' +
				'</td>' +
				'<td class="p-2" style="width:10%;">' +
				'<input type="text" class="form-control m-0 p-2 bg-white col diskon text-center" name="diskon' + u + '" id="diskon' + u + '" value="0" data-index="' + u + '">' +
				'</td>' +
				'<td class="p-2" style="width:16%;">' +
				'<input type="text" class="form-control m-0 p-2 bg-white col totalsPj text-right" id="total' + u + '" name="total' + u + '" data-index="' + u + '" value="' + number_format($("#h_barang").val(), 2, '.', ',') + '">' +
				'<input type="hidden" class="form-control m-0 p-2 bg-white col totalsHpp" id="total_hpp' + u + '" name="total_hpp' + u + '" data-index="' + u + '" value="' + $("#hpp_barang").val() + '">' +
				'</td>' +
				'<td class="p-2" id="action' + u + '" style="width:0%;">' +
				'<button type="button" name="remove" data-index="' + u + '" class="btn btn-danger btn_remove" value="" >X</button>' +
				'</td>' +
				'</tr>');
			$('.sum_baris').val(parseFloat($('.sum_baris').val()) + 1);
			hitungTotal();
			hitungTotalHpp();
			$("#kd_barang").val('');
			$("#nm_barang").val('');
			$("#bunit_barang").val('');
			$("#unit_barang").val('');
			$("#unit_conv").val('');
			$("#hpp_barang").val('');
			$("#h_barang").val('');
			$("#akun_psd").val('');
			$("#akun_hpp").val('');
			$("#akun_pdpt").val('');
		} else {
			Swal.fire('Retur Penjualan', 'Barang masih kosong', 'warning')
		}
	});

	$(document).on('click', '.btn_remove', function() {
		var id = $(this).data("index");
		$('#row' + id).remove();

		hitungTotal();
		hitungTotalHpp();
	});

	$(document).on('keypress keyup blur', '.qtyB', function() {
		$(this).val(formatRupiah(this.value));
		qty = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
		var id = $(this).data("index");
		$("#hargaT_asli" + id).val($('#harga_barang' + id).val().replace(/[^-.\d]/g, '') * qty);
		$('#totDiskon' + id).val(parseFloat(($('#harga_barang' + id).val().replace(/[^-.\d]/g, '') * ($('#diskon' + id).val() / 100)) * qty * $('#conv_unit' + id).val()));
		$('#total_hpp' + id).val(parseFloat($('#harga_hpp' + id).val() * qty));
		$('#total' + id).val(parseFloat((qty * $('#conv_unit' + id).val() * $('#harga_barang' + id).val().replace(/[^-.\d]/g, '')) - $('#totDiskon' + id).val()));
		$('#total' + id).val(number_format($('#total' + id).val(), 2, '.', ','))
		$("#harga_diskon" + id).val(parseFloat($('#harga' + id).val() * $('#conv_unit' + id).val() - ($('#harga' + id).val() * ($('#diskon' + id).val() / 100))));

		hitungTotal();
		hitungTotalHpp();
	});

	$(document).on('change', '.convUnit', function() {
		var id = $(this).data("index");
		var unit = $(this).val();
		$('#conv_unit' + id).val(unit);
		$('#harga_barang' + id).val(number_format(parseFloat($('#harga' + id).val() * unit), 2, '.', ','));
		$("#hargaT_asli" + id).val($('#harga_barang' + id).val().replace(/[^-.\d]/g, '') * $('#qty_barang' + id).val().replace(/[^-.\d]/g, '') * unit)
		$('#totDiskon' + id).val(parseFloat(($('#harga_barang' + id).val().replace(/[^-.\d]/g, '') * ($('#diskon' + id).val() / 100)) * $('#qty_barang' + id).val().replace(/[^-.\d]/g, '') * unit));
		$('#total' + id).val(parseFloat(($('#qty_barang' + id).val().replace(/[^-.\d]/g, '') * $('#harga_barang' + id).val().replace(/[^-.\d]/g, '')) - $('#totDiskon' + id).val()));
		$('#total' + id).val(number_format($('#total' + id).val(), 2, '.', ','))
		$('#total_hpp' + id).val(parseFloat(($('#harga_hpp' + id).val() * $('#qty_barang' + id).val().replace(/[^-.\d]/g, '') * unit)));
		hitungTotal();
		hitungTotalHpp();
	});

	$(document).on('keyup', '.h_barang', function() {
		$(this).val(formatRupiah(this.value))
		harga = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
		var id = $(this).data("index");
		$("#hargaT_asli" + id).val(harga * $('#qty_barang' + id).val().replace(/[^-.\d]/g, ''));
		$("#harga_diskon" + id).val(harga - (harga * ($('#diskon' + id).val() / 100)));
		$('#totDiskon' + id).val(parseFloat((harga * ($('#diskon' + id).val() / 100)) * $('#qty_barang' + id).val().replace(/[^-.\d]/g, '')));
		$('#total' + id).val(parseFloat(($('#qty_barang' + id).val().replace(/[^-.\d]/g, '') * harga) - $('#totDiskon' + id).val()));
		$('#total' + id).val(number_format($('#total' + id).val(), 2, '.', ','))
		hitungTotal();
	});

	$(document).on("click", '.detail_penjualan', function() {
		hargah = parseFloat($(this).val()) || 0;
		var id = $(this).data("index");
		$('#total_hpp' + id).val(parseFloat($('#qty_barang' + id).val().replace(/[^-.\d]/g, '') * $('#conv_unit' + id).val() * hargah));
		hitungTotalHpp();
	});

	$(document).on("click", '.diskon', function() {
		$(this).select();
	});
	$(document).on('keyup', '.diskon', function() {
		$(this).val(formatRupiah(this.value));
		diskon = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
		if (diskon > 100) {
			diskon = 100;
			$(this).val(100);
			$(this).select();
		}
		if (diskon < 0) {
			diskon = 0;
			$(this).val(0);
			$(this).select();
		}
		if (diskon == "") {
			diskon = 0;
			$(this).val(0);
			$(this).select();
		}
		var id = $(this).data("index");
		$('#harga_diskon' + id).val(parseFloat($('#harga_barang' + id).val().replace(/[^-.\d]/g, '') - ($('#harga_barang' + id).val().replace(/[^-.\d]/g, '') * (diskon / 100))));
		$('#totDiskon' + id).val(parseFloat(($('#harga_barang' + id).val().replace(/[^-.\d]/g, '') * (diskon / 100)) * $('#qty_barang' + id).val().replace(/[^-.\d]/g, '')));
		$('#total' + id).val(parseFloat(($('#qty_barang' + id).val().replace(/[^-.\d]/g, '') * $('#harga_barang' + id).val().replace(/[^-.\d]/g, '')) - $('#totDiskon' + id).val()));
		$('#total' + id).val(number_format($('#total' + id).val(), 2, '.', ','))
		hitungTotal();
	});

	$(document).on('keyup', '.totalsPj', function(e) {
		if (e.keyCode != 13) {
			$(this).val(formatRupiah(this.value))
			totalB = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
			var id = $(this).data("index");
			$('#totDiskon' + id).val(0);
			$('#diskon' + id).val(0)
			$('#harga_barang' + id).val(parseFloat((totalB / $('#qty_barang' + id).val().replace(/[^-.\d]/g, ''))));
			$('#harga_barang' + id).val(number_format($('#harga_barang' + id).val(), 2, '.', ','));
			$("#harga_diskon" + id).val($('#harga_barang' + id).val().replace(/[^-.\d]/g, '') - ($('#harga_barang' + id).val().replace(/[^-.\d]/g, '') * ($('#diskon' + id).val() / 100)));
			hitungTotal();
		}
	});

	$(document).on('keyup', '.totalsHpp', function() {
		totalH = parseFloat($(this).val()) || 0;
		var id = $(this).data("index");
		$('#total_hpp' + id).val(0);
		$('#harga_hpp' + id).val(0);
		hitungTotalHpp();
	});

	$('#ppn_jual').keyup(function() {
		$(this).val(formatRupiah(this.value));
		ppn = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
		hitungTotal()
	});
	$('#biaya_kirim').keyup(function() {
		$(this).val(formatRupiah(this.value));
		kirim = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
		hitungTotal()
	});
	$('#jml_bayar').keyup(function() {
		$(this).val(formatRupiah(this.value));
		bayar = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
		hitungTotal()
	});

	$('#formPenj').on('keyup keypress', function(e) {
		if (e.which == 13) {
			e.preventDefault();
		}
	});


	$(document).ready(function() {
		$('#lookup').DataTable({
			"responsive": true,
			"info": false,
			"processing": true
		});
		$('#lookup_filter input').focus()
		//$('#lookup_filter [type="search"]').focus()
		$('#lookup-1').DataTable({
			"responsive": true,
			"info": false,
			"processing": true
		});
		$('#lookup_filter input').focus()
		//$('#lookup_filter [type="search"]').focus()
		$('#lookup-2').DataTable({
			"responsive": true,
			"info": false,
			"processing": true
		});
		$('#lookup_filter input').focus()
		//$('#lookup_filter [type="search"]').focus()
		$('#lookup-3').DataTable({
			"responsive": true,
			"info": false,
			"processing": true
		});
		$('#lookup-4').DataTable({
			"responsive": true,
			"info": false,
			"processing": true
		});
		$('#lookup_filter input').focus()
		//$('#lookup_filter [type="search"]').focus()
	});

	//retur barang
	$(".ins_retur").click(function() {
		var detail = $("#no_penjualan").val();
		$('#reff').val(detail)
		$('#myModalPenjualan').modal('hide');
		$('#row0').remove();
		$.getJSON("<?= site_url('Penjualan/getPenjualan?n_penjualan=') ?>" + detail, function(json) {
			var u;
			for (u = 0; u < json.length; u++) {
				var hapok = 0;
				var unitQty = 1;
				if (json[u].satuan == json[u].bigUnit) {
					unitQty = json[u].conv_unit;
					hapok = json[u].jumlah * json[u].hargapokok;
				}
				$('#dynamic_field').append('<tr id="row' + u + '" "class="dynamic-added">' +
					'<input type="hidden" id="conv_unit' + u + '" name="conversiUnit' + u + '" value="' + unitQty + '" readonly>' +
					'<input type="hidden" name="h_diskon' + u + '" id="totDiskon' + u + '" value="' + parseFloat((json[u].harga_asli * json[u].jumlah) - (json[u].harga * json[u].jumlah)) + '" readonly>' +
					'<input type="hidden" name="akunpersediaan' + u + '" id="akunpersediaan' + u + '" value="' + json[u].akunpsd + '" readonly>' +
					'<input type="hidden" name="akunhpp' + u + '" id="akunhpp' + u + '" value="' + json[u].akunhpp + '" readonly>' +
					'<input type="hidden" name="akunpendapatan' + u + '" id="akunpendapatan' + u + '" value="' + json[u].akunpdpt + '" readonly>' +
					'<input type="hidden" name="harga_diskon' + u + '" id="harga_diskon' + u + '" value="' + json[u].harga + '" readonly>' +
					'<input type="hidden" id="hargaT_asli' + u + '" name="hargaT_asli' + u + '" value="' + parseFloat(json[u].harga_asli * json[u].jumlah) + '" readonly>' +
					'<input type="hidden" id="harga' + u + '" name="harga' + u + '" value="' + json[u].harga + '" readonly>' +
					'<td class="p-2" style="width:10%;">' +
					'<input type="text" class="form-control m-0 p-2 bg-white col sn_barang" name="n_barang' + u + '" id="n_barang' + u + '" data-index="' + u + '" value="' + json[u].n_barang + '" readonly>' +
					'</td>' +
					'<td class="p-2" style="width:25%;">' +
					'<input type="text" class="form-control m-0 p-2 bg-white col" name="nama_barang' + u + '" id="nama_barang' + u + '" value="' + json[u].namaBarang + '" readonly>' +
					'</td>' +
					'<td class="p-2" style="width:7%;">' +
					'<input type="text" class="form-control m-0 p-2 bg-white col qtyB text-center" name="qty_barang' + u + '" data-index="' + u + '" id="qty_barang' + u + '" value="' + json[u].jumlah + '" readonly>' +
					'</td>' +
					'<td class="p-2" style="width:13%;">' +
					'<select class="form-control convUnit" name="satuan_barang' + u + '" id="satuan_barang' + u + '" data-index="' + u + '" readonly>' +
					'<option value="' + unitQty + '" id="e_Unit' + u + '">' + json[u].satuan + '</option>' +
					'</select>' +
					'</td>' +
					'<td class="p-2" style="width:16%;">' +
					'<input type="text" class="form-control m-0 p-2 bg-white col h_barang text-right" name="harga_barang' + u + '" id="harga_barang' + u + '" value="' + number_format(json[u].harga_asli, 2, '.', ',') + '" data-index="' + u + '" readonly>' +
					'<input type="hidden" name="harga_hpp' + u + '" id="harga_hpp' + u + '" data-index="' + u + '" value="' + json[u].hargapokok + '" readonly>' +
					'</td>' +
					'<td class="p-2" style="width:10%;">' +
					'<input type="text" class="form-control m-0 p-2 bg-white col diskon text-center" name="diskon' + u + '" id="diskon' + u + '" value="' + json[u].disc + '" data-index="' + u + '" readonly>' +
					'</td>' +
					'<td class="p-2" style="width:16%;">' +
					'<input type="text" class="form-control m-0 p-2 bg-white col totalsPb text-right" id="total' + u + '" name="total' + u + '" data-index="' + u + '" value="' + number_format(parseFloat(json[u].harga * json[u].jumlah), 2, '.', ',') + '" readonly>' +
					'<input type="hidden" class="form-control m-0 p-2 bg-white col totalsHpp" id="total_hpp' + u + '" name="total_hpp' + u + '" data-index="' + u + '" value="' + parseFloat(json[u].hargapokok * json[u].jumlah) + '">' +
					'</td>' +
					'<td class="p-2" id="action' + u + '">' +
					'</td>' +
					'</tr>'
				);
				$("#bt_proses").focus();
			}
			$('.d_Pelanggan').val($('#dt_pelanggan').val());
			$('#reff_penjualan').val($('#reff_penj').val());
			$('#ketr_penjualan').val($('#ketr_penj').val());
			$('.sum_baris').val(parseInt(json.length));
			$("#ketr").val('Retur Penjualan dari ' + $("#no_penjualan").val())
			$("#dr_penjualan").val($("#no_penjualan").val());
			hitungTotal();
			hitungTotalHpp();
		});
		var n_pelanggan = $('#dt_pelanggan').val().split(" | ");
		$.getJSON("<?= site_url('Pelanggan/getPelanggan?n_pelanggan=') ?>" + n_pelanggan[0], function(json) {
			console.log(json);
			$(".d_Batas").val(number_format(json.batas, 2, '.', ','));
			if (json == false) {
				$(".d_Pelanggan").val("");
				$('#myModalPenjualan').modal('show');
			}
			if (json != false) {
				getPiutang(n_pelanggan[0]);
				$('#n_barang0').focus();
			}
		});
	});

	$(".detail_penjualan").click(function() {
		var detail = $(this).data('trans');
		$("#no_penjualan").val($(this).data('trans'));
		$("#dt_pelanggan").val($(this).data('pelanggan'));
		$("#reff_penj").val($(this).data('reff'));
		$("#ketr_penj").val($(this).data('ketr'));
		$('#select_retur').val(detail);
		//tampil ajax barang
		$.getJSON("<?= site_url('Penjualan/getPenjualan?n_penjualan=') ?>" + detail, function(json) {
			console.log(json);
			var html = '';
			var i;
			for (i = 0; i < json.length; i++) {
				html += '<tr>' +
					'<td>' + json[i].n_barang + '</td>' +
					'<td>' + json[i].namaBarang + '</td>' +
					'<td>' + json[i].jumlah + '</td>' +
					'<td>' + number_format(json[i].harga, 2, '.', ',') + '</td>' +
					'</tr>';
				$('#totalPenjualan').val(number_format(json[i].totalPenj, 2, '.', ','));
			}
			$('#show_detail').html(html);
		});
	});
	//focus 
	$(document).ready(function() {
		$('#kd_barang').focus();
		$('.modal').on('shown.bs.modal', function() {
			$('input[type="search"]').val('')
			$('input[type="search"]').focus()
		});
		$('#myModalPelanggan input[type="search"]').keypress(function(e) {
			if (e.which == 13) {
				$('.chs_pel:first').focus();
			}
		});
		$('#myModalBarang input[type="search"]').keypress(function(e) {
			if (e.which == 13) {
				$('.chs_brg:first').focus();
			}
		});
		$('#myModalBank input[type="search"]').keypress(function(e) {
			if (e.which == 13) {
				$('.chs_bnk:first').focus();
			}
		});
		$('#myModalPelanggan').on('hidden.bs.modal', function() {
			$('#reff').focus();
		});
		$('#myModalBarang').on('hidden.bs.modal', function() {
			$('#add_barang').focus();
		});
		$('#myModalBank').on('hidden.bs.modal', function() {
			$('#jml_bayar').focus();
		});
		$('#myModalProses').on('shown.bs.modal', function() {
			$('.d_Pelanggan').focus();
		});
	});
	$('#kd_barang').on('keypress', function(e) {
		if (e.which == 32) {
			$("#bt_proses").focus();
		}
	});
	$('#add_barang').on('keypress', function(e) {
		var u = $('.sum_baris').val() - 1;
		if (e.which == 13) {
			$("#qty_barang" + u).focus();
		}
	});
	$(document).on('keypress', '.qtyB', function(e) {
		let index = $(this).data('index');
		if (e.which == 13) {
			$("#satuan_barang" + index).focus();
		}
	});
	$(document).on('keypress', '.convUnit', function(e) {
		let index = $(this).data('index');
		if (e.which == 13) {
			$("#harga_barang" + index).focus();
		}
	});
	$(document).on('keypress', '.h_barang', function(e) {
		let index = $(this).data('index');
		if (e.which == 13) {
			$("#diskon" + index).focus();
		}
	});
	$(document).on('keypress', '.diskon', function(e) {
		let index = $(this).data('index');
		if (e.which == 13) {
			$("#total" + index).focus();
		}
	});

	$(document).on('keypress', '.totalsPj', function(e) {
		if (e.which == 13) {
			$("#kd_barang").focus();
		}
		if (e.which == 32) {
			$("#bt_proses").focus();
		}
	});
	$("#reff").keypress(function(e) {
		if (e.which == 13) {
			$("#ketr").focus();
		}
	});
	$("#ketr").keypress(function(e) {
		if (e.which == 13) {
			$("#ppn_jual").focus();
		}
	});
	$("#ppn_jual").keypress(function(e) {
		if (e.which == 13) {
			$("#biaya_kirim").focus();
		}
	});
	$("#biaya_kirim").keypress(function(e) {
		if (e.which == 13) {
			$(".js-btn-step").focus();
		}
	});
	$("#c_kas").on('keypress', function(e) {
		if (e.which == 32) {
			$(this).removeClass('btn-success');
			$(this).addClass('btn-secondary');
			$("#c_bank").removeClass('btn-secondary');
			$("#c_bank").addClass('btn-success');
			$("#c_bayar").val($("#c_bank").val());
			$('.bank').show();
			$('.bank').removeAttr("disabled");
			$('#myModalBank').modal('show');
		}
		if (e.keyCode == 13) {
			$('#jml_bayar').focus();
		}
	});
	$('#jml_bayar').keypress(function(e) {
		if (e.which == 13) {
			$('.js-btn-step').focus();
		}
	});

	$(document).on('click focus', 'input', function() {
		$(this).select();
	});