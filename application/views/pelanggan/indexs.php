<div class="row">
    <div class="col-md-12 justify-content-md-center">
        <div class="card card-primary shadow">
            <div class="card-body">
                <div class="col mb-3" align="right">
                    <button type="button" class="btn btn-success btn-md" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-add">
                        <i class="fa fa-plus"></i> Tambah Pelanggan
                    </button>
                </div>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-hover table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th width="50px">Nomor</th>
                                <th>Nama Pelanggan</th>
                                <th>Alamat</th>
                                <th width="90px">Telepon</th>
                                <th width="60px">Aksi</th>
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

                                    <td>
                                        <a href="" class="badge badge-warning edit<?= $s ?>" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-edit"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="badge badge-danger delete-btn text-light" data-id="<?= $value->n_pelanggan ?>"><i class="fa fa-eraser"></i></a>
                                    </td>
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
    </div>
</div>
</section>
<!-- ######################################################################### -->
<div class="modal fade" id="modal-add">
    <div class="modal-dialog" style="max-width: 60%; min-width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Isi Data Pelanggan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('Pelanggan/dosave') ?>" method="POST">
                    <div class="form-group m-1">
                        <label class="col-6 col-sm-6 col-md-6 p-0">Tgl. Registrasi</label>
                        <label class="col-6 col-sm-4 col-md-4 p-0"></label>
                    </div>
                    <div class="form-group form-row mb-1">
                        <div class="input-group col-12 col-sm-12 col-md-6 p-1">
                            <input type="text" class="form-control" name="tanggal" value="<?= date("d-M-Y") ?>" id="datepicker-autoclose1" readonly required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="input-group col-12 col-sm-12 col-md-6 p-1">
                            <div class="alert alert-warning alert-dismissible fade show mb-0" role="alert" style="padding-top: 8px;  padding-bottom: 0px;" id="">
                                Nomor terakhir <strong><?= @$pelangganLast->n_pelanggan ?></strong>
                                <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button> -->
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-0">
                        <label class="col-12 col-sm-12 col-md-12 p-0">Akun Perkiraan</label>
                    </div>
                    <div class="form-group form-row mb-2">
                        <div class="input-group col-12 col-sm-12 col-md-12 p-1">
                            <input type="text" class="form-control d_akun col-sm-3" value="" name="akun" onkeypress="return false;" required>
                            <input type="text" class="form-control d_namaakun" value="" onkeypress="return false;" name="namaakun">
                            <div class="input-group-append col-sm-2">
                                <a href="#myModal1" data-toggle="modal">
                                    <button class="btn btn-outline-secondary" type="button"><i class="fa fa-search"></i></button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-0">
                        <label class="col-4 col-sm-4 col-md-4 p-0">Nomor Pelanggan</label>
                        <label class="col-8 col-sm-6 col-md-6 p-0">Nama Pelanggan</label>
                    </div>
                    <div class="form-group form-row mb-2">
                        <div class="input-group col-11 col-sm-12 col-md-4 p-1">
                            <input class="form-control" type="text" name="n_pelanggan" value="<?= @$detail->n_pelanggan ?>" maxlength="12" id="" required>
                        </div>
                        <div class="input-group col-11 col-sm-12 col-md-8 p-1">
                            <input class="form-control" type="text" name="nama" value="<?= @$detail->nama ?>" maxlength="50" id="" required>
                        </div>
                    </div>
                    <div class="form-group m-0">
                        <label class="col-4 col-sm-4 col-md-4 p-0">Barcode</label>
                        <label class="col-4 col-sm-4 col-md-4 p-0">Batas Kredit</label>
                        <label class="col-4 col-sm-3 col-md-3 p-0">Password</label>
                    </div>
                    <div class="form-group form-row mb-2">
                        <div class="input-group col-11 col-sm-4 col-md-4 p-1">
                            <input class="form-control" type="text" name="barcode" value="<?= @$detail->barcode ?>" maxlength="15" id="">
                        </div>
                        <div class="input-group col-11 col-sm-4 col-md-4 p-1">
                            <input class="form-control money" type="text" name="batas" value="<?= @$detail->batas ?>" id="" required>
                        </div>
                        <div class="input-group col-11 col-sm-4 col-md-4 p-1">
                            <input class="form-control col-md-9 pass" type="password" name="pass" value="<?= @$detail->pass ?>" maxlength="12" id=""><br>
                            <a href="#" class="badge badge-info visible"><i class="fa fa-eye-slash"></i></a>
                        </div>
                    </div>
                    <div class="form-group m-0">
                        <label class="col-12 col-sm-12 col-md-12 p-0">Alamat</label>
                    </div>
                    <div class="form-group form-row mb-3">
                        <div class="input-group col-11 col-sm-12 col-md-12 p-1">
                            <input class="form-control" type="text" name="alamat" value="<?= @$detail->alamat ?>" maxlength="50" id="">
                        </div>
                    </div>
                    <div class="form-group m-0">
                        <label class="col-4 col-sm-4 col-md-4 p-0">Telepon</label>
                        <label class="col-4 col-sm-4 col-md-4 p-0">Email</label>
                        <label class="col-4 col-sm-3 col-md-3 p-0">Salesman</label>
                    </div>
                    <div class="form-group form-row mb-3">
                        <div class="input-group col-11 col-sm-4 col-md-4 p-1">
                            <input class="form-control" type="text" name="telepon" value="<?= @$detail->telepon ?>" maxlength="15" id="">
                        </div>
                        <div class="input-group col-11 col-sm-4 col-md-4 p-1">
                            <input class="form-control" type="text" name="email" value="<?= @$detail->email ?>" maxlength="25" id="">
                        </div>
                        <div class="input-group col-11 col-sm-4 col-md-4 p-1">
                            <select name="n_sales" class="form-control">
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
                    <input type="hidden" name="act" value="insert">
                    <input type="hidden" name="id" value="<?= @$detail->n_pelanggan ?>">
                    <button type="submit" class="btn btn-primary btn-md col-md-12 simpan" value="simpan">SIMPAN</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ######################################################################### -->
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog" style="max-width: 60%; min-width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Edit Data Pelanggan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="<?= site_url('Pelanggan/dosave') ?>" method="POST">
                    <div class="form-group m-0">
                        <label class="col-6 col-sm-6 col-md-6 p-0">Tgl. Registrasi</label>
                        <label class="col-6 col-sm-4 col-md-4 p-0"></label>
                    </div>
                    <div class="form-group form-row mb-1">
                        <div class="input-group col-12 col-sm-12 col-md-6 p-1">
                            <input type="text" class="form-control e_tanggal" name="tanggal" value="<?= @$detail->tanggal ?>" id="datepicker-autoclose2" required readonly>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="input-group col-12 col-sm-12 col-md-6 p-1">
                            <div class="btn-group justify-content-md-center" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-success" style="min-width:80px; max-width:80px" id="aktif">AKTIF</button>
                                <button type="button" class="btn btn-secondary" style="min-width:110px; max-width:110px" id="taktif">TIDAK AKTIF</button>
                            </div>
                            <input type="text" class="status" name="status" hidden>
                        </div>
                    </div>
                    <div class="form-group m-0">
                        <label class="col-12 col-sm-12 col-md-12 p-0">Akun Perkiraan</label>
                    </div>
                    <div class="form-group form-row mb-2">
                        <div class="input-group col-12 col-sm-12 col-md-12 p-1">
                            <input type="text" class="form-control d_akun col-sm-3 e_akun" name="akun" onkeypress="return false;" required>
                            <input type="text" class="form-control d_namaakun e_n_akun" value="<?= @$detail->n_akun ?>" onkeypress="return false;" name="namaakun">
                            <div class="input-group-append col-sm-2">
                                <a href="#myModal1" data-toggle="modal">
                                    <button class="btn btn-outline-secondary" type="button"><i class="fa fa-search"></i></button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-0">
                        <label class="col-4 col-sm-4 col-md-4 p-0">Nomor Pelanggan</label>
                        <label class="col-8 col-sm-6 col-md-6 p-0">Nama Pelanggan</label>
                    </div>
                    <div class="form-group form-row mb-2">
                        <div class="input-group col-11 col-sm-12 col-md-4 p-1">
                            <input class="form-control e_n_pelanggan" type="text" name="n_pelanggan" value="<?= @$detail->n_pelanggan ?>" maxlength="12" id="" required readonly>
                        </div>
                        <div class="input-group col-11 col-sm-12 col-md-8 p-1">
                            <input class="form-control e_nama" type="text" name="nama" value="<?= @$detail->nama ?>" maxlength="50" id="" required>
                        </div>
                    </div>
                    <div class="form-group m-0">
                        <label class="col-4 col-sm-4 col-md-4 p-0">Barcode</label>
                        <label class="col-4 col-sm-4 col-md-4 p-0">Batas Kredit</label>
                        <label class="col-4 col-sm-3 col-md-3 p-0">Password</label>
                    </div>
                    <div class="form-group form-row mb-2">
                        <div class="input-group col-11 col-sm-4 col-md-4 p-1">
                            <input class="form-control e_barcode" type="text" name="barcode" value="<?= @$detail->barcode ?>" maxlength="15" id="">
                        </div>
                        <div class="input-group col-11 col-sm-4 col-md-4 p-1">
                            <input class="form-control e_batas money-edit" type="text" name="batas" value="<?= @$detail->batas ?>" id="" required>
                        </div>
                        <div class="input-group col-11 col-sm-4 col-md-4 p-1">
                            <input class="col-md-10 form-control e_pass pass" type="password" name="pass" value="<?= @$detail->pass ?>" maxlength="12" id=""><br>
                            <a href="#" class="badge badge-info visible"><i class="fa fa-eye-slash"></i></a>
                        </div>
                    </div>
                    <div class="form-group m-0">
                        <label class="col-12 col-sm-12 col-md-12 p-0">Alamat</label>
                    </div>
                    <div class="form-group form-row mb-3">
                        <div class="input-group col-11 col-sm-12 col-md-12 p-1">
                            <input class="form-control e_alamat" type="text" name="alamat" value="<?= @$detail->alamat ?>" maxlength="50" id="">
                        </div>
                    </div>
                    <div class="form-group m-0">
                        <label class="col-4 col-sm-4 col-md-4 p-0">Telepon</label>
                        <label class="col-4 col-sm-4 col-md-4 p-0">E-mail</label>
                        <label class="col-4 col-sm-3 col-md-3 p-0">Salesman</label>
                    </div>
                    <div class="form-group form-row mb-3">
                        <div class="input-group col-11 col-sm-4 col-md-4 p-1">
                            <input class="form-control e_telepon" type="text" name="telepon" value="<?= @$detail->telepon ?>" maxlength="15" id="">
                        </div>
                        <div class="input-group col-11 col-sm-4 col-md-4 p-1">
                            <input class="form-control e_email" type="text" name="email" value="<?= @$detail->email ?>" maxlength="25" id="">
                        </div>
                        <div class="input-group col-11 col-sm-4 col-md-4 p-1">
                            <select name="n_sales" class="form-control e_n_sales">
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

                    <input type="hidden" name="act" value="edit">
                    <input type="hidden" name="id" value="<?= @$detail->n_pelanggan ?>">
                    <button type="submit" class="btn btn-warning btn-md col-md-12 edit" value="simpan">UPDATE</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ############################################################################ -->
