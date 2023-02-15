<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col mb-3" align="right">
                <button class="btn btn-sm btn-primary px-2" id="export-excel">
                    <i class="fas fa-file-excel fa-fw mr-2"></i>
                    Export Excel
                </button>
                <a href="<?= site_url('kasbank/tambah') ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah Transaksi</a>

            </div>
        </div>
        <div class="text-center">
            <div class="d-flex justify-content-center">
                <div class="col-sm-6 col-md-6 form-group row">
                    <label class="col-4 col-sm-4 col-md-4 text-right control-label col-form-label">Bulan :</label>
                    <div class="col-8 col-sm-8 col-md-8 pr-0">
                        <select class="custom-select pr-0 range select2" id="bulanJ">
                            <?= $optionBulan ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 form-group row">
                    <label class="col-4 col-sm-4 col-md-4 text-right pl-0 control-label col-form-label">Tahun :</label>
                    <div class="col-8 col-sm-8 col-md-8">
                        <select class="custom-select range select2" id="tahunJ">
                            <?= $optionTahun ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="table" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th style="width: 15%;">Aksi</th>
                        <th style="width: 5px;">No</th>
                        <th>No Kasbank</th>
                        <th>Tanggal</th>
                        <th>Reff</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add">
    <div class="container">
        <!-- <form method="POST" id="formKasbank" action="<?= site_url('kasbank/dosave') ?>" target="_blank"> -->

        <div class="row mt-4">
            <div class="col-md-3">
                <div class="row">
                    <div class="card col-md-12 p-0">
                        <h5 class="text-white bg-success p-2">INFORMASI</h5>
                        <div class="card-body shadow" style="padding-top: 0px;">
                            <input type="hidden" class="form-control col-md-12" id="n_transaksi" value="<?= $n_kasmasuk ?>" name="n_transaksi" onkeypress="return false;">
                            <div class="row mt-2">
                                <label for="tgl_transaksi" class="col-sm-12 text-left control-label col-form-label">Tanggal <b class="text-danger">*</b></label>
                            </div>
                            <div class="row">
                                <div class="input-group">
                                    <input type="text" class="form-control col-md-12" name="tgl_transaksi" value="<?= $tanggal ?>" id="tgl_transaksi" readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <label for="reff" class="col-sm-12 text-left control-label col-form-label">Refferensi</label>
                            </div>
                            <div class="row">
                                <input type="text" class="form-control col-md-12" id="reff" value="-" name="reff">
                            </div>
                            <div class="row mt-2">
                                <label for="keterangan" class="col-sm-12 text-left control-label col-form-label">Keterangan <b class="text-danger">*</b></label>
                            </div>
                            <div class="row">
                                <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Catatan keterangan"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="card col-md-12 p-0">
                        <h5 class="text-white bg-success p-2 m-0 inf_trans">TRANSAKSI</h5>
                        <div class="card-body shadow">
                            <div class="row">
                                <label class="col-sm-12 text-left control-label col-form-label">Metode Transaksi</label>
                            </div>
                            <div class="row">
                                <div class="input-group col-md-12">
                                    <div class="btn-group justify-content-md-center" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-xs btn-success" id="kas" value="kas">KAS</button>
                                        <a href="#myModalBank" data-toggle="modal">
                                            <button type="button" class="btn btn-xs btn-default" id="bank" value="bank">BANK</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 justify-content-md-center">
                                    <input type="text" class="form-control bank" id="d_Bank" name="no_bank" value="" readonly required>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-12 text-left control-label col-form-label">Jenis Transaksi</label>
                            </div>
                            <div class="row">
                                <div class="input-group col-md-12">
                                    <div class="btn-group justify-content-md-center" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-xs btn-success" id="masuk">MASUK</button>
                                        <a href="#" data-toggle="modal">
                                            <button type="button" class="btn btn-xs btn-default" id="keluar">KELUAR</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="status" value="M" name="jenis">
                            <input type="hidden" id="bayar" value="KAS" name="bayar">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <h5 class="card-title m-b-0 p-2 text-light bg-success">DETAIL TRANSAKSI</h5>
                    <div class="card-body shadow p-0">
                        <div class="row">
                            <div class="table-responsive pl-3" style="overflow-y: scroll; height: 375px;">
                                <input type="hidden" name="jml_baris" id="jml_baris" value="0">
                                <table class="table" id="isi_detail">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width:25%">Akun</th>
                                            <th style="width:50%">Perkiraan</th>
                                            <th style="width:25%">Jumlah</th>
                                            <th>*</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="row0" class="dynamic-added">
                                            <td><input type="text" class="form-control akun" id="akun0" name="akun0" data-urut="0"></td>
                                            <td><input type="text" class="form-control nama0" id="nama0" name="nama0" data-urut="0"></td>
                                            <td><input type="text" class="form-control jumlah money" style="text-align: right;" name="jumlah0" id="jumlah0" data-urut="0" required></td>
                                            <td id="action0"></td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <div class="row mb-3 ml-2">
                            <div class="row col-xl-6 col-6">
                            </div>
                            <div class="row col-xl-2 col-2">

                            </div>
                            <div class="row col-xl-4 col-md-4 col-sm-4 bg-danger">
                                <label class="col-sm-7 col-6 col-md-5 control-label col-form-label pl-0 pr-0">
                                    <h6 class="text-light"><b><i>TOTAL :</i></b></h6>
                                </label>
                                <div class="col-sm-6 col-6 col-md-7">
                                    <input type="text" class="form-control text-right border-0 bg-danger text-light pl-0 pr-0" style="font-size:16px;" id="total" value="0,00" name="sum_bayar" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <!-- <a class="d-none" role="button" target="_blank" id="btn-cetak">Cetak</a> -->
                            </div>
                            <button type="button" class="form-control btn btn-success text-light mt-5 col-4 mb-3" id="simpan"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

<?php $this->load->view('template/bundle/template_scripts'); ?>