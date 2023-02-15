<form action="<?= site_url('Coa/penghubung_dosave') ?>" method="POST">
    <div class="row">
        <div class="container col-md-12">
            <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="btn btn-outline-success active" id="pills-bukubesar-tab" data-toggle="tab" href="#pills-bukubesar" role="tab" aria-controls="pills-bukubesar" aria-selected="true"><i class="m-r-5 fas fa-book"></i>Penghubung Kas & Rugilaba</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-success" id="pills-pembelian-tab" data-toggle="tab" href="#pills-pembelian" role="tab" aria-controls="pills-pembelian" aria-selected="false"><i class="m-r-5 fas fa-truck-loading"></i>Penghubung Pembelian</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-success" id="pills-penjualan-tab" data-toggle="tab" href="#pills-penjualan" role="tab" aria-controls="pills-penjualan" aria-selected="false"><i class="m-r-5 fas fa-shopping-cart"></i>Penghubung Penjualan</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <!-- TAB BUKU BESAR -->
                <div class="tab-pane fade show active" id="pills-bukubesar" role="tabpanel" aria-labelledby="pills-bukubesar-tab">
                    <div class="card shadow card-success col-9 p-0 m-auto">
                        <div class="card-body">
                            <div class="row col-md-12 justify-content-md-center">
                                <div class="col col-sm-12 form-group">
                                    <label class="col-sm text-left control-label col-form-label" for="">Kas</label>
                                    <div class="row col-md-12">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control d_akun col-sm-3" name="a_kas" value="<?= @$hubung_kas->akun ?>" onkeypress="return false;" required>
                                            <input type="text" class="form-control d_namaakun" name="n_kas" value="<?= @$hubung_kas->nama ?>" onkeypress="return false;">
                                            <div class="input-group-append col-sm-2">
                                                <a href="#myModal1" data-toggle="modal">
                                                    <button class="btn btn-outline-secondary s_akun" type="button" data-index="kas"><i class="fa fa-search"></i></button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12 justify-content-md-center">
                                <div class="col col-sm-12 form-group">
                                    <label class="col-sm text-left control-label col-form-label" for="">LABA / RUGI</label>
                                    <div class="row col-md-12">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control d_akun col-sm-3" name="a_rl" value="<?= @$hubung_rl->akun ?>" onkeypress="return false;" required>
                                            <input type="text" class="form-control d_namaakun" name="n_rl" value="<?= @$hubung_rl->nama ?>" onkeypress="return false;">
                                            <div class="input-group-append col-sm-2">
                                                <a href="#myModal1" data-toggle="modal">
                                                    <button class="btn btn-outline-secondary s_akun" type="button" data-index="rl"><i class="fa fa-search"></i></button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- TAB Pembelian -->
                <div class="tab-pane fade" id="pills-pembelian" role="tabpanel" aria-labelledby="pills-pembelian-tab">
                    <div class="card shadow card-success col-9 p-0 m-auto">
                        <div class="card-body">
                            <div class="row col-md-12 justify-content-md-center">
                                <div class="col col-sm-12 form-group">
                                    <label class="col-sm text-left control-label col-form-label" for="">UANG MUKA PEMBELIAN</label>
                                    <div class="row col-md-12">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control d_akun col-sm-3" name="a_umb" value="<?= @$hubung_umb->akun ?>" onkeypress="return false;" required>
                                            <input type="text" class="form-control d_namaakun" name="n_umb" value="<?= @$hubung_umb->nama ?>" onkeypress="return false;">
                                            <div class="input-group-append col-sm-2">
                                                <a href="#myModal1" data-toggle="modal">
                                                    <button class="btn btn-outline-secondary s_akun" type="button" data-index="umb"><i class="fa fa-search"></i></button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12 justify-content-md-center">
                                <div class="col col-sm-12 form-group">
                                    <label class="col-sm text-left control-label col-form-label" for="">BIAYA PEMBELIAN</label>
                                    <div class="row col-md-12">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control d_akun col-sm-3" name="a_bkb" value="<?= @$hubung_bkb->akun ?>" onkeypress="return false;" required>
                                            <input type="text" class="form-control d_namaakun" name="n_bkb" value="<?= @$hubung_bkb->nama ?>" onkeypress="return false;">
                                            <div class="input-group-append col-sm-2">
                                                <a href="#myModal1" data-toggle="modal">
                                                    <button class="btn btn-outline-secondary s_akun" type="button" data-index="bkb"><i class="fa fa-search"></i></button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12 justify-content-md-center">
                                <div class="col col-sm-12 form-group">
                                    <label class="col-sm text-left control-label col-form-label" for="">PAJAK PEMBELIAN</label>
                                    <div class="row col-md-12">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control d_akun col-sm-3" name="a_pb" value="<?= @$hubung_pb->akun ?>" onkeypress="return false;" required>
                                            <input type="text" class="form-control d_namaakun" name="n_pb" value="<?= @$hubung_pb->nama ?>" onkeypress="return false;">
                                            <div class="input-group-append col-sm-2">
                                                <a href="#myModal1" data-toggle="modal">
                                                    <button class="btn btn-outline-secondary s_akun" type="button" data-index="pb"><i class="fa fa-search"></i></button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12 justify-content-md-center">
                                <div class="col col-sm-12 form-group">
                                    <label class="col-sm text-left control-label col-form-label" for="">DISKON PEMBELIAN</label>
                                    <div class="row col-md-12">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control d_akun col-sm-3" name="a_dsp" value="<?= @$hubung_dsp->akun ?>" onkeypress="return false;" required>
                                            <input type="text" class="form-control d_namaakun" name="n_dsp" value="<?= @$hubung_dsp->nama ?>" onkeypress="return false;">
                                            <div class="input-group-append col-sm-2">
                                                <a href="#myModal1" data-toggle="modal">
                                                    <button class="btn btn-outline-secondary s_akun" type="button" data-index="dsp"><i class="fa fa-search"></i></button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- TAB penjualan -->
                <div class="tab-pane fade" id="pills-penjualan" role="tabpanel" aria-labelledby="pills-penjualan-tab">
                    <div class="card shadow card-success col-9 p-0 m-auto">
                        <div class="card-body">
                            <div class="row col-md-12 justify-content-md-center">
                                <div class="col col-sm-12 form-group">
                                    <label class="col-sm text-left control-label col-form-label" for="">UANG MUKA PENJUALAN</label>
                                    <div class="row col-md-12">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control d_akun col-sm-3" name="a_umj" value="<?= @$hubung_umj->akun ?>" onkeypress="return false;" required>
                                            <input type="text" class="form-control d_namaakun" name="n_umj" value="<?= @$hubung_umj->nama ?>" onkeypress="return false;">
                                            <div class="input-group-append col-sm-2">
                                                <a href="#myModal1" data-toggle="modal">
                                                    <button class="btn btn-outline-secondary s_akun" type="button" data-index="umj"><i class="fa fa-search"></i></button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12 justify-content-md-center">
                                <div class="col col-sm-12 form-group">
                                    <label class="col-sm text-left control-label col-form-label" for="">BIAYA PENJUALAN</label>
                                    <div class="row col-md-12">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control d_akun col-sm-3" name="a_bkj" value="<?= @$hubung_bkj->akun ?>" onkeypress="return false;" required>
                                            <input type="text" class="form-control d_namaakun" name="n_bkj" value="<?= @$hubung_bkj->nama ?>" onkeypress="return false;">
                                            <div class="input-group-append col-sm-2">
                                                <a href="#myModal1" data-toggle="modal">
                                                    <button class="btn btn-outline-secondary s_akun" type="button" data-index="bkj"><i class="fa fa-search"></i></button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12 justify-content-md-center">
                                <div class="col col-sm-12 form-group">
                                    <label class="col-sm text-left control-label col-form-label" for="">PAJAK PENJUALAN</label>
                                    <div class="row col-md-12">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control d_akun col-sm-3" name="a_pj" value="<?= @$hubung_pj->akun ?>" onkeypress="return false;" required>
                                            <input type="text" class="form-control d_namaakun" name="n_pj" value="<?= @$hubung_pj->nama ?>" onkeypress="return false;">
                                            <div class="input-group-append col-sm-2">
                                                <a href="#myModal1" data-toggle="modal">
                                                    <button class="btn btn-outline-secondary s_akun" type="button" data-index="pj"><i class="fa fa-search"></i></button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12 justify-content-md-center">
                                <div class="col col-sm-12 form-group">
                                    <label class="col-sm text-left control-label col-form-label" for="">DISKON PENJUALAN</label>
                                    <div class="row col-md-12">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control d_akun col-sm-3" name="a_dsk" value="<?= @$hubung_dsk->akun ?>" onkeypress="return false;" required>
                                            <input type="text" class="form-control d_namaakun" name="n_dsk" value="<?= @$hubung_dsk->nama ?>" onkeypress="return false;">
                                            <div class="input-group-append col-sm-2">
                                                <a href="#myModal1" data-toggle="modal">
                                                    <button class="btn btn-outline-secondary s_akun" type="button" data_index="dsk"><i class="fa fa-search"></i></button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row col-md-12 ml-1 mb-5 justify-content-md-center">
            <button class="btn btn-success col-9"><i class="fa fa-save"></i> SIMPAN</button>
        </div>
    </div>
</form>

<div id="myModal1" class="modal" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true" data-modal-parent="#modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Akun Perkiraan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="hidden" name="" id="indexData">
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