<style>
    .bt-sg {
        color: #28b779;
    }

    /* .activeA {
        font-weight: bold;
        background-color: #28b779;
        color: #fff;
    } */

    ul,
    #myUL {
        list-style-type: none;
    }

    #myUL {
        margin: 0;
        padding: 0;
    }

    .caret {
        cursor: pointer;
        -webkit-user-select: none;
        /* Safari 3.1+ */
        -moz-user-select: none;
        /* Firefox 2+ */
        -ms-user-select: none;
        /* IE 10+ */
        user-select: none;
    }

    .caret::before {
        content: "\25B6";
        color: black;
        display: inline-block;
        margin-right: 6px;
    }

    .caret-down::before {
        -ms-transform: rotate(90deg);
        /* IE 9 */
        -webkit-transform: rotate(90deg);
        /* Safari */
        transform: rotate(90deg);
    }

    .nested {
        display: none;
    }

    .activeB {
        display: block;
    }
</style>
<?php
foreach ($d_coa as $key => $value1) {
    echo '<input type="hidden" id="no_akun' . $key . '" value="' . $value1->akun . '">';
} ?>
<div class="container col-md-12 p-0">
    <div class="row row justify-content-md-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col mb-3" align="left">
                            <div class="btn-group justify-content-md-center" role="group" aria-label="Basic example">
                                <!-- <button type="button" class="btn btn-outline-info activeB" id="btnTable"><i class="fa fa-table"></i></button>
                                <button type="button" class="btn btn-outline-info" id="btnList"><i class="fa fa-list"></i></button> -->
                            </div>
                        </div>

                        <div class="col mb-3" align="right">
                            <button type="button" class="btn btn-success btn-sm btnTMBH" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-add">
                                <i class="fa fa-plus"></i> Tambah Perkiraan
                            </button>
                        </div>
                    </div>

                    <div class="col" id="viewList" style="display: none">
                        <ul id="myUL">
                            <?php
                            $g = 0;
                            foreach ($d_grup as $key => $value_g) {
                            ?>
                                <li><span class="caret"></span>
                                    <table class="table table-bordered" style="width:80%;">
                                        <?php
                                        ?>
                                        <thead>
                                            <th>#</th>
                                            <th>Nomor</th>
                                            <th>Nama Perkiraan</th>
                                            <th style="width:80px">*</th>
                                        </thead>

                                        <td style="width:30px"><strong>G</strong></td>
                                        <td style="width:90px"><?= $value_g->akun ?></td>
                                        <td><?= $value_g->nama ?></td>
                                        <!-- <td style="width:80px"><span class="badge badge-warning"><i class="fa fa-edit"></i></span><span class="badge badge-danger"><i class="fa fa-eraser"></i></span></td> -->
                                    </table>
                                    <ul class="nested">
                                        <?php
                                        foreach ($d_subgrup as $key1 => $value_sg) {
                                            if ($value_sg->subgrup == $value_g->nama) {
                                        ?>
                                                <li><span class="caret"></span>
                                                    <table class="table table-bordered" style="width:90%;">
                                                        <td style="width:50px"><strong>SG</strong></td>
                                                        <td style="width:135px"><?= $value_sg->akun ?></td>
                                                        <td><?= $value_sg->nama ?></td>
                                                        <!-- <td style="width:80px"><span class="badge badge-warning"><i class="fa fa-edit"></i></span><span class="badge badge-danger"><i class="fa fa-eraser"></i></span></td> -->
                                                    </table>
                                                    <ul class="nested">
                                                        <?php
                                                        foreach ($d_detailgrup as $key2 => $value_dg) {
                                                            if ($value_dg->detail == $value_sg->nama) {
                                                        ?>
                                                                <li>
                                                                    <table class="table table-bordered" style="width:100%;">
                                                                        <td style="width:50px"><strong>D</strong></td>
                                                                        <td style="width:130px"><?= $value_dg->akun ?></td>
                                                                        <td><?= $value_dg->nama ?></td>
                                                                        <!-- <td style="width:90px"><span class="badge badge-warning"><i class="fa fa-edit"></i></span><span class="badge badge-danger"><i class="fa fa-eraser"></i></span></td> -->
                                                                    </table>
                                                            <?php }
                                                        } ?>
                                                    </ul>
                                                </li>
                                        <?php }
                                        } ?>
                                    </ul>
                                </li>
                            <?php } ?>
                        </ul>
                        </li>
                        </ul>
                    </div>

                    <div class="table-responsive" id="viewTable">
                        <table id="zero_config" class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="60px">Opsi</th>
                                    <th width="70px">Nomor</th>
                                    <th>Nama Perkiraan</th>
                                    <th>Grup</th>
                                    <th>Sub Grup</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $s = 0;
                                foreach ($d_coa as $key => $value) {
                                ?>
                                    <tr>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-warning btn-xs btnED perkiraan edit<?= $s ?>" tabindex="1" role="dialog" aria-labelledby="myModalLabel" data-toggle="modal" data-target="#modal-edit" id="btn_edit" data-grup="<?= $value->grup ?>"><i class="fa fa-edit"></i></button>
                                                <button type="button" data-id="<?= $value->akun ?>" class="btn btn-danger btn-xs delete-btn"><i class="fa fa-eraser"></i></button>
                                                <!-- <a onclick="return confirm('Apakah anda ingin menghapus perkiraan ini?')" href="<?= base_url('Coa/hapus') ?>/<?= $value->akun ?>" class="btn btn-danger btn-xs delete-btn"><i class="fa fa-eraser"></i></a> -->
                                                <!-- <a href="<?= base_url('Coa/hapus') ?>/<?= $value->akun ?>" class="btn btn-danger btn-xs delete-btn"><i class="fa fa-eraser"></i></a> -->
                                            </div>
                                        </td>
                                        <td><?= $value->akun ?></td>
                                        <td><?= $value->nama ?></td>
                                        <td><?= $value->grup ?></td>
                                        <td><?= $value->subgrup ?></td>
                                        <td><?= $value->detail ?></td>
                                        <input type="hidden" class="akun<?= $s ?>" value="<?= $value->akun ?>">
                                        <input type="hidden" class="nama<?= $s ?>" value="<?= $value->nama ?>">
                                        <input type="hidden" class="link<?= $s ?>" value="<?= $value->link ?>">
                                        <input type="hidden" class="grup<?= $s ?>" value="<?= $value->grup ?>">
                                        <input type="hidden" class="subgrup<?= $s ?>" value="<?= $value->subgrup ?>">
                                        <input type="hidden" class="detail<?= $s ?>" value="<?= $value->detail ?>">
                                    </tr>
                                <?php $s++;
                                } ?>
                                <input type="text" class="sum_coa" value="<?= $s ?>" hidden>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ################################################################# -->
