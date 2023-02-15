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
                        <td style="vertical-align:middle;">Laporan Daftar Barang</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/persediaan/daftar_barang') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td style="vertical-align:middle;">Laporan Persediaan Barang</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/persediaan/persediaan_barang') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                    <!-- <tr>
                        <th scope="row">3</th>
                        <td style="vertical-align:middle;">Laporan Persediaan Barang Per Grup</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/persediaan/persediaan_barang_grup') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td style="vertical-align:middle;">Laporan Persediaan Barang Per Departemen</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/persediaan/persediaan_barang_departement') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr> -->
                    <tr>
                        <th scope="row">3</th>
                        <td style="vertical-align:middle;">Laporan Perbandingan Harga</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/persediaan/perbandingan_harga') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                    <!-- <tr>
                        <th scope="row">6</th>
                        <td style="vertical-align:middle;">Laporan Harian Costing</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/persediaan/harian_costing') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">7</th>
                        <td style="vertical-align:middle;">Laporan Harian Assembling</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/persediaan/persediaanassembling') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr> -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $this->load->view('template/bundle/template_scripts'); ?>