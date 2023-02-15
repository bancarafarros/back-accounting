function prosesbeli() {
	if ($('.d_Pemasok').val()) {
		var sel = $('.sum_baris').val();
		var tanggal = $('.tanggal').val()
		var jatuh_tempo = $('.jatuh_tempo').val()
		for (let br = 0; br < sel; br++) {
			if ($('#harga_barang' + br).val()) {
				parseFloat($('#harga_barang' + br).val($('#harga_barang' + br).val().replace(/[^-.\d]/g, '')));
				parseFloat($('#total' + br).val($('#total' + br).val().replace(/[^-.\d]/g, '')));
				parseFloat($('#qty_barang' + br).val($('#qty_barang' + br).val().replace(/[^-.\d]/g, '')));
			}
		}
		$('#total_beli').val($('#total_beli').val().replace(/[^-.\d]/g, ''));
		$('#jml_bayar').val($('#jml_bayar').val().replace(/[^-.\d]/g, ''));
		$('#sisa_bayar').val($('#sisa_bayar').val().replace(/[^-.\d]/g, ''));
		$('#biaya_kirim').val($('#biaya_kirim').val().replace(/[^-.\d]/g, ''));
		$('#ppn_beli').val($('#ppn_beli').val().replace(/[^-.\d]/g, ''));
		$('.total_all').val($('.total_all').val().replace(/[^-.\d]/g, ''));
		// $('#formPemb').submit();
		// setTimeout(function() {
		// 	location.reload();
		// }, 1000)
		if (jatuh_tempo < tanggal) {
			Swal.fire('Tanggal', 'Tanggal jatuh tempo tidak boleh sebelum tanggal transaksi', 'warning');
		} else {
			$.ajax({
				url: $('#formPemb').attr('action'),
				type: "POST",
				data: $('#formPemb').serialize(),
				dataType: "JSON",
				beforeSend: () => {
					showLoading()
				},
				success: function (response) {
					hideLoading()
					if (response.status) {
						$('body').append('<a class="d-none" role="button" target="_blank" id="btn-cetak">Cetak</a>');
						$('#btn-cetak').attr('href', (site_url + '/pembelian/cetak_nota/' + response.n_transaksi + '?download=false'));
						Swal.fire('Pembelian!', response.message, 'success').then((result) => {
							document.getElementById("btn-cetak").click();
							$('#myModalProses').modal('hide');
							location.reload();
						});
					} else {
						Swal.fire('Pembelian', response.message, 'error').then((result) => {
							location.reload();
						});
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					hideLoading()
					Swal.fire('Error!', 'Internal server error', 'error').then((result) => {
						// location.reload();
					});
				}
			});
		}
	} else {
		Swal.fire('Pembelian', 'Pemasok masih belum diisi', 'warning');
	}
}

//tmbol proses
$('#bt_proses').on('click keypress', function () {
	if ($('#total_beli').val().replace(/[^-.\d]/g, '') != 0) {
		$('#myModalProses').modal('show');
	} else {
		Swal.fire('Pembelian', 'Data masih belum diisi dan total tidak boleh 0', 'warning')
	}
});

//modal proses
// $(document).ready(function() {
// 	$('#myModalProses').modalSteps({
// 		btnCancelHtml: "Cancel",
// 		btnPreviousHtml: "Kembali",
// 		btnNextHtml: "Pembayaran",
// 		btnLastStepHtml: "Simpan",
// 		disableNextButton: false,
// 		completeCallback: function() {
// 			if ($('.d_Pemasok').val()) {
// 				var sel = $('.sum_baris').val();

// 				for (let br = 0; br < sel; br++) {
// 					if ($('#harga_barang' + br).val()) {
// 						parseFloat($('#harga_barang' + br).val($('#harga_barang' + br).val().replace(/[^-.\d]/g, '')));
// 						parseFloat($('#total' + br).val($('#total' + br).val().replace(/[^-.\d]/g, '')));
// 						parseFloat($('#qty_barang' + br).val($('#qty_barang' + br).val().replace(/[^-.\d]/g, '')));
// 					}
// 				}
// 				$('#total_beli').val($('#total_beli').val().replace(/[^-.\d]/g, ''));
// 				$('#jml_bayar').val($('#jml_bayar').val().replace(/[^-.\d]/g, ''));
// 				$('#sisa_bayar').val($('#sisa_bayar').val().replace(/[^-.\d]/g, ''));
// 				$('#biaya_kirim').val($('#biaya_kirim').val().replace(/[^-.\d]/g, ''));
// 				$('#ppn_beli').val($('#ppn_beli').val().replace(/[^-.\d]/g, ''));
// 				$('.total_all').val($('.total_all').val().replace(/[^-.\d]/g, ''));
// 				$('#formPemb').submit();
// 				setTimeout(function() {
// 					location.reload();
// 				}, 1000)
// 			} else {
// 				Swal.fire('Pembelian', 'Pemasok masih belum diisi', 'warning');
// 			}
// 		},
// 		callbacks: {},
// 		getTitleAndStep: function() {
// 			$("#n_db").text($("#i_database").val());
// 			$("#n_perusahaan").text($("#i_perusahaan").val());
// 			$("#n_alamat").text($("#i_alamat").val());
// 			$("#n_telp").text($("#i_telp").val());
// 			$("#c_kas").focus();
// 		}
// 	});
// });

//hitung total all
function hitungTotal(totalB) {
	var totalB = 0
	var total = 0;
	var totalD = 0;
	var totalBeli = $('#total_beli').val();
	var ppn = parseFloat($("#ppn_beli").val().replace(/[^-.\d]/g, ''));
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
		$('#total_beli').val(number_format(total, 2, '.', ','));
		$('#total_diskon').val(totalD);
		$('.total_all').val(number_format(parseFloat(total + ppn + kirim), 2, '.', ','));
		$('#sisa_bayar').val(number_format(parseFloat(total + ppn + kirim - bayar - uangMuka), 2, '.', ','));
	}
}
//format angka select
$(".money").on("click", function () {
	$(this).select();
});