<div id="myModal1" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true" data-modal-parent="#modal-add">
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

<script>
    $(".money").on("click", function() {
        $(this).select();
    });
    $(".money-edit").on("click", function() {
        $(this).select();
    });
    $(".money").autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        aSign: 'Rp '
    });
    $(".money-edit").autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        aSign: 'Rp '
    });
    $(document).ready(function() {
        for (let s = 0; s < $(".sum_akun").val(); s++) {
            $(".chs_akun" + s).click(function() {
                $(".d_akun").val($('.no_akun' + s).val());
                $(".d_namaakun").val($('.no_namaakun' + s).val());
                $(".e_tanggal").val($('.tanggal' + a).val());
            });
        }

        number_format = function(number, decimals, dec_point, thousands_sep) {
            number = number.toFixed(decimals);
            var nstr = number.toString();
            nstr += '';
            x = nstr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? dec_point + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1))
                x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');
            return x1 + x2;
        }

        for (let a = 0; a < $(".sum_pelanggan").val(); a++) {
            $(".edit" + a).click(function() {
                $(".e_n_pelanggan").val($('.n_pelanggan' + a).val());
                $(".e_barcode").val($('.barcode' + a).val());
                $(".e_pass").val($('.pass' + a).val());
                $(".e_tanggal").val($('.tanggal' + a).val());
                $(".e_akun").val($('.akun' + a).val());
                $(".e_n_akun").val($('.n_akun' + a).val());
                $(".e_nama").val($('.nama' + a).val());
                $(".e_alamat").val($('.alamat' + a).val());
                $(".e_telepon").val($('.telepon' + a).val());
                $(".e_email").val($('.email' + a).val());
                var batas = parseFloat($('.batas' + a).val());
                $(".e_batas").val('Rp ' + number_format(batas, 2, ".", ","));
                $(".e_n_sales").val($('.n_sales' + a).val());
                if ($('.status' + a).val() == "a") {
                    $("#taktif").removeClass('btn-danger');
                    $("#taktif").addClass('btn-secondary');
                    $("#aktif").removeClass('btn-secondary');
                    $("#aktif").addClass('btn-success');
                    $(".status").val("a");
                }
                if ($('.status' + a).val() == "ta") {
                    $("#aktif").removeClass('btn-success');
                    $("#aktif").addClass('btn-secondary');
                    $("#taktif").removeClass('btn-secondary');
                    $("#taktif").addClass('btn-danger');
                    $(".status").val("t");
                }
            });
        }
    });
