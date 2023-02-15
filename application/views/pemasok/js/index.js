function validatePhone(telepon) {
    if (telepon == '' || !telepon.match(/^0[0-9]{9,13}$/)) {
        $('#telepon').css({
            'color': '#B94A48',
            'background': '#F2DEDE',
            'border': 'solid 1px #EED3D7'
        });
    } else {
        $('#telepon').css({
            'color': '#468847',
            'background': '#DFF0D8',
            'border': 'solid 1px #D6E9C6'
        });
    }
}

function validatePhoneEdit(telepon) {
    if (telepon == '' || !telepon.match(/^0[0-9]{9,13}$/)) {
        $('#e_telepon').css({
            'color': '#B94A48',
            'background': '#F2DEDE',
            'border': 'solid 1px #EED3D7'
        });
    } else {
        $('#e_telepon').css({
            'color': '#468847',
            'background': '#DFF0D8',
            'border': 'solid 1px #D6E9C6'
        });
    }
}

function hapus(n_pemasok) {
    Swal.fire({
        icon: "warning",
        title: "Pemasok",
        text: "Apakah Anda yakin ingin menghapus data pemasok?",
        showCancelButton: true,
        cancelButtonText: "Batal",
        confirmButtonText: "Hapus",
        reverseButtons: true,
    }).then((result) => {
        if (result.value) {
            location.href = site_url + "/pemasok/hapus/" + n_pemasok;
        }
    });
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

$(function () {
    $('#zero_config').DataTable({
        pageLength: 25,
    });
})

for (let s = 0; s < $(".sum_akun").val(); s++) {
    $(".chs_akun" + s).click(function () {
        $(".d_akun").val($('.no_akun' + s).val());
        $(".d_namaakun").val($('.no_namaakun' + s).val());
        $(".e_tanggal").val($('.tanggal' + s).val());
    });
}

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

for (let a = 0; a < $(".sum_pemasok").val(); a++) {
    $(".edit" + a).click(function () {
        $(".e_nomor").val($('.n_pemasok' + a).val());
        $(".e_nama").val($('.nama' + a).val());
        $(".e_tanggal").val($('.tanggal' + a).val());
        $(".e_akun").val($('.akun' + a).val());
        $(".e_n_akun").val($('.n_akun' + a).val());
        $(".e_alamat").val($('.alamat' + a).val());
        $(".e_telepon").val($('.telepon' + a).val());
        $(".e_email").val($('.email' + a).val());
        var batas = parseFloat($('.batas' + a).val());
        $(".e_batas").val(number_format(parseFloat(batas), 2, '.', ','));
    });
}

$(document).ready(function () {
    $('#lookup').DataTable();
    $('#lookup_filter input').focus()
    //$('#lookup_filter [type="search"]').focus()
    $('#lookup-edit').DataTable();
    $('#lookup_filter input').focus()
    //$('#lookup_filter [type="search"]').focus()
});
$('#nAktif').click(function () {
    var table = $('#TabelNaktif').DataTable();
    $.getJSON("<?= site_url('pemasok/getPemasokNaktif') ?>", function (json) {
        // console.log(json);
        for (i = 0; i < json.length; i++) {
            table.clear().draw();
            table.row.add([json[i].n_pemasok, json[i].nama, '<button type="button" class="btn btn-sm btn-warning aktifPemasok" data-index="' + json[i].n_pemasok + '"><i class="fa fa-check"></i></button>']).draw();
        }
    });
})
$(document).on('click keypress', '.aktifPemasok', function (e) {
    Swal.fire({
        icon: "warning",
        title: "Pemasok",
        text: "Apakah anda ingin mengaktifkan kembali pemasok ini?",
        showCancelButton: true,
        cancelButtonText: "Batal",
        confirmButtonText: "Proses",
        reverseButtons: true,
    }).then((result) => {
        if (result.value) {
            location.href = "<?= site_url('pemasok/aktifPemasok/') ?>" + $(this).data('index');
        }
    });
})

$(document).on('keyup', '.numeric', function () {
    $(this).val(formatRupiah(this.value));
});

$(function () {
    $('#form-add').submit(function (e) {
        e.preventDefault();
        var no_hp = $('#telepon').val();
        if (no_hp.match(/^0[0-9]{9,13}$/)) {
            $(".batas").val($(".batas").val().replace(/,/g, ''));
            if ($(this).parsley().isValid()) {
                Swal.fire({
                    icon: "question",
                    title: "Peringatan",
                    text: "Apakah Anda yakin ingin menyimpan pemasok?",
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
                            beforeSend: function () {
                                showLoading();
                            },
                            success: function (response) {
                                hideLoading();
                                Swal.fire({
                                    confirmButtonColor: "#3ab50d",
                                    icon: "success",
                                    title: `${response.message.title}`,
                                    html: `${response.message.body}`,
                                }).then((result) => {
                                    location.reload();
                                });
                            },
                            error: function (request, status, error) {
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
        } else {
            Swal.fire('Telepon', 'Telepon tidak sesuai, nomor harus diawali dengan 0, minimal 10 digit dan maksimal 14 digit.<br>Contoh: 0811231231', 'warning');
        }
    })

    $('#form-edit').submit(function (e) {
        e.preventDefault();
        var e_no_hp = $('#e_telepon').val();
        if (e_no_hp.match(/^0[0-9]{9,13}$/)) {
            $(".e_batas").val($(".e_batas").val().replace(/,/g, ''));
            if ($(this).parsley().isValid()) {
                Swal.fire({
                    icon: "question",
                    title: "Peringatan",
                    text: "Apakah Anda yakin ingin menyimpan pemasok?",
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
                            beforeSend: function () {
                                showLoading();
                            },
                            success: function (response) {
                                hideLoading();
                                Swal.fire({
                                    confirmButtonColor: "#3ab50d",
                                    icon: "success",
                                    title: `${response.message.title}`,
                                    html: `${response.message.body}`,
                                }).then((result) => {
                                    location.reload();
                                });
                            },
                            error: function (request, status, error) {
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
        } else {
            Swal.fire('Telepon', 'Telepon tidak sesuai, nomor harus diawali dengan 0, minimal 10 digit dan maksimal 14 digit.<br>Contoh: 0811231231', 'warning');
        }
    })
})

// clear modal add on hidden
$('#modal-add').on('hidden.bs.modal', function () {
    $(this).find('#form-add')[0].reset();
    $('#form-add').parsley().reset();
    $('#telepon').css({
        'color': '',
        'background': '',
        'border': ''
    });
});

// clear css modal edit on hidden
$('#modal-edit').on('hidden.bs.modal', function () {
    $('#form-edit').parsley().reset();
    $('#e_telepon').css({
        'color': '',
        'background': '',
        'border': ''
    });
});

// focus search ketika modal akun dibuka
$('#myModal1').on('shown.bs.modal', function () {
    $('input[type="search"]').focus();
});
$('#myModal1-edit').on('shown.bs.modal', function () {
    $('input[type="search"]').focus();
});

// destroy dan reinitialize datatable akun on hidden
$('#myModal1').on('hidden.bs.modal', function () {
    $('#lookup').DataTable().destroy();
    $('#lookup').DataTable();
});
$('#myModal1-edit').on('hidden.bs.modal', function () {
    $('#lookup-edit').DataTable().destroy();
    $('#lookup-edit').DataTable();
});