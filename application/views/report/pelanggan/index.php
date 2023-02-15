<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" width="100%">
                <thead class="">
                    <tr>
                        <th scope="col" style="width:5%">No</th>
                        <th scope="col" style="width:25%">Nama Laporan</th>
                        <th scope="col" style="width:10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td style="vertical-align:middle;">Laporan Daftar Pelanggan</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/pelanggan/daftar_pelanggan') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td style="vertical-align:middle;">Laporan Piutang Global</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/pelanggan/piutang_global') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td style="vertical-align:middle;">Laporan Piutang Detail</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/pelanggan/piutang_detail') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                    <!-- <tr>
                        <th scope="row">4</th>
                        <td style="vertical-align:middle;">Laporan Piutang Lunas</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/pelanggan/piutang_lunas') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">5</th>
                        <td style="vertical-align:middle;">Laporan Pembayaran Piutang</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/pelanggan/pembayaran_piutang') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr> -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="lap_daftar_pelanggan" class="modal fade" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Tanggal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="<?= site_url('laporan/neraca') ?>" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl" value="<?= date("Y-m-d") ?>" placeholder="Tanggal">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> Tutup</button>
                    <button class="btn btn-success"><span class="fa fa-print"></span> Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="lap_piu_global" class="modal fade" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Tanggal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="<?= site_url('laporan/rugilaba') ?>" target="_blank">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-xs-3">Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl" id="datepicker-rulab" value="<?= date("Y-m-d") ?>" placeholder="yyyy-mm-dd">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> Tutup</button>
                    <button class="btn btn-success"><span class="fa fa-print"></span> Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="lap_piu_detail" class="modal fade" data-backdrop-limit="1" tabindex="" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Bulan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="<?= site_url('laporan/rugilaba_bulanan') ?>" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Bulan</label>
                        <div class="col-xs-9">
                            <select name="bulan" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                <option>Pilih Bulan</option>
                                <?php foreach ($bulan_rulab as $key => $value) {

                                    $bulannya = strtotime($value->bulan_jurnal);
                                    $bln = date('F Y', $bulannya);
                                ?>
                                    <option value="<?php echo $value->bulan_jurnal; ?>"><?php echo $bln; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> Tutup</button>
                    <button class="btn btn-success"><span class="fa fa-print"></span> Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="lap_piu_lunas" class="modal fade" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Tanggal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="<?= site_url('laporan/bukubantu') ?>" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Dari Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_dari" id="datepicker-bukubantu1" value="<?= date("Y-m-d") ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <label class="control-label col-xs-3">Sampai Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_sampai" id="datepicker-bukubantu2" value="<?= date("Y-m-d") ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> Tutup</button>
                    <button class="btn btn-success"><span class="fa fa-print"></span> Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view('template/bundle/template_scripts'); ?>