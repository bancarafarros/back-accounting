$(function() {
    var tanggal_awal = "<?= $tanggal ?>";
    var tanggal_akhir = "<?= $tanggal ?>";
    loadReport(tanggal_awal, tanggal_akhir);
});

function carifilter() {
    var tanggal_awal = $('#tanggal-dari').val();
    var tanggal_akhir = $('#tanggal-sampai').val();
    $('#link-cetak').attr('href', site_url + '/report/persediaan/pdf_persediaanbaranggrup?tglawal=' + tanggal_awal + '&tglakhir=' + tanggal_akhir);
    loadReport(tanggal_awal, tanggal_akhir);
}

function loadReport(tanggal_awal, tanggal_akhir) {
    $.ajax({
        url: site_url + '/report/persediaan/persediaan_barang_grup_data',
        type: "POST",
        data: {
            tgl_dari: tanggal_awal,
            tgl_sampai: tanggal_akhir
        },
        dataType: "JSON",
        beforeSend: () => {
            showLoading()
        },
        success: function(response) {
            hideLoading();
            $('#tanggal-awal').text(response.tanggal_awal_indo);
            $('#tanggal-akhir').text(response.tanggal_akhir_indo);
            $('#container-data').html(response.data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            hideLoading()
            Swal.fire('Error!', 'Internal server error', 'error').then((result) => {
                // location.reload();
            });
        }
    });
}