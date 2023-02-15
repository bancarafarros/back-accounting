
var table;
$(function () {
	// table = $('#table').DataTable({
	// 	"pageLength": 30,
	// 	"scrollX": true,
	// 	"processing": true,
	// 	"serverSide": true,
	// 	"order": [],
	// 	"ajax": {
	// 		"url": site_url + "/jurnal/datatable_jurnal",
	// 		"type": "POST",
	// 	},
	// 	'dom': 'rtip',
	// });

	table = $('#table').DataTable({
		"sDom": "ftipr",
		"sServerMethod": "POST",
		"autoWidth": false,
		"bSort": false,
		"pageLength": 30,
		"bProcessing": true,
		"bServerSide": true,
		"fnServerParams": function (aoData) {
			var tahunbulan = $('#tahunJ').val() + '-' + $('#bulanJ').val();
			aoData.push({
				name: "tahunbulan",
				"value": tahunbulan
			});
		},
		"fnStateSaveParams": function (oSetings, sValue) {
			// body...
		},
		"fnStateLoadParams": function (oSetings, oData) {
			showLoading();
		},
		'sAjaxSource': site_url + "/jurnal/datatable_jurnal",
		'aoColumns': [{
			mDataProp: 'opsi'
		},
		{
			mDataProp: 'nomor'
		},
		{
			mDataProp: 'tanggal'
		},
		{
			mDataProp: 'referensi'
		},
		{
			mDataProp: 'keterangan'
		},
		],
	});

	table.on('processing.dt', function (e, settings, processing) {
		if (processing) {
			showLoading()
		} else {
			hideLoading()
		}
	})

	$('.range').change(function () {
		table.draw();
	})

	$("#btnSearch").click(function (e) {
		e.preventDefault();
		table.search($("#search").val()).draw();

		setFiltered()
	});

});

//form tambah Jurnal
$('#formAddjurnal').on('keyup keypress', function (e) {
	if (e.which == 13) {
		e.preventDefault();
	}
});

