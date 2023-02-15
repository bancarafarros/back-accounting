$(function () {
    var n_pemasok = "<?= $n_pemasok->n_pemasok ?>";
    var tanggal_awal = "<?= $tanggal ?>";
    var tanggal_akhir = "<?= $tanggal ?>";
    loadReport(n_pemasok, tanggal_awal, tanggal_akhir);
});

function carifilter() {
    var n_pemasok = $('#n_pemasok').val();
    var tanggal_awal = $('#tanggal-dari').val();
    var tanggal_akhir = $('#tanggal-sampai').val();
    $('#link-cetak').attr('href', site_url + '/report/pembelian/pembelian_pemasok_pdf?npemasok=' + n_pemasok + '&tglawal=' + tanggal_awal + '&tglakhir=' + tanggal_akhir);
    loadReport(n_pemasok, tanggal_awal, tanggal_akhir);
}

function loadReport(n_pemasok, tanggal_awal, tanggal_akhir) {
    $.ajax({
        url: site_url + '/report/pembelian/pembelian_pemasok_data',
        type: "POST",
        data: {
            n_pemasok: n_pemasok,
            tgl_dari: tanggal_awal,
            tgl_sampai: tanggal_akhir
        },
        dataType: "JSON",
        beforeSend: () => {
            showLoading()
        },
        success: function (response) {
            hideLoading();
            $('#n-pemasok').text(response.n_pemasok);
            $('#tanggal-awal').text(response.tanggal_awal_indo);
            $('#tanggal-akhir').text(response.tanggal_akhir_indo);
            $('#container-data').html(response.data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            hideLoading()
            Swal.fire('Error!', 'Internal server error', 'error').then((result) => {
                // location.reload();
            });
        }
    });
}