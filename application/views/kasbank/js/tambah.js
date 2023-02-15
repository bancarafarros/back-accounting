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


	$(document).ready(function() {
	    $(".bank").hide();
	    $("#simpan").on('click keypress', function(e) {
	        e.preventDefault();
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
	                $.ajax({
	                    url: $('#formKasbank').attr('action'),
	                    type: "POST",
	                    data: $('#formKasbank').serialize(),
	                    dataType: "JSON",
	                    beforeSend: () => {
	                        showLoading()
	                    },
	                    success: function(response) {
	                        hideLoading()
	                        if (response.status) {
	                            $('body').append('<a class="d-none" role="button" target="_blank" id="btn-cetak">Cetak</a>');
	                            $('#btn-cetak').attr('href', (site_url + '/kasbank/cetak_nota/' + response.n_transaksi + '?download=false'));
	                            Swal.fire('Sukses!', response.message, 'success').then((result) => {
	                                document.getElementById("btn-cetak").click();
	                                window.location.reload();
	                            });
	                        } else {
	                            Swal.fire('Jurnal', response.message, 'error').then((result) => {
	                                location.reload();
	                            });
	                        }

	                    },
	                    error: function(jqXHR, textStatus, errorThrown) {
	                        hideLoading();
	                        Swal.fire('Error!', 'Error Tambah/Update Data ', 'error');
	                    }
	                });
	            } else {
	                Swal.fire('Kas Bank', 'Data keterangan masih belum diisi', 'warning');
	            }
	        } else {
	            Swal.fire('Kas Bank', 'Data masih kosong', 'warning');
	        }
	    });

	    for (let s = 0; s < $(".sum_bank").val(); s++) {
	        $(".chs_bank" + s).on('keypress click', function(e) {
	            $("#d_Bank").val($('.no_bank' + s).val() + " | " + $('.nama_bank' + s).val());
	            $("#bayar").val($('.akun_bank' + s).val());
	        });
	    }

	    for (let s = 0; s < $(".sum_akun").val(); s++) {
	        $(".chs_akun" + s).click(function() {
	            index = $('#cekIndex').val();
	            $('#akun' + index).val($('.no_akun' + s).val());
	            $('#nama' + index).val($('.no_namaakun' + s).val());
	        });
	    }

	    $(document).on('keypress', '.akun', function(event) {
	        // $('.nama'+i).val("");
	        var akun = $(this).val();
	        var i = $(this).data('urut');
	        if (event.keyCode == 13) {
	            $.getJSON("<?= site_url('Jurnal/getAkun?akun=') ?>" + akun, function(json) {
	                if (json.length > 0) {
	                    $('#nama' + i).val(json[0].nama);
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
	                    Swal.fire('Kas Bank', "Isi nominal terlebih dahulu!", 'warning');
	                }
	                a += 1;
	            } else if ($("#akun" + i).val() == 0) {

	                Swal.fire('Kas Bank', "Isi akun terlebih dahulu!", 'warning');


	            } else if ($("#jumlah" + i).val() != 0 && $(".akun" + i).val() != "" && $(".nama" + i).val() != "") {
	                var j = i + 1;
	                z = parseFloat($('#jumlah' + i).val().replace(/,/g, ''));
	                $('#jumlah' + i).val(number_format(z, 2, '.', ','));
	                if (i == $('#jml_baris').val()) {
	                    html = '<tr id="row' + j + '" class="dynamic-added">' +
	                        '<td>' + '<input type="text" class="form-control akun" name="akun' + j + '" id="akun' + j + '" data-urut="' + j + '">' + '</td>' +
	                        '<td>' + '<input type="text" class="form-control nama' + j + '" name="nama' + j + '" id="nama' + j + '" data-urut="' + j + '">' + '</td>' +
	                        '<td>' + '<input type="text" class="form-control jumlah money" style="text-align: right;" id="jumlah' + j + '" name="jumlah' + j + '" data-urut="' + j + '">' + '</td>' +
	                        '<td id="action' + j + '">' + '' + '</td>' +
	                        '</tr>';
	                    $('#isi_detail tbody').append(html);
	                    $('#akun' + i).prop('readonly', true);
	                    $('#nama' + i).prop('readonly', true);
	                    $("#jumlah" + i).prop('required', true);
	                    $('#jml_baris').val(parseFloat($('#jml_baris').val()) + 1);
	                    $('#action' + i).html('<a href="#" class="badge badge-danger btn_remove" id="' + i + '">x</a>')
	                    a = 1;
	                    $('#akun' + j).focus();
	                }
	            } else {
	                Swal.fire('Kas Bank', "Harap pilih perkiraan terlebih dahulu!", 'warning');
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

	$("#kas").click(function() {
	    $("#bank").removeClass('btn-success');
	    $("#bank").addClass('btn-default');
	    $(this).removeClass('btn-default');
	    $(this).addClass('btn-success');
	    $(".bank").hide();

	    if ($('#masuk').hasClass('btn-success')) {
	        $('#n_transaksi').val('<?= $n_kasmasuk ?>');
	        $('#status').val('M');
	        $('#bayar').val('KAS');
	        $("#d_Bank").val('');
	    } else if ($('#keluar').hasClass('btn-success')) {
	        $('#n_transaksi').val('<?= $n_kaskeluar ?>');
	        $('#status').val('K');
	        $('#bayar').val('KAS');
	        $("#d_Bank").val('');
	    }

	});

	$("#bank").click(function() {
	    $('#myModalBank').on('hidden.bs.modal', function() {

	        if ($('#d_Bank').val() == '') {
	            Swal.fire('Bank', 'Bank masih belum dipilih', 'warning');
	            $('#simpan').hide();
	        } else {
	            $('#simpan').show();
	        }
	    });
	    $("#kas").click(function() {
	        $('#simpan').show();
	    });
	    $("#kas").removeClass('btn-success');
	    $("#kas").addClass('btn-default');
	    $(this).removeClass('btn-default');
	    $(this).addClass('btn-success');
	    $(".bank").show();

	    if ($('#masuk').hasClass('btn-success')) {
	        $('#n_transaksi').val('<?= $n_bankmasuk ?>');
	        $('#status').val('M');
	    } else if ($('#keluar').hasClass('btn-success')) {
	        $('#n_transaksi').val('<?= $n_bankkeluar ?>');
	        $('#status').val('K');
	    }

	});

	$("#masuk").click(function() {
	    $("#keluar").removeClass('btn-success');
	    $("#keluar").addClass('btn-default');
	    $(this).removeClass('btn-default');
	    $(this).addClass('btn-success');

	    if ($('#kas').hasClass('btn-success')) {
	        $('#n_transaksi').val('<?= $n_kasmasuk ?>');
	        $('#status').val('M');
	        $('#bayar').val('KAS');
	    } else if ($('#bank').hasClass('btn-success')) {
	        $('#n_transaksi').val('<?= $n_bankmasuk ?>');
	        $('#status').val('M');
	    }
	});

	$("#keluar").click(function() {
	    $("#masuk").removeClass('btn-success');
	    $("#masuk").addClass('btn-default');
	    $(this).removeClass('btn-default');
	    $(this).addClass('btn-success');

	    if ($('#kas').hasClass('btn-success')) {
	        $('#n_transaksi').val('<?= $n_kaskeluar ?>');
	        $('#status').val('K');
	        $('#bayar').val('KAS');
	    } else if ($('#bank').hasClass('btn-success')) {
	        $('#n_transaksi').val('<?= $n_bankkeluar ?>');
	        $('#status').val('K');
	    }
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
	        $("#kas").addClass('btn-default');
	        $('#bank').removeClass('btn-default');
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
	        $("#masuk").addClass('btn-default');
	        $('#keluar').removeClass('btn-default');
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


	$("body").on('input', '#keterangan', function() { // Mencegah spasi di awal input
	    $(this).val($(this).val().replace(/^\s+/g, ''));
	});