
$(".btnG").click(function () {
    $(".btnSG").removeClass('btn-success');
    $(".btnSG").removeClass('text-light');
    $(".btnD").removeClass('btn-success');
    $(".btnD").removeClass('text-light');
    $(".btnSG").removeClass('activeA');
    $(".btnD").removeClass('activeA');
    $(this).addClass('activeA');
    $(this).addClass('btn-success text-light');
    $(".selG").hide();
    $(".selSG").hide();
    $(".grup").val('');
});

$(".btnSG").click(function () {
    $(".btnG").removeClass('btn-success');
    $(".btnG").removeClass('text-light');
    $(".btnD").removeClass('btn-success');
    $(".btnD").removeClass('text-light');
    $(".btnG").removeClass('activeA');
    $(".btnD").removeClass('activeA');
    $(this).addClass('activeA');
    $(this).addClass('btn-success text-light');
    $(".selG").hide();
    $(".selSG").hide();
    $(".selG").toggle();
    var text = $(".grup").children("option:selected").val();
    $(".temp_grup").val(text);
    $(".subgrup").val('');
});

$(".btnD").click(function () {
    $(".btnG").removeClass('btn-success');
    $(".btnG").removeClass('text-light');
    $(".btnSG").removeClass('btn-success');
    $(".btnSG").removeClass('text-light');
    $(".btnSG").removeClass('activeA');
    $(".btnG").removeClass('activeA');
    $(this).addClass('activeA');
    $(this).addClass('btn-success text-light');
    $(".selG").hide();
    $(".selSG").hide();
    $(".selSG").toggle();
    $(".selG").toggle();
});


$(".btnTMBH").click(function () {
    $(".btn01").addClass('btn-success');
    $(".btn01").addClass('text-light');
    $(".btn02").removeClass('btn-success');
    $(".btn02").removeClass('text-light');
    $(".btn03").removeClass('btn-success');
    $(".btn03").removeClass('text-light');
    $(".btn04").removeClass('btn-success');
    $(".btn04").removeClass('text-light');
    $(".btn05").removeClass('btn-success');
    $(".btn05").removeClass('text-light');
    $(".btn06").removeClass('btn-success');
    $(".btn06").removeClass('text-light');
    $(".btn07").removeClass('text-light');
    $(".btn07").removeClass('btn-success');
    $(".btn08").removeClass('btn-success');
    $(".btn08").removeClass('text-light');
    $(".btn02").removeClass('activeA');
    $(".btn03").removeClass('activeA');
    $(".btn04").removeClass('activeA');
    $(".btn05").removeClass('activeA');
    $(".btn06").removeClass('activeA');
    $(".btn07").removeClass('activeA');
    $(".btn08").removeClass('activeA');
    $(".btnG").addClass('btn-success');
    $(".btnG").addClass('text-light');
    $(".btnSG").removeClass('btn-success');
    $(".btnSG").removeClass('text-light');
    $(".btnD").removeClass('btn-success');
    $(".btnD").removeClass('text-light');
    $(".btnSG").removeClass('activeA');
    $(".btnD").removeClass('activeA');
    $(".selG").hide();
    $(".selSG").hide();
    $(".grup").val('');
});

$(".btnED").click(function () {
    $(".btnD").addClass('btn-success');
    $(".btnD").addClass('text-light');
    $(".btnG").removeClass('btn-success');
    $(".btnG").removeClass('text-light');
    $(".btnSG").removeClass('btn-success');
    $(".btnSG").removeClass('text-light');
    $(".btnSG").removeClass('activeA');
    $(".btnG").removeClass('activeA');
});

$(".grup").change(function () {
    var text = $(this).children("option:selected").val();
    $(".temp_grup").val(text);
});

$(".subgrup").change(function () {
    var text = $(this).children("option:selected").val();
    $(".temp_subgrup").val(text);
});

