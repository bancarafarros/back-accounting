$(function(){
    var tanggal = "<?= $tanggal ?>";
    loadReport(tanggal);
});

function carifilter(){
    var tanggal = $('#filter_pemasok').val();
    $('#link-cetak').attr('href', site_url + 'report/pemasok/daftar_pemasok_pdf?tgl=' + tanggal);
    loadReport(tanggal)
}
function loadReport(tanggal){
    $.ajax({
        url: site_url + '/report/pemasok/daftar_pemasok_data',
        type: "POST",
        data: {
            tanggal: tanggal
        },
        dataType: "JSON",
        beforeSend: () => {
            showLoading()
        },
        success: function(response){
            hideLoading();
            $('#pemasok').html(response.data);
            $('#per-tanggal').text(response.tanggalindo);
        },
        error: function (jqXHR, textStatus, errorThrown){
            hideLoading();
            Swal.fire('Error!', 'Internal Server erorr', 'error');
        }
    });
}