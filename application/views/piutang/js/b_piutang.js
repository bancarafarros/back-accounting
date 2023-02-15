$('#pembayaranP').on('keyup keypress', function(e) {
    if (e.which == 13) {
        e.preventDefault();
    }
});
//format 
$(document).on('click focus', '.money', function() {
    $(this).select();
});
$(document).ready(function() {
    $('.Pelanggan').focus();
    $('.lookup').DataTable({
        "info": false,
        "paging": false,
    });
    $('.lookup_filter input').focus()
    // $('.lookup_filter [type="search"]').focus()
    $('.lookup-edit').DataTable({
        "responsive": true
    });
    $('.lookup_filter input').focus()
    // $('#lookup_filter [type="search"]').focus()

    $('.modal').on('shown.bs.modal', function() {
        $('input[type="search"]').val('')
        $('input[type="search"]').focus()
    });
    $('#myModalBank').on('hidden.bs.modal', function() {
        $('#save').focus();
    });
    $("#save").on('keypress click', function(e) {
        e.preventDefault();
        for (let jh = 0; jh < $('#sumJ_piutang').val(); jh++) {
            parseFloat($('#j_bayar' + jh).val($('#j_bayar' + jh).val().replace(/[^-.\d]/g, '')));
            parseFloat($('#sisa' + jh).val($('#sisa' + jh).val().replace(/[^-.\d]/g, '')));
            parseFloat($('#s_piutang' + jh).val($('#s_piutang' + jh).val().replace(/[^-.\d]/g, '')));
        }
        $('#totalJ_bayar').val($('#totalJ_bayar').val().replace(/[^-.\d]/g, ''));
        if ($('[name=n_pelanggan]').val() && $('#totalJ_bayar').val() > 0) {
            // $("#pembayaranP").submit();
            // setTimeout(function() {
            //     location.reload();
            // }, 1000);
            $.ajax({
				url: $('#pembayaranP').attr('action'),
				type: "POST",
				data: $('#pembayaranP').serialize(),
				dataType: "JSON",
				beforeSend: () => {
					showLoading()
				},
				success: function(response) {
					hideLoading()
					if (response.status) {
						$('body').append('<a class="d-none" role="button" target="_blank" id="btn-cetak">Cetak</a>');
						$('#btn-cetak').attr('href', (site_url + '/piutang/cetak_nota_bayar/' + response.n_transaksi + '?download=false'));
						Swal.fire('Pembayaran Piutang!', response.message, 'success').then((result) => {
							document.getElementById("btn-cetak").click();
							location.reload();
						});
					} else {
						Swal.fire('Pembayaran Piutang!', response.message, 'error').then((result) => {
							location.reload();
						});
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					hideLoading()
					Swal.fire('Error!', 'Internal server error', 'error').then((result) => {
						location.reload();
					});
				}
			});
        } else {
            Swal.fire('Bayar Piutang', 'Data masih kosong, silahkan cek kembali', 'warning');
        }
    });
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
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);
    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? ',' : '';
        rupiah += separator + ribuan.join(',');
    }

    rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
}

function DataPiutang(detail) {
    $.getJSON("<?= site_url('Piutang/getDPiutang?n_pelanggan=') ?>" + detail, function(json) {
        for (let a = 0; a < json.length; a++) {
            var format_sisa = number_format(json[a].sisa, 2, '.', ',');
            $('#list_piutang').append('<tr><td class="p-1" style="width:10%;><input type="hidden" name="sum_piutang' + a + '" class="form-control p-1 sum_piutang" value="' + json.length + '"><input type="text" name="n_penjualan' + a + '" class="form-control p-1 bg-white border-0" readonly value="' + json[a].n_penjualan + '"></td><td class="p-1" style="width:10%;"><input type="text" name="tgl_piutang' + a + '" class="form-control p-1 bg-white border-0" readonly value="' + json[a].tanggal + '"></td><td class="p-1" style="width:10%;"><input type="text" name="d_ket' + a + '" class="form-control p-1 bg-white border-0" readonly value="' + json[a].keterangan + '"></td><td class="p-1" style="width:10%;"><input type="text" name="s_piutang' + a + '" id="s_piutang' + a + '" class="form-control money p-1 bg-white border-0" readonly value="' + format_sisa + '"></td><td class="p-1" style="width:10%;"><input type="text" name="j_bayar' + a + '" data-id="' + a + '" id="j_bayar' + a + '" max-value="14" class="form-control money p-1 bg-white j_bayar" value="0"></td><td class="p-1" style="width:10%;"><input type="text" name="sisa' + a + '" id="sisa' + a + '" class="form-control money p-1 bg-white border-0" readonly value="' + format_sisa + '"></td></tr>');
            totalP += parseFloat(json[a].sisa);
            sum_sisa += parseFloat(json[a].sisa);
            jmlP = json.length
        }
        if (json.length > 0) {
            $('#sumJ_piutang').val(json.length);
            $('#totalP').val(number_format(totalP, 2, '.', ','));
            $('#totalS_piutang').val(number_format(totalP, 2, '.', ','));
            $('#keterangan').val('Terima dari ' + json[0].pelanggan);
            $(".sum_sisa").val(number_format(sum_sisa, 2, '.', ','));
            $('#j_bayar0').focus();
        } else {
            Swal.fire('Bayar Piutang', "Pelanggan a/n " + $('.d_n_pelanggan').val() + ' tidak memiliki piutang silahkan pilih pelanggan yang lain', 'warning');
            $('.Pelanggan').val("");
            $('.d_n_pelanggan').val("");
            $('.Pelanggan').focus();
        }
    });
}