$("#save").on('click keypress', function (e) {
	e.preventDefault();
	var baris = $('#jml_baris').val();
	if (baris > 0 && $('#keterangan').val() != "") {
		if ($('.selisih').val() == 0) {
			for (p = 0; p <= baris; p++) {
				if ($('#akun' + p).val()) {
					$("#adddebet" + p).val($("#adddebet" + p).val().replace(/[^-.\d]/g, ''));
					$("#addkredit" + p).val($("#addkredit" + p).val().replace(/[^-.\d]/g, ''));
				}
			}
			$('.total_kredit').val($('.total_kredit').val().replace(/[^-.\d]/g, ''))
			$('.total_debet').val($('.total_debet').val().replace(/[^-.\d]/g, ''))
			// $('#row' + baris).remove(); // Error jika ada data yg tidak dienter tapi angka sudah dimasukkan, dana jadi balance dan bisa disubmit, tapi ketika disubmit, data yg tidak dienter tersebut akan keremove.
			$.ajax({
				url: $('#formAddjurnal').attr('action'),
				type: "POST",
				data: $('#formAddjurnal').serialize(),
				dataType: "JSON",
				beforeSend: () => {
					showLoading()
				},
				success: function (response) {
					hideLoading()
					if (response.status) {
						$('body').append('<a class="d-none" role="button" target="_blank" id="btn-cetak">Cetak</a>');

						$('#btn-cetak').attr('href', (site_url + '/jurnal/cetak_nota/' + response.n_transaksi + '?download=false'));
						Swal.fire('Sukses!', response.message, 'success').then((result) => {
							document.getElementById("btn-cetak").click();
							$('#modal-add').modal('hide');
							window.location.reload();
						});
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: response['message']
						})
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					hideLoading()
					Swal.fire('Error!', 'Internal server error', 'error').then((result) => {
						location.reload();
					});
				}
			});
		} else {
			Swal.fire('Jurnal', 'Jurnal harus balance silahkan cek kembali', 'warning')
		}
	} else {
		Swal.fire('Jurnal', 'Data Masih Kosong / Keterangan Wajib diisi', 'warning')
	}
});
number_format = function (number, decimals, dec_point, thousands_sep) {
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
function hitungTotal() {
	var _debet = 0;
	var _kredit = 0;
	var total_debet = (parseFloat($('.total_debet').val().replace(/,/g, "") || 0));
	var total_kredit = (parseFloat($('.total_kredit').val().replace(/,/g, "") || 0));
	var selisih = (parseFloat($('.selisih').val() || 0));
	for (let q = 0; q <= $('#jml_baris').val(); q++) {
		if ($('.adddebet' + q).val()) {
			_debet += parseFloat($('.adddebet' + q).val().replace(/,/g, "") || 0);
		}
		if ($('.addkredit' + q).val()) {
			_kredit += parseFloat($('.addkredit' + q).val().replace(/,/g, "") || 0);
		}
		selisih = _debet - _kredit;
		$('.total_debet').val(number_format(_debet, 2, '.', ','));
		$('.total_kredit').val(number_format(_kredit, 2, '.', ','));
		$('.selisih').val(number_format(selisih, 2, '.', ','));
	}
	if (selisih == 0 && $('#akun' + $('#jml_baris').val()).val() != '') {
		$('#save').show();
	} else {
		$('#save').hide();
	}
}

//hitung total detail
function hitungTotalDetail() {
	var _debet = 0;
	var _kredit = 0;
	var sum_debet = (parseFloat($('.sum_debet').val().replace(/,/g, "") || 0));
	var sum_kredit = (parseFloat($('.sum_kredit').val().replace(/,/g, "") || 0));
	var sum_selisih = (parseFloat($('.sum_selisih').val() || 0));
	for (let q = 0; q <= $('#sum_baris').val(); q++) {
		if ($('.d_adddebet' + q).val()) {
			_debet += parseFloat($('.d_adddebet' + q).val().replace(/,/g, "") || 0);
		}
		if ($('.d_addkredit' + q).val()) {
			_kredit += parseFloat($('.d_addkredit' + q).val().replace(/,/g, "") || 0);
		}
		selisih = _debet - _kredit;
		$('.sum_debet').val(number_format(_debet, 2, '.', ','));
		$('.sum_kredit').val(number_format(_kredit, 2, '.', ','));
		$('.sum_selisih').val(number_format(selisih, 2, '.', ','));
	}
	if (selisih == 0) {
		$('#editJurnSave').show();
	} else {
		$('#editJurnSave').hide();
	}
}

// start focus awal
$(document).ready(function () {
	$('#save').hide();
	$('#editJurnSave').hide();
	$("#modal-add").on('shown.bs.modal', function () {
		// $('#jml_baris').val(0);
		$(this).find('#reff').focus();
		$(this).find('#reff').select();
	});

	// clear modal add on hidden
	$('#modal-add').on('hidden.bs.modal', function () {
		$('#save').hide();
		$(this).find('#formAddjurnal')[0].reset();
		var baris = $('#jml_baris').val();
		for (p = 0; p < baris; p++) {
			$('#row' + p).remove();
		}
	});

	//focus modal
	$('#myModalAkun').on('shown.bs.modal', function () {
		$('input[type="search"]').val("");
		$('input[type="search"]').focus();
	});

	// destroy dan reinitialize datatable akun on hidden
	$('#myModalAkun').on('hidden.bs.modal', function () {
		$('.lookup').DataTable().destroy();
		$('.lookup').DataTable();
		// $('.lookup').DataTable({
		// 	"info": false,
		// 	"paging": false,
		// });
	});

	$('#myModalAkun').on('keydown', 'input[type="search"]', function (e) {
		if (e.which == 13) {
			$('.chsAkn:first').focus();
		}
	});
	$('#myModalAkun').on('hidden.bs.modal', function () {
		$('#adddebet' + $('#cekIndex').val()).focus();
	});

	$('.lookup').DataTable();
	// $('.lookup').DataTable({
	// 	"info": false,
	// 	"paging": false,
	// });
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
	$(".chs_akun" + s).click(function () {
		index = $('#cekIndex').val();
		$('#akun' + index).val($('.no_akun' + s).val());
		$('.nama' + index).val($('.no_namaakun' + s).val());
	});
}


$("body").on('keyup', '#reff', function (event) {
	if (event.keyCode == 13) {
		if ($(this).val() != "") {
			textboxes = $('#keterangan');
			currentBoxNumber = textboxes.index(this);
			if (textboxes[currentBoxNumber + 1] != null) {
				nextBox = textboxes[currentBoxNumber + 1];
				nextBox.focus();
				nextBox.select();
			}
			event.preventDefault();
			return false;
		} else {
			$(this).val('-');
			textboxes = $('#keterangan');
			currentBoxNumber = textboxes.index(this);
			if (textboxes[currentBoxNumber + 1] != null) {
				nextBox = textboxes[currentBoxNumber + 1];
				nextBox.focus();
				nextBox.select();
			}
			event.preventDefault();
			return false;
		}
	}
});

$("body").on('keyup', '#keterangan', function (event) {
	if (event.keyCode == 13) {
		textboxes = $('#akun0');
		currentBoxNumber = textboxes.index(this);
		if (textboxes[currentBoxNumber + 1] != null) {
			nextBox = textboxes[currentBoxNumber + 1];
			nextBox.focus();
			nextBox.select();
		}
		event.preventDefault();
		return false;
	}
});

// $("body").on('keydown', '#keterangan', function (event) { // Cek spasi
// 	if (event.which === 32 && event.target.selectionStart === 0) { 
// 		console.log('Ini spasi');
// 	}
// });

$("body").on('input', '#keterangan', function () { // Mencegah spasi di awal input
	$(this).val($(this).val().replace(/^\s+/g, ''));
});

$(document).on('keypress', '.akun', function (event) {
	// $('.nama'+i).val("");
	var a = $(this).data('urut');
	akun = $('#akun' + a).val();
	if (event.keyCode == 13) {
		$.getJSON("<?= site_url('Jurnal/getAkun?akun=') ?>" + akun, function (json) {
			if (json.length > 0) {
				$('.nama' + a).val(json[0].nama);
				textboxes = $('#adddebet' + a);
				currentBoxNumber = textboxes.index(this);
				if (textboxes[currentBoxNumber + 1] != null) {
					nextBox = textboxes[currentBoxNumber + 1];
					nextBox.focus();
					nextBox.select();
				}
				event.preventDefault();
				return false;
			}
			if (json.length == 0) {
				$('#cekIndex').val(a);
				$('#myModalAkun').modal('show');
			}
		});
	}
	if (event.keyCode == 32) {
		if (a > 0) {
			$('#save').focus();
		} else {
			Swal.fire('Jurnal', 'Data masih kosong', 'warning')
		}
	}

});

let c = 0;

// adddebet
$(document).on('keyup', '.adddebet', function (event) {
	$(this).val(formatRupiah(this.value));
	var i = $(this).data('urut');
	if (event.keyCode == 13 && c > 0) {
		if ($("#adddebet" + i).val() == 0) {
			textboxes = $('#addkredit' + i);
			currentBoxNumber = textboxes.index(this);
			if (textboxes[currentBoxNumber + 1] != null) {
				nextBox = textboxes[currentBoxNumber + 1];
				nextBox.focus();
				nextBox.select();
			}
			event.preventDefault();
			return false;
		} else if ($("#adddebet" + i).val() != 0 && $("#akun" + i).val() != "" && $(".nama" + i).val() != "") {
			if ($(this).data('urut') == $('#jml_baris').val()) {
				j = i + 1;
				html = '<tr id="row' + j + '" class="dynamic-added">' +
					'<td>' + '<input type="text" class="form-control akun" id="akun' + j + '" name="akun' + j + '" data-urut="' + j + '">' + '</td>' +
					'<td>' + '<input type="text" class="form-control nama' + j + '" name="' + j + '" data-urut="' + j + '">' + '</td>' +
					'<td>' + '<input type="text" class="form-control adddebet money adddebet' + j + '" id="adddebet' + j + '" style="text-align: right;" name="adddebet' + j + '" data-urut="' + j + '">' + '</td>' +
					'<td>' + '<input type="text" class="form-control addkredit money addkredit' + j + '" id="addkredit' + j + '" style="text-align: right;" name="addkredit' + j + '" data-urut="' + j + '">' + '</td>' +
					'<td id="action' + j + '"></td>' +
					'</tr>';
				$('#isi_detail tbody').append(html);
				$('#jml_baris').val(parseInt($('#jml_baris').val()) + 1);
				$('#akun' + i).prop('readonly', true);
				$('.nama' + i).prop('readonly', true);
				$('#addkredit' + i).val(number_format(0, 2, ".", ","));
				$('#action' + i).html('<a href="#" class="badge badge-danger btn_remove" id="' + i + '">x</a>');
			}
			c = 0;
			textboxes = $('#akun' + j);
			currentBoxNumber = textboxes.index(this);
			if (textboxes[currentBoxNumber + 1] != null) {
				nextBox = textboxes[currentBoxNumber + 1];
				nextBox.focus();
				nextBox.select();
			}
			event.preventDefault();
			return false;
		} else {
			Swal.fire('Jurnal', 'Harap pilih perkiraan terlebih dahulu!', 'warning')
		}
	}
	c += 1;
	hitungTotal();
});

// d_adddebet
$(document).on('keyup', '.d_adddebet', function (event) {
	$(this).val(formatRupiah(this.value));
	var i = $(this).data('urut');
	// console.log($('#sum_baris').val())
	if (c > 0) {
		if ($(this).data('urut') == $('#sum_baris').val()) {
			$('#sum_baris').val(parseInt($('#sum_baris').val()) + 1);
			$('#d_addkredit' + i).val(number_format(0, 2, ".", ","));
		} else if ($('#d_adddebet' + i).val() != 0) {
			$('#d_addkredit' + i).val(number_format(0, 2, ".", ","));
		} else if ($('#d_adddebet' + i).val() == "") {
			$('#d_adddebet' + i).val(number_format(0, 2, ".", ","));
		}
	}
	c += 1;
	hitungTotalDetail();
});

// addkredit
$(document).on('keyup', '.addkredit', function (event) {
	$(this).val(formatRupiah(this.value));
	var i = $(this).data('urut');
	if (event.keyCode == 13) {
		if ($("#addkredit" + i).val() == 0) {
			textboxes = $('#adddebet' + i);
			currentBoxNumber = textboxes.index(this);
			if (textboxes[currentBoxNumber + 1] != null) {
				nextBox = textboxes[currentBoxNumber + 1];
				nextBox.focus();
				nextBox.select();
			}
			event.preventDefault();
			return false;
		} else if ($("#addkredit" + i).val() != 0 && $("#akun" + i).val() != "" && $(".nama" + i).val() != "") {
			if ($(this).data('urut') == $('#jml_baris').val()) {
				j = i + 1;
				html = '<tr id="row' + j + '" class="dynamic-added">' +
					'<td>' + '<input type="text" class="form-control akun" id="akun' + j + '" name="akun' + j + '" data-urut="' + j + '">' + '</td>' +
					'<td>' + '<input type="text" class="form-control nama' + j + '" name="' + j + '" data-urut="' + j + '">' + '</td>' +
					'<td>' + '<input type="text" class="form-control adddebet money adddebet' + j + '" id="adddebet' + j + '" style="text-align: right;" name="adddebet' + j + '" data-urut="' + j + '">' + '</td>' +
					'<td>' + '<input type="text" class="form-control addkredit money addkredit' + j + '" id="addkredit' + j + '" style="text-align: right;" name="addkredit' + j + '" data-urut="' + j + '">' + '</td>' +
					'<td id="action' + j + '"></td>' +
					'</tr>';
				$('#isi_detail tbody').append(html);
				$('#jml_baris').val(parseInt($('#jml_baris').val()) + 1)
				$('#akun' + i).prop('readonly', true);
				$('.nama' + i).prop('readonly', true);
				$('#adddebet' + i).val(number_format(0, 2, ".", ","));
				$('#action' + i).html('<a href="#" class="badge badge-danger btn_remove" id="' + i + '">x</a>');
			}
			textboxes = $('#akun' + j);
			currentBoxNumber = textboxes.index(this);
			if (textboxes[currentBoxNumber + 1] != null) {
				nextBox = textboxes[currentBoxNumber + 1];
				nextBox.focus();
				nextBox.select();
			}
			event.preventDefault();
			return false;
		} else {
			Swal.fire('Jurnal', 'Harap pilih perkiraan terlebih dahulu!', 'warning');
		}
	}
	hitungTotal();
});

// d_addkredit
$(document).on('keyup', '.d_addkredit', function (event) {
	$(this).val(formatRupiah(this.value));
	var i = $(this).data('urut');
	// console.log($('#sum_baris').val())
	if (c > 0) {
		if ($(this).data('urut') == $('#sum_baris').val()) {
			$('#sum_baris').val(parseInt($('#sum_baris').val()) + 1);
			$('#d_adddebet' + i).val(number_format(0, 2, ".", ","));
		} else if ($('#d_addkredit' + i).val() != 0) {
			$('#d_adddebet' + i).val(number_format(0, 2, ".", ","));
		} else if ($('#d_addkredit' + i).val() == "") {
			$('#d_addkredit' + i).val(number_format(0, 2, ".", ","));
		}
	}
	c += 1;
	hitungTotalDetail();
});

$('body').on('click', '.btn_remove', function () {
	var id = $(this).attr("id");
	total_debet = parseFloat($('.total_debet').val().replace(/,/g, "")) - parseFloat($('#adddebet' + id).val().replace(/,/g, ""));
	total_kredit = parseFloat($('.total_kredit').val().replace(/,/g, "")) - parseFloat($('#addkredit' + id).val().replace(/,/g, ""));;
	selisih = total_debet - total_kredit;
	$('.selisih').val(number_format(selisih, 2, ".", ","));
	$('.total_debet').val(number_format(total_debet, 2, ".", ","));
	$('.total_kredit').val(number_format(total_kredit, 2, ".", ","));
	$('#row' + id).remove();
	if (selisih == 0 && $('#akun' + $('#jml_baris').val()).val() != '') {
		$('#save').show();
	} else {
		$('#save').hide();
	}
});

//form get jurnal

$(document).on('click', '.detail', function () {
	var text = $(this).data('kode');
	var keterangan = $(this).data('keterangan');
	var tanggal = $(this).data('tanggal');
	var jenis = $(this).data('jenis');

	$('#editJurn').hide();
	$('#hpsJurn').hide();
	$('#editJurnSave').hide();

	$('#j_jurnal').val(jenis);
	$("#tbl_detail").show();
	if (keterangan.search("(KOREKSI)") == -1) {
		$("#ket_jurnal").val("(KOREKSI) " + keterangan);
	} else {
		$("#ket_jurnal").val(keterangan);
	}
	$("#lbl_detail").text(text + " - " + keterangan);
	$("#highlight").show();
	//tampil ajax barang
	$.getJSON("<?= site_url('jurnal/getDetail?n_jurnal=') ?>" + text, function (json) {
		var html = '';
		// var i;
		sum_debet = 0;
		sum_kredit = 0;
		sum_selisih = 0;
		// for (i = 0; i < json.length; i++) {
		$.each(json, function (i) {
			dbt = parseFloat(json[i].debet);
			krd = parseFloat(json[i].kredit);
			debet = number_format(parseFloat(dbt), 2, '.', ',');
			kredit = number_format(parseFloat(krd), 2, '.', ',');
			sum_debet = sum_debet + parseFloat(dbt);
			sum_kredit = sum_kredit + parseFloat(krd);
			sum_selisih = sum_debet - sum_kredit;
			$('#sum_debet').val(number_format(parseFloat(sum_debet), 2, '.', ','));
			$('#sum_kredit').val(number_format(parseFloat(sum_kredit), 2, '.', ','));
			$('#sum_selisih').val(number_format(parseFloat(sum_selisih), 2, '.', ','));
			var sum = json.length
			// console.log(sum)
			html += '<tr>' +
				'<td><input type="text" name="akun' + i + '" class="border-0 bg-transparent form-control d_akun' + i + '" id="d_akun' + i + '" value="' + json[i].akun + '" data-urut="' + i + '" readonly></td>' + '<td><input type="text" name="nama_akun' + i + '" class="border-0 bg-transparent form-control d_nama' + i + '" id="d_nama' + i + '" value="' + json[i].nama_akun + '" data-urut="' + i + '" readonly></td>' + '<td style="text-align:right"><input type="text" name="debet' + i + '" class="border-0 bg-transparent text-right form-control d_adddebet d_adddebet' + i + ' nom_edit" id="d_adddebet' + i + '" data-urut="' + i + '" readonly value="' + debet + '"></td>' + '<td style="text-align:right"><input type="text" name="kredit' + i + '" class="border-0 bg-transparent text-right form-control d_addkredit d_addkredit' + i + ' nom_edit" id="d_addkredit' + i + '" data-urut="' + i + '" readonly value="' + kredit + '"><input type="hidden" id="sum_baris" value="' + sum + '" name="sum_baris"><input type="hidden" class="no_jurnal" value="' + text + '" name="no_jurnal"><input type="hidden" value="' + tanggal + '" name="tanggal"></td>' + '</tr>';
		})
		sum_selisih = sum_debet - sum_kredit;
		sum_selisih = parseFloat(sum_selisih).toFixed(2);
		if (sum_selisih != 0) {
			$("#sum_selisih").show();
			$("#highlight").addClass("alert-danger");
			$("#highlight").removeClass("alert-success");
			$('#editJurn').show();
			$('#hpsJurn').show();
		} else if ($('#j_jurnal').val() == "GL") {
			$("#sum_selisih").show();
			$("#highlight").addClass("alert-success");
			$("#highlight").removeClass("alert-danger");
			$('#editJurn').show();
			$('#hpsJurn').show();
		} else {
			$("#sum_selisih").hide();
			$("#highlight").removeClass("alert-danger");
			$("#highlight").addClass("alert-success");
		};
		$('#show_detail').html(html);
		$('#modal-detail').modal('show');
	});
});

$('#editJurn').on('click', function () {
	$('.nom_edit').attr("readonly", false);
	$(".nom_edit").removeClass("border-0");
	$(this).hide()
	$('#hpsJurn').hide();
	$('#editJurnSave').show()
});
$('#editJurnSave').on('click', function (e) {
	e.preventDefault();
	if ($('.sum_selisih').val() == 0) {
		for (p = 0; p <= $('#sum_baris').val(); p++) {
			if ($('.d_akun' + p).val()) {
				$(".d_adddebet" + p).val($(".d_adddebet" + p).val().replace(/[^-.\d]/g, ''));
				$(".d_addkredit" + p).val($(".d_addkredit" + p).val().replace(/[^-.\d]/g, ''));
			}
		}
		$('.sum_kredit').val($('.sum_kredit').val().replace(/[^-.\d]/g, ''))
		$('.sum_debet').val($('.sum_debet').val().replace(/[^-.\d]/g, ''))
		$.ajax({
			url: $('#jurnalEdit').attr('action'),
			type: "POST",
			data: $('#jurnalEdit').serialize(),
			dataType: "JSON",
			beforeSend: () => {
				showLoading()
			},
			success: function (response) {
				hideLoading()
				if (response.status) {
					$('body').append('<a class="d-none" role="button" target="_blank" id="btn-cetak">Cetak</a>');
					$('#btn-cetak').attr('href', (site_url + '/jurnal/cetak_nota/' + response.n_transaksi + '?download=false'));
					Swal.fire('Jurnal!', response.message, 'success').then((result) => {
						document.getElementById("btn-cetak").click();
						$('#modal-detail').modal('hide');
						location.reload();
					});
				} else {
					Swal.fire('Jurnal', response.message, 'error').then((result) => {
						location.reload();
					});
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				hideLoading()
				Swal.fire('Error!', 'Internal server error', 'error').then((result) => {
					location.reload();
				});
			}
		});
	} else {
		Swal.fire('Jurnal', 'Jurnal harus balance silahkan cek kembali', 'warning');
	}
});
$('#hpsJurn').on('click', function (e) {
	e.preventDefault();
	// location.href = "<?= site_url('Jurnal/hapusJurnal/') ?>" + $(".no_jurnal").val();
	Swal.fire({
		icon: "question",
		title: "Jurnal",
		text: "Apakah Anda yakin ingin menghapus data jurnal?",
		showCancelButton: true,
		cancelButtonText: "Batal",
		confirmButtonText: "Hapus",
		reverseButtons: true,
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: site_url + '/jurnal/hapusjurnal/',
				type: "POST",
				data: {
					n_jurnal: $(".no_jurnal").val()
				},
				dataType: "JSON",
				beforeSend: () => {
					showLoading()
				},
				success: function (response) {
					hideLoading()
					if (response.status) {
						Swal.fire('Jurnal!', response.message, 'success').then((result) => {
							$('#modal-detail').modal('hide');
							location.reload();
						});
					} else {
						Swal.fire('Jurnal', response.message, 'error').then((result) => {
							location.reload();
						});
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					hideLoading()
					Swal.fire('Error!', 'Internal server error', 'error').then((result) => {
						location.reload();
					});
				}
			});
		}
	});
});