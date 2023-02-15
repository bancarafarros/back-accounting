$(function () {
    var n_pelanggan = "<?= $n_pelanggan->n_pelanggan ?>";
    var tanggal_awal = "<?= $tanggal ?>";
    var tanggal_akhir = "<?= $tanggal ?>";
    loadReport(n_pelanggan, tanggal_awal, tanggal_akhir);
});

function carifilter() {
    var n_pelanggan = $('#n_pelanggan').val();
    var tanggal_awal = $('#tanggal-dari').val();
    var tanggal_akhir = $('#tanggal-sampai').val();
    $('#link-cetak').attr('href', site_url + '/report/penjualan/penjualan_pelanggan_pdf?npelanggan=' + n_pelanggan + '&tglawal=' + tanggal_awal + '&tglakhir=' + tanggal_akhir);
    loadReport(n_pelanggan, tanggal_awal, tanggal_akhir);
}

function loadReport(n_pelanggan, tanggal_awal, tanggal_akhir) {
    $.ajax({
        url: site_url + '/report/penjualan/penjualan_pelanggan_data',
        type: "POST",
        data: {
            n_pelanggan: n_pelanggan,
            tgl_dari: tanggal_awal,
            tgl_sampai: tanggal_akhir
        },
        dataType: "JSON",
        beforeSend: () => {
            showLoading()
        },
        success: function (response) {
            hideLoading();
            $('#n-pelanggan').text(response.n_pelanggan);
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