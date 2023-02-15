<div class="card card-primary shadow">
    <div class="card-body">
        <div class="mb-3" align="right">
            <button type="button" class="btn btn-success btn-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-add">
                <i class="fa fa-plus"></i> Tambah Pelanggan
            </button>
        </div>
        <div class="table-responsive">
            <table id="zero_config" class="table table-hover table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th width="10%">Aksi</th>
                        <th width="10%">Nomor</th>
                        <th>Nama Pelanggan</th>
                        <th>Alamat</th>
                        <th width="90px">Telepon</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $s = 0;
                    foreach ($d_pelanggan as $key => $value) {
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
                                    <a href="" class="btn btn-xs btn-warning edit<?= $s ?>" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-edit"><i class="fa fa-edit"></i></a>
                                    <a href="#" class="btn btn-xs btn-danger delete-btn text-light" data-id="<?= $value->n_pelanggan ?>"><i class="fa fa-eraser"></i></a>
                                </div>
                            </td>
                            <td><?= $value->n_pelanggan ?></td>
                            <td><?= $value->nama ?></td>
                            <td><?= $value->alamat ?></td>
                            <td><?= $value->telepon ?></td>
                            <input type="hidden" class="n_pelanggan<?= $s ?>" value="<?= $value->n_pelanggan ?>">
                            <input type="hidden" class="barcode<?= $s ?>" value="<?= $value->barcode ?>">
                            <input type="hidden" class="pass<?= $s ?>" value="<?= $value->pass ?>">
                            <input type="hidden" class="tanggal<?= $s ?>" value="<?= $value->tanggal ?>">
                            <input type="hidden" class="akun<?= $s ?>" value="<?= $value->akun ?>">
                            <input type="hidden" class="nama<?= $s ?>" value="<?= $value->nama ?>">
                            <input type="hidden" class="alamat<?= $s ?>" value="<?= $value->alamat ?>">
                            <input type="hidden" class="telepon<?= $s ?>" value="<?= $value->telepon ?>">
                            <input type="hidden" class="email<?= $s ?>" value="<?= $value->email ?>">
                            <input type="hidden" class="batas<?= $s ?>" value="<?= $value->batas ?>">
                            <input type="hidden" class="status<?= $s ?>" value="<?= $value->statusA ?>">
                            <input type="hidden" class="n_sales<?= $s ?>" value="<?= $value->n_sales ?>">
                            <input type="hidden" class="n_akun<?= $s ?>" value="<?= $value->n_akun ?>">
                        </tr>
                    <?php $s++;
                    } ?>
                    <input type="text" class="sum_pelanggan" value="<?= $s ?>" hidden>
                </tbody>
            </table>
        </div>
        <button class="btn btn-danger btn-sm float-right mt-4" type="button" id="nAktif" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#ModalAktif">Pelanggan Tidak Aktif</button>
    </div>
</div>
<!-- ######################################################################### -->
<div class="modal fade" id="modal-add" style="overflow-y:auto;" data-backdrop="static">
    <div class=" modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Isi Data Pelanggan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('pelanggan/dosave') ?>" method="POST" id="form-add" data-parsley-validate>
                <div class="modal-body">
                    <div class="row">
                    <input type="hidden" class="form-control" name="tanggal" value="<?= date("Y-m-d") ?>" id="datepicker-autoclose1" readonly required>
                        <div class="col-sm-12">
                            <div class="form-group">
                            <label class="">Nama Pelanggan<b class="text-danger"> *</b></label>
                            <input class="form-control capital" type="text" name="nama" placeholder="Nama Pelanggan" value="<?= @$detail->nama ?>" maxlength="50" id="namaPelanggan" required>
                            </div>
                        </div>
                        
                        <div class="col-sm-12">
                            <div class="form-group m-0">
                                <label class="col-12 col-sm-12 col-md-12 p-0">Akun Perkiraan<b class="text-danger"> *</b></label>
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

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="telepon">Barcode</label>
                                <input class="form-control" type="text" name="barcode" placeholder="Barcode" value="<?= @$detail->barcode ?>" maxlength="15" id="barcode">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">Batas Kredit</label>
                                <input class="form-control money numeric" type="number" name="batas" placeholder="Batas Kredit" value="0" id="batas">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="alamat">Alamat <?= $requiredLabel ?></label>
                                <input class="form-control capital" type="text" placeholder="Alamat" name="alamat" maxlength="255" id="alamat" required>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="telepon">No HP <?= $requiredLabel ?></label>
                                <input class="form-control telepon numeric" type="number" name="telepon" placeholder="No HP" value="<?= @$detail->telepon ?>" maxlength="15" id="telepon" onkeyup="validatePhone(this.value)" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="email">Email <?= $requiredLabel ?></label>
                                <input class="form-control" type="email" name="email" placeholder="Email" value="<?= @$detail->email ?>" maxlength="25" id="email" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="email">Salesman <?= $requiredLabel ?></label>
                                <select name="n_sales" class="form-control" required>
                                <?php
                                foreach ($d_sales as $details) {
                                    if ($details->n_sales == @$detail->n_sales) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    } ?>
                                    <option value="<?= $details->n_sales ?>" <?= $selected ?>> <?= $details->nama ?> </option>
                                <?php } ?>
                            </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="act" value="insert">
                    <input type="hidden" name="id" value="<?= @$detail->n_pelanggan ?>">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-md col-md-12 simpan" value="simpan">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ######################################################################### -->
