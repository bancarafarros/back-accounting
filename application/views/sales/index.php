<div class="card shadow">
    <div class="card-body">
        <div class="mb-2" align="right">
            <button type="button" class="btn btn-success btn-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-add" id="btn_add">
                <i class="fa fa-plus"></i> Tambah Sales
            </button>
        </div>
        <div class="table-responsive">
            <table id="zero_config" class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th width="10%">Aksi</th>
                        <th width="70px">Nomor</th>
                        <th>Nama Sales</th>
                        <th>Alamat</th>
                        <th width="90px">Telepon</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $s = 0;
                    foreach ($d_sales as $key => $value) { ?>
                        <tr>
                            <td>
                                <div class="btn-group">
                                    <a href="#" role="button" class="btn btn-xs btn-warning edit<?= $s ?>" tabindex="1" role="dialog" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-edit" id="btn_edit"><i class="fa fa-edit"></i></a>
                                    <button type="button" onclick="hapus('<?= $value->n_sales ?>')" class="btn btn-xs btn-danger"><i class="fa fa-eraser"></i></button>
                                </div>
                            </td>
                            <td><?= $value->n_sales ?></td>
                            <td><?= $value->nama ?></td>
                            <td><?= $value->alamat ?></td>
                            <td><?= $value->telepon ?></td>
                            <input type="hidden" class="n_sales<?= $s ?>" value="<?= $value->n_sales ?>">
                            <input type="hidden" class="nama<?= $s ?>" value="<?= $value->nama ?>">
                            <input type="hidden" class="alamat<?= $s ?>" value="<?= $value->alamat ?>">
                            <input type="hidden" class="telepon<?= $s ?>" value="<?= $value->telepon ?>">
                        </tr>
                    <?php $s++;
                    } ?>
                    <input type="text" class="sum_sales" value="<?= $s ?>" hidden>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- ######################################################################## -->
<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Isi Data Sales</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-add" action="<?= site_url('sales/dosave') ?>" method="POST" data-parsley-validate>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="nama">Nama Sales <?= $requiredLabel ?></label>
                                <input class="form-control capital" placeholder="Nama" type="text" name="nama" maxlength="60" id="nama" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="telepon">No HP <?= $requiredLabel ?></label>
                                <input class="form-control numeric" placeholder="No HP" type="text" name="telepon" maxlength="15" onkeyup="validatePhone(this.value)" id="telepon" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="alamat">Alamat <?= $requiredLabel ?></label>
                                <input class="form-control capital" placeholder="Alamat" type="text" name="alamat" maxlength="255" id="alamat" required>
                            </div>
                        </div>
                        <input type="hidden" name="act" value="insert">
                        <input type="hidden" name="id" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                    <button type="submit" class="btn btn-success" value="simpan"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ######################################################################## -->
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Edit Data Sales</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit" action="<?= site_url('sales/dosave') ?>" method="POST" data-parsley-validate>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="e_n_sales">Nomor Sales <?= $requiredLabel ?></label>
                                <input class="form-control e_n_sales" placeholder="Nomor sales" type="text" name="n_sales" value="<?= @$detail->n_sales ?>" id="e_n_sales" readonly required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="e_nama">Nama Sales <?= $requiredLabel ?></label>
                                <input class="form-control capital e_nama" placeholder="Nama" type="text" name="nama" value="<?= @$detail->nama ?>" maxlength="60" id="e_nama" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="e_telepon">No HP <?= $requiredLabel ?></label>
                                <input class="form-control numeric e_telepon" type="text" name="telepon" value="<?= @$detail->telepon ?>" maxlength="15" id="e_telepon" onkeyup="validatePhoneUpdate(this.value)" required>
                            </div>
                        </div>
                        <div class="col-sm-12 form-group">
                            <label for="e_alamat">Alamat <?= $requiredLabel ?></label>
                            <input class="form-control capital e_alamat" placeholder="Alamat" type="text" name="alamat" value="<?= @$detail->alamat ?>" maxlength="255" id="e_alamat" required>
                        </div>
                    </div>
                    <input type="hidden" name="act" value="edit">
                    <input type="hidden" name="id" value="<?= @$detail->n_sales ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                    <button type="submit" class="btn btn-warning" value="simpan"><i class="fa fa-edit"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ######################################################################## -->
<?php $this->load->view('template/bundle/template_scripts'); ?>