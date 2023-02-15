<div class="card">
    <div class="card-body">
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
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/penjualan/harian') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td style="vertical-align:middle;">Laporan Penjualan per Pelanggan</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/penjualan/penjualan_perpelanggan') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td style="vertical-align:middle;">Laporan Penjualan per Pelanggan dengan Detail</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/penjualan/penjualan_pelanggan') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td style="vertical-align:middle;">Laporan Best Buy</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/penjualan/bestbuy') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $this->load->view('template/bundle/template_scripts'); ?>