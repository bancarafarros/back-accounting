$(function () {
    var tanggal_awal = "<?= $tanggal ?>";
    var tanggal_akhir = "<?= $tanggal ?>";
    loadReport(tanggal_awal, tanggal_akhir);
});

function carifilter() {
    var tanggal_awal = $('#tanggal-dari').val();
    var tanggal_akhir = $('#tanggal-sampai').val();
    $('#link-cetak').attr('href', site_url + '/report/kasbank/pdf_bankkeluar?tglawal=' + tanggal_awal + '&tglakhir=' + tanggal_akhir);
    if (tanggal_akhir >= tanggal_awal) {
        loadReport(tanggal_awal, tanggal_akhir);
    } else {
        Swal.fire('Tanggal', 'Tanggal akhir tidak boleh kurang dari tanggal awal', 'warning');
    }
}

function loadReport(tanggal_awal, tanggal_akhir) {
    $.ajax({
        url: site_url + '/report/kasbank/bankkeluar_data',
        type: "POST",
        data: {
            tgl_dari: tanggal_awal,
            tgl_sampai: tanggal_akhir
        },
        dataType: "JSON",
        beforeSend: () => {
            showLoading()
        },
        success: function (response) {
            hideLoading();
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