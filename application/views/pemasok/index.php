<div class="card shadow">
    <div class="card-body">
        <div class="mb-3" align="right">
            <button type="button" class="btn btn-success btn-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-add">
                <i class="fa fa-plus"></i> Tambah Pemasok
            </button>
        </div>
        <div class="table-responsive">
            <table id="zero_config" class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th width="10%">Aksi</th>
                        <th width="10%">Nomor</th>
                        <th>Nama Pemasok</th>
                        <th>Alamat</th>
                        <th width="90px">Telepon</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $s = 0;
                    foreach ($d_pemasok as $key => $value) {
                        $tgl = strtotime($value->tanggal);
                        $tanggal = date('d-M-Y', $tgl);
                        if ($value->n_akun == "") {
                            $warn = 'class="bg-danger text-light"';
                        } else {
                            $warn = '';
                        }
                    ?>
                        <tr <?= $warn ?>>
                            <td>
                                <div class="btn-group">
                                    <a href="#" role="button" class="btn btn-xs btn-warning edit<?= $s ?>" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-edit"><i class="fa fa-edit"></i></a>
                                    <button type="button" class="btn btn-danger btn-xs text-light" onclick="hapus('<?= $value->n_pemasok ?>')"><i class="fa fa-eraser"></i></button>
                                </div>
                            </td>
                            <td><?= $value->n_pemasok ?></td>
                            <td><?= $value->nama ?></td>
                            <td><?= $value->alamat ?></td>
                            <td><?= $value->telepon ?></td>
                            <input type="hidden" class="n_pemasok<?= $s ?>" value="<?= $value->n_pemasok ?>">
                            <input type="hidden" class="nama<?= $s ?>" value="<?= $value->nama ?>">
                            <input type="hidden" class="tanggal<?= $s ?>" value="<?= $tanggal ?>">
                            <input type="hidden" class="akun<?= $s ?>" value="<?= $value->akun ?>">
                            <input type="hidden" class="n_akun<?= $s ?>" value="<?= @$value->n_akun ?>">
                            <input type="hidden" class="alamat<?= $s ?>" value="<?= $value->alamat ?>">
                            <input type="hidden" class="telepon<?= $s ?>" value="<?= $value->telepon ?>">
                            <input type="hidden" class="email<?= $s ?>" value="<?= $value->email ?>">
                            <input type="hidden" class="batas<?= $s ?>" value="<?= $value->batas ?>">
                            <input type="hidden" class="status<?= $s ?>" value="<?= $value->statusA ?>">
                        </tr>
                    <?php $s++;
                    } ?>
                    <input type="text" class="sum_pemasok" value="<?= $s ?>" hidden>
                </tbody>
            </table>
        </div>
        <button class="btn btn-danger btn-sm float-right mt-5" type="button" id="nAktif" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#ModalAktif">Pemasok Tidak Aktif</button>
    </div>
</div>

<!-- ######################################################################## -->
<div class="modal fade" id="modal-add" style="overflow-y:auto;" data-backdrop="static">
    <div class=" modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Isi Data Pemasok</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-add" action="<?= site_url('pemasok/ajaxsave') ?>" method="POST" data-parsley-validate>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control" name="tanggal" value="<?= date("Y-m-d") ?>" readonly required>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="nama">Nama Pemasok <?= $requiredLabel ?></label>
                                <input class="form-control capital" type="text" name="nama" placeholder="Nama pemasok" maxlength="50" id="nama" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="telepon">No HP <?= $requiredLabel ?></label>
                                <input class="form-control" type="number" placeholder="No Hp" name="telepon" maxlength="14" id="telepon" onkeyup="validatePhone(this.value)" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">Email <?= $requiredLabel ?></label>
                                <input class="form-control" type="email" placeholder="Email" name="email" maxlength="50" id="email" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group m-0">
                                <label class="">Akun Perkiraan <?= $requiredLabel ?></label>
                            </div>
                            <div class="form-group form-row mb-3">
                                <div class="input-group col-12 col-sm-12 col-md-12 p-1">
                                    <input type="text" class="form-control d_akun col-sm-3" name="akun" data-parsley-errors-container="#perkiraan-errors" readonly required>
                                    <input type="text" class="form-control d_namaakun" name="namaakun" readonly>
                                    <div class="input-group-append col-sm-2">
                                        <a href="#myModal1" data-toggle="modal">
                                            <button class="btn btn-success" type="button"><i class="fa fa-search"></i></button>
                                        </a>
                                    </div>
                                </div>
                                <div id="perkiraan-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="alamat">Alamat <?= $requiredLabel ?></label>
                                <input class="form-control capital" type="text" placeholder="Alamat" name="alamat" maxlength="255" id="alamat" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="">Batas Kredit</label>
                                <input class="form-control batas numeric" type="text" id="batas" placeholder="Batas kredit" name="batas" value="0" required>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="status" id="">
                    <input type="hidden" name="act" value="insert">
                    <input type="hidden" name="id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default m-r-10" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                    <button type="submit" class="btn btn-success" value="simpan"><i class="fa fa-save"></i> SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ######################################################################## -->