let jmlP = 0;
var totalP = 0;
var bayar = 0;
var sum_sisa = 0;
for (let s = 0; s < $(".sum_n_pelanggan").val(); s++) {
    $(".chs_n_pelanggan" + s).on('keypress click', function() {
        var value = $('.no_pelanggan' + s).val() + " | " + $('.no_namapelanggan' + s).val();
        $(".d_n_pelanggan").val(value);
        $(".Pelanggan").val($('.no_pelanggan' + s).val());
        var sales = $('.n_sales' + s).val();
        $(".d_n_sales").val(sales);
        $(".d_Batas").val(number_format($('.batas_kredit' + s).val(), 2, '.', ','));
        $('#list_piutang').html("");
        $('#sumJ_piutang').val(0);
        totalP = 0;
        $('#myModalPelanggan').modal('hide');
        var pelanggan = $('.no_pelanggan' + s).val();
        //tampil Data Hutang
        DataPiutang(pelanggan);

    });
}

$(document).on('keyup', '.Pelanggan', function(e) {
    var keyCode = (event.keyCode ? event.keyCode : event.which);
    if (keyCode == 13) {
        var detail = $(this).val();

        $.getJSON("<?= site_url('Pelanggan/getPelanggan?n_pelanggan=') ?>" + detail, function(json) {
            var value = json.n_pelanggan + " | " + json.nama;
            $(".d_n_pelanggan").val(value);
            $(".pelanggan").val(json.n_pelanggan);
            batas_kredit = parseFloat(json.batas);
            $(".d_Batas").val(number_format(batas_kredit, 2, '.', ','));
            $('#list_piutang').html("");
            $('#sumJ_piutang').val(0);
            totalP = 0;
            if (json == false) {
                $(".d_n_pelanggan").val("");
                $(".Pelanggan").val("");
                $('#myModalPelanggan').modal('show');
            }
            if (json != false) {
                DataPiutang(json.n_pelanggan);
            }
        });
    }
});

$(document).on('keyup', '.j_bayar', function(e) {
    $(this).val(formatRupiah(this.value))
    bayar = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;

    var totalS = 0;
    var totalB = 0;
    var id = $(this).data("id");
    $('#sisa' + id).val($('#s_piutang' + id).val().replace(/,/g, "") - bayar);
    $('#sisa' + id).val(number_format($('#sisa' + id).val(), 2, '.', ','));
    for (let sum = 0; sum < $('#sumJ_piutang').val(); sum++) {
        totalS += parseFloat($('#sisa' + sum).val().replace(/,/g, ""));
        totalB += parseFloat($('#j_bayar' + sum).val().replace(/[^-.\d]/g, ''));
    }
    $('#totalS_piutang').val(number_format(totalS, 2, '.', ','));
    $('#totalJ_bayar').val(number_format(totalB, 2, '.', ','));
});

// cara bayar
$('.bank').hide();
$('.bank').attr("disabled");
$("#c_kas").click(function() {
    $("#c_bank").removeClass('btn-success');
    $("#c_bank").addClass('btn-default');
    $(this).removeClass('btn-default');
    $(this).addClass('btn-success');
    $("#c_bayar").val($(this).val());
    $('.bank').hide();
    $('.bank').attr("disabled");
    $("#d_Bank").val("");
});
$("#c_bank").click(function() {
    $("#c_kas").removeClass('btn-success');
    $("#c_kas").addClass('btn-default');
    $(this).removeClass('btn-default');
    $(this).addClass('btn-success');
    $("#c_bayar").val($(this).val());
    $('.bank').show();
    $('.bank').removeAttr("disabled");
});
for (let s = 0; s < $(".sum_bank").val(); s++) {
    $(".chs_bank" + s).on('keypress click', function(e) {
        $("#d_Bank").val($('.no_bank' + s).val() + " | " + $('.nama_bank' + s).val());
        $("#d_akunBank").val($('.akun_bank' + s).val());
        $('#myModalBank').modal('hide');
    });
}

//focus
$('#myModalPelanggan').on('keyup keypress', 'input[type="search"]', function(e) {
    if (e.which == 13) {
        $('.chs:first').focus();
    }
});
$('#myModalBank').on('keyup keypress', 'input[type="search"]', function(e) {
    if (e.keyCode == 13) {
        $('.chsBnk:first').focus();
    }
});
var sm = 0
$('table').on('keypress', '.j_bayar', function(e) {
    if (e.keyCode == 13) {
        var idb = parseFloat($(this).data('id')) + 1;
        if ($(this).data('id') < $('#sumJ_piutang').val()) {
            $('#j_bayar' + idb).focus();
        }
        if (idb == $('#sumJ_piutang').val()) {
            $('#keterangan').focus();
        }
    }
});
$('#keterangan').on('keypress', function(e) {
    if (e.which == 13) {
        $("#c_kas").focus();
    }
});
$("#c_kas").on('keypress', function(e) {
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
        $('#save').focus();
    }
});

$("#c_bank").click(function() {
    $('#myModalBank').on('hidden.bs.modal', function() {

        if ($('#d_Bank').val() == '') {
            Swal.fire('Transaksi Piutang', 'Bank tidak boleh kosong', 'warning');
            $('#save').hide();
        
        } else {
            $('#save').show();
        }
    });

    $("#c_kas").click(function() {
        $('#save').show();
    });

    $("#c_kas").removeClass('btn-success');
    $("#c_kas").addClass('btn-default');
    $(this).removeClass('btn-default');
    $(this).addClass('btn-success');
    $(".bank").show();
});