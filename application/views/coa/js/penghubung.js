$(document).ready(function() {
    $('#lookup').DataTable({
        "paging": false,
        "search": true,
        "responsive": true
    });
});
$('.s_akun').click(function() {
    $('#indexData').val($(this).data('index'));
})
for (let s = 0; s < $(".sum_akun").val(); s++) {
    $(".chs_akun" + s).click(function() {
        var index = $('#indexData').val();
        $('input[name="a_' + index + '"]').val($('.no_akun' + s).val());
        $('input[name="n_' + index + '"]').val($('.no_namaakun' + s).val());
    });
}