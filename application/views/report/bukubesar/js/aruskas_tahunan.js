$(function() {
    var tanggal = "<?= $tanggal ?>";
    loadReport(tanggal);
});

function carifilter() {
    var tanggal = $('#filterym').val();
    $('#link-cetak').attr('href', site_url + 'report/bukubesar/aruskas_cetak/' + tanggal);
    loadReport(tanggal);
}

function loadReport(tanggal) {
    $.ajax({
        url: site_url+ '/report/bukubesar/aruskastahunan_data',
        type: "POST",
        data: {
            tanggal: tanggal
        },
        dataType: "JSON",
        beforeSend: () => {
            showLoading()
        },
        success: function(response) {
            hideLoading();
            $('#per-tanggal').text(response.tanggal_indo);
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