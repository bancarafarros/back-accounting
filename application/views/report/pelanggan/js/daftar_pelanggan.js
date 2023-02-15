$(function () {
    var tanggal = "<?= $tanggal ?>";
    loadReport(tanggal);
});

function carifilter() {
    var tanggal = $('#filterym').val();
    $('#link-cetak').attr('href', site_url + 'report/pelanggan/pdf_daftar_pelanggan/' + tanggal);
    loadReport(tanggal);
}

function loadReport(tanggal) {
    $.ajax({
        url: site_url + '/report/pelanggan/daftar_pelanggan_data',
        type: "POST",
        data: {
            tanggal: tanggal
        },
        dataType: "JSON",
        beforeSend: () => {
            showLoading()
        },
        success: function (response) {
            hideLoading();
            $('#per-tanggal').text(response.tanggal_indo);
            $('#laporan').html(response.data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            hideLoading()
            Swal.fire('Error!', 'Internal server error', 'error').then((result) => {
                // location.reload();
            });
        }
    });
}