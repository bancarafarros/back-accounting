$(".money").on("click", function () {
    $(this).select();
});
$(".money-edit").on("click", function () {
    $(this).select();
})
$(document).ready(function () {
    for (let s = 0; s < $(".sum_akun").val(); s++) {
        $(".chs_akun" + s).click(function () {
            $(".d_akun").val($('.no_akun' + s).val());
            $(".d_namaakun").val($('.no_namaakun' + s).val());
            $(".e_tanggal").val($('.tanggal' + a).val());
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

    for (let a = 0; a < $(".sum_pelanggan").val(); a++) {
        $(".edit" + a).click(function () {
            $(".e_n_pelanggan").val($('.n_pelanggan' + a).val());
            $(".e_barcode").val($('.barcode' + a).val());
            $(".e_pass").val($('.pass' + a).val());
            $(".e_tanggal").val($('.tanggal' + a).val());
            $(".e_akun").val($('.akun' + a).val());
            $(".e_n_akun").val($('.n_akun' + a).val());
            $(".e_nama").val($('.nama' + a).val());
            $(".e_alamat").val($('.alamat' + a).val());
            $(".e_telepon").val($('.telepon' + a).val());
            $(".e_email").val($('.email' + a).val());
            var batas = parseFloat($('.batas' + a).val());
            $(".e_batas").val('Rp ' + number_format(batas, 2, ".", ","));
            $(".e_n_sales").val($('.n_sales' + a).val());
            if ($('.status' + a).val() == "a") {
                $("#taktif").removeClass('btn-danger');
                $("#taktif").addClass('btn-secondary');
                $("#aktif").removeClass('btn-secondary');
                $("#aktif").addClass('btn-success');
                $(".status").val("a");
            }
            if ($('.status' + a).val() == "ta") {
                $("#aktif").removeClass('btn-success');
                $("#aktif").addClass('btn-secondary');
                $("#taktif").removeClass('btn-secondary');
                $("#taktif").addClass('btn-danger');
                $(".status").val("t");
            }
        });
    }
});

$(document).ready(function () {
    $('#zero_config').DataTable({
        pageLength: 25,
    });
    $(".simpan").click(function () {
        var value = $(".money").val().replace("Rp ", "");
        var value = value.replace(/,/g, "");
        $(".money").val(value);
    });
    $(".edit").click(function () {
        var value = $(".money-edit").val().replace("Rp ", "");
        var value = value.replace(/,/g, "");
        $(".money-edit").val(value);
    });
    $('#lookup').DataTable({
        "paging": false,
        "search": true,
        "responsive": true
    });
    $('#lookup_filter input').focus()
    //$('#lookup_filter [type="search"]').focus()
    $('#lookup-edit').DataTable({
        "paging": false,
        "search": true,
        "responsive": true
    });
    $('#lookup_filter input').focus()

    $("#aktif").click(function () {
        $("#taktif").removeClass('btn-danger');
        $("#taktif").addClass('btn-secondary');
        $(this).removeClass('btn-secondary');
        $(this).addClass('btn-success');
        $(".status").val("a");
    });
    $("#taktif").click(function () {
        $("#aktif").removeClass('btn-success');
        $("#aktif").addClass('btn-secondary');
        $(this).removeClass('btn-secondary');
        $(this).addClass('btn-danger');
        $(".status").val("t");
    });
    $(".visible").click(function () {
        var type = $('.pass').attr("type");
        // now test it's value
        if (type === 'password') {
            $('.pass').attr("type", "text");
        } else {
            $('.pass').attr("type", "password");
        }
    });
});

$('.delete-btn').on('click', function () {
    Swal.fire({
        icon: "warning",
        title: "Pelanggan",
        text: "Apakah Anda ingin menghapus data pelanggan ini?",
        showCancelButton: true,
        cancelButtonText: "Batal",
        confirmButtonText: "Hapus",
        reverseButtons: true,
    }).then((result) => {
        if (result.value) {
            location.href = "<?= site_url('pelanggan/hapus/') ?>" + $(this).data('id');
        }
    });
});

$('#nAktif').click(function () {
    var table = $('#TabelNaktif').DataTable();
    $.getJSON("<?= site_url('Pelanggan/getPelangganNaktif') ?>", function (json) {
        // console.log(json);
        for (i = 0; i < json.length; i++) {
            table.clear().draw();
            table.row.add([json[i].n_pelanggan, json[i].nama, '<button type="button" class="btn btn-sm btn-warning aktifPelanggan" data-index="' + json[i].n_pelanggan + '"><i class="fa fa-check"></i></button>']).draw();
        }
    });
})
$(document).on('click keypress', '.aktifPelanggan', function (e) {
    if (confirm('Apakah anda ingin mengaktifkan kembali pelanggan ini?')) {
        location.href = "<?= site_url('pelanggan/aktifPelanggan/') ?>" + $(this).data('index');
    }
})

$(function () {
    // $('#form-add').submit(function (e) {
    //     e.preventDefault();

    //     var money = $('.money').val()
    //     var telepon = $('.telepon').val()

    //     if (isNaN(money)) {
    //         Swal.fire('Daftar Pelanggan', 'Batas kredit harus dalam bentuk angka saja', 'warning');

    //     } else if (isNaN(telepon)) {
    //         Swal.fire('Daftar Pelanggan', 'Nomor handphone harus dalam bentuk angka saja', 'warning');

    //     } else if ($(this).parsley().isValid()) {
    //         Swal.fire({
    //             icon: "question",
    //             title: "Peringatan",
    //             text: "Apakah Anda yakin ingin menyimpan pelanggan?",
    //             showCancelButton: true,
    //             cancelButtonText: "Batal",
    //             confirmButtonText: "Simpan",
    //             confirmButtonColor: "#3ab50d",
    //             reverseButtons: true,
    //         }).then((result) => {
    //             if (result.value) {
    //                 $.ajax({
    //                     type: "post",
    //                     dataType: 'json',
    //                     url: $(this).attr('action'),
    //                     data: $(this).serialize(),
    //                     // contentType: false,
    //                     // processData: false,
    //                     beforeSend: function () {
    //                         showLoading();
    //                     },
    //                     success: function (response) {
    //                         hideLoading();
    //                         Swal.fire({
    //                             confirmButtonColor: "#3ab50d",
    //                             icon: "success",
    //                             title: `${response.message.title}`,
    //                             html: `${response.message.body}`,
    //                         }).then((result) => {
    //                             location.reload();
    //                         });
    //                     },
    //                     error: function (request, status, error) {
    //                         hideLoading();
    //                         Swal.fire({
    //                             confirmButtonColor: "#3ab50d",
    //                             icon: "error",
    //                             title: `${request.responseJSON.message.title}`,
    //                             html: `${request.responseJSON.message.body}`,
    //                         });
    //                     },
    //                 });
    //             }
    //         });
    //     }
    // });

    $('#form-add').submit(function (e) {
        e.preventDefault();

        var money = $('.money').val()
        var telepon = $('.telepon').val()

        if (isNaN(money)) {
            $('.money').css({
                'color': '#B94A48',
                'background': '#F2DEDE',
                'border': 'solid 1px #EED3D7'
            });
            Swal.fire('Daftar Pelanggan', 'Batas kredit harus dalam bentuk angka saja', 'warning');

        } else if (isNaN(telepon)) {
            $('.telepon').css({
                'color': '#B94A48',
                'background': '#F2DEDE',
                'border': 'solid 1px #EED3D7'
            });
            Swal.fire('Daftar Pelanggan', 'Nomor handphone harus dalam bentuk angka saja', 'warning');

        } else if (telepon.match(/^0[0-9]{9,13}$/)) {
            $(".money").val($(".money").val().replace(/,/g, ''));
            
            if ($(this).parsley().isValid()) {
                Swal.fire({
                    icon: "question",
                    title: "Peringatan",
                    text: "Apakah Anda yakin ingin menyimpan pelanggan?",
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
            Swal.fire({
                icon : 'warning',
                title : 'Daftar Pelanggan',
                text : 'Nomor telepon belum sesuai',
                footer : '<span class="text-danger">example: 08xxxxxx</span>'
            });
        }
    });
    
    $('#form-edit').submit(function (e) {
        e.preventDefault();

        var e_batas = $('.e_batas').val()
        var e_telepon = $('.e_telepon').val()

        if (isNaN(e_batas)) {
            $('.e_batas').css({
                'color': '#B94A48',
                'background': '#F2DEDE',
                'border': 'solid 1px #EED3D7'
            });
            Swal.fire('Daftar Pelanggan', 'Batas kredit harus dalam bentuk angka saja', 'warning');

        } else if (isNaN(e_telepon)) {
            $('.e_telepon').css({
                'color': '#B94A48',
                'background': '#F2DEDE',
                'border': 'solid 1px #EED3D7'
            });
            Swal.fire('Daftar Pelanggan', 'Nomor handphone harus dalam bentuk angka saja', 'warning');
        
        } else if (e_telepon.match(/^0[0-9]{9,13}$/)) {
            $(".e_batas").val($(".e_batas").val().replace(/,/g, ''));
            
            if ($(this).parsley().isValid()) {
                Swal.fire({
                    icon: "question",
                    title: "Peringatan",
                    text: "Apakah Anda yakin ingin menyimpan perubahan pelanggan?",
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
            Swal.fire({
                icon : 'warning',
                title : 'Daftar Pelanggan',
                text : 'Nomor telepon belum sesuai',
                footer : '<span class="text-danger">example: 08xxxxxx</span>'
            });
        }
    });
});

$("body").on('input', '#namaPelanggan', function () {
    $(this).val($(this).val().replace(/^\s+/g, ''));
});

$("body").on('input', '#barcode', function () {
    $(this).val($(this).val().replace(/^\s+/g, ''));
});

$("body").on('input', '#batas', function () {
    $(this).val($(this).val().replace(/^\s+/g, ''));
});

$("body").on('input', '#alamat', function () {
    $(this).val($(this).val().replace(/^\s+/g, ''));
});

$("body").on('input', '#telepon', function () {
    $(this).val($(this).val().replace(/^\s+/g, ''));
});

$("body").on('input', '#email', function () {
    $(this).val($(this).val().replace(/^\s+/g, ''));
});

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