var sumbtn;
$(function () {
    sumbtn = ($('.bt-sg').length) + 1;
})
for (let index = 1; index < sumbtn; index++) {
    $(".btn" + index).click(function () {
        $(".btn02").removeClass('btn-success');
        $(".btn02").removeClass('text-light');
        $(".btn03").removeClass('activeA');
        $(".btn04").removeClass('activeA');
        $(".btn05").removeClass('activeA');
        $(".btn06").removeClass('activeA');
        $(".btn07").removeClass('activeA');
        $(".btn08").removeClass('activeA');
        $(this).addClass('btn-success text-light');
        var text = $(this).data('value');
        $("#kode_coa").val(text);
        $("#kode_grup").val("AKTIVA");
        $('.sub_AKTIVA').show()
        $('.sub_HUTANG').hide()
        $('.sub_MODAL').hide()
        $('.sub_PENDAPATAN').hide()
        $('.sub_HPP').hide()
        $('.sub_BIAYA').hide()
        $('.sub_PENDAPATAN_LAIN').hide()
        $('.sub_BIAYA_LAIN').hide()
    });
}

$("#btnList").click(function () {
    $("#viewList").show();
    $("#viewTable").hide();
    $("#btnTable").removeClass('activeB');
    $(this).addClass('activeB');
});
$("#btnTable").click(function () {
    $("#viewList").hide();
    $("#viewTable").show();
    $("#btnList").removeClass('activeB');
    $(this).addClass('activeB');
});
$(".btn01").click(function () {
    $(".btn02").removeClass('btn-success');
    $(".btn02").removeClass('text-light');
    $(".btn03").removeClass('btn-success');
    $(".btn03").removeClass('text-light');
    $(".btn04").removeClass('btn-success');
    $(".btn04").removeClass('text-light');
    $(".btn05").removeClass('btn-success');
    $(".btn05").removeClass('text-light');
    $(".btn06").removeClass('btn-success');
    $(".btn06").removeClass('text-light');
    $(".btn07").removeClass('text-light');
    $(".btn07").removeClass('btn-success');
    $(".btn08").removeClass('btn-success');
    $(".btn08").removeClass('text-light');
    $(".btn02").removeClass('activeA');
    $(".btn03").removeClass('activeA');
    $(".btn04").removeClass('activeA');
    $(".btn05").removeClass('activeA');
    $(".btn06").removeClass('activeA');
    $(".btn07").removeClass('activeA');
    $(".btn08").removeClass('activeA');
    $(".btnG").addClass('btn-success');
    $(".btnG").addClass('text-light');
    $(".btnSG").removeClass('btn-success');
    $(".btnSG").removeClass('text-light');
    $(".btnD").removeClass('btn-success');
    $(".btnD").removeClass('text-light');
    $(this).addClass('btn-success text-light');
    var text = $(this).data('value');
    $("#kode_coa").val(text);
    $("#kode_grup").val("AKTIVA");
    $('.sub_AKTIVA').show()
    $('.sub_HUTANG').hide()
    $('.sub_MODAL').hide()
    $('.sub_PENDAPATAN').hide()
    $('.sub_HPP').hide()
    $('.sub_BIAYA').hide()
    $('.sub_PENDAPATAN_LAIN').hide()
    $('.sub_BIAYA_LAIN').hide()
});
$(".btn02").click(function () {
    $(".btn01").removeClass('btn-success');
    $(".btn01").removeClass('text-light');
    $(".btn03").removeClass('btn-success');
    $(".btn03").removeClass('text-light');
    $(".btn04").removeClass('btn-success');
    $(".btn04").removeClass('text-light');
    $(".btn05").removeClass('btn-success');
    $(".btn05").removeClass('text-light');
    $(".btn06").removeClass('btn-success');
    $(".btn06").removeClass('text-light');
    $(".btn07").removeClass('text-light');
    $(".btn07").removeClass('btn-success');
    $(".btn08").removeClass('btn-success');
    $(".btn08").removeClass('text-light');
    $(".btn03").removeClass('activeA');
    $(".btn04").removeClass('activeA');
    $(".btn05").removeClass('activeA');
    $(".btn06").removeClass('activeA');
    $(".btn07").removeClass('activeA');
    $(".btn08").removeClass('activeA');
    $(".btnG").addClass('btn-success');
    $(".btnG").addClass('text-light');
    $(".btnSG").removeClass('btn-success');
    $(".btnSG").removeClass('text-light');
    $(".btnD").removeClass('btn-success');
    $(".btnD").removeClass('text-light');
    $(this).addClass('btn-success text-light');
    var text = $(this).data('value');
    $("#kode_coa").val(text);
    $("#kode_grup").val("HUTANG");
    $('.sub_AKTIVA').hide()
    $('.sub_HUTANG').show()
    $('.sub_MODAL').hide()
    $('.sub_PENDAPATAN').hide()
    $('.sub_HPP').hide()
    $('.sub_BIAYA').hide()
    $('.sub_PENDAPATAN_LAIN').hide()
    $('.sub_BIAYA_LAIN').hide()
});
$(".btn03").click(function () {
    $(".btn01").removeClass('btn-success');
    $(".btn01").removeClass('text-light');
    $(".btn02").removeClass('btn-success');
    $(".btn02").removeClass('text-light');
    $(".btn04").removeClass('btn-success');
    $(".btn04").removeClass('text-light');
    $(".btn05").removeClass('btn-success');
    $(".btn05").removeClass('text-light');
    $(".btn06").removeClass('btn-success');
    $(".btn06").removeClass('text-light');
    $(".btn07").removeClass('text-light');
    $(".btn07").removeClass('btn-success');
    $(".btn08").removeClass('btn-success');
    $(".btn08").removeClass('text-light');
    $(".btn01").removeClass('activeA');
    $(".btn02").removeClass('activeA');
    $(".btn04").removeClass('activeA');
    $(".btn05").removeClass('activeA');
    $(".btn06").removeClass('activeA');
    $(".btn07").removeClass('activeA');
    $(".btn08").removeClass('activeA');
    $(".btnG").addClass('btn-success');
    $(".btnG").addClass('text-light');
    $(".btnSG").removeClass('btn-success');
    $(".btnSG").removeClass('text-light');
    $(".btnD").removeClass('btn-success');
    $(".btnD").removeClass('text-light');
    $(this).addClass('btn-success text-light');
    var text = $(this).data('value');
    $("#kode_coa").val(text);
    $("#kode_grup").val("MODAL");
    $('.sub_AKTIVA').hide()
    $('.sub_HUTANG').hide()
    $('.sub_MODAL').show()
    $('.sub_PENDAPATAN').hide()
    $('.sub_HPP').hide()
    $('.sub_BIAYA').hide()
    $('.sub_PENDAPATAN_LAIN').hide()
    $('.sub_BIAYA_LAIN').hide()
});
$(".btn04").click(function () {
    $(".btn01").removeClass('btn-success');
    $(".btn01").removeClass('text-light');
    $(".btn02").removeClass('btn-success');
    $(".btn02").removeClass('text-light');
    $(".btn03").removeClass('btn-success');
    $(".btn03").removeClass('text-light');
    $(".btn05").removeClass('btn-success');
    $(".btn05").removeClass('text-light');
    $(".btn06").removeClass('btn-success');
    $(".btn06").removeClass('text-light');
    $(".btn07").removeClass('text-light');
    $(".btn07").removeClass('btn-success');
    $(".btn08").removeClass('btn-success');
    $(".btn08").removeClass('text-light');
    $(".btn01").removeClass('activeA');
    $(".btn02").removeClass('activeA');
    $(".btn03").removeClass('activeA');
    $(".btn05").removeClass('activeA');
    $(".btn06").removeClass('activeA');
    $(".btn07").removeClass('activeA');
    $(".btn08").removeClass('activeA');
    $(".btnG").addClass('btn-success');
    $(".btnG").addClass('text-light');
    $(".btnSG").removeClass('btn-success');
    $(".btnSG").removeClass('text-light');
    $(".btnD").removeClass('btn-success');
    $(".btnD").removeClass('text-light');
    $(this).addClass('btn-success text-light');
    var text = $(this).data('value');
    $("#kode_coa").val(text);
    $("#kode_grup").val("PENDAPATAN");
    $('.sub_AKTIVA').hide()
    $('.sub_HUTANG').hide()
    $('.sub_MODAL').hide()
    $('.sub_PENDAPATAN').show()
    $('.sub_HPP').hide()
    $('.sub_BIAYA').hide()
    $('.sub_PENDAPATAN_LAIN').hide()
    $('.sub_BIAYA_LAIN').hide()
});
$(".btn05").click(function () {
    $(".btn01").removeClass('btn-success');
    $(".btn01").removeClass('text-light');
    $(".btn02").removeClass('btn-success');
    $(".btn02").removeClass('text-light');
    $(".btn03").removeClass('btn-success');
    $(".btn03").removeClass('text-light');
    $(".btn04").removeClass('btn-success');
    $(".btn04").removeClass('text-light');
    $(".btn06").removeClass('btn-success');
    $(".btn06").removeClass('text-light');
    $(".btn07").removeClass('btn-success');
    $(".btn07").removeClass('text-light');
    $(".btn08").removeClass('btn-success');
    $(".btn08").removeClass('text-light');
    $(".btn01").removeClass('activeA');
    $(".btn02").removeClass('activeA');
    $(".btn03").removeClass('activeA');
    $(".btn04").removeClass('activeA');
    $(".btn06").removeClass('activeA');
    $(".btn07").removeClass('activeA');
    $(".btn08").removeClass('activeA');
    $(".btnG").addClass('btn-success');
    $(".btnG").addClass('text-light');
    $(".btnSG").removeClass('btn-success');
    $(".btnSG").removeClass('text-light');
    $(".btnD").removeClass('btn-success');
    $(".btnD").removeClass('text-light');
    $(this).addClass('btn-success text-light');
    var text = $(this).data('value');
    $("#kode_coa").val(text);
    $("#kode_grup").val("HPP");
    $('.sub_AKTIVA').hide()
    $('.sub_HUTANG').hide()
    $('.sub_MODAL').hide()
    $('.sub_PENDAPATAN').hide()
    $('.sub_HPP').show()
    $('.sub_BIAYA').hide()
    $('.sub_PENDAPATAN_LAIN').hide()
    $('.sub_BIAYA_LAIN').hide()
});
$(".btn06").click(function () {
    $(".btn01").removeClass('btn-success');
    $(".btn01").removeClass('text-light');
    $(".btn02").removeClass('btn-success');
    $(".btn02").removeClass('text-light');
    $(".btn03").removeClass('btn-success');
    $(".btn03").removeClass('text-light');
    $(".btn04").removeClass('btn-success');
    $(".btn04").removeClass('text-light');
    $(".btn05").removeClass('btn-success');
    $(".btn05").removeClass('text-light');
    $(".btn07").removeClass('text-light');
    $(".btn07").removeClass('btn-success');
    $(".btn08").removeClass('btn-success');
    $(".btn08").removeClass('text-light');
    $(".btn01").removeClass('activeA');
    $(".btn02").removeClass('activeA');
    $(".btn03").removeClass('activeA');
    $(".btn04").removeClass('activeA');
    $(".btn05").removeClass('activeA');
    $(".btn07").removeClass('activeA');
    $(".btn08").removeClass('activeA');
    $(".btnG").addClass('btn-success');
    $(".btnG").addClass('text-light');
    $(".btnSG").removeClass('btn-success');
    $(".btnSG").removeClass('text-light');
    $(".btnD").removeClass('btn-success');
    $(".btnD").removeClass('text-light');
    $(this).addClass('btn-success text-light');
    var text = $(this).data('value');
    $("#kode_coa").val(text);
    $("#kode_grup").val("BIAYA");
    $('.sub_AKTIVA').hide()
    $('.sub_HUTANG').hide()
    $('.sub_MODAL').hide()
    $('.sub_PENDAPATAN').hide()
    $('.sub_HPP').hide()
    $('.sub_BIAYA').show()
    $('.sub_PENDAPATAN_LAIN').hide()
    $('.sub_BIAYA_LAIN').hide()
});
$(".btn07").click(function () {
    $(".btn01").removeClass('btn-success');
    $(".btn01").removeClass('text-light');
    $(".btn02").removeClass('btn-success');
    $(".btn02").removeClass('text-light');
    $(".btn03").removeClass('btn-success');
    $(".btn03").removeClass('text-light');
    $(".btn04").removeClass('btn-success');
    $(".btn04").removeClass('text-light');
    $(".btn05").removeClass('btn-success');
    $(".btn05").removeClass('text-light');
    $(".btn06").removeClass('text-light');
    $(".btn06").removeClass('btn-success');
    $(".btn08").removeClass('btn-success');
    $(".btn08").removeClass('text-light');
    $(".btn01").removeClass('activeA');
    $(".btn02").removeClass('activeA');
    $(".btn03").removeClass('activeA');
    $(".btn04").removeClass('activeA');
    $(".btn05").removeClass('activeA');
    $(".btn06").removeClass('activeA');
    $(".btn08").removeClass('activeA');
    $(".btnG").addClass('btn-success');
    $(".btnG").addClass('text-light');
    $(".btnSG").removeClass('btn-success');
    $(".btnSG").removeClass('text-light');
    $(".btnD").removeClass('btn-success');
    $(".btnD").removeClass('text-light');
    $(this).addClass('btn-success text-light');
    var text = $(this).data('value');
    $("#kode_coa").val(text);
    $("#kode_grup").val("PENDAPATAN LAIN");
    $('.sub_AKTIVA').hide()
    $('.sub_HUTANG').hide()
    $('.sub_MODAL').hide()
    $('.sub_PENDAPATAN').hide()
    $('.sub_HPP').hide()
    $('.sub_BIAYA').hide()
    $('.sub_PENDAPATAN_LAIN').show()
    $('.sub_BIAYA_LAIN').hide()
});
$(".btn08").click(function () {
    $(".btn01").removeClass('btn-success');
    $(".btn01").removeClass('text-light');
    $(".btn02").removeClass('btn-success');
    $(".btn02").removeClass('text-light');
    $(".btn03").removeClass('btn-success');
    $(".btn03").removeClass('text-light');
    $(".btn04").removeClass('btn-success');
    $(".btn04").removeClass('text-light');
    $(".btn05").removeClass('btn-success');
    $(".btn05").removeClass('text-light');
    $(".btn06").removeClass('text-light');
    $(".btn06").removeClass('btn-success');
    $(".btn07").removeClass('btn-success');
    $(".btn07").removeClass('text-light');
    $(".btn01").removeClass('activeA');
    $(".btn02").removeClass('activeA');
    $(".btn03").removeClass('activeA');
    $(".btn04").removeClass('activeA');
    $(".btn05").removeClass('activeA');
    $(".btn06").removeClass('activeA');
    $(".btn07").removeClass('activeA');
    $(".btnG").addClass('btn-success');
    $(".btnG").addClass('text-light');
    $(".btnSG").removeClass('btn-success');
    $(".btnSG").removeClass('text-light');
    $(".btnD").removeClass('btn-success');
    $(".btnD").removeClass('text-light');
    $(this).addClass('btn-success text-light');
    var text = $(this).data('value');
    $("#kode_coa").val(text);
    $("#kode_grup").val("BIAYA LAIN");
    $('.sub_AKTIVA').hide()
    $('.sub_HUTANG').hide()
    $('.sub_MODAL').hide()
    $('.sub_PENDAPATAN').hide()
    $('.sub_HPP').hide()
    $('.sub_BIAYA').hide()
    $('.sub_PENDAPATAN_LAIN').hide()
    $('.sub_BIAYA_LAIN').show()
});