<div class="modal fade" id="modal-edit" style="overflow-y:auto;" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Edit Data Pemasok</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit" action="<?= site_url('pemasok/ajaxsave') ?>" method="POST" data-parsley-validate>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="e_nomor">Nomor Pemasok <?= $requiredLabel ?></label>
                                <input class="form-control e_nomor" type="text" placeholder="Nomor pemasok" name="n_pemasok" value="<?= @$detail->n_pemasok ?>" id="e_nomor" required readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <label for="">Status <?= $requiredLabel ?></label>
                            <select class="custom-select form-control select2" name="status" id="e_status" required>
                                <option value="1" <?= (@$value->statusA == '1' ? 'selected' : null) ?>>Aktif</option>
                                <option value="0" <?= (@$value->statusA == '0' ? 'selected' : null) ?>>Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="e_nama">Nama Pemasok <?= $requiredLabel ?></label>
                                <input class="form-control e_nama capital" type="text" placeholder="Nama pemasok" name="nama" value="<?= @$detail->nama ?>" id="e_nama" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="e_telepon">Telepon <?= $requiredLabel ?></label>
                                <input class="form-control e_telepon" type="number" placeholder="No telp" name="telepon" value="<?= @$detail->telepon ?>" id="e_telepon" maxlength="14" onkeyup="validatePhoneEdit(this.value)" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="e_email">Email <?= $requiredLabel ?></label>
                                <input class="form-control e_email" type="email" placeholder="Email" name="email" value="<?= @$detail->email ?>" id="e_email" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label for="">Akun Perkiraan <?= $requiredLabel ?></label>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control col-sm-3 d_akun e_akun" value="" name="akun" readonly required data-parsley-errors-container="#e_perkiraan-errors">
                                    <input type="text" class="form-control d_namaakun e_n_akun" value="" name="namaakun" readonly>
                                    <div class="input-group-append col-sm-2">
                                        <a href="#myModal1-edit" data-toggle="modal">
                                            <button class="btn btn-success" type="button"><i class="fa fa-search"></i></button>
                                        </a>
                                    </div>
                                </div>
                                <div id="e_perkiraan-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="e_alamat">Alamat <?= $requiredLabel ?></label>
                                <input class="form-control e_alamat capital" type="text" name="alamat" value="<?= @$detail->alamat ?>" id="e_alamat" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="e_batas">Batas Kredit</label>
                                <input class="form-control e_batas numeric" placeholder="Batas kredit" type="text" name="batas" value="<?= @$detail->batas ?>" id="e_batas">
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-row mb-3">
                        <input type="hidden" name="act" value="edit">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default m-r-10" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                    <button type="submit" class="btn btn-warning edit" value="simpan"><i class="fa fa-edit"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ######################################################################## -->
<div id="myModal1" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true" data-modal-parent="#modal-add">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Akun Perkiraan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow-y: auto;">
                <div class="table-responsive">
                    <table id="lookup" class="table" width="100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nomor</th>
                                <th>Nama Akun</th>
                                <th>Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0;
                            foreach ($d_akun as $key => $value) { ?>
                                <tr>
                                    <td><?= $value->akun ?></td>
                                    <td><?= $value->nama ?></td>
                                    <input type="hidden" class="no_akun<?= $no ?>" value="<?= $value->akun ?>">
                                    <input type="hidden" class="no_namaakun<?= $no ?>" value="<?= $value->nama ?>">
                                    <td align="center">
                                        <button type="button" class="btn btn-sm btn-success chs_akun<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></button>
                                    </td>
                                </tr>
                            <?php $no++;
                            } ?>
                            <input type="hidden" class="sum_akun" value="<?= $no ?>">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ######################################################################## -->
<div id="myModal1-edit" class="modal modal-child-edit" data-backdrop-limit="1" tabindex="1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true" data-modal-parent="#modal-edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Akun Perkiraan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow-y: auto;">
                <!-- <div class="table-responsive"> -->
                <table id="lookup-edit" class="table" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nomor</th>
                            <th>Nama Akun</th>
                            <th>Pilih</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0;
                        foreach ($d_akun as $key => $value) { ?>
                            <tr>
                                <td><?= $value->akun ?></td>
                                <td><?= $value->nama ?></td>
                                <input type="hidden" class="no_akun<?= $no ?>" value="<?= $value->akun ?>">
                                <input type="hidden" class="no_namaakun<?= $no ?>" value="<?= $value->nama ?>">
                                <td align="center"><button type="button" class="btn btn-sm btn-success chs_akun<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></button></td>
                            </tr>
                        <?php $no++;
                        } ?>
                        <input type="hidden" class="sum_akun" value="<?= $no ?>">
                    </tbody>
                </table>
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>
<!-- ######################################################################## -->
<div id="ModalAktif" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Daftar Pemasok Tidak Aktif</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="TabelNaktif" class="table" width="100%">
                        <thead class="">
                            <tr>
                                <th>Nomor</th>
                                <th>Nama Pemasok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="Pemasok_nktif">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('template/bundle/template_scripts'); ?>