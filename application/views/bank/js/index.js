$(document).ready(function() {
    $('#zero_config').DataTable({
        "search": true,
        "responsive": true,
        "paging": true,
        "lengthChange": true,
        "pageLength": 25,
        "processing": true
    });

    $("body").on('input', '#nama', function() {
        $(this).val($(this).val().replace(/^\s+/g, ''));
    });
    $("body").on('input', '#pemilik', function() {
        $(this).val($(this).val().replace(/^\s+/g, ''));
    });
    $("body").on('input', '#alamat', function() {
        $(this).val($(this).val().replace(/^\s+/g, ''));
    });

    $("body").on('input', '#e_nama', function() {
        $(this).val($(this).val().replace(/^\s+/g, ''));
    });
    $("body").on('input', '#e_pemilik', function() {
        $(this).val($(this).val().replace(/^\s+/g, ''));
    });
    $("body").on('input', '#e_alamat', function() {
        $(this).val($(this).val().replace(/^\s+/g, ''));
    });
    $("body").on('input', '#e_telepon', function() {
        $(this).val($(this).val().replace(/^\s+/g, ''));
    });

    $('#modal-add').on('hidden.bs.modal', function() {
        $(this).find('#add_bank')[0].reset();
        $('#add_bank').parsley().reset();
    }); //untuk reset modal


    // jQuery.validator.setDefaults({
    //     debug: true,
    //     success: "valid"
    // });
    // $("#edit_bank").validate({
    //     rules: {
    //         e_norek: {
    //             required: true,
    //             min: 3
    //         },
    //         telepon: {
    //             required: function(element) {
    //                 return $("#e_norek").val() < 13;
    //             }
    //         }
    //     }
    // });

    for (let a = 0; a < $(".sum_bank").val(); a++) {
        $(".edit" + a).click(function() {
            $(".e_n_bank").val($('.n_bank' + a).val());
            $(".e_nama").val($('.nama' + a).val());
            $(".e_akun").val($('.akun' + a).val());
            $(".e_Nakun").val($('.n_akun' + a).val());
            $(".e_pemilik").val($('.pemilik' + a).val());
            $(".e_norek").val($('.norek' + a).val());
            $(".e_alamat").val($('.alamat' + a).val());
            $(".e_telepon").val($('.telepon' + a).val());
        });
    }

    for (let s = 0; s < $(".sum_akun").val(); s++) {
        $(".chs_akun" + s).click(function() {
            $(".d_akun").val($('.no_akun' + s).val());
            $(".d_namaakun").val($('.no_namaakun' + s).val());
        });
    }
});

function hapus(n_bank) {
    Swal.fire({
        icon: "warning",
        title: "Bank",
        text: "Apakah Anda yakin ingin menghapus data bank?",
        showCancelButton: true,
        cancelButtonText: "Batal",
        confirmButtonText: "Hapus",
        reverseButtons: true,
    }).then((result) => {
        if (result.value) {
            location.href = site_url + "/bank/hapus/" + n_bank;
        }
    });
}

// jQuery.validator.addMethod("alphanumeric", function(value, element) {
//     return this.optional(element) || /^[\w- _(),./]+$/i.test(value);
// }, "Inputan yang anda masukan salah, silahkan cek kembali");
// jQuery.validator.addMethod("alphanumeric1", function(value, element) {
//     return this.optional(element) || /^[\w-_(),./]+$/i.test(value);
// }, "Inputan yang anda masukan salah, silahkan cek kembali");

// $('#add_bank').validate({
//     rules: {
//         n_bank: {
//             required: true,
//             alphanumeric1: true,
//         },
//         nama: {
//             required: true,
//             alphanumeric: true,
//         },
//         pemilik: {
//             required: true,
//             alphanumeric: true,
//         },
//         alamat: {
//             required: true,
//             alphanumeric: true,
//         },
//     }
// });
// $('#edit_bank').validate({
//     rules: {
//         n_bank: {
//             required: true,
//             alphanumeric1: true,
//         },
//         nama: {
//             required: true,
//             alphanumeric: true,
//         },
//         pemilik: {
//             required: true,
//             alphanumeric: true,
//         },
//         alamat: {
//             required: true,
//             alphanumeric: true,
//         },
//     }
// });