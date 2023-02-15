function tampilKartu(pelanggan) {
    $.getJSON("<?= site_url('piutang/getKartu?n_pelanggan=') ?>" + pelanggan, function(json) {
        var html = '';
        var i;
        sum_sisa = 0;
        if (Array.isArray(json)) {
            for (i = 0; i < json.length; i++) {
                sum_sisa = sum_sisa + parseFloat(json[i].sisa);
                $(".sum_sisa").val(number_format(sum_sisa, 2, '.', ','));
                sisa = number_format(parseFloat(json[i].sisa), 2, '.', ',');
                html += '<tr>' +
                    '<td>' + json[i].n_penjualan + '</td>' +
                    '<td>' + json[i].tanggal + '</td>' +
                    '<td>' + json[i].keterangan + '</td>' +
                    '<td align="right">' + sisa + '</td>' +
                    '<tr>';
            }
        }
        $('#ketr').focus();
        $('#show_kartu').html(html);
    });
}
$('#formpiutang').on('keyup keypress', function(e) {
    if (e.which == 13) {
        e.preventDefault();
    }
});
var shortDateFormat = 'dd/MM/yyyy';
// $(".money").on("click", function() {
//     $(this).select();
// });
// $(".money").autoNumeric('init', {
//     aSep: ',',
//     aDec: '.'
// });

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

$("body").on('input', '#ketr', function () {
	$(this).val($(this).val().replace(/^\s+/g, ''));
});

$(document).ready(function() {
    $('.d_n_pelanggan').focus();
    $('.lookupMod').DataTable({
        "info": false,
        "paging": false,
    });
    $('.lookup').DataTable({
        "info": false,
        "paging": false,
        "ordering": false,
        "searching": false,
    });
    $('.lookup_filter input').focus()
    // $('.lookup_filter [type="search"]').focus()
    $('.lookup-edit').DataTable({
        "responsive": true
    });
    $('.lookup_filter input').focus()
    // $('#lookup_filter [type="search"]').focus()

    $("#jumlah").on("input", function() {
        // allow numbers, a comma or a dot
        var v = $(this).val(),
            vc = v.replace(/[^0-9,\.]/, '');
        if (v !== vc)
            $(this).val(vc);
    });
    $('.modal').on('shown.bs.modal', function() {
        $('input[type="search"]').val('')
        $('input[type="search"]').focus()
    });
    $('#myModalBank').on('hidden.bs.modal', function() {
        $('#jumlah').focus();
    });

    $("#save").on('keypress click', function(e) {
        e.preventDefault();

        var tanggal = $('.tanggal').val()
		var jatuh_tempo = $('.jatuh_tempo').val()

        if (jatuh_tempo < tanggal) {
			Swal.fire('Transaksi Penjualan', 'Tanggal jatuh tempo harus sama atau sesudah tanggal transaksi', 'warning');
        
        } else if (document.forms['formpiutang'].keterangan.value === "") {
            Swal.fire('Transaksi Piutang', "Data masih kosong silahkan cek kembali", 'warning');
        
        } else if ($('.d_n_pelanggan').val() && parseInt($('#jumlah').val()) > 0) {
            var value = $(".money").val().replace(/,/g, "");
            $(".money").val(value);
            // $("#formpiutang").submit();
            // setTimeout(function(){
            //     location.reload();
            // }, 1000);
            $.ajax({
				url: $('#formpiutang').attr('action'),
				type: "POST",
				data: $('#formpiutang').serialize(),
				dataType: "JSON",
				beforeSend: () => {
					showLoading()
				},
				success: function(response) {
					hideLoading()
					if (response.status) {
						$('body').append('<a class="d-none" role="button" target="_blank" id="btn-cetak">Cetak</a>');
						$('#btn-cetak').attr('href', (site_url + '/piutang/cetak_nota/' + response.n_transaksi + '?download=false'));
						Swal.fire('Piutang!', response.message, 'success').then((result) => {
							document.getElementById("btn-cetak").click();
							location.reload();
						});
					} else {
						Swal.fire('Piutang!', response.message, 'error').then((result) => {
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
            Swal.fire('Transaksi Piutang', "Data masih kosong silahkan cek kembali", 'warning');
        }
    });
});

for (let s = 0; s < $(".sum_n_pelanggan").val(); s++) {
    $(".chs_n_pelanggan" + s).click(function() {
        var value = $('.no_pelanggan' + s).val() + " | " + $('.no_namapelanggan' + s).val();
        $(".d_n_pelanggan").val(value);
        $(".keterangan").val('Terima dari ' + $('.no_namapelanggan' + s).val());
        $(".n_pelanggan").val($('.no_pelanggan' + s).val());
        batas_kredit = parseFloat($('.batas_kredit' + s).val());
        $(".batas").val(number_format(batas_kredit, 2, '.', ','));
        var sales = $('.n_sales' + s).val();
        $(".d_n_sales").val(sales);
        $(".sum_sisa").val(0);

        tampilKartu($('.no_pelanggan' + s).val());
    });
}
$(document).on('keyup', '.d_n_pelanggan', function(e) {
    var keyCode = (event.keyCode ? event.keyCode : event.which);
    if (keyCode == 13) {
        var detail = $(this).val();
        $.getJSON("<?= site_url('Pelanggan/getPelanggan?n_pelanggan=') ?>" + detail, function(json) {
            console.log(json);
            var value = json.n_pelanggan + " | " + json.nama;
            $(".d_n_pelanggan").val(value);
            $("#n_pelanggan").val(json.n_pelanggan);
            $(".n_pelanggan").val(json.n_pelanggan);
            batas_kredit = parseFloat(json.batas);
            $("#batas").val(number_format(batas_kredit, 2, '.', ','));
            $(".sum_sisa").val(0);
            if (json == false) {
                $('#myModalPelanggan').modal('show');
            }
            if (json != false) {
                tampilKartu(json.n_pelanggan);
            }
        });
    }
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
    $('#jumlah').focus();
});
$("#c_bank").click(function() {
    $('#myModalBank').modal('show');
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
$('#ketr').on('keypress', function(e) {
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
        $('#jumlah').focus();
    }
});
$("#jumlah").on('keypress', function(e) {
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