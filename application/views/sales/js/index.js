$(document).ready(function () {
    $('#zero_config').DataTable({
        pageLength: 25,
    });
    for (let a = 0; a < $(".sum_sales").val(); a++) {
        $(".edit" + a).click(function () {
            $(".e_n_sales").val($('.n_sales' + a).val());
            $(".e_nama").val($('.nama' + a).val());
            $(".e_alamat").val($('.alamat' + a).val());
            $(".e_telepon").val($('.telepon' + a).val());
        });
    }

    $('#form-add').submit(function (e) {
        e.preventDefault();
        var cek_no_hp = $('#telepon').val();
        if(cek_no_hp.match(/^0[0-9]{9,13}$/)){
            if ($(this).parsley().isValid()) {
                Swal.fire({
                    icon: "question",
                    title: "Peringatan",
                    text: "Apakah Anda yakin ingin menyimpan sales?",
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
        }else{
            Swal.fire({
                icon : 'error',
                title : 'Nomor Handphone',
                text : 'Format nomor handphone tidak sesuai!',
                footer : '<span class="text-danger">example: 08xxxxxx</span>'
            });
        }
    })

    $('#form-edit').submit(function (e) {
        e.preventDefault();
        var cek_hp_edit = $('#e_telepon').val();
        if(cek_hp_edit.match(/^0[0-9]{9,13}$/)){
            if ($(this).parsley().isValid()) {
                Swal.fire({
                    icon: "question",
                    title: "Peringatan",
                    text: "Apakah Anda yakin ingin mengubah sales?",
                    showCancelButton: true,
                    cancelButtonText: "Batal",
                    confirmButtonText: "Ubah",
                    confirmButtonColor: "#3ab50d",
                    reverseButtons: true,
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "post",
                            dataType: 'json',
                            url: $(this).attr('action'),
                            data: $(this).serialize(),
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
        }else{
            Swal.fire({
                icon : 'error',
                title : 'Nomor Handphone',
                text : 'Format nomor handphone tidak sesuai!',
                footer : '<span class="text-danger">example: 08xxxxxx</span>'
            });
        }
    })
});

function hapus(n_sales) {
    Swal.fire({
        icon: "warning",
        title: "Sales",
        text: "Apakah Anda yakin ingin menghapus data sales?",
        showCancelButton: true,
        cancelButtonText: "Batal",
        confirmButtonText: "Hapus",
        reverseButtons: true,
    }).then((result) => {
        if (result.value) {
            location.href = site_url + "/sales/hapus/" + n_sales;
        }
    });
}

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

function validatePhoneUpdate(telepon) {
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

$('#modal-add').on('hidden.bs.modal', function(){
    $('#form-add').parsley().reset();
    $('#form-add')[0].reset();
    $('#telepon').css({
        'color': '',
        'background': '',
        'border': ''
    });
});

$('#modal-edit').on('hidden.bs.modal', function(){
    $('#form-edit').parsley().reset();
    $('#e_telepon').css({
        'color': '',
        'background': '',
        'border': ''
    });
});