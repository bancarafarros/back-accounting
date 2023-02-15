$(function (){
    var tanggal_awal = "<?= $tanggal ?>";
    var tanggal_akhir = "<?= $tanggal ?>";

    loadReport(tanggal_awal, tanggal_akhir);
});

function carifilter(){
    var tanggal_awal = $('#tanggal-dari').val();
    var tanggal_akhir = $('#tanggal-sampai').val();
    $('#link-cetak').attr('href', site_url + 'report/pemasok/hutang_global_pdf?tgl_awal=' + tanggal_awal + '&tgl_akhir=' + tanggal_akhir );
    loadReport(tanggal_awal, tanggal_akhir);
}

function loadReport(tanggal_awal, tanggal_akhir)
{
    $.ajax({
        url: site_url + '/report/pemasok/hutang_global_data',
        type: "POST",
        data: {
            tanggal_awal: tanggal_awal,
            tanggal_akhir: tanggal_akhir
        },
        dataType: "JSON",
        beforeSend: () => {
            showLoading();
        },
        success: function (response){
            hideLoading();
            $('#hutang-global').html(response.data);
            $('#tanggal-awal').text(response.tanggal_awal_indo);
            $('#tanggal-akhir').text(response.tanggal_akhir_indo);
        },
        error: function (jqXHR, textStatus, errorThrown){
            hideLoading()
            Swal.fire('Error!', 'Internal server error', 'error');
        }
    });
}