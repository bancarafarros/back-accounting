$(function() {
    var bulan = "<?= $bulan ?>";
    loadReport(bulan);
});

function carifilter() {
    var bulan = $('#filterym').val();
    $('#link-cetak').attr('href', site_url + 'report/bukubesar/aruskasbulanan_cetak/' + bulan);
    loadReport(bulan);
}

function loadReport(bulan) {
    $.ajax({
        url: site_url+ '/report/bukubesar/aruskasbulanan_data',
        type: "POST",
        data: {
            bulan: bulan
        },
        dataType: "JSON",
        beforeSend: () => {
            showLoading()
        },
        success: function(response) {
            hideLoading();
            $('#per-bulan').text(response.bulan_indo);
            $('#total-laba').html(response.ttllaba);
            $('#container-pendapatan').html(response.pendapatan);
            $('#container-hpp').html(response.hpp);
            $('#container-biaya').html(response.biaya);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            hideLoading()
            Swal.fire('Error!', 'Internal server error', 'error').then((result) => {
                // location.reload();
            });
        }
    });
}