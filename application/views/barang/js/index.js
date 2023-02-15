function hapusbarang(n_barang) {
    Swal.fire({
        title: 'Hapus Barang',
        text: "Apakah anda yakin ingin menghapus barang ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        // reverseButtons: true,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?= site_url('barang/hapus?') ?>",
                type: "POST",
                data: {
                    n_barang: n_barang
                },
                dataType: "JSON",
                beforeSend: () => {
                    showLoading()
                },
                success: function(response) {
                    hideLoading()
                    if (response.status) {
                        Swal.fire({
                            title: 'Barang',
                            text: response.message,
                            icon: 'success',
                        }).then(function() {
                            location.reload();
                        })
                    } else {
                        Swal.fire('error', response.message, 'error');
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
    });
}

function simpanbarang() {
    $('#add_Nbarang').submit(function(e) {
        e.preventDefault();
        if ($(this).parsley().isValid()) {
            console.log('oke');
            getN_barang();
            $('#h_beli').val($('#h_beli').val().replace(/\./g, ''));
            $('#h_jual').val($('#h_jual').val().replace(/\./g, ''));
            $.ajax({
                url: $('#add_Nbarang').attr('action'),
                type: "POST",
                data: $('#add_Nbarang').serialize(),
                dataType: "JSON",
                beforeSend: () => {
                    showLoading()
                },
                success: function(response) {
                    hideLoading()
                    if (response.status) {
                        Swal.fire({
                            title: 'Barang',
                            text: response.message,
                            icon: 'success',
                        }).then(function() {
                            $('#modal-add').modal('hide');
                            location.reload();
                        })
                    } else {
                        Swal.fire('error', response.message, 'error');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    hideLoading()



                }
            });
        }
    })


}

function ubahbarang() {
    getN_barang();
    // parseFloat($('#h_beli').val($('#h_beli').val().replace(/[^-.\d]/g, '')));
    $('.e_harga_beli').val($('.e_harga_beli').val().replace(/\./g, ''));
    // parseFloat($('#h_jual').val($('#h_jual').val().replace(/[^-.\d]/g, '')));
    $('.e_harga_jual1').val($('.e_harga_jual1').val().replace(/\./g, ''));
    $.ajax({
        url: $('#edit_Nbarang').attr('action'),
        type: "POST",
        data: $('#edit_Nbarang').serialize(),
        dataType: "JSON",
        beforeSend: () => {
            showLoading()
        },
        success: function(response) {
            hideLoading()
            let e_barang = ('#e_nama').val();
            if (e_barang.trim() == '') {
                console.log('enter');
                Swal.fire('warning', 'nama barang masih kosong', 'warning');

            } else if (response.status) {
                console.log('masuk sini');

                // Swal.fire({
                //     title: 'Barang2',
                //     text: response.message,
                //     icon: 'success',
                // }).then(function() {
                //     $('#modal-edit').modal('hide');
                //     location.reload();
                // })
            } else {
                Swal.fire('error', response.message, 'error');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            hideLoading()
            Swal.fire('Data Barang!', 'Data Barang Harus Diisi', 'warning').then((result) => {
                // location.reload();
            });
        }
    });
}
// number_format
function getN_barang() {
    var selected = $(".grup").find('option:selected');
    var id = selected.val();
    var kode = selected.data('value');
    //tampil ajax barang
    $.getJSON("<?= site_url('barang/KodeLast?grup=') ?>" + id, function(json) {
        //   console.log(json);
        var nomorLast = parseInt(json.KodeLast);

        function pad(str, max) {
            str = str.toString();
            return str.length < max ? pad("0" + str, max) : str;
        }
        var nomorBaru = pad(nomorLast + 1, 5);
        $("#autonumber").val(kode + "." + nomorBaru);
        $(".d_namaakun_persediaan").val(json.namaakun_persediaan);
        $(".d_namaakun_hpp").val(json.namaakun_hpp);
        $(".d_namaakun_pendapatan").val(json.namaakun_pendapatan);
        $(".d_akun_persediaan").val(json.akun_persediaan);
        $(".d_akun_hpp").val(json.akun_hpp);
        $(".d_akun_pendapatan").val(json.akun_pendapatan);
    });
}
//function formatRupiah(angka, prefix)
function getKartuBarang() {
    var table = $('#detailkartu').DataTable({
        "order": false,
        "retrieve": true
    });
    var n_barang = $('.kode_barang').val()
    var from_date = $('.from_date').val();
    var to_date = $('.to_date').val();
    table.clear().draw()
    $.getJSON("<?= site_url('barang/getKartuBarang?') ?>" + "from_date=" + from_date + "&to_date=" + to_date + "&n_barang=" + n_barang, function(json) {
        for (i = 0; i < json.length; i++) {
            table.row.add([json[i].tanggal, json[i].reff, json[i].keluar, json[i].masuk, json[i].satuan, json[i].sisa, number_format(parseFloat(json[i].harga), 0, ',', '.')]).draw();
        }
    });
}

$(document).ready(function() {
    $('.lookup').DataTable({
        "search": true,
        "responsive": true,
        "paging": true,
        "lengthChange": true,
        "pageLength": 25,
        "processing": true
    });
    // jQuery.validator.addMethod("alphanumeric", function(value, element) {
    // 	return this.optional(element) || /^[\w- _(),./]+$/i.test(value);
    // }, "Inputan yang anda masukan salah, silahkan cek kembali");
    // $('#add_Nbarang').validate({
    // 	rules: {
    // 		nama: {
    // 			required: true,
    // 			alphanumeric: true,
    // 		},
    // 	}
    // });
    // $('#edit_Nbarang').validate({
    // 	rules: {
    // 		nama: {
    // 			required: true,
    // 			alphanumeric: true,
    // 		},
    // 	}
    // });
    $(".grup").change(function() {
        getN_barang();
    });

    for (let s = 0; s < $(".sum_akun_persediaan").val(); s++) {
        $(".chs_akun_persediaan" + s).click(function() {
            $(".d_akun_persediaan").val($('.no_akun_persediaan' + s).val());
            $(".d_namaakun_persediaan").val($('.no_namaakun_persediaan' + s).val());
        });
    }

    for (let s = 0; s < $(".sum_akun_hpp").val(); s++) {
        $(".chs_akun_hpp" + s).click(function() {
            $(".d_akun_hpp").val($('.no_akun_hpp' + s).val());
            $(".d_namaakun_hpp").val($('.no_namaakun_hpp' + s).val());
        });
    }

    for (let s = 0; s < $(".sum_akun_pendapatan").val(); s++) {
        $(".chs_akun_pendapatan" + s).click(function() {
            $(".d_akun_pendapatan").val($('.no_akun_pendapatan' + s).val());
            $(".d_namaakun_pendapatan").val($('.no_namaakun_pendapatan' + s).val());
        });
    }

    for (let a = 0; a < $(".sum_barang").val(); a++) {
        $(document).on('click', ".edit" + a, function() {
            var n_barang = $('.n_barang' + a).val();
            $.getJSON("<?= site_url('Barang/getDetail?n_barang=') ?>" + n_barang, function(json) {
                $(".e_n_barang").val(json.n_barang);
                $(".e_barcode").val(json.barcode);
                $(".e_akun_hpp").val(json.akun_hpp);
                $(".e_akun_persediaan").val(json.akun_persediaan);
                $(".e_akun_pendapatan").val(json.akun_pendapatan);
                $(".e_namaakun_hpp").val(json.namaakun_hpp);
                $(".e_namaakun_persediaan").val(json.namaakun_persediaan);
                $(".e_namaakun_pendapatan").val(json.namaakun_pendapatan);
                $(".e_harga_beli").val(number_format(parseFloat(json.harga_beli), 2, '.', ','));
                $(".e_harga_jual1").val(number_format(parseFloat(json.harga_jual1), 2, '.', ','));
                $(".e_n_grup").val(json.n_grup);
                $(".e_nama_grup").val(json.nama_grup);
                $(".e_nama").val(json.nama);
                $(".e_stock_min").val(json.stock_min);
                $(".e_stock_etalase").val(json.stock_etalase);
                $(".e_stock_gudang").val(json.stock_gudang);
                $(".e_n_unit").val(json.n_unit);
                $(".e_b_unit").val(json.b_unit);
                $(".e_konversi_unit").val(json.konversi_unit);
                $(".e_harga_jual2").val(json.harga_jual2);
                $(".e_harga_jual3").val(json.harga_jual3);
                $(".e_diskon").val(json.diskon);
                $(".e_keterangan1").val(json.keterangan1);
                $(".e_keterangan2").val(json.keterangan2);
                $(".e_keterangan3").val(json.keterangan3);
            });
        });
    }
});
// $('#add_Nbarang').submit(function() {
// 	if ($("#add_Nbarang").valid()) {
// 		getN_barang();
// 		parseFloat($('#h_beli').val($('#h_beli').val().replace(/[^-.\d]/g, '')));
// 		parseFloat($('#h_jual').val($('#h_jual').val().replace(/[^-.\d]/g, '')));
// 		return processForm(this);
// 	}
// });
// $('#edit_Nbarang').submit(function() {
// 	if ($("#edit_Nbarang").valid()) {
// 		getN_barang();
// 		parseFloat($('.e_harga_beli').val($('.e_harga_beli').val().replace(/[^-.\d]/g, '')));
// 		parseFloat($('.e_harga_jual1').val($('.e_harga_jual1').val().replace(/[^-.\d]/g, '')));
// 		return processForm(this);
// 	}
// });

$("body").on('input', '#nama', function() {
    $(this).val($(this).val().replace(/^\s+/g, ''));
});
$('.money').keyup(function(e) {
    $(this).val(formatRupiah(this.value))
    bayar = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
});
$(document).on('click focus', '.money', function() {
    $(this).select();
});
$('.tampilKartu').click(function() {
    $('.kode_barang').val($(this).data('kode'))
    getKartuBarang();
})
$('.set_kartu').click(function() {
    getKartuBarang();
});

// $('.delete-btn').on('click', function() {
// 	if (confirm('Apakah anda ingin menghapus data barang ini?')) {
// 		location.href = "<?= site_url("barang/hapus/") ?>" + $(this).data('id');
// 	}
// });
$('.get_hpp').on('click', function() {
    $('#n_hpp').val(number_format(parseFloat($(this).data('hpp')), 0, ',', '.'));
});
$('#add_Nbarang').on('keyup keypress', function(e) {
    if (e.which == 13) {
        e.preventDefault();
    }
});
$('#edit_Nbarang').on('keyup keypress', function(e) {
    if (e.which == 13) {
        e.preventDefault();
    }
});

$("#btnEtalase").click(function() {
    $("#formEtalase").toggle();
    $("#sEtalase").toggle();
});
$("#btnEtalase-edit").click(function() {
    $("#formEtalase-edit").toggle();
    $("#sEtalase-edit").toggle();
});

$(function() {
    $('#add_Nbarang').submit(function(e) {
        e.preventDefault();
        if ($(this).parsley().isValid()) {
            console.log('oke');
        }
    })
    $('#modal-add').on('hidden.bs.modal', function() {
        $(this).find('#add_Nbarang')[0].reset();
        $('#add_Nbarang').parsley().reset();
    });

    $('#modal-edit').on('hidden.bs.modal', function() {
        $(this).find('#edit_Nbarang')[0].reset();
        $('#edit_Nbarang').parsley().reset();
    });


    $('#edit_Nbarang').submit(function(e) {
        e.preventDefault();
        if ($(this).parsley().isValid()) {
            Swal.fire({
                icon: "question",
                title: "Peringatan",
                text: "Apakah Anda yakin ingin mengubah data barang?",
                showCancelButton: true,
                cancelButtonText: "Batal",
                confirmButtonText: "Simpan",
                confirmButtonColor: "#3ab50d",
                reverseButtons: true,
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "post",
                        dataType: 'json',
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        // contentType: false,
                        // processData: false,
                        beforeSend: function() {
                            showLoading();
                        },
                        success: function(response) {
                            hideLoading();
                            Swal.fire({
                                confirmButtonColor: "#3ab50d",
                                icon: "success",
                                title: 'Berhasil',
                                html: 'Data Barang Berhasil Diubah',
                            }).then((result) => {
                                location.reload();
                            });
                        },
                        error: function(request, status, error) {
                            hideLoading();
                            Swal.fire({
                                confirmButtonColor: "#3ab50d",
                                icon: "error",
                                title: `${request.responseJSON.message.title}`,
                                html: `${request.responseJSON.message.body}`,
                            });
                        },
                    });
                }
            });
        }
    })
})