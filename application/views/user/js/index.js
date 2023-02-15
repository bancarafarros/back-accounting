function resetPassword(id){
    $.ajax({
        type : 'ajax',
        method : 'POST',
        url : site_url+'/user/ajaxdata',
        data: {id_user: id},
        dataType: 'json',
        beforeSend : function(){
            showLoading();
        },
        success: function(response){
            hideLoading();
            $('[name=email_awal]').val(response.email);
            $('[name=id_user]').val(response.id_user);
            $('#modal-reset').modal('show');
        },
        error: function(xmlresponse){
            hideLoading();
            Swal.fire('Gagal!', 'Internal server error', 'error');
            console.log(xmlresponse)
        }
    });
}

$(function(){
    $('#freset').submit(function(e){
        e.preventDefault()
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: site_url + '/user/ajaxresetpassword',
            data: $('#freset').serialize(),
            dataType: 'json',
            beforeSend : function(){
                showLoading();
            },
            success: function(response) {
                hideLoading();
                if (response.success) {
                    Swal.fire('Sukses!', response.message, 'success').then(function() {
                        $('#freset').trigger("reset");
                        $('#modal-reset').modal('hide');
                        $('.fa-refresh').trigger('click');
                    })
                } else {
                    Swal.fire('Gagal!', response.message, 'error');
                }
            },
            error: function(xmlresponse) {
                hideLoading();
                Swal.fire('Gagal!', 'Internal server error', 'error');
                console.log(xmlresponse);
            }
        })
    })
})