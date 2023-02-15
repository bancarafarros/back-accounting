<form action="<?= site_url('hutang/dosave') ?>" id="formhutang" method="POST" target="_blank" data-parsley-validate>
    <div class="card" style="min-height: 450px">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="">Pemasok / Suplier <?= $requiredLabel ?></label>
                        <div class="input-group">
                            <input type="text" class="form-control d_n_pemasok" placeholder="No. Pemasok | Nama Pemasok" name="" required data-parsley-errors-container="#akun-error">
                            <input type="hidden" class="form-control n_pemasok" name="n_pemasok" onkeypress="return false;" required >
                            <div class="input-group-append">
                                <a href="#myModalPemasok" data-toggle="modal">
                                    <button class="btn btn-success" type="button"><i class="fa fa-search"></i></button>
                                </a>
                            </div>
                        </div>
                        <div id="akun-error"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="">Batas Kredit yang di berikan Supplier</label>
                        <input class="form-control batas text-right" type="text" name="batas" value="" placeholder="0" id="batas" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="">Tanggal <b class="text-danger">*</b></label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="tanggal_transaksi" name="tanggal" value="<?= $tanggal ?>" readonly required>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="">Jatuh Tempo <?= $requiredLabel ?></label>
                    <div class="input-group">
                        <input type="text" class="form-control datepicker" name="tempo" id="tempo" value="<?= $tanggal ?>" required data-parsley-errors-container="#tempo-error">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                    <div id="tempo-error"></div>
                </div>
                <div class="col-md-12">
                    <label class="">Keterangan <?= $requiredLabel ?></label>
                    <div class="input-group">
                        <textarea class="form-control" placeholder="Keterangan" id="ketr" name="keterangan" required rows="2" data-parsley-errors-container="#keterangan-error"></textarea>
                    </div>
                    <div id="keterangan-error"></div>
                </div>
                <div class="col-md-6 mt-3">
                    <label class="">Cara Bayar <b class="text-danger">*</b></label>
                    <div class="input-group">
                        <div class="btn-group justify-content-md-center" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-success btn-sm" id="c_kas" value="kas">KAS</button>
                            <button type="button" class="btn btn-default btn-sm" id="c_bank" value="bank">BANK</button>
                            <input type="text" class="form-control bank" id="d_Bank" name="no_bank" value="" readonly>
                        </div>
                        <input type="hidden" name="c_bayar" id="c_bayar" value="kas">
                        <input type="hidden" name="akun_bank" id="d_akunBank" value="kas">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label class="">Jumlah Hutang <b class="text-danger">*</b></label>
                        <input class="form-control money text-right" type="text" placeholder="0.00" name="jumlah" id="jumlah" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        <input type="hidden" name="status" value="b">
                        <button type="submit" class="btn btn-success col-md-3" id="save" value="Simpan"><i class="fa fa-save"></i> SIMPAN & CETAK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="row justify-content-md-center">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-title m-b-0 p-2 text-light bg-success"> <i class="fab fa-cc-mastercard"></i> Kartu hutang</h5>
            <div class="card-body">
                <div class="table-responsive mt-3" id="TabelKartu">
                    <input type="hidden" name="no_pemasok" id="n_pemasok">
                    <table id="lookup" class="table text-nowrap lookup" style="max-height: 2px;">
                        <thead class="thead-dark">
                            <tr>
                                <th>Opsi</th>
                                <th>No Transaksi</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody id="show_kartu"></tbody>
                    </table>
                </div>
                <div class="row d-flex flex-row-reverse">
                    <div class="col-12"></div>
                    <input type="text" name="sum_sisa" class="form-control sum_sisa col-3 bg-success mr-3 text-white" value="0" style="text-align: right; border: 0px" onkeypress="return false;">
                    <label class="col-md-3 text-right control-label col-form-label" style="font-size:16px;">Sisa Hutang :</label>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ######################################################################## -->
<div id="myModalPemasok" class="modal fade" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Akun Pemasok</h4>
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
                                <th>Nama Pemasok</th>
                                <th>Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0;
                            foreach ($d_pemasok as $key => $value) { ?>
                                <tr>
                                    <td><?= $value->n_pemasok ?></td>
                                    <td><?= $value->nama ?></td>
                                    <input type="hidden" class="batas_kredit<?= $no ?>" value="<?= $value->batas ?>">
                                    <input type="hidden" class="no_pemasok<?= $no ?>" value="<?= $value->n_pemasok ?>">
                                    <input type="hidden" class="no_namapemasok<?= $no ?>" value="<?= $value->nama ?>">
                                    <td align="center">
                                        <a href="#" class="btn btn-success btn-xs chs chs_n_pemasok<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></a>
                                    </td>
                                </tr>
                            <?php $no++;
                            } ?>
                            <input type="hidden" class="sum_n_pemasok" value="<?= $no ?>">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
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
                                        <button type="button" class="btn btn-success btn-xs btnSelect chsBnk chs_bank<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></button>
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
<!-- ######################################################################## -->