</script>

<script>
    $(document).ready(function() {
        $(".simpan").click(function() {
            var value = $(".money").val().replace("Rp ", "");
            var value = value.replace(/,/g, "");
            $(".money").val(value);
        });
        $(".edit").click(function() {
            var value = $(".money-edit").val().replace("Rp ", "");
            var value = value.replace(/,/g, "");
            $(".money-edit").val(value);
        });
        $('#lookup').DataTable({
            "paging": false,
            "search": true,
            "responsive": true
        });
        $('#lookup_filter input').focus()
        //$('#lookup_filter [type="search"]').focus()
        $('#lookup-edit').DataTable({
            "paging": false,
            "search": true,
            "responsive": true
        });
        $('#lookup_filter input').focus()

        $("#aktif").click(function() {
            $("#taktif").removeClass('btn-danger');
            $("#taktif").addClass('btn-secondary');
            $(this).removeClass('btn-secondary');
            $(this).addClass('btn-success');
            $(".status").val("a");
        });
        $("#taktif").click(function() {
            $("#aktif").removeClass('btn-success');
            $("#aktif").addClass('btn-secondary');
            $(this).removeClass('btn-secondary');
            $(this).addClass('btn-danger');
            $(".status").val("t");
        });
        $(".visible").click(function() {
            var type = $('.pass').attr("type");
            // now test it's value
            if (type === 'password') {
                $('.pass').attr("type", "text");
            } else {
                $('.pass').attr("type", "password");
            }
        });
    });

    $('.delete-btn').on('click', function() {
        if (confirm('Apakah anda ingin menghapus data pelanggan ini?')) {
            location.href = "<?= site_url('pelanggan/hapus/') ?>" + $(this).data('id');
        }
    });

    $('#nAktif').click(function() {
        var table = $('#TabelNaktif').DataTable();
        $.getJSON("<?= site_url('Pelanggan/getPelangganNaktif') ?>", function(json) {
            // console.log(json);
            for (i = 0; i < json.length; i++) {
                table.clear().draw();
                table.row.add([json[i].n_pelanggan, json[i].nama, '<button type="button" class="btn btn-sm btn-warning aktifPelanggan" data-index="' + json[i].n_pelanggan + '"><i class="fa fa-check"></i></button>']).draw();
            }
        });
    })
    $(document).on('click keypress', '.aktifPelanggan', function(e) {
        if (confirm('Apakah anda ingin mengaktifkan kembali pelanggan ini?')) {
            location.href = "<?= site_url('pelanggan/aktifPelanggan/') ?>" + $(this).data('index');
        }
    })
</script>