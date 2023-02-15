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
                        <td style="vertical-align:middle;">Buku Besar</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/bukubesar') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td style="vertical-align:middle;">Kas & Bank</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/kasbank') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    <tr>
                        <th scope="row">3</th>
                        <td style="vertical-align:middle;">Penjualan</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/penjualan') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td style="vertical-align:middle;">Pembelian</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/pembelian') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">5</th>
                        <td style="vertical-align:middle;">Pelanggan</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/pelanggan') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">6</th>
                        <td style="vertical-align:middle;">Pemasok</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/pemasok') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">7</th>
                        <td style="vertical-align:middle;">Persediaan</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/persediaan') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $this->load->view('template/bundle/template_scripts'); ?>