<div class="modal fade" id="modal-add">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Isi Data Perkiraan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-tambah" action="<?= site_url('coa/dosave') ?>" method="POST" data-parsley-validate>
                    <div class="col">
                        <div class="row col-md-12 form-group">
                            <label class="col-sm-4 text-left control-label col-form-label" for="">Grup Perkiraan<b class="text-danger"> *</b></label>
                            <div class="row col-md-12">
                                <button type="button" class="btn btn-outline-success col ml-1 mt-1 bt-sg btn01 perkiraan" style="min-width:170px; max-width:170px" id="grup" data-grup="AKTIVA" data-value="1" name="grup">1 AKTIVA</button>
                                <button type="button" class="btn btn-outline-success col ml-1 mt-1 bt-sg btn02 perkiraan" style="min-width:170px; max-width:170px" id="grup" data-grup="HUTANG" data-value="2" name="grup">2 HUTANG</button>
                                <button type="button" class="btn btn-outline-success col ml-1 mt-1 bt-sg btn03 perkiraan" style="min-width:170px; max-width:170px" id="grup" data-grup="MODAL" data-value="3" name="grup">3 MODAL</button>
                                <button type="button" class="btn btn-outline-success col ml-1 mt-1 bt-sg btn04 perkiraan" style="min-width:170px; max-width:170px" id="grup" data-grup="PENDAPATAN" data-value="4" name="grup">4 PENDAPATAN</button>
                                <button type="button" class="btn btn-outline-success col ml-1 mt-1 bt-sg btn06 perkiraan" style="min-width:170px; max-width:170px" id="grup" data-grup="BIAYA" data-value="5" name="grup">5 BIAYA</button>
                                <button type="button" class="btn btn-outline-success col ml-1 mt-1 bt-sg btn05 perkiraan" style="min-width:170px; max-width:170px" id="grup" data-grup="HPP" data-value="6" name="grup">6 HPP</button>
                                <button type="button" class="btn btn-outline-success col ml-1 mt-1 bt-sg btn07 perkiraan" style="min-width:170px; max-width:170px" id="grup" data-grup="PENDAPATAN LAIN" data-value="7" name="grup">7 PENDAPATAN LAIN</button>
                                <button type="button" class="btn btn-outline-success col ml-1 mt-1 bt-sg btn08 perkiraan" style="min-width:170px; max-width:170px" id="grup" data-grup="BIAYA LAIN" data-value="8" name="grup">8 BIAYA LAIN</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-sm-4 form-group">
                            <label class="col-sm text-left control-label col-form-label" for="">Nomor Akun<b class="text-danger"> *</b></label>
                            <div class="row col-sm-12">
                                <div class="row col-md-5">
                                    <input class="form-control" type="text" name="kode" id="kode_coa" value="1" readonly>
                                </div>
                                <div class="row col-md-9">
                                    <input class="form-control numeric" type="text" name="akun" placeholder="Nomor Akun" value="<?= @$detail->akun ?>" id="addNakun" required maxlength="3" data-parsley-errors-container="#error-nomorAkun">
                                </div>
                            </div>
                            <div id="error-nomorAkun"></div>
                        </div>

                        <div class="col col-sm-5 form-group">
                            <label class="col-sm text-left control-label col-form-label" for="">Nama Akun<b class="text-danger"> *</b></label>
                            <div class="row col-md-12">
                                <input class="form-control" type="text" name="nama" placeholder="Nama Akun" value="<?= @$detail->nama ?>" id="namaAkun" required>
                            </div>
                        </div>

                        <div class="col col-sm-3 form-group">
                            <label class="col-sm text-left control-label col-form-label" for="">Link</label>
                            <div class="row col-md-12">
                                <input class="form-control" type="text" name="link" placeholder="Link" value="<?= @$detail->link ?>" id="link" maxlength="4">
                            </div>
                        </div>

                        <div class="col col-sm-4 form-group">
                            <label name="" class="col-sm text-left control-label col-form-label" for="">Sub Grup<b class="text-danger"> *</b></label>
                            <div class="row col-md-12">
                                <div id="container-subgrup">
                                </div>
                            </div>
                        </div>

                        <div class="col col-sm-5 form-group">
                            <label class="col-sm text-left control-label col-form-label" for="">Detail<b class="text-danger"> *</b></label>
                            <div class="row col-md-12">
                                <input class="form-control" type="text" name="detail" placeholder="Detail" value="<?= @$detail->detail ?>" id="detail" required>
                            </div>
                        </div>
                        <input class="form-control" type="hidden" name="grup" id="kode_grup" value="AKTIVA" readonly>
                    </div>

                    <!-- <div class="form-group">
                        <label class="col-sm-4 text-left control-label col-form-label" for="">Tingkat Nomor Perkiraan<b class="text-danger"> *</b></label>
                        <div class="row col-lg-12">
                            <div class="btn-group justify-content-md-center" role="group" aria-label="Basic example" required>
                                <button type="button" class="btn btn-outline-success activeA btnG" style="min-width:120px">GRUP</button>
                                <button type="button" class="btn btn-outline-success btnSG" style="min-width:120px">SUB GRUP</button>
                                <button type="button" class="btn btn-outline-success btnD" style="min-width:120px">DETAIL</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col col-sm-4 form-group selG" style="display: none" id="">
                                <label name="" class="col-sm text-left control-label col-form-label" for="">Sub Grup<b class="text-danger"> *</b></label>
                                <div class="row col-md-12">
                                    <div id="container-subgrup">
                                    </div>
                                </div>
                            </div>

                            <div class="col col-sm-4 form-group selSG" style="display: none" id="">
                                <label class="col-sm text-left control-label col-form-label" for="">Detail<b class="text-danger"> *</b></label>
                                <div class="row col-md-12">
                                    <input class="form-control" type="text" name="detail" placeholder="Detail" value="<?= @$detail->detail ?>" id="detail" required>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <input type="hidden" name="act" value="insert">
                    <input type="hidden" name="id" value="<?= @$detail->akun ?>">
                    <button type="submit" class="btn btn-success btn-md col-md-12" value="simpan" id="submit"><i class="fa fa-save"></i> SIMPAN</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ################################################################# -->
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog" style="max-width: 62%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Edit Data Perkiraan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-edit" action="<?= site_url('Coa/dosave') ?>" method="POST" data-parsley-validate>
                    <div class="col">
                        <div class="row">
                            <div class="col col-sm-4 form-group">
                                <label class="col-sm text-left control-label col-form-label" for="">Nomor Akun<b class="text-danger"> *</b></label>
                                <div class="row col-sm-12">
                                    <input class="form-control e_akun" type="number" name="akun" value="<?= @$detail->akun ?>" id="" readonly required>
                                </div>
                            </div>

                            <div class="col col-sm-5 form-group">
                                <label class="col-sm text-left control-label col-form-label" for="">Nama Akun<b class="text-danger"> *</b></label>
                                <div class="row col-md-12">
                                    <input class="form-control e_nama" type="text" name="nama" value="<?= @$detail->nama ?>" id="namaAkun" required>
                                </div>
                            </div>

                            <div class="col col-sm-3 form-group">
                                <label class="col-sm text-left control-label col-form-label" for="">Link</label>
                                <div class="row col-md-12">
                                    <input class="form-control e_link" type="text" name="link" value="<?= @$detail->link ?>" id="link" maxlength="4">
                                </div>
                            </div>
                            <input class="form-control" type="hidden" name="grup" id="kode_grup" value="AKTIVA" readonly>
                        </div>

                        <div class="form-group">
                            <!-- <label class="col-sm-4 text-left control-label col-form-label" for="">Tingkat Nomor Perkiraan<b class="text-danger"> *</b></label> -->
                            <div class="row col-lg-12">
                                <div class="btn-group justify-content-md-center" role="group" aria-label="Basic example" required>
                                    <!-- <button type="button" class="btn btn-outline-success activeA btnG" style="min-width:120px">GRUP</button>
                                    <button type="button" class="btn btn-outline-success btnSG" style="min-width:120px">SUB GRUP</button>
                                    <button type="button" class="btn btn-outline-success btnD" style="min-width:120px">DETAIL</button> -->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col col-sm-4 form-group selG" style="display: none" id="">
                                    <label name="" class="col-sm text-left control-label col-form-label" for="">Sub Grup<b class="text-danger"> *</b></label>
                                    <div class="row col-md-12">
                                    <div id="container-subgrup-edit">
                                    </div>
                                </div>
                            </div>

                            <div class="col col-sm-4 form-group selSG" style="display: none" id="">
                                <label class="col-sm text-left control-label col-form-label" for="">Detail<b class="text-danger"> *</b></label>
                                <div class="row col-md-12">
                                    <input class="form-control e_detail" type="text" name="detail" value="<?= @$detail->detail ?>" id="detail" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <input type="hidden" name="act" value="edit">
                    <input type="hidden" name="id" value="<?= @$detail->akun ?>">
                    <input type="hidden" name="" class="e_subgrup">
                    <input type="hidden" name="" class="e_detail">
                    <button type="submit" class="btn btn-success btn-md col-md-12" value="simpan" id="submit"><i class="fa fa-save"></i> SIMPAN</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('template/bundle/template_scripts'); ?>