$('.bt-sg').click(function () {
    $(".btnSG").removeClass('activeA');
    $(".btnD").removeClass('activeA');
    $(".btnG").addClass('activeA');
    $(".temp_grup").val("");
    $(".temp_subgrup").val("");
    $(".selG").hide();
    $(".selSG").hide();
    $(".grup").val('');
});

for (let a = 0; a < $(".sum_coa").val(); a++) {
    $(".edit" + a).click(function () {
        $(".e_akun").val($('.akun' + a).val());
        $(".e_nama").val($('.nama' + a).val());
        $(".e_grup").val($('.grup' + a).val());
        $(".e_subgrup").val($('.subgrup' + a).val());
        $(".e_detail").val($('.detail' + a).val());
        $("#modal-edit .btnSG").removeClass('activeA');
        $("#modal-edit .btnD").removeClass('activeA');
        $("#modal-edit .btnG").addClass('activeA');
        $("#modal-edit .selG").hide();
        $("#modal-edit .selSG").hide();
        $("#modal-edit .selG").hide();
        $('.sub_AKTIVA').hide()
        $('.sub_HUTANG').hide()
        $('.sub_MODAL').hide()
        $('.sub_PENDAPATAN').hide()
        $('.sub_HPP').hide()
        $('.sub_BIAYA').hide()
        $('.sub_PENDAPATAN_LAIN').hide()
        $('.sub_BIAYA_LAIN').hide()

        if ($('.subgrup' + a).val()) {
            $("#modal-edit .btnG").removeClass('activeA');
            $("#modal-edit .btnD").removeClass('activeA');
            $("#modal-edit .btnSG").addClass('activeA');
            $("#modal-edit .selG").hide();
            $("#modal-edit .selSG").hide();
            $("#modal-edit .selG").toggle();
            $('.sub_' + $('.grup' + a).val()).show();
            $('#modal-edit .grup option').each(function () {
                if ($(this).val() == $('.subgrup' + a).val()) {
                    $(this).attr('selected', true);
                }
            });
        };
        if ($('.detail' + a).val()) {
            $("#modal-edit .btnG").removeClass('activeA');
            $("#modal-edit .btnSG").removeClass('activeA');
            $("#modal-edit .btnD").addClass('activeA');
            $("#modal-edit .selG").hide();
            $("#modal-edit .selSG").hide();
            $("#modal-edit .selSG").toggle();
            $("#modal-edit .selG").toggle();
            $('.sub_' + $('.grup' + a).val()).show();
            $('#modal-edit .subgrup option').each(function () {
                if ($(this).val() == $('.detail' + a).val()) {
                    $(this).attr('selected', true);
                }
            });
        };
        $(".e_detail").val();
        $(".e_link").val($('.link' + a).val());
    });
}

