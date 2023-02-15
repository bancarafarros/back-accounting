<div class="card shadow card-primary" style="min-height: 400px">
    <div class="card-body">
        <form action="<?= site_url('piutang/dosave') ?>" id="formpiutang" name="formpiutang" method="POST">
            <div class="row">
                <div class="col-md-6">
                    <label for="n_pelanggan">Pelanggan <b class="text-danger">*</b></label>
                    <div class="input-group">
                        <input type="text" class="form-control d_n_pelanggan col-9" name="n_pelanggan" id="n_pelanggan" readonly placeholder="No. Pelanggan | Nama Pelanggan" onkeypress="return false;">
                        <input type="hidden" class="form-control d_n_sales" name="n_sales" onkeypress="return false;" required>
                        <input type="hidden" class="form-control n_pelanggan" name="n_pelanggan" onkeypress="return false;" required>
                        <div class="input-group-append">
                            <a href="#myModalPelanggan" data-toggle="modal">
                                <button class="btn btn-success" type="button"><i class="fa fa-search"></i></button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="batas">Batas Kredit <b class="text-danger">*</b></label>
                    <div class="input-group">
                        <input class="form-control batas text-right" type="text" id="batas" name="batas" value="" placeholder="0" id="batas" readonly>
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                    <label for="tanggal">Tanggal <b class="text-danger">*</b></label>
                    <div class="input-group">
                        <input type="text" class="form-control col-9 tanggal" id="tanggal" name="tanggal" value="<?= date("Y-m-d") ?>" readonly required>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                    <label for="tempo">Jatuh Tempo <b class="text-danger">*</b></label>
                    <div class="input-group">
                        <input type="text" id="tempo" class="form-control datepicker jatuh_tempo" name="tempo" value="<?= date('Y-m-d') ?>" required>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <label for="ketr">Keterangan <b class="text-danger">*</b></label>
                    <div class="input-group">
                        <input class="form-control" type="text" placeholder="Keterangan" id="ketr" name="keterangan" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="text-left control-label col-form-label">Cara Bayar <b class="text-danger">*</b></label>
                    <div class="input-group">
                        <div class="btn-group justify-content-md-center" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-success btn-md" id="c_kas" value="kas">KAS</button>
                            <button type="button" class="btn btn-default btn-md" id="c_bank" value="bank">BANK</button>
                            <input type="text" class="form-control bank" id="d_Bank" name="no_bank" value="" readonly>
                        </div>
                        <input type="hidden" name="c_bayar" id="c_bayar" value="kas">
                        <input type="hidden" name="akun_bank" id="d_akunBank" value="kas">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="col-12 text-left control-label col-form-label">Jumlah Piutang <b class="text-danger">*</b></label>
                    <div class="input-group">
                        <input class="form-control money text-right" type="text" placeholder="0.00" name="jumlah" id="jumlah" required>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="d-flex justify-content-end">
                        <input type="hidden" name="status" value="b">
                        <button type="button" class="btn btn-success btn-md col-md-3" id="save" value="Simpan"><i class="fa fa-save"></i> SIMPAN & CETAK</button>
                    </div>
                </div>
            </div>
            <div class="row form-group">
            </div>
        </form>
    </div>
</div>
<div class="row justify-content-md-center">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-title m-b-0 p-2 text-light bg-success"> <i class="fab fa-cc-mastercard"></i> Kartu Piutang</h5>
            <div class="card-body">
                <div class="table-responsive mt-3" id="TabelKartu">
                    <input type="hidden" name="no_pelanggan" id="n_pelanggan">
                    <table id="lookup" class="table text-nowrap lookup" style="max-height: 2px;">
                        <thead class="thead-dark">
                            <tr>
                                <th>No Transaksi</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody id="show_kartu">

                        </tbody>
                    </table>
                </div>
                <div class="row mt-3 d-flex flex-row-reverse">
                    <div class="col-12"></div>
                    <input type="text" name="sum_sisa" class="form-control sum_sisa col-3 bg-success mr-3 text-white" value="0" style="text-align: right; border: 0px" onkeypress="return false;">
                    <label class="col-md-3 text-right control-label col-form-label" style="font-size:16px;">Sisa Piutang :</label>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ######################################################################## -->
<div id="myModalPelanggan" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true" data-modal-parent="#modal-add">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Pelanggan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" style=" max-height: calc(100vh - 150px); overflow-y: auto;">
                <div class="table-responsive">
                    <table id="lookup" class="table lookupMod" width="100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nomor</th>
                                <th>Nama Pelanggan</th>
                                <th>Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0;
                            foreach ($d_pelanggan as $key => $value) { ?>
                                <tr>
                                    <td><?= $value->n_pelanggan ?></td>
                                    <td><?= $value->nama ?></td>
                                    <input type="hidden" class="batas_kredit<?= $no ?>" value="<?= $value->batas ?>">
                                    <input type="hidden" class="n_sales<?= $no ?>" value="<?= $value->n_sales ?>">
                                    <input type="hidden" class="no_pelanggan<?= $no ?>" value="<?= $value->n_pelanggan ?>">
                                    <input type="hidden" class="no_namapelanggan<?= $no ?>" value="<?= $value->nama ?>">
                                    <td align="center">
                                        <a href="#" class="btn btn-success btn-sm chs chs_n_pelanggan<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></a>
                                    </td>
                                </tr>
                            <?php $no++;
                            } ?>
                            <input type="hidden" class="sum_n_pelanggan" value="<?= $no ?>">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ######################################################################## -->
<!-- ######################################################################## -->
<div id="myModalBank" class="modal" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Bank</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                    <table id="lookup" class="table lookupMod" width="100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nomor</th>
                                <th>Nama Bank</th>
                                <th>Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0;
                            foreach ($d_bank as $key => $value) { ?>
                                <tr>
                                    <td><?= $value->n_bank ?></td>
                                    <td><?= $value->nama ?></td>
                                    <input type="hidden" class="no_bank<?= $no ?>" value="<?= $value->n_bank ?>">
                                    <input type="hidden" class="nama_bank<?= $no ?>" value="<?= $value->nama ?>">
                                    <input type="hidden" class="akun_bank<?= $no ?>" value="<?= $value->akun ?>">
                                    <td align="center">
                                        <button type="button" class="btn btn-sm btn-success btnSelect chsBnk chs_bank<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></button>
                                    </td>
                                </tr>
                            <?php $no++;
                            } ?>
                            <input type="hidden" class="sum_bank" value="<?= $no ?>">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('template/bundle/template_scripts'); ?>