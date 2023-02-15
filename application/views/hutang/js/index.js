
    function tampilKartu(pemasok) {
        var table = $('#lookup').DataTable({
            "paging": false,
            "retrieve": true,
        });
        $.getJSON("<?= site_url('Hutang/getKartu?n_pemasok=') ?>" + pemasok, function(json) {
            table.clear().draw();
            var i;
            sum_sisa = 0;
            var opsi;
            for (i = 0; i < json.length; i++) {
                sum_sisa = sum_sisa + parseFloat(json[i].sisa);
                $(".sum_sisa").val(number_format(sum_sisa, 2, '.', ','));
                sisa = number_format(parseFloat(json[i].sisa), 2, '.', ',');
                opsi = '<a role="button" href="' + site_url + '/hutang/cetak_nota/' + json[i].n_pembelian + '?download=false' + '" class="btn btn-xs btn-success" target="_blank"><i class="fa fa-print"></i></a>';
                table.row.add([opsi, json[i].n_pembelian, json[i].tanggal, json[i].keterangan, sisa]).draw(false);
            }

            $('#ketr').focus();
        });
    }

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

    $('#formhutang').on('keyup keypress', function(e) {
        if (e.which == 13) {
            e.preventDefault();
        }
    });
    var shortDateFormat = 'dd/MM/yyyy';
    $(".money").on("click", function() {
        $(this).select();
    });
    $('.money').keyup(function(e) {
        $(this).val(formatRupiah(this.value))
        bayar = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
        // var cekJumlahHutang = $('input.money').parsley();
        if(bayar > batas_kredit){
            // window.ParsleyUI.addError(cekJumlahHutang, "customErrorHutang", 'jumlah hutang tidak boleh lebih batas kredit');
            $('#save').hide();
        }else{
            $('#save').show();
            // window.ParsleyUI.removeError(cekJumlahHutang, "customErrorHutang");
        }
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

    var batas = '';
    var batas_kredit = '';

    //Pemasok
    for (let s = 0; s < $(".sum_n_pemasok").val(); s++) {
        $(".chs_n_pemasok" + s).click(function() {
            var value = $('.no_pemasok' + s).val() + " | " + $('.no_namapemasok' + s).val();
            $(".d_n_pemasok").val(value);
            $("#n_pemasok").val($('.no_pemasok' + s).val());
            $(".n_pemasok").val($('.no_pemasok' + s).val());
            batas_kredit = parseFloat($('.batas_kredit' + s).val());
            batas = $("#batas").val(number_format(batas_kredit, 2, '.', ','));

            $(".sum_sisa").val(0);
            //tampil ajax Kartu
            tampilKartu($('.no_pemasok' + s).val());
        });
    }

    $(document).on('keyup', '.d_n_pemasok', function(e) {
        var keyCode = (event.keyCode ? event.keyCode : event.which);
        if (keyCode == 13) {
            var detail = $(this).val();
            //tampil ajax barang
            $.getJSON("<?= site_url('Pemasok/getPemasok?n_pemasok=') ?>" + detail, function(json) {
                console.log(json);
                var value = json.n_pemasok + " | " + json.nama;
                $(".d_n_pemasok").val(value);
                $("#n_pemasok").val(json.n_pemasok);
                $(".n_pemasok").val(json.n_pemasok);
                batas_kredit = parseFloat(json.batas);
                $("#batas").val(number_format(batas_kredit, 2, '.', ','));
                $(".sum_sisa").val(0);
                if (json == false) {
                    $('#myModalPemasok').modal('show');
                }
                if (json != false) {
                    tampilKartu(json.n_pemasok);
                }
            });
        }
    });
    $(document).ready(function() {
        $('.d_n_pemasok').focus();
        $('.lookupMod').DataTable({
            "info": false,
            "paging": false,
        });
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
        // $("#save").on('keypress click', function() {
        //     if ($('.d_n_pemasok').val() && parseInt($('#jumlah').val()) > 0) {
        //         var value = $(".money").val().replace(/,/g, "");
        //         $(".money").val(value);
        //         // $("#formhutang").submit();
        //         // setTimeout(function() {
        //         //     location.reload();
        //         // }, 1000);
        //         $.ajax({
        //             url: $('#formhutang').attr('action'),
        //             type: "POST",
        //             data: $('#formhutang').serialize(),
        //             dataType: "JSON",
        //             beforeSend: () => {
        //                 showLoading()
        //             },
        //             success: function(response) {
        //                 hideLoading()
        //                 if (response.status) {
        //                     $('body').append('<a class="d-none" role="button" target="_blank" id="btn-cetak">Cetak</a>');
        //                     $('#btn-cetak').attr('href', (site_url + '/hutang/cetak_nota/' + response.n_transaksi + '?download=false'));
        //                     Swal.fire('Hutang!', response.message, 'success').then((result) => {
        //                         document.getElementById("btn-cetak").click();
        //                         location.reload();
        //                     });
        //                 } else {
        //                     Swal.fire('Hutang!', response.message, 'error').then((result) => {
        //                         location.reload();
        //                     });
        //                 }
        //             },
        //             error: function(jqXHR, textStatus, errorThrown) {
        //                 hideLoading()
        //                 Swal.fire('Error!', 'Internal server error', 'error').then((result) => {
        //                     location.reload();
        //                 });
        //             }
        //         });
        //     } else {
        //         Swal.fire('Transaksi Hutang', 'Data masih kosong, silahkan cek kembali', 'warning');
        //     }
        // });
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
        $('#myModalBank').on('hidden.bs.modal', function (){
            if($('.bank').val() == ''){
                $('#c_kas').addClass('btn-success');
                $('#c_bank').removeClass('btn-success');
                $('#c_bayar').val($('#c_kas').val());
                $('.bank').hide();
            }
        });
    }

    //focus
    $('#myModalPemasok').on('keyup keypress', 'input[type="search"]', function(e) {
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


    $(function () {
        $('#formhutang').submit(function (e) {
            e.preventDefault();
            var tempo = $('#tempo').val();
            var tanggal_transaksi = $('#tanggal_transaksi').val();
            if ($(this).parsley().isValid()) {
                var value = $(".money").val().replace(/,/g, "");
                $(".money").val(value);

                if(value == 0){
                    Swal.fire('Hutang',"Jumlah hutang tidak boleh nol",'error');
                }else{
                    if(tempo < tanggal_transaksi){
                        Swal.fire('Hutang', "Tanggal jatuh tempo tidak boleh sebelum tanggal transaksi hutang", 'error');
                    }else{
                        $.ajax({
                            url: $('#formhutang').attr('action'),
                            type: "POST",
                            data: $('#formhutang').serialize(),
                            dataType: "JSON",
                            beforeSend: () => {
                                showLoading()
                            },
                            success: function(response) {
                                hideLoading()
                                if (response.status) {
                                    $('body').append('<a class="d-none" role="button" target="_blank" id="btn-cetak">Cetak</a>');
                                    $('#btn-cetak').attr('href', (site_url + '/hutang/cetak_nota/' + response.n_transaksi + '?download=false'));
                                    Swal.fire('Hutang!', response.message, 'success').then((result) => {
                                        document.getElementById("btn-cetak").click();
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire('Hutang!', response.message, 'error').then((result) => {
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
                    }
                }
            }
        })
    })