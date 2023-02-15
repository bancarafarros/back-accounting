
	//tmbol proses
	$('#bt_proses').on('click keypress', function() {
		if ($('#total_costing').val().replace(/[^-.\d]/g, '') > 0) {
			$('#myModalProses').modal('show');
		} else {
			Swal.fire('Costing', 'Data Masih belum diisi dan total tidak boleh 0', 'warning')
		}
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

	//Set akun
	for (let s = 0; s < $(".sum_akun").val(); s++) {
		$(".chs_akun" + s).click(function() {
			$(".d_akun").val($('.no_akun' + s).val());
			$(".d_namaakun").val($('.n_akun' + s).val());
		});
	}

	//btn save
	$('#saveCost').click(function() {
		if ($('.d_akun').val()) {
			var sel = $('.sum_baris').val();
			for (let br = 0; br < sel; br++) {
				if ($('#harga_barang' + br).val()) {
					parseFloat($('#harga_barang' + br).val($('#harga_barang' + br).val().replace(/[^-.\d]/g, '')));
					parseFloat($('#total' + br).val($('#total' + br).val().replace(/[^-.\d]/g, '')));
					parseFloat($('#qty_barang' + br).val($('#qty_barang' + br).val().replace(/[^-.\d]/g, '')));
				}
			}
			$('#total_costing').val($('#total_costing').val().replace(/[^-.\d]/g, ''));
			$('#formCost').submit();
			setTimeout(function() {
				location.reload();
			}, 1000)
		} else {
			Swal.fire('Costing', 'Anda Belum Memilih Perkiraan Biaya', 'warning');
		}
	})

	//hitung total all
	function hitungTotal(totalB) {
		var totalB = 0
		var total = 0;
		var totalBeli = $('#total_costing').val();
		for (let q = 0; q < $('.sum_baris').val(); q++) {
			if ($('#total' + q).val()) {
				total += parseFloat($('#total' + q).val().replace(/[^-.\d]/g, ''));
			}
			$('#total_costing').val(number_format(total, 2, '.', ','));
		}
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
	//format angka select
	$(".money").on("click", function() {
		$(this).select();
	});

	// isi data barang dengan kode
	var total_all = 0;
	$(document).on('keypress', '#kd_barang', function(e) {
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
				$("#h_barang").val(json.harga_pokok);
				$("#akun_barang").val(json.akun_persediaan);
				$("#stock_gudang").val(json.stock_gudang);

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
		$(".chs_barang" + b).click(function() {
			$.getJSON("<?= site_url('Barang/getDetailMulti?n_barang=') ?>" + $(this).data('id'), function(json) {
				$("#kd_barang").val(json.n_barang);
				$("#nm_barang").val(json.nama);
				$("#unit_barang").val(json.n_unit);
				$("#bunit_barang").val(json.b_unit);
				$("#unit_conv").val(json.konversi_unit);
				$("#h_barang").val(json.harga_pokok);
				$("#akun_barang").val(json.akun_persediaan);
				$("#stock_gudang").val(json.stock_gudang);

			});
		});
	}
	//addbarang
	$("#add_barang").on('click keypress', function() {
		if ($('#nm_barang').val()) {
			if ($("#stock_gudang").val() > 0) {
				var u = $('.sum_baris').val();
				$('#dynamic_field').append('<tr id="row' + u + '" "class="dynamic-added">' +
					'<input type="hidden" id="conv_unit' + u + '" name="conversiUnit' + u + '" value="1" readonly>' +
					'<input type="hidden" name="perkiraan' + u + '" id="perkiraan' + u + '" value="' + $("#akun_barang").val() + '" readonly>' +
					'<input type="hidden" id="harga' + u + '" name="harga' + u + '" value="' + $("#h_barang").val() + '" readonly>' +
					'<input type="hidden" id="stockNow' + u + '" name="stock' + u + '" value="' + $("#stock_gudang").val() + '">' +
					'<td class="p-2 pl-3" style="width:15%;">' +
					'<input type="text" class="form-control m-0 p-2 bg-white col sn_barang" name="n_barang' + u + '" id="n_barang' + u + '" data-index="' + u + '" value="' + $("#kd_barang").val() + '" readonly>' +
					'</td>' +
					'<td class="p-2" style="width:30%;">' +
					'<input type="text" class="form-control m-0 p-2 bg-white col" name="nama_barang' + u + '" id="nama_barang' + u + '" value="' + $("#nm_barang").val() + '" readonly>' +
					'</td>' +
					'<td class="p-2" style="width:7%;">' +
					'<input type="text" class="form-control m-0 p-2 bg-white col qtyB text-center" name="qty_barang' + u + '" data-index="' + u + '" id="qty_barang' + u + '" value="1">' +
					'</td>' +
					'<td class="p-2" style="width:12%;">' +
					'<select class="form-control convUnit" name="satuan_barang' + u + '" id="satuan_barang' + u + '" data-index="' + u + '">' +
					'<option value="1" id="e_nUnit' + u + '">' + $("#unit_barang").val() + '</option>' +
					'<option value="' + $("#unit_conv").val() + '" id="e_bUnit' + u + '">' + $("#bunit_barang").val() + '</option>' +
					'</select>' +
					'</td>' +
					'<td class="p-2" style="width:16%;">' +
					'<input type="text" class="form-control m-0 p-2 bg-white col h_barang text-right" name="harga_barang' + u + '" id="harga_barang' + u + '" value="' + number_format($("#h_barang").val(), 2, '.', ',') + '" data-index="' + u + '" readonly>' +
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
				$("#h_barang").val('');
				$("#akun_barang").val('');
			} else {
				Swal.fire('Costing', 'Stock barang Kosong', 'warning')
			}
		} else {
			Swal.fire('Costing', 'Barang masih kosong', 'warning')
		}
	});


	//pengolah data barang
	//aksi tombol remove
	$(document).on('click', '.btn_remove', function() {
		var id = $(this).data("index");
		$('#row' + id).remove();

		hitungTotal();
	});

	//tambah qty barang
	$(document).on('keypress keyup blur', '.qtyB', function() {
		$(this).val(formatRupiah(this.value));
		qty = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
		var id = $(this).data("index");
		if (qty <= $('#stockNow' + id).val()) {
			$('#total' + id).val(number_format(parseFloat((qty * $('#harga_barang' + id).val().replace(/[^-.\d]/g, ''))), 2, '.', ','));
			hitungTotal();
		} else {
			Swal.fire('Costing', 'Stock Tidak Mencukupi!', 'warning')
			$(this).val(0)
		}
	});

	//convert unit barang
	$(document).on('change', '.convUnit', function() {
		var id = $(this).data("index");
		var unit = $(this).val();
		$('#conv_unit' + id).val(unit);
		$('#harga_barang' + id).val(number_format(parseFloat($('#harga' + id).val() * unit), 2, '.', ','));
		$('#total' + id).val(number_format(parseFloat($('#qty_barang' + id).val().replace(/[^-.\d]/g, '') * $('#harga_barang' + id).val().replace(/[^-.\d]/g, '')), 2, '.', ','));
		hitungTotal();
	});


	//disable funtion keyboard
	$('#formCost').on('keyup keypress', function(e) {
		if (e.which == 13) {
			e.preventDefault();
		}
	});
	$(document).ready(function() {
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
	$(document).ready(function() {
		$('#kd_barang').focus();
		$('.modal').on('shown.bs.modal', function() {
			$('input[type="search"]').val('')
			$('input[type="search"]').focus()
		});
		$('#myModalBarang input[type="search"]').keypress(function(e) {
			if (e.which == 13) {
				$('.chs_brg:first').focus();
			}
		});
		$('#myModalAkun input[type="search"]').keypress(function(e) {
			if (e.which == 13) {
				$('.chs_akun:first').focus();
			}
		});
		$('#myModalBarang').on('hidden.bs.modal', function() {
			$('#add_barang').focus();
		});
		$('#myModalAkun').on('hidden.bs.modal', function() {
			$('#bt_akun').blur();
			$('#saveCost').focus();
		});
		$('#myModalProses').on('shown.bs.modal', function() {
			$('#reff').focus();
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
			$("#bt_akun").focus();
		}
	});

	$(document).on('click focus', 'input', function() {
		$(this).select();
	});