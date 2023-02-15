<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <tr>
                    <th>Nama Resmi</th>
                    <td><?= $instansi->nama_resmi ?></td>
                </tr>
                <tr>
                    <th>Nama Pendek</th>
                    <td><?= $instansi->nama_pendek ?></td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td><?= $instansi->alamat ?></td>
                <tr>
                <tr>
                    <th>Kab/Kota</th>
                    <td><?= $instansi->kota ?></td>
                <tr>
                    <th>Kode Pos</th>
                    <td><?= $instansi->kode_pos ?></td>
                </tr>
                </tr>
                <tr>
                    <th>No Telp</th>
                    <td><?= $instansi->no_telp ?></td>
                </tr>
                <tr>
                    <th>Website</th>
                    <td><?= $instansi->website ?></td>
                </tr>
            </table>
        </div>
        <button class="btn btn-success btn-sm" onclick="edit()"><i class="fa fa-edit"></i> Edit</button>
    </div>
</div>
<div class="modal fade" id="modal-edit" style="overflow-y:auto;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Edit Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('setting/dosave') ?>" method="POST" id="add_bank">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="nama_resmi">Nama Resmi</label>
                                <input class="form-control" type="text" name="nama_resmi" placeholder="Nama resmi" maxlength="50" id="nama_resmi" value="<?= $instansi->nama_resmi ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="nama_pendek">Nama Pendek</label>
                                <input class="form-control" type="text" name="nama_pendek" placeholder="Nama pendek" value="<?= $instansi->nama_pendek ?>" maxlength="16" id="nama_pendek">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" name="alamat" placeholder="Alamat" rows="2" id="alamat"><?= $instansi->alamat ?></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="kota">Kab/Kota</label>
                                <input class="form-control" type="text" name="kota" placeholder="Kab/Kota" id="kota" value="<?= $instansi->kota ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="kode_pos">Kode Pos</label>
                                <input class="form-control" type="text" name="kode_pos" placeholder="Kode pos" maxlength="6" id="kode_pos" value="<?= $instansi->kode_pos ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="no_telp">Telepon</label>
                                <input class="form-control" type="nomor" name="no_telp" placeholder="No. Telp" maxlength="15" id="no_telp" value="<?= $instansi->no_telp ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="website">Wesbite</label>
                                <input class="form-control" type="nomor" name="website" placeholder="Website" maxlength="30" id="website" value="<?= $instansi->website ?>">
                            </div>
                        </div>
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
<?php $this->load->view('template/bundle/template_scripts'); ?>