// Format mata uang	
number_format = function (numbers, decimals, dec_point, thousands_sep) {
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
function getHutang(pemasok) {
	$.getJSON("<?= site_url('Hutang/getKartu?n_pemasok=') ?>" + pemasok, function (json) {
		var html = '';
		var i;
		sum_sisa = 0;
		for (i = 0; i < json.length; i++) {
			sum_sisa = sum_sisa + parseFloat(json[i].sisa);
			$(".sum_sisa").val(number_format(sum_sisa, 2, '.', ','));
		}
	});
}
// isi data pemasok
for (let s = 0; s < $(".sum_pemasok").val(); s++) {
	$(".chs_pemasok" + s).on('click keypress', function () {
		$(".d_Pemasok").val($('.no_pemasok' + s).val() + " | " + $('.nama_pemasok' + s).val());
		$(".d_Batas").val(number_format(parseFloat($('.batas_kredit' + s).val()), 2, '.', ','));
		getHutang($('.no_pemasok' + s).val());
		$("#ketr").val("Pembelian a/n " + $('.nama_pemasok' + s).val())
	});
}
$(document).on('keypress', '.d_Pemasok', function (e) {
	if (e.keyCode == 13) {
		var detail = $(this).val();
		//tampil ajax barang
		$.getJSON("<?= site_url('Pemasok/getPemasok?n_pemasok=') ?>" + detail, function (json) {
			var value = json.n_pemasok + " | " + json.nama;
			$(".d_Pemasok").val(value);
			$(".d_Batas").val(number_format(parseFloat(parseFloat(json.batas)), 2, '.', ','));
			if (json == false) {
				$(".d_Pemasok").val("");
				$('#myModalPemasok').modal('show');
			}
			if (json != false) {
				getHutang(detail);
				$('#n_barang0').focus();
				$("#ketr").val("Pembelian a/n " + json.nama)
			}
		});
	}
});

$("body").on('input', '.d_Pemasok', function () { // Mencegah spasi di awal input
	$(this).val($(this).val().replace(/^\s+/g, ''));
});

// cara bayar
$('.bank').hide();
$('.bank').attr("disabled");
$("#c_kas").click(function () {
	$("#c_bank").removeClass('btn-success');
	$("#c_bank").addClass('btn-default');
	$(this).removeClass('btn-default');
	$(this).addClass('btn-success');
	$("#c_bayar").val($(this).val());
	$('.bank').hide();
	$('.bank').attr("disabled");
	$("#d_Bank").val("");
});
$("#c_bank").click(function () {
	$("#c_kas").removeClass('btn-success');
	$("#c_kas").addClass('btn-default');
	$(this).removeClass('btn-default');
	$(this).addClass('btn-success');
	$("#c_bayar").val($(this).val());
	$('.bank').show();
	$('.bank').removeAttr("disabled");
});
for (let s = 0; s < $(".sum_bank").val(); s++) {
	$(".chs_bank" + s).click(function () {
		$("#d_Bank").val($('.no_bank' + s).val() + " | " + $('.nama_bank' + s).val());
		$("#d_akunBank").val($('.akun_bank' + s).val());
	});
}
// isi data barang dengan kode
var total_all = 0;
$(document).on('keypress', '#kd_barang', function (e) {
	// var index = $(this).data('index');
	var keyCode = (event.keyCode ? event.keyCode : event.which);
	if (keyCode == 13) {
		// if (index == $('.sum_baris').val()) {
		var detail = $(this).val();
		//tampil ajax barang
		$.getJSON("<?= site_url('Barang/getDetailMulti?n_barang=') ?>" + detail, function (json) {
			$("#kd_barang").val(json.n_barang);
			$("#nm_barang").val(json.nama);
			$("#unit_barang").val(json.n_unit);
			$("#bunit_barang").val(json.b_unit);
			$("#unit_conv").val(json.konversi_unit);
			$("#hpp_barang").val(json.harga_pokok);
			$("#h_barang").val(json.harga_beli);
			$("#akun_barang").val(json.akun_persediaan);

			if (json == false) {
				$('#myModalBarang').modal('show');
				// $('#urut_barang').val(index);
			}
			if (json != false) {
				$('#add_barang').focus();
			}
		});
		// }
	}
});

//isi data barang dengan modal
for (let b = 0; b < $(".sum_barang").val(); b++) {
	$(".chs_barang" + b).click(function () {
		$.getJSON("<?= site_url('Barang/getDetailMulti?n_barang=') ?>" + $(this).data('id'), function (json) {
			$("#kd_barang").val(json.n_barang);
			$("#nm_barang").val(json.nama);
			$("#unit_barang").val(json.n_unit);
			$("#bunit_barang").val(json.b_unit);
			$("#unit_conv").val(json.konversi_unit);
			$("#hpp_barang").val(json.harga_pokok);
			$("#h_barang").val(json.harga_beli);
			$("#akun_barang").val(json.akun_persediaan);
		});
	});
}
//addbarang
$("#add_barang").on('click keypress', function () {
	if ($('#nm_barang').val()) {
		var u = $('.sum_baris').val();
		$('#dynamic_field').append('<tr id="row' + u + '" "class="dynamic-added">' +
			'<input type="hidden" id="conv_unit' + u + '" name="conversiUnit' + u + '" value="1" readonly>' +
			'<input type="hidden" name="h_hpp' + u + '" id="h_hpp' + u + '" value="' + $("#hpp_barang").val() + '" readonly>' +
			'<input type="hidden" name="h_diskon' + u + '" id="totDiskon' + u + '" value="0" readonly>' +
			'<input type="hidden" name="perkiraan' + u + '" id="perkiraan' + u + '" value="' + $("#akun_barang").val() + '" readonly>' +
			'<input type="hidden" name="harga_diskon' + u + '" id="harga_diskon' + u + '" value="' + $("#h_barang").val() + '" readonly>' +
			'<input type="hidden" id="hargaT_asli' + u + '" name="hargaT_asli' + u + '" value="' + $("#h_barang").val() + '" readonly>' +
			'<input type="hidden" id="harga' + u + '" name="harga' + u + '" value="' + $("#h_barang").val() + '" readonly>' +
			'<td class="p-2" style="width:10%;">' +
			'<input type="text" class="form-control m-0 p-2 bg-white col sn_barang" name="n_barang' + u + '" id="n_barang' + u + '" data-index="' + u + '" value="' + $("#kd_barang").val() + '" readonly>' +
			'</td>' +
			'<td class="p-2" style="width:25%;">' +
			'<input type="text" class="form-control m-0 p-2 bg-white col" name="nama_barang' + u + '" id="nama_barang' + u + '" value="' + $("#nm_barang").val() + '" readonly>' +
			'</td>' +
			'<td class="p-2" style="width:8%;">' +
			'<input type="text" class="form-control m-0 p-2 bg-white col qtyB text-center" name="qty_barang' + u + '" data-index="' + u + '" id="qty_barang' + u + '" value="1">' +
			'</td>' +
			'<td class="p-2" style="width:13%;">' +
			'<select class="form-control convUnit" name="satuan_barang' + u + '" id="satuan_barang' + u + '" data-index="' + u + '">' +
			'<option value="1" id="e_nUnit' + u + '">' + $("#unit_barang").val() + '</option>' +
			'<option value="' + $("#unit_conv").val() + '" id="e_bUnit' + u + '">' + $("#bunit_barang").val() + '</option>' +
			'</select>' +
			'</td>' +
			'<td class="p-2" style="width:16%;">' +
			'<input type="text" class="form-control m-0 p-2 bg-white col h_barang text-right" name="harga_barang' + u + '" id="harga_barang' + u + '" value="' + number_format($("#h_barang").val(), 2, '.', ',') + '" data-index="' + u + '" readonly>' +
			'</td>' +
			'<td class="p-2" style="width:10%;">' +
			'<input type="text" class="form-control m-0 p-2 bg-white col diskon text-center" name="diskon' + u + '" id="diskon' + u + '" value="0" data-index="' + u + '">' +
			'</td>' +
			'<td class="p-2" style="width:16%;">' +
			'<input type="text" class="form-control m-0 p-2 bg-white col totalsPb text-right" id="total' + u + '" name="total' + u + '" data-index="' + u + '" value="' + number_format($("#h_barang").val(), 2, '.', ',') + '" readonly>' +
			'</td>' +
			'<td class="p-2" id="action' + u + '" style="width:0%;">' +
			'<button type="button" name="remove" data-index="' + u + '" class="btn btn-danger btn_remove" value="" >X</button>' +
			'</td>' +
			'</tr>');
		$('.sum_baris').val(parseFloat($('.sum_baris').val()) + 1);
		hitungTotal();
		$("#kd_barang").val('');
		$("#nm_barang").val('');
		$("#bunit_barang").val('');
		$("#unit_barang").val('');
		$("#unit_conv").val('');
		$("#hpp_barang").val('');
		$("#h_barang").val('');
		$("#akun_barang").val('');
	} else {
		Swal.fire('Pembelian', 'Barang masih kosong', 'warning')
	}
});


//pengolah data barang
//aksi tombol remove
$(document).on('click', '.btn_remove', function () {
	var id = $(this).data("index");
	$('#row' + id).remove();

	hitungTotal();
});

//tambah qty barang
$(document).on('keypress keyup blur', '.qtyB', function () {
	$(this).val(formatRupiah(this.value));
	qty = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
	var id = $(this).data("index");
	$("#hargaT_asli" + id).val($('#harga_barang' + id).val().replace(/[^-.\d]/g, '') * qty);
	$('#totDiskon' + id).val(parseFloat(($('#harga_barang' + id).val().replace(/[^-.\d]/g, '') * ($('#diskon' + id).val() / 100)) * qty));
	$('#total' + id).val(parseFloat((qty * $('#harga_barang' + id).val().replace(/[^-.\d]/g, '')) - $('#totDiskon' + id).val()));
	$('#total' + id).val(number_format($('#total' + id).val(), 2, '.', ','))
	$("#harga_diskon" + id).val(parseFloat($('#harga' + id).val() * $('#conv_unit' + id).val() - ($('#harga' + id).val() * ($('#diskon' + id).val() / 100))));
	hitungTotal();
});

//convert unit barang
$(document).on('change', '.convUnit', function () {
	var id = $(this).data("index");
	var unit = $(this).val();
	$('#conv_unit' + id).val(unit);
	$('#harga_barang' + id).val(number_format(parseFloat($('#harga' + id).val() * unit), 2, '.', ','));
	$("#harga_diskon" + id).val(parseFloat($('#harga' + id).val() * unit - ($('#harga' + id).val() * ($('#diskon' + id).val() / 100))));
	$("#hargaT_asli" + id).val($('#harga_barang' + id).val().replace(/[^-.\d]/g, '') * $('#qty_barang' + id).val().replace(/[^-.\d]/g, ''))
	$('#totDiskon' + id).val(parseFloat(($('#harga_barang' + id).val().replace(/[^-.\d]/g, '') * ($('#diskon' + id).val() / 100)) * $('#qty_barang' + id).val().replace(/[^-.\d]/g, '') * unit));
	$('#total' + id).val(parseFloat(($('#qty_barang' + id).val().replace(/[^-.\d]/g, '') * $('#harga_barang' + id).val().replace(/[^-.\d]/g, '')) - $('#totDiskon' + id).val()));
	$('#total' + id).val(number_format($('#total' + id).val(), 2, '.', ','))
	hitungTotal();
});

//isi harga satuan barang
// $(document).on('keyup', '.h_barang', function () {
// 	$(this).val(formatRupiah(this.value))
// 	harga = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
// 	var id = $(this).data("index");
// 	$("#hargaT_asli" + id).val(harga * $('#qty_barang' + id).val().replace(/[^-.\d]/g, ''));
// 	$("#harga_diskon" + id).val(harga - (harga * ($('#diskon' + id).val() / 100)));
// 	$('#totDiskon' + id).val(parseFloat((harga * ($('#diskon' + id).val() / 100)) * $('#qty_barang' + id).val().replace(/[^-.\d]/g, '')));
// 	$('#total' + id).val(parseFloat(($('#qty_barang' + id).val().replace(/[^-.\d]/g, '') * harga) - $('#totDiskon' + id).val()));
// 	$('#total' + id).val(number_format($('#total' + id).val(), 2, '.', ','))
// 	hitungTotal();
// });

//diskon barang 
$(document).on("click", '.diskon', function () {
	$(this).select();
});
$(document).on('keyup', '.diskon', function () {
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
	$("#harga_diskon" + id).val($('#harga_barang' + id).val().replace(/[^-.\d]/g, '') - ($('#harga_barang' + id).val().replace(/[^-.\d]/g, '') * (diskon / 100)));
	$('#totDiskon' + id).val(parseFloat(($('#harga_barang' + id).val().replace(/[^-.\d]/g, '') * (diskon / 100)) * $('#qty_barang' + id).val().replace(/[^-.\d]/g, '')));
	$('#total' + id).val(parseFloat(($('#qty_barang' + id).val().replace(/[^-.\d]/g, '') * $('#harga_barang' + id).val().replace(/[^-.\d]/g, '')) - $('#totDiskon' + id).val()));
	$('#total' + id).val(number_format($('#total' + id).val(), 2, '.', ','))
	hitungTotal();
});

//total haraga barang setelah diolah
// $(document).on('keyup', '.totalsPb', function (e) {
// 	if (e.keyCode != 13) {
// 		$(this).val(formatRupiah(this.value))
// 		totalB = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
// 		var id = $(this).data("index");
// 		$('#totDiskon' + id).val(0);
// 		$('#diskon' + id).val(0)
// 		$('#harga_barang' + id).val(parseFloat((totalB / $('#qty_barang' + id).val().replace(/[^-.\d]/g, ''))));
// 		$('#harga_barang' + id).val(number_format($('#harga_barang' + id).val(), 2, '.', ','));
// 		$("#harga_diskon" + id).val($('#harga_barang' + id).val().replace(/[^-.\d]/g, '') - ($('#harga_barang' + id).val().replace(/[^-.\d]/g, '') * ($('#diskon' + id).val() / 100)));
// 		hitungTotal();
// 	}
// });

//ppn pembelian
$('#ppn_beli').keyup(function () {
	$(this).val(formatRupiah(this.value));
	ppn = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
	hitungTotal()
});

//biaya kirim pembelian
$('#biaya_kirim').keyup(function () {
	$(this).val(formatRupiah(this.value));
	kirim = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
	hitungTotal()
});

//jumlah yang dibayar akan mengurangi sisa
$('#jml_bayar').keyup(function () {
	$(this).val(formatRupiah(this.value));
	bayar = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
	total = parseFloat($('.total_all').val().replace(/[^-.\d]/g, ''));
	hitungTotal();
	if (bayar > total) {
		$('#proses').hide();
	} else if ($('#c_bank').hasClass("btn-success") && $('#d_Bank').val() == '') {
		$('#proses').hide();
	} else {
		$('#proses').show();
	}
});

//disable funtion keyboard
$('#formPemb').on('keyup keypress', function (e) {
	if (e.which == 13) {
		e.preventDefault();
	}
});

//pembelian order
$(document).ready(function () {
	$(".detail_order").click(function () {
		var detail = $(this).data('order');
		//tampil ajax barang
		$.getJSON("<?= site_url('Pembelian/getOrder?n_order=') ?>" + detail, function (json) {
			console.log(json);
			var html = '';
			var i;
			for (i = 0; i < json.length; i++) {
				html += '<tr>' +
					'<td>' + json[i].n_barang + '</td>' +
					'<td>' + json[i].namaBarang + '</td>' +
					'<td>' + json[i].sisaOrder + '</td>' +
					'<td>' + json[i].jumlahTrima + '</td>' +
					'</tr>';
				$('#totalOrder').val(json[i].totalOrder);
			}
			$('#show_detail').html(html);
		});
	});
	$('.tanggal').change(function () {
		$(this).attr('value', $('.tanggal').val());
	});
	$('.jatuh_tempo').change(function () {
		$(this).attr('value', $('.jatuh_tempo').val());
	});
});


$(document).ready(function () {
	$('.lookup').DataTable({
		"responsive": true,
		"info": false,
		"processing": true
	});
	$('.lookup_filter input').focus()
	//$('.lookup_filter [type="search"]').focus()
	$('.lookup-edit').DataTable({
		"responsive": true
	});
	$('.lookup_filter input').focus()
	//$('#lookup_filter [type="search"]').focus()
});

//focus 
$(document).ready(function () {
	$('#kd_barang').focus();
	$('.modal').on('shown.bs.modal', function () {
		$('input[type="search"]').val('')
		$('input[type="search"]').focus()
	});
	$('#myModalPemasok input[type="search"]').keypress(function (e) {
		if (e.which == 13) {
			$('.chs_pem:first').focus();
		}
	});
	$('#myModalBarang input[type="search"]').keypress(function (e) {
		if (e.which == 13) {
			$('.chs_brg:first').focus();
		}
	});
	$('#myModalBank input[type="search"]').keypress(function (e) {
		if (e.which == 13) {
			$('.chs_bnk:first').focus();
		}
	});
	$('#myModalPemasok').on('hidden.bs.modal', function () {
		$('#reff').focus();
	});
	$('#myModalBarang').on('hidden.bs.modal', function () {
		$('#add_barang').focus();
	});
	$('#myModalBank').on('hidden.bs.modal', function () {
		$('#jml_bayar').focus();
		bayar = parseFloat($('#jml_bayar').val().replace(/[^-.\d]/g, ''));
		total = parseFloat($('.total_all').val().replace(/[^-.\d]/g, ''));
		if ($('#d_Bank').val() == '') {
			Swal.fire('Bank', 'Bank masih belum dipilih', 'warning');
			$('#proses').hide();
		} else if (bayar > total) {
			$('#proses').hide();
		} else {
			$('#proses').show();
		}
	});
	$('#myModalProses').on('shown.bs.modal', function () {
		$('.d_Pemasok').focus();
	});
	$("#c_kas").click(function () {
		bayar = parseFloat($('#jml_bayar').val().replace(/[^-.\d]/g, ''));
		total = parseFloat($('.total_all').val().replace(/[^-.\d]/g, ''));
		if (bayar > total) {
			$('#proses').hide();
		} else {
			$('#proses').show();
		}
	});
});
$('#kd_barang').on('keypress', function (e) {
	if (e.which == 32) {
		$("#bt_proses").focus();
	}
});
$('#add_barang').on('keypress', function (e) {
	var u = $('.sum_baris').val() - 1;
	if (e.which == 13) {
		$("#qty_barang" + u).focus();
	}
});
$(document).on('keypress', '.qtyB', function (e) {
	let index = $(this).data('index');
	if (e.which == 13) {
		$("#satuan_barang" + index).focus();
	}
});
$(document).on('keypress', '.convUnit', function (e) {
	let index = $(this).data('index');
	if (e.which == 13) {
		$("#harga_barang" + index).focus();
	}
});
$(document).on('keypress', '.h_barang', function (e) {
	let index = $(this).data('index');
	if (e.which == 13) {
		$("#diskon" + index).focus();
	}
});
$(document).on('keypress', '.diskon', function (e) {
	let index = $(this).data('index');
	if (e.which == 13) {
		$("#total" + index).focus();
	}
});

$(document).on('keypress', '.totalsPb', function (e) {
	if (e.which == 13) {
		$("#kd_barang").focus();
	}
	if (e.which == 32) {
		$("#bt_proses").focus();
	}
});
$("#reff").keypress(function (e) {
	if (e.which == 13) {
		$("#ketr").focus();
	}
});
$("#ketr").keypress(function (e) {
	if (e.which == 13) {
		$("#ppn_beli").focus();
	}
});
$("#ppn_beli").keypress(function (e) {
	if (e.which == 13) {
		$("#biaya_kirim").focus();
	}
});
$("#biaya_kirim").keypress(function (e) {
	if (e.which == 13) {
		$(".js-btn-step").focus();
	}
});
$("#c_kas").on('keypress', function (e) {
	if (e.which == 32) {
		$(this).removeClass('btn-success');
		$(this).addClass('btn-default');
		$("#c_bank").removeClass('btn-default');
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
$('#jml_bayar').keypress(function (e) {
	if (e.which == 13) {
		$('.js-btn-step').focus();
	}
});

$(document).on('click focus', 'input', function () {
	$(this).select();
});