<div class="modal fade" id="modal-edit" style="overflow-y:auto;">
    <div class="modal-dialog" style="max-width: 60%; min-width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
            <h4>Edit Data Pelanggan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('pelanggan/dosave') ?>" method="POST" id="form-edit" data-parsley-validate>
                <div class="modal-body">
                    <div class="row">
                    <input type="hidden" class="form-control e_tanggal" name="tanggal" value="<?= @$detail->tanggal ?>" id="datepicker-autoclose2" required readonly>
                        
                    <div class="col-sm-6">
                            <div class="form-group">
                            <label class="">Nomor Pelanggan <?= $requiredLabel ?></label>
                                <input class="form-control e_n_pelanggan" type="text" name="n_pelanggan" value="<?= @$detail->n_pelanggan ?>" maxlength="12" id="" required readonly>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label for="">Status <?= $requiredLabel ?></label>
                            <select class="custom-select form-control select2" name="status" id="e_status" required>
                                <option value="1" <?= (@$value->statusA == '1' ? 'selected' : null) ?>>Aktif</option>
                                <option value="0" <?= (@$value->statusA == '0' ? 'selected' : null) ?>>Tidak Aktif</option>
                            </select>
                            </div>
                        </div>
                    
                        <div class="col-sm-12">
                            <div class="form-group">
                            <label class="col-8 col-sm-6 col-md-6 p-0">Nama Pelanggan <?= $requiredLabel ?></label>
                            <input class="form-control e_nama capital" type="text" name="nama" value="<?= @$detail->nama ?>" maxlength="50" id="namaPelanggan" required>
                            </div>
                        </div>
                        
                        <div class="col-sm-12">
                            <div class="form-group m-0">
                            <label class="col-12 col-sm-12 col-md-12 p-0">Akun Perkiraan <?= $requiredLabel ?></label>
                            </div>
                            <div class="form-group form-row mb-3">
                                <div class="input-group col-12 col-sm-12 col-md-12 p-1">
                                    <input type="text" class="form-control d_akun col-sm-3 e_akun" name="akun" data-parsley-errors-container="#perkiraan-errors" readonly required>
                                    <input type="text" class="form-control d_namaakun e_n_akun" name="namaakun" value="<?= @$detail->n_akun ?>" readonly>
                                    <div class="input-group-append col-sm-2">
                                        <a href="#myModal1" data-toggle="modal">
                                            <button class="btn btn-success" type="button"><i class="fa fa-search"></i></button>
                                        </a>
                                    </div>
                                </div>
                                <div id="perkiraan-errors"></div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Barcode</label>
                                <input class="form-control" type="text" name="barcode" placeholder="Barcode" value="<?= @$detail->barcode ?>" maxlength="15" id="barcode">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Batas Kredit</label>
                                <input class="form-control e_batas money-edit" type="text" name="batas" value="<?= @$detail->batas ?>" id="batas" required>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                            <label class="col-12 col-sm-12 col-md-12 p-0">Alamat <?= $requiredLabel ?></label>
                            <input class="form-control e_alamat" type="text" name="alamat" value="<?= @$detail->alamat ?>" maxlength="50" id="alamat" required>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                            <label>No HP <?= $requiredLabel ?></label>
                            <input class="form-control e_telepon numeric" type="number" name="telepon" value="<?= @$detail->telepon ?>" maxlength="15" id="e_telepon" onkeyup="validatePhoneEdit(this.value)" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                            <label>E-mail <?= $requiredLabel ?></label>
                            <input class="form-control e_email" type="email" name="email" value="<?= @$detail->email ?>" maxlength="25" id="email" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                            <label>Salesman <?= $requiredLabel ?></label>
                            <select name="n_sales" class="form-control e_n_sales" required>
                                <?php
                                foreach ($d_pelanggan as $details) {
                                    if ($details->n_sales) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    } ?>
                                    <option value="<?= $details->n_sales ?>" <?= $selected ?>> <?= $details->nama_sales ?> </option>
                                <?php } ?>
                            </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="act" value="edit">
                    <input type="hidden" name="id" value="<?= @$detail->n_pelanggan ?>">
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-warning btn-md col-md-12 edit" value="simpan">UPDATE</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ############################################################################ -->
<div id="myModal1" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true" data-modal-parent="#modal-add">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Akun Perkiraan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style=" max-height: calc(100vh - 150px); overflow-y: auto;">
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
                                        <a role="button" href="#" class="btn btn-success btn-sm chs_akun<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></a>
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
<!-- ############################################################################## -->
<div id="myModal1-edit" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true" data-modal-parent="#modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Akun Perkiraan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" style=" max-height: calc(100vh - 150px); overflow-y: auto;">
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
                                    <td align="right"><a href="#" class="badge badge-primary chs_akun<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></a></td>
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

<div id="ModalAktif" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Daftar Pelanggan Tidak Aktif</h5>
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
                                <th>Nama Pelanggan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="Pelanggan_nktif">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('template/bundle/template_scripts'); ?>