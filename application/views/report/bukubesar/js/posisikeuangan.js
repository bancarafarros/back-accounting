$(function () {
    var tanggal = "<?= $tanggal ?>";
    loadReport(tanggal);
});

function carifilter() {
    var tanggal = $('#filterym').val();
    $('#link-cetak').attr('href', site_url + '/report/bukubesar/pdfposisikeuangan/' + tanggal);
    loadReport(tanggal);
}

function loadReport(tanggal) {
    $.ajax({
        url: site_url + '/report/bukubesar/posisikeuangandata',
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
            // $('#aktiva-sub').text(response.aktiva.subgrup);
            // $('#pasivah-sub').text(response.pasiva_h.subgrup);
            // $('#pasivam-sub').text(response.pasiva_m.subgrup);
            $('#total-kewajiban').text(response.total_kewajiban);
            $('#total-aktiva').text(response.ttlaktiva);
            $('#total-pasiva').text(response.total_pasiva);
            $('#coa_laba').text(response.coa_laba.nama);
            $('#total-laba').text(response.coa_laba.nominal);
            $('#container-aktiva').html(response.aktivas);
            $('#container-pasivah').html(response.pasivas_h);
            $('#container-pasivam').html(response.pasivas_m);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            hideLoading()
            Swal.fire('Error!', 'Internal server error', 'error').then((result) => {
                // location.reload();
            });
        }
    });
}