var toggler = document.getElementsByClassName("caret");
var i;

for (i = 0; i < toggler.length; i++) {
    toggler[i].addEventListener("click", function () {
        this.parentElement.querySelector(".nested").classList.toggle("activeB");
        this.classList.toggle("caret-down");
    });
}

$(document).ready(function () {
    $('.sub_AKTIVA').show()
    $('.sub_HUTANG').hide()
    $('.sub_MODAL').hide()
    $('.sub_PENDAPATAN').hide()
    $('.sub_HPP').hide()
    $('.sub_BIAYA').hide()
    $('.sub_PENDAPATAN_LAIN').hide()
    $('.sub_BIAYA_LAIN').hide()
});

// $('.delete-btn').on('click', function() {
//     if (confirm('Apakah anda ingin menghapus perkiraan ini?')) {
//         location.href = "<?= site_url('Coa/hapus/') ?>" + $(this).data('id');
//     }
// });

$('.delete-btn').on('click', function () {
    Swal.fire({
        icon: "warning",
        title: "Daftar Perkiraan",
        text: "Apakah anda ingin menghapus perkiraan ini?",
        showCancelButton: true,
        cancelButtonText: "Tidak",
        confirmButtonText: "Hapus",
        reverseButtons: true,
    }).then((result) => {
        if (result.value) {
            location.href = "<?= site_url('Coa/hapus/') ?>" + $(this).data('id');
        }
    });
});

