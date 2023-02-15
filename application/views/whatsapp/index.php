<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-lg-6">
                <table class="table table-sm table-bordered">
                    <tbody>
                        <tr>
                            <td class="text-muted">Atas Nama</td>
                            <td id="wa-name">
                                -
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Nomor Whatsapp</td>
                            <td id="wa-sender">
                                -
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Kuota WhatsApp</td>
                            <td id="wa-quota">
                                -
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status Koneksi</td>
                            <td id="wa-status" class="text-warning">
                                CONNECTING
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Aktif Sampai</td>
                            <td id="wa-exp-date">
                                -
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-3">
                    <input type="text" class="form-control text-center" placeholder="Masukkan nomor WA tujuan" id="target-number" autocomplete="off">
                    <button class="btn btn-success w-100 mt-2" id="send-whatsapp">
                        <i class="ti ti-email"></i> Coba kirim pesan WhatsApp
                    </button>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <iframe src="<?= $qrcode ?>" title="WhatsApp Generate QR Code" height="600px" width="100%" border="0" id="iframe-wablas">
                </iframe>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('template/bundle/template_scripts'); ?>
<script>
    $(document).ready(function() {
        const sendButton = $('#send-whatsapp');
        const targetInput = $('#target-number');
        sendButton.click(sendWhatsapp);

        checkStatus();
        setInterval(() => {
            checkStatus();
        }, 7500);

    });


    function sendWhatsapp() {
        if ($('#send-whatsapp').attr('disabled'))
            return;
        let number = $('#target-number').val();
        if (number) {
            $.get({
                url: "<?= site_url('/dashboard/pengaturan/whatsapp/send') ?>/" + number,
                dataType: 'json',
            }).done(function() {
                Swal.fire({
                    confirmButtonColor: "#3ab50d",
                    icon: "success",
                    title: `Berhasil mengirim pesan`,
                });
            })
        }
    }


    function checkStatus() {
        $.get({
            url: '<?= site_url('dashboard/pengaturan/whatsapp/device') ?>',
            error: function(error) {
                const status = $('#wa-status');
                status
                    .removeClass('text-success')
                    .removeClass('text-danger')
                    .addClass('text-warning');
                status.text('CONNECTING');
            },
            success: function(response, responseStatus) {
                var wa = response;
                const status = $('#wa-status');

                // var sms = response.data.sms;
                let keys = Object.keys(wa);
                if (responseStatus === 'error' || !wa || ['name', 'sender', 'quota', 'expired_date', 'status'].some(key => !keys.includes(key))) {
                    status
                        .removeClass('text-success')
                        .removeClass('text-danger')
                        .addClass('text-warning');
                    status.text('CONNECTING');
                    return;
                }

                $('#wa-name').text(wa.name);
                $('#wa-sender').text(wa.sender);
                $('#wa-quota').text(wa.quota);
                status.text(wa.status.toUpperCase());
                $('#wa-exp-date').text(wa['expired_date']);

                if (wa.status == 'connected') {
                    status
                        .removeClass('text-danger')
                        .removeClass('text-warning')
                        .addClass('text-success');

                    $('#target-number').attr('readonly', false);
                    $('#send-whatsapp').attr('disabled', false);
                }

                if (wa.status == 'disconnected') {
                    status
                        .removeClass('text-success')
                        .removeClass('text-warning')
                        .addClass('text-danger');

                    $('#target-number').attr('readonly', true);
                    $('#send-whatsapp').attr('disabled', true);
                }
            }
        });
    }
</script>