function hapusgrup(n_grup) {
    Swal.fire({
        icon: "warning",
        title: "Grup Barang",
        text: "Apakah Anda yakin ingin menghapus data?",
        showCancelButton: true,
        cancelButtonText: "Batal",
        confirmButtonText: "Hapus",
        reverseButtons: true,
    }).then((result) => {
        if (result.value) {
            location.href = site_url + '/barang/grupbarang_hapus/' + n_grup;
        }
    });
}

$(document).ready(function() {
    for (let a = 0; a < $(".sum_grup").val(); a++) {
        $(".edit" + a).click(function() {
            $(".e_n_grup").val($('.n_grup' + a).val());
            $(".e_grup").val($('.grup' + a).val());
            console.log($('.n_grup' + a).val());
        });
    }

    $('#modal-add').on('hidden.bs.modal', function() {
        $(this).find('#add_grup')[0].reset();
        $('#add_grup').parsley().reset();
    });

    $('#modal-add-depart').on('hidden.bs.modal', function() {
        $(this).find('#add_depart')[0].reset();
        $('#add_depart').parsley().reset();
    });

    $('#modal-edit').on('hidden.bs.modal', function() {
        $(this).find('#edit_grup')[0].reset();
        $('#edit_grup').parsley().reset();
    });
    $('#modal-edit-depart').on('hidden.bs.modal', function() {
        $(this).find('#edit_depart')[0].reset();
        $('#edit_depart').parsley().reset();
    });
    for (let a = 0; a < $(".sum_depart").val(); a++) {
        $(".editdepart" + a).click(function() {
            var n_grup = $('.n_grup2' + a).val();
            console.log(n_grup);
            $.getJSON("<?= site_url('Barang/getDetailDepart?n_grup=') ?>" + n_grup, function(json) {
                console.log(json);
                $(".e_n_grup").val(json.n_grup);
                $(".e_grup").val(json.grup);
                $(".e_departement").val(json.departement);
                $(".e_kode").val(json.kode);
                $(".e_margin_departement").val(json.margin_departement);
                $(".e_akun_persediaan").val(json.akun_persediaan);
                $(".e_akun_hpp").val(json.akun_hpp);
                $(".e_akun_pendapatan").val(json.akun_pendapatan);
                $(".e_namaakun_hpp").val(json.namaakun_hpp);
                $(".e_namaakun_pendapatan").val(json.namaakun_pendapatan);
                $(".e_namaakun_persediaan").val(json.namaakun_persediaan);
                $(".e_namagrup").val("cooming soon");

            });
        });
    }

    $(".kode").change(function() {
        var id = $(this).val();
        $("#grup").val(id);
        //tampil ajax barang
        $.getJSON("<?= site_url('Barang/grupbarang_KodeLast?grup=') ?>" + id, function(json) {
            console.log(json);
            var nomorLast = parseInt(json.KodeLast);

            function pad(str, max) {
                str = str.toString();
                return str.length < max ? pad("0" + str, max) : str;
            }
            var nomorBaru = pad(nomorLast + 1, 3);
            $("#autonumber").val(id + "." + nomorBaru);
        });
    });

    // $('#form-add-depart').submit(function (e) {
    //     e.preventDefault();
    //     if ($(this).parsley().isValid()) {
    //         Swal.fire({
    //             icon: "question",
    //             title: "Peringatan",
    //             text: "Apakah Anda yakin ingin menyimpan departement?",
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
    // })
});

$('.zero_config').dataTable({
    "paging": false,
    "info": false,
    "scrollX": false,
    "searching": false,
    "scrollCollapse": true,
});
$('.lookup').DataTable({
    "paging": false,
    "search": true,
    "responsive": true,
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
jQuery.validator.addMethod("alphanumeric", function(value, element) {
    return this.optional(element) || /^[\w- _(),./]+$/i.test(value);
}, "Inputan yang anda masukan salah, silahkan cek kembali");
jQuery.validator.addMethod("alphanumeric1", function(value, element) {
    return this.optional(element) || /^[\w-_(),./]+$/i.test(value);
}, "Inputan yang anda masukan salah, silahkan cek kembali");

// $('#add_grup').validate({
//     rules: {
//         n_grup: {
//             required: true,
//             alphanumeric: true,
//         },
//         grup: {
//             required: true,
//             alphanumeric: true,
//         },
//     }
// });


$(function() {
        $('#add_Nbarang').submit(function(e) {
            e.preventDefault();
            if ($(this).parsley().isValid()) {
                console.log('oke');
            }
        })


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
    // $('#add_depart').validate({
    //     rules: {
    //         departement: {
    //             required: true,
    //             alphanumeric: true,
    //         },
    //         kode: {
    //             required: true,
    //             alphanumeric1: true,
    //         },
    //     }
    // });
    // $('#edit_depart').validate({
    //     rules: {
    //         departement: {
    //             required: true,
    //             alphanumeric: true,
    //         },
    //         kode: {
    //             required: true,
    //             alphanumeric1: true,
    //         },
    //     }
    // });

// $(function() {
//     $('#add_grup').submit(function(e) {
//         e.preventDefault();
//         let no = $('#n_grup').val
//             //if
//         if ($(this).parsley().isValid()) {
//             if ('#n_grup' != null) {
//                 console.log('masuk');
//             }
//         }
//     })

//     $('#modal-add').on('hidden.bs.modal', function() {
//         $(this).find('#add_grup')[0].reset();
//         $('#add_grup').parsley().reset();
//     });


// })