// $("#addNakun").keydown(function () {
//     var namaCoa = [];
//     console.log(namaCoa);
//     for (let c = 0; c < $('.sum_coa').val(); c++) {
//         namaCoa.push($("#no_akun" + c).val());
//     }
//     console.log(namaCoa);
//     if ($.inArray($('#kode_coa').val() + $(this).val(), namaCoa) != 1) {
//         alert("Nomor akun ini sudah terpakai")
//         $(this).focus();
//     }
// });

$(function () {
    $('#form-tambah').submit(function (e) {
        e.preventDefault();

        var namaCoa = [];
        var num = /^[0-9]+$/;

        for (let c = 0; c < $('.sum_coa').val(); c++) {
            namaCoa.push($("#no_akun" + c).val());
        }

        let coa = $('#addNakun').val();

        if ($.inArray($('#kode_coa').val() + coa, namaCoa) != -1) {
            Swal.fire('Daftar Perkiraan', 'Nomor Akun sudah terpakai', 'warning');

        } else if (addNakun.value === "" && namaAkun.value === "" && link.value === "" && detail.value === "") {
            Swal.fire('Daftar Perkiraan', "Data masih kosong silahkan cek kembali", 'warning');

        } else if (!addNakun.value.match(num)) {
            Swal.fire('Daftar Perkiraan', 'Nomor akun harus dalam bentuk angka saja', 'warning');

        } else {
            $.ajax({
                type: "POST",
                url: "<?= site_url('Coa/dosave') ?>",
                data: $(this).serialize(),
                success: function (data) {
                    // console.log(mashookk);
                    $(this).submit();
                },
                // data: $("#form-tambah").serialize(),
                // data: {
                //     grup: grup,
                // },    
                // dataType: "dataType",
                // success: function (response) {
                // console.log(response);
                // }
            });
            location.href = "<?= site_url('Coa') ?>";
        }
    });
});

