<form action="<?= site_url('piutang/do_pembayaran') ?>" method="POST" id="pembayaranP">
    <div class="container col-md-12 p-0">
        <div class="row row justify-content-md-center">
            <div class="col-md-12">
                <div class="card shadow card-success">
                    <div class="card-body">
                        <div class="row mb-3 form-group">
                            <div class="col-7">
                                <label for="n_pelanggan" class="text-left control-label col-form-label col-6 pl-0">Pelanggan: <b class="text-danger">*</b></label>
                                <div class="input-group">
                                    <input type="text" class="form-control Pelanggan col-3" name="pelanggan" value="" placeholder="Kode Pelanggan" readonly required>
                                    <input type="text" class="form-control d_n_pelanggan col-9 ml-1 mr-1" name="n_pelanggan" id="n_pelanggan" placeholder="Nama Pelanggan" required readonly>
                                    <input type="hidden" class="form-control d_n_sales" name="n_sales" value="" required>
                                    <div class="input-group-append">
                                        <a href="#myModalPelanggan" data-toggle="modal">
                                            <button class="btn btn-success" type="button"><i class="fa fa-search"></i></button>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-3 ml-auto">
                                <label for="tgl_transaksi" class="text-left control-label col-form-label col-12">Tanggal: <b class="text-danger">*</b></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="tgl_transaksi" name="tgl_transaksi" value="<?= date("Y-m-d") ?>" readonly required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row form-group mb-0">
                                <div class="table-responsive" style="overflow-y: scroll; height: 200px;">
                                    <table class="table">
                                        <thead class="bg-white" style="position: sticky; top: 0; display:block; z-index:2;">
                                            <tr>
                                                <th style="width:10%;">Kode</th>
                                                <th style="width:10%;">Tanggal</th>
                                                <th style="width:10%;">Keterangan</th>
                                                <th style="width:10%;">Jumlah Piutang</th>
                                                <th style="width:10%;">Jumlah bayar</th>
                                                <th style="width:10%;">Sisa Piutang</th>
                                            </tr>
                                        </thead>
                                        <tbody id="list_piutang" style="display:block;">
                                        </tbody>
                                    </table>
                                    <input type="hidden" name="j_piutang" id="sumJ_piutang" value="0">
                                </div>
                            </div>
                            <hr class="border">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan <b class="text-danger">*</b></label>
                                        <textarea class="form-control" rows="2" id="keterangan" placeholder="Catatan transaksi" name="keterangan" value=""></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1 form-group">
                                <div class="col-5 mt-3">
                                </div>
                                <div class="col-2 ml-auto">
                                    <label class=" text-right pr-0 pl-0 m-0"><b>Total Piutang</b></label>
                                    <input type="text" class="form-control text-right border-0 pl-0 pr-1 pt-1" name="total_piutang" value="0" id="totalP" style="font-size:16px;" readonly>
                                </div>
                                <div class="col-2">
                                    <label class=" text-right pr-0 pl-0 m-0"><b>Total Bayar</b></label>
                                    <input type="text" class="form-control text-right border-0 pl-0 pr-1 pt-1 bg-danger text-light" style="font-size:16px;" id="totalJ_bayar" name="sum_bayar" value="0" readonly>
                                </div>
                                <div class="col-2">
                                    <label class=" text-right pr-0 pl-0 m-0"><b>Sisa Piutang</b></label>
                                    <input type="text" class="form-control text-right border-0 pl-0 pr-1 pt-1" style="font-size:16px;" name="sisa_piutang" value="0" id="totalS_piutang" readonly>
                                </div>
                            </div>
                            <div class="row mb-4 form-group">
                                <div class="col-6">
                                    <div class="row ml-1">
                                        <label class="text-left control-label col-form-label p-0 m-0">Cara Bayar <b class="text-danger">*</b></label>
                                        <div class="input-group">
                                            <div class="btn-group justify-content-md-center" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-success btn-md" id="c_kas" value="kas">KAS</button>
                                                <a href="#myModalBank" data-toggle="modal">
                                                    <button type="button" class="btn btn-default btn-md" id="c_bank" value="bank">BANK</button>
                                                </a>
                                                <input type="text" class="form-control bank" id="d_Bank" name="no_bank" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ml-1">
                                        <input type="hidden" name="c_bayar" id="c_bayar" value="kas">
                                        <input type="hidden" name="akun_bank" id="d_akunBank" value="kas">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group mt-3">
                                        <button type="button" class="btn btn-md btn-success col-8 ml-auto p-2" id="save" value="SIMPAN & CETAK"><i class="fa fa-save"></i> SIMPAN & CETAK</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
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
                    <table id="" class="table lookup" width="100%">
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
                                    <input type="hidden" class="no_pelanggan<?= $no ?>" value="<?= $value->n_pelanggan ?>">
                                    <input type="hidden" class="no_namapelanggan<?= $no ?>" value="<?= $value->nama ?>">
                                    <input type="hidden" class="n_sales<?= $no ?>" value="<?= $value->n_sales ?>">
                                    <input type="hidden" class="batas_kredit<?= $no ?>" value="<?= $value->batas ?>">
                                    <td align="center">
                                        <a role="button" href="#" class="btn btn-success btn-sm chs chs_n_pelanggan<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></a>
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
<div id="myModalBank" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
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
                    <table id="lookup" class="table lookup" width="100%">
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
                                        <button type="button" class="btn btn-sm btn-success chsBnk chs_bank<?= $no ?>" data-dismiss="modal"><i class="fa fa-check"></i></button>
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