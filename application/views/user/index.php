<!-- grocery -->
<?php echo $output->output; ?>
<div class="modal fade" id="modal-reset" style="overflow-y:auto;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reset Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('user/ajaxresetpassword') ?>" method="POST" id="freset">
                <div class="modal-body">
                    <input type="hidden" id="id_sekolah" name="id_sekolah">
                    <input type="hidden" id="id_user" name="id_user">
                    <div class="form-group">
                        <label for="email_awal">Email</label>
                        <input type="email" name="email_awal" id="email_awal" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email_baru">Email Baru</label>
                        <input type="email" name="email_baru" id="email_baru" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">Password Baru <b class="text-danger">*</b></label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="ulangi_password">Ulangi Password <b class="text-danger">*</b></label>
                        <input type="password" name="ulangi_password" id="ulangi_password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                    <button type="submit" class="btn btn-success" value="simpan" id=btn_simpan><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view("template/bundle/template_scripts") ?>