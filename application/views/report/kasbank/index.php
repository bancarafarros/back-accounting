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
                        <td style="vertical-align:middle;">Laporan Kas Masuk</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/kasbank/kasmasuk') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td style="vertical-align:middle;">Laporan Kas Keluar</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/kasbank/kaskeluar') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td style="vertical-align:middle;">Laporan Bank Masuk</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/kasbank/bankmasuk') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td style="vertical-align:middle;">Laporan Bank Keluar</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="<?= site_url('report/kasbank/bankkeluar') ?>"><span class="fa fa-search"></span> Lihat</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $this->load->view('template/bundle/template_scripts'); ?>