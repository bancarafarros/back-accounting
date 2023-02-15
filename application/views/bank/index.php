<div class="card p-0 mt-0">
    <div class="card-body">
        <div class="mb-3" align="right">
            <button type="button" class="btn btn-success btn-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-add" id="btn_add">
                <i class="fa fa-plus"></i> Tambah Bank
            </button>
        </div>
        <div class="table-responsive">
            <table id="zero_config" class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th width="10%">Aksi</th>
                        <th width="70px">Nomor</th>
                        <th width="70px">Nomor Rekening</th>
                        <th>Nama Bank</th>
                        <th>Nama Pemilik</th>
                        <th>Akun Perkiraan</th>
                        <th>Alamat</th>
                        <th width="90px">Telepon</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $s = 0;
                    foreach ($d_bank as $key => $value) { ?>
                        <tr>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-warning btn-xs edit<?= $s ?>" tabindex="1" role="dialog" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-edit" id="btn_edit"><i class="fa fa-edit"></i></button>
                                    <button type="button" onclick="hapus('<?= $value->n_bank ?>')" class="btn btn-danger btn-xs"><i class="fa fa-eraser"></i></button>
                                </div>
                            </td>
                            <td><?= $value->n_bank ?></td>
                            <td><?= $value->norek ?></td>
                            <td><?= $value->nama ?></td>
                            <td><?= $value->pemilik ?></td>
                            <td><?= $value->n_akun ?></td>
                            <td><?= $value->alamat ?></td>
                            <td><?= $value->telepon ?></td>
                            <input type="hidden" class="n_bank<?= $s ?>" value="<?= $value->n_bank ?>">
                            <input type="hidden" class="nama<?= $s ?>" value="<?= $value->nama ?>">
                            <input type="hidden" class="alamat<?= $s ?>" value="<?= $value->alamat ?>">
                            <input type="hidden" class="telepon<?= $s ?>" value="<?= $value->telepon ?>">
                            <input type="hidden" class="akun<?= $s ?>" value="<?= $value->akun ?>">
                            <input type="hidden" class="n_akun<?= $s ?>" value="<?= $value->n_akun ?>">
                            <input type="hidden" class="norek<?= $s ?>" value="<?= $value->norek ?>">
                            <input type="hidden" class="pemilik<?= $s ?>" value="<?= $value->pemilik ?>">
                            <input type="hidden" class="alamat<?= $s ?>" value="<?= $value->alamat ?>">
                        </tr>
                    <?php $s++;
                    } ?>
                    <input type="text" class="sum_bank" value="<?= $s ?>" hidden>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- ######################################################################## -->
<div class="modal fade" id="modal-add" style="overflow-y:auto;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Tambah Data Bank</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('bank/dosave') ?> " method="POST" id="add_bank" data-parsley-validate>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="Nama">Nama Bank <?= $requiredLabel ?></label>
                                <input class="form-control capital" oninput="validate(this)" type="text" name="nama" placeholder="Nama Bank" id="nama" value="<?= set_value('nama') ?>" required>
                                <small class="form-text text-danger"><?= form_error('nama') ?></small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="norek">Nomor Rekening <?= $requiredLabel ?></label>
                                <input class="form-control" type="number" oninput="validate(this)" pattern="[0-9]{10,29}" name="norek" placeholder="No. Rekening" maxlength="16" id="norek" required>
                                <small class="form-text text-danger"><?= form_error('norek') ?></small>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="pemilik">Nama Pemilik <?= $requiredLabel ?></label>
                                <input class="form-control capital" type="text" name="pemilik" placeholder="Nama Pemilik" maxlength="50" id="pemilik" required>
                                <small class="form-text text-danger"><?= form_error('pemilik') ?></small>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="akun">Akun Perkiraan <?= $requiredLabel ?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control d_akun col-sm-3" name="akun" id="akun" placeholder="Akun" readonly required data-parsley-errors-container="#perkiraan-errors">
                                    <input type="text" class="form-control d_namaakun" name="namaakun" id="namaakun" placeholder="Nama Akun" readonly>
                                    <div class="input-group-append col-sm-2 pt-1">
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
                                <label for="alamat">Alamat <?= $requiredLabel ?></label>
                                <input class="form-control capital" type="text" name="alamat" placeholder="Alamat" maxlength="50" id="alamat" required>
                                <small class="form-text text-danger"><?= form_error('alamat') ?></small>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="telepon">Telepon <?= $requiredLabel ?></label>
                                <input class="form-control numeric" type="text" name="telepon" oninput="validate(this)" pattern="0[0-9]{11,14}" placeholder="No. Telp" min="0" maxlength="13" id="telepon" required>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="act" value="insert">
                    <input type="hidden" name="id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ######################################################################## -->