// Tambah
$(document).ready(function () {
    $('.btnTMBH').click(function (e) {
        e.preventDefault();
        var grup = "AKTIVA";

        $.ajax({
            method: "POST",
            url: "<?= site_url('Coa/getSubGrup') ?>",
            data: {
                grup: grup,
            },

            dataType: "json",
            success: function (response) {
                $('#container-subgrup').html(response);
            }
        });
    });
    $('.perkiraan').click(function (e) {
        e.preventDefault();
        var grup = $(this).data('grup')

        $.ajax({
            method: "POST",
            url: "<?= site_url('Coa/getSubGrup') ?>",
            data: {
                grup: grup,
            },

            dataType: "json",
            success: function (response) {
                $('#container-subgrup').html(response);
            }
        });
    });
});

//  Edit
$(document).ready(function () {
    $('.perkiraan').click(function (e) {
        e.preventDefault();
        var grup = $(this).data('grup')

        $.ajax({
            method: "POST",
            url: "<?= site_url('Coa/getSubGrup') ?>",
            data: {
                grup: grup,
            },

            dataType: "json",
            success: function (response) {
                $('#container-subgrup-edit').html(response);
            }
        });
    });
});

$("body").on('input', '#addNakun', function () {
    $(this).val($(this).val().replace(/^\s+/g, ''));
});

$("body").on('input', '#namaAkun', function () {
    $(this).val($(this).val().replace(/^\s+/g, ''));
});

$("body").on('input', '#link', function () {
    $(this).val($(this).val().replace(/^\s+/g, ''));
});

$("body").on('input', '#detail', function () {
    $(this).val($(this).val().replace(/^\s+/g, ''));
});