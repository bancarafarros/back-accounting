<div class="card">
    <div class="card-body">
        <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-bukubesar-tab" data-toggle="pill" href="#pills-bukubesar" role="tab" aria-controls="pills-bukubesar" aria-selected="true"><i class="m-r-5 fa fa-book"></i>Buku Besar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-penjualan-tab" data-toggle="pill" href="#pills-penjualan" role="tab" aria-controls="pills-penjualan" aria-selected="false"><i class="m-r-5 fa fa-shopping-cart"></i>Penjualan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-pembelian-tab" data-toggle="pill" href="#pills-pembelian" role="tab" aria-controls="pills-pembelian" aria-selected="false"><i class="m-r-5 fa fa-truck-loading"></i>Pembelian</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-pelanggan-tab" data-toggle="pill" href="#pills-pelanggan" role="tab" aria-controls="pills-pelanggan" aria-selected="false"><i class="m-r-5 fa fa-users"></i>Pelanggan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-pemasok-tab" data-toggle="pill" href="#pills-pemasok" role="tab" aria-controls="pills-pemasok" aria-selected="false"><i class="m-r-5 fa fa-user"></i>Pemasok</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-persediaan-tab" data-toggle="pill" href="#pills-persediaan" role="tab" aria-controls="pills-persediaan" aria-selected="false"><i class="m-r-5 fa fa-cube"></i>Persediaan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-kasbank-tab" data-toggle="pill" href="#pills-kasbank" role="tab" aria-controls="pills-kasbank" aria-selected="false"><i class="m-r-5 fa fa-money-bill-alt"></i>Kas dan Bank</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <!-- TAB BUKU BESAR -->
            <div class="tab-pane fade show active" id="pills-bukubesar" role="tabpanel" aria-labelledby="pills-bukubesar-tab">
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
                                <td style="vertical-align:middle;">Laporan Neraca</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="#lap_neraca" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td style="vertical-align:middle;">Laporan Rugi Laba Tahunan</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="#lap_rulab" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td style="vertical-align:middle;">Laporan Rugi Laba Bulanan</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="#lap_rulab_bulanan" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td style="vertical-align:middle;">Laporan Buku Bantu Seluruh Perkiraan</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="#lap_bukubantu" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">5</th>
                                <td style="vertical-align:middle;">Laporan Buku Bantu Tiap Perkiraan</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="#lap_bukubantu_perkiraan" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- TAB PENJUALAN -->
            <div class="tab-pane fade" id="pills-penjualan" role="tabpanel" aria-labelledby="pills-penjualan-tab">
                <div class="table-responsive">
                    <table class="table table-hover" width="100%">
                        <thead>
                            <tr>
                                <th style="width:5%">No</th>
                                <th style="width:25%">Nama Laporan</th>
                                <th style="width:10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td style="vertical-align:middle;">Laporan Penjualan Harian</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="#lap_penjualan_harian" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td style="vertical-align:middle;">Laporan Penjualan per Pelanggan</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="#lap_penjualan_perpelanggan" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td style="vertical-align:middle;">Laporan Penjualan per Pelanggan dengan Detail</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="#lap_penjualan_pelanggan" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td style="vertical-align:middle;">Laporan Best Buy</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="#lap_bestbuy" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- TAB PEMBELIAN -->
            <div class="tab-pane fade" id="pills-pembelian" role="tabpanel" aria-labelledby="pills-pembelian-tab">
                <div class="table-responsive">
                    <table class="table table-hover" width="100%">
                        <thead>
                            <tr>
                                <th style="width:5%">No</th>
                                <th style="width:25%">Nama Laporan</th>
                                <th style="width:10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td style="vertical-align:middle;">Laporan Pembelian Harian</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="#lap_pembelian_harian" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td style="vertical-align:middle;">Laporan Pembelian per Pemasok</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="#lap_pembelian_perpemasok" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td style="vertical-align:middle;">Laporan Pembelian per Pemasok dengan Detail</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="#lap_pembelian_pemasok" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td style="vertical-align:middle;">Laporan Barang Masuk</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="#lap_barangmasuk" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- TAB PELANGGAN -->
            <div class="tab-pane fade" id="pills-pelanggan" role="tabpanel" aria-labelledby="pills-pelanggan-tab">
                <div class="table-responsive">
                    <table class="table table-hover" width="100%">
                        <thead>
                            <tr>
                                <th style="width:5%">No</th>
                                <th style="width:25%">Nama Laporan</th>
                                <th style="width:10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td style="vertical-align:middle;">Laporan Daftar Pelanggan</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="<?= site_url('laporan/daftar_pelanggan') ?>" target="_blank"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td style="vertical-align:middle;">Laporan Piutang Global</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="<?= site_url('laporan/piutang_global') ?>" target="_blank"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td style="vertical-align:middle;">Laporan Piutang Detail</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="<?= site_url('laporan/piutang_detail') ?>" target="_blank"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- TAB PEMASOK -->
            <div class="tab-pane fade" id="pills-pemasok" role="tabpanel" aria-labelledby="pills-pemasok-tab">
                <div class="table-responsive">
                    <table class="table table-hover" width="100%">
                        <thead>
                            <tr>
                                <th style="width:5%">No</th>
                                <th style="width:25%">Nama Laporan</th>
                                <th style="width:10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td style="vertical-align:middle;">Laporan Daftar Pemasok</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="<?= site_url('laporan/daftar_pemasok') ?>" target="_blank"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td style="vertical-align:middle;">Laporan Hutang Global</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="<?= site_url('laporan/hutang_global') ?>" target="_blank"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td style="vertical-align:middle;">Laporan Hutang Detail</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="<?= site_url('laporan/hutang_detail') ?>" target="_blank"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- TAB PERSEDIAAN -->
            <div class="tab-pane fade" id="pills-persediaan" role="tabpanel" aria-labelledby="pills-persediaan-tab">
                <div class="table-responsive">
                    <table class="table table-hover" width="100%">
                        <thead>
                            <tr>
                                <th style="width:5%">No</th>
                                <th style="width:25%">Nama Laporan</th>
                                <th style="width:10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td style="vertical-align:middle;">Laporan Daftar Barang</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="<?= site_url('laporan/daftar_barang') ?>" target="_blank"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td style="vertical-align:middle;">Laporan Persediaan Barang</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="<?= site_url('laporan/persediaan_barang') ?>" target="_blank"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td style="vertical-align:middle;">Laporan Perbandingan Harga</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="<?= site_url('laporan/perbandingan_harga') ?>" target="_blank"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- TAB KASBANK -->
            <div class="tab-pane fade" id="pills-kasbank" role="tabpanel" aria-labelledby="pills-kasbank-tab">
                <div class="table-responsive">
                    <table class="table table-hover" width="100%">
                        <thead>
                            <tr>
                                <th style="width:5%">No</th>
                                <th style="width:25%">Nama Laporan</th>
                                <th style="width:10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td style="vertical-align:middle;">Laporan Kas Masuk</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="#lap_kasmasuk" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td style="vertical-align:middle;">Laporan Kas Keluar</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="#lap_kaskeluar" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td style="vertical-align:middle;">Laporan Bank Masuk</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="#lap_bankmasuk" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td style="vertical-align:middle;">Laporan Bank Keluar</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="#lap_bankkeluar" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">5</th>
                                <td style="vertical-align:middle;">Cetak Ulang Transaksi Kas</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="#cetakulangkas" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">6</th>
                                <td style="vertical-align:middle;">Cetak Ulang Transaksi Bank</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="#cetakulangbank" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="lap_neraca" class="modal fade" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
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
<div id="lap_rulab" class="modal fade" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
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
<div id="lap_rulab_bulanan" class="modal fade" data-backdrop-limit="1" tabindex="" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
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
<div id="lap_bukubantu" class="modal fade" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
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
<div id="lap_bukubantu_perkiraan" class="modal fade" data-backdrop-limit="1" tabindex="" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Tanggal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="<?= site_url('laporan/bukubantuP') ?>" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Akun Perkiraan</label>
                        <div class="col-xs-9">
                            <select name="akun_jurnal" class="select2 form-control custom-select" style="width: 100%; height:24px;">
                                <option>Pilih Akun</option>
                                <?php foreach ($perkiraan as $key => $value) {
                                ?>
                                    <option value="<?php echo $value->akun; ?>"><?php echo $value->akun . " - " . $value->nama; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <label class="control-label col-xs-3">Dari Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_dari" id="datepicker-bukubantuP1" value="<?= date("Y-m-d") ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <label class="control-label col-xs-3">Sampai Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_sampai" id="datepicker-bukubantuP2" value="<?= date("Y-m-d") ?>">
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
<div id="lap_penjualan_harian" class="modal fade" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Tanggal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="<?= site_url('laporan/penjualan_harian') ?>" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Dari Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_dari" id="datepicker-penjharian1" value="<?= date("Y-m-d") ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <label class="control-label col-xs-3">Sampai Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_sampai" id="datepicker-penjharian2" value="<?= date("Y-m-d") ?>">
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

<div id="lap_penjualan_perpelanggan" class="modal fade" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Tanggal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="<?= site_url('laporan/penjualan_perpelanggan') ?>" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Dari Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_dari" id="datepicker-perpelanggan1" value="<?= date("Y-m-d") ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <label class="control-label col-xs-3">Sampai Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_sampai" id="datepicker-perpelanggan2" value="<?= date("Y-m-d") ?>">
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

<div id="lap_penjualan_pelanggan" class="modal fade" data-backdrop-limit="1" tabindex="" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Pelanggan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="<?= site_url('laporan/penjualan_pelanggan') ?>" target="_blank">
                <div class="modal-body">
                    <!-- <div class="form-group"> -->
                    <label class="control-label col-xs-3">Pelanggan</label>
                    <div class="col-xs-9">
                        <select name="n_pelanggan" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                            <option>Select</option>
                            <?php foreach ($d_pelanggan as $key => $value) {
                            ?>
                                <option value="<?php echo $value->n_pelanggan; ?>"><?php echo $value->nama; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <label class="control-label col-xs-3">Dari Tanggal</label>
                    <div class="col-xs-9">
                        <div class="input-group">
                            <input type="text" class="form-control datepicker" name="tgl_dari" id="datepicker-penjpelanggan1" value="<?= date("Y-m-d") ?>">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <label class="control-label col-xs-3">Sampai Tanggal</label>
                    <div class="col-xs-9">
                        <div class="input-group">
                            <input type="text" class="form-control datepicker" name="tgl_sampai" id="datepicker-penjpelanggan2" value="<?= date("Y-m-d") ?>">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                </div>

                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> Tutup</button>
                    <button class="btn btn-success"><span class="fa fa-print"></span> Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="lap_kasmasuk" class="modal fade" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Tanggal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="<?= site_url('laporan/kasmasuk') ?>" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Dari Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_dari" id="datepicker-kasmasuk1" value="<?= date("Y-m-d") ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <label class="control-label col-xs-3">Sampai Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_sampai" id="datepicker-kasmasuk2" value="<?= date("Y-m-d") ?>">
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
<div id="lap_kaskeluar" class="modal fade" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Tanggal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="<?= site_url('laporan/kaskeluar') ?>" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Dari Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_dari" id="datepicker-kaskeluar1" value="<?= date("Y-m-d") ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <label class="control-label col-xs-3">Sampai Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_sampai" id="datepicker-kaskeluar2" value="<?= date("Y-m-d") ?>">
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
<div id="lap_bankmasuk" class="modal fade" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Tanggal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="<?= site_url('laporan/bankmasuk') ?>" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Dari Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_dari" id="datepicker-bankmasuk1" value="<?= date("Y-m-d") ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <label class="control-label col-xs-3">Sampai Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_sampai" id="datepicker-bankmasuk2" value="<?= date("Y-m-d") ?>">
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
<div id="lap_bankkeluar" class="modal fade" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Tanggal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="<?= site_url('laporan/bankkeluar') ?>" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Dari Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_dari" id="datepicker-bankkeluar1" value="<?= date("Y-m-d") ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <label class="control-label col-xs-3">Sampai Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_sampai" id="datepicker-bankkeluar2" value="<?= date("Y-m-d") ?>">
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
<div id="lap_pembelian_harian" class="modal fade" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Tanggal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="<?= site_url('laporan/pembelian_harian') ?>" target="_blank">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-xs-3">Dari Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_dari" id="datepicker-pembharian1" value="<?= date("Y-m-d") ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <label class="control-label col-xs-3">Sampai Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_sampai" id="datepicker-pembharian2" value="<?= date("Y-m-d") ?>">
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
<div id="lap_pembelian_perpemasok" class="modal fade" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Tanggal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="<?= site_url('laporan/pembelian_perpemasok') ?>" target="_blank">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-xs-3">Dari Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_dari" id="datepicker-perpemasok1" value="<?= date("Y-m-d") ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <label class="control-label col-xs-3">Sampai Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_sampai" id="datepicker-perpemasok2" value="<?= date("Y-m-d") ?>">
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

<div id="lap_pembelian_pemasok" class="modal fade" data-backdrop-limit="1" tabindex="" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Pemasok</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="<?= site_url('laporan/pembelian_pemasok') ?>" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Pemasok</label>
                        <div class="col-xs-9">
                            <select name="n_pemasok" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                <option>Select</option>
                                <?php foreach ($d_pemasok as $key => $value) {
                                ?>
                                    <option value="<?php echo $value->n_pemasok; ?>"><?php echo $value->nama; ?></option>
                                <?php } ?>
                            </select>
                            <label class="control-label col-xs-3">Dari Tanggal</label>
                            <div class="col-xs-9">
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" name="tgl_dari" id="datepicker-pembpemasok1" value="<?= date("Y-m-d") ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <label class="control-label col-xs-3">Sampai Tanggal</label>
                            <div class="col-xs-9">
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" name="tgl_sampai" id="datepicker-pembpemasok2" value="<?= date("Y-m-d") ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
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
<div id="lap_bestbuy" class="modal fade" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Tanggal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="<?= site_url('laporan/bestbuy') ?>" target="_blank">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-xs-3">Dari Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_dari" id="datepicker-bestbuy1" value="<?= date("Y-m-d") ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <label class="control-label col-xs-3">Sampai Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_sampai" id="datepicker-bestbuy2" value="<?= date("Y-m-d") ?>">
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
<div id="lap_barangmasuk" class="modal fade" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Tanggal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="<?= site_url('laporan/barangmasuk') ?>" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Dari Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_dari" id="datepicker-barangmasuk1" value="<?= date("Y-m-d") ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <label class="control-label col-xs-3">Sampai Tanggal</label>
                        <div class="col-xs-9">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" name="tgl_sampai" id="datepicker-barangmasuk2" value="<?= date("Y-m-d") ?>">
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

<div id="cetakulangkas" class="modal fade" data-backdrop-limit="1" tabindex="" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Transaksi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="<?= site_url('kasBank/cetak_ulangkas') ?>" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Daftar Transaksi Kas</label>
                        <div class="col-xs-9">
                            <select name="transkas" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                <option>Pilih Transaksi</option>
                                <?php foreach ($datatranskas as $key => $value) {
                                ?>
                                    <option value="<?php echo $value->n_kasbank; ?>"><?php echo $value->n_jurnal . ' - ' . $value->keterangan; ?></option>
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

<div id="cetakulangbank" class="modal fade" data-backdrop-limit="1" tabindex="" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Transaksi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="<?= site_url('kasBank/cetak_ulangbank') ?>" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Daftar Transaksi Bank</label>
                        <div class="col-xs-9">
                            <select name="transbank" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                <option>Pilih Transaksi</option>
                                <?php foreach ($datatransbank as $key => $value) {
                                ?>
                                    <option value="<?php echo $value->n_kasbank; ?>"><?php echo $value->n_jurnal . ' - ' . $value->keterangan; ?></option>
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
<?php $this->load->view('template/bundle/template_scripts'); ?>