<div class="modal fade" id="modal-edit" style="overflow-y:auto;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Edit Data Bank</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('bank/dosave') ?>" method="POST" id="edit_bank" data-parsley-validate>
                <div class="modal-body">
                    <input class="form-control capital e_n_bank" type="hidden" name="n_bank" placeholder="Nomor Bank" value="<?= @$detail->n_bank ?>" maxlength="6" id="e_n_bank" required>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="e_nama">Nama Bank <?= $requiredLabel ?></label>
                                <input class="form-control capital e_nama" type="text" name="nama" placeholder="Nama Bank" value="<?= @$detail->nama ?>" maxlength="50" id="e_nama" required>
                            </div>
                        </div>
                        <div class="col-sm-6 m-0">
                            <div class="form-group">
                                <label for="e_norek">Nomor Rekening <?= $requiredLabel ?></label>
                                <input class="form-control numeric e_norek" type="text" name="norek" pattern="[0-9]{10,29}" placeholder="No. Rekening" value="<?= @$detail->norek ?>" maxlength="16" id="e_norek" required>
                            </div>
                        </div>
                        <div class="col-sm-12 m-0">
                            <div class="form-group">
                                <label for="e_pemilik">Nama Pemilik <?= $requiredLabel ?></label>
                                <input class="form-control capital e_pemilik" type="text" name="pemilik" placeholder="Nama Pemilik" value="<?= @$detail->pemilik ?>" maxlength="50" id="e_pemilik" required>
                            </div>
                        </div>
                    </div>
                    <div class="row m-0 p-0 col-md-12">
                        <label class="col-sm-6">Akun Perkiraan <?= $requiredLabel ?></label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control d_akun e_akun col-sm-3" name="akun" readonly required data-parsley-errors-container="#e_perkiraan-errors">
                            <input type="text" class="form-control d_namaakun e_Nakun" name="namaakun" placeholder="Nama Akun" required readonly>
                            <div class="input-group-append col-sm-2">
                                <a href="#myModal1" data-toggle="modal">
                                    <button class="btn btn-success" type="button"><i class="fa fa-search"></i></button>
                                </a>
                            </div>
                        </div>
                        <div id="e_perkiraan-errors"></div>
                    </div>
                    <div class="m-0">
                        <div class="form-group">
                            <label for="e_alamat">Alamat <?= $requiredLabel ?></label>
                            <input class="form-control capital e_alamat" type="text" name="alamat" placeholder="Alamat" value="<?= @$detail->alamat ?>" maxlength="50" id="e_alamat" required>
                        </div>
                    </div>
                    <div class="m-0 mb-3">
                        <div class="form-group">
                            <label for="e_telepon">No HP <?= $requiredLabel ?></label>
                            <input class="form-control numeric e_telepon" type="text" minlength="11" maxlength="13" name="telepon" placeholder="No HP" value="<?= @$detail->telepon ?>" maxlength="15" id="e_telepon" required>
                        </div>
                    </div>
                    <input type="hidden" name="act" value="edit">
                    <input type="hidden" name="id" value="<?= @$detail->n_bank ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                    <button type="submit" class="btn btn-success" value="simpan"><i class="fa fa-edit"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ######################################################################## -->
<div id="myModal1" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true" data-modal-parent="#modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Akun Perkiraan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                                    <!-- <input type="text" class="no_akun" <?= $no ?>" value="<?= $value->akun ?>"></td> -->
                                    <input type="hidden" class="n_akun<?= $no ?>" value="<?= $value->nama ?>">
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Akun Perkiraan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
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
                                    <td align="right"><button type="button" class="btn btn-sm btn-primary chs_akun<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></button></td>
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
<?php $this->load->view('template/bundle/template_scripts'); ?>
<script>
    $(document).ready(function() {

        jQuery.validator.addMethod("noSpace", function(value, element) {
            return value.indexOf(" ") < 0 && value != "";
        }, "No space please and don't leave it empty");

        function validate(input) {
            if (/^\s/.test(input.value))
                input.value = '';
        }

    })

    $(function() {
        $('#add_bank').submit(function(e) {

            let akun = $('#akun').val();
            let no_hp = $('#telepon').val();
            if (akun.trim() == '') {
                Swal.fire('Daftar Perkiraan', 'Pilih Akun Perkiraan', 'warning');
                e.preventDefault();
                return false;
            } else if (no_hp.trim() == '' || !no_hp.match(/^0[0-9]{11,14}$/)) {
                $('#telepon').css({
                    'background': '#FFEDEF',
                    'boredr': 'solid 1px red'
                });
                Swal.fire('Telepon', 'Telepon Tidak Sesuai', 'warning');
                e.preventDefault();
                return false;
            } else {
                $('#telepon').css({
                    'background': '#99FF99',
                    'boredr ': 'solid 1px 99FF99'
                });

                console.log('keluar');
                Swal.fire('Sukses!', 'Bank Berhasil Ditambahkan', 'success');

                location.reload();
                return true;
            }

        })
    })

    function validatephone(telepon) {
        if (telepon == '' || !telepon.match(/^0[0-9]{11,14}$/)) {
            $('#telepon').css({
                'background': '#FFEDEF',
                'boredr': 'solid 1px red'
            });

        } else {
            $('#telepon').css({
                'background': '#99FF99',
                'boredr ': 'solid 1px 99FF99'
            });
            return true;
        }
        console.log()
    }
</script>