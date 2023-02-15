<style>
    @page {
        margin-top: 10px;
        margin-bottom: 10px;
        font-size: 8pt;
    }

    .font-weight-bolder {
        font-weight: bold;
        font-size: large;
        color: black;
    }

    .text {
        font-size: 11pt;
        color: black;
    }

    .bg-dark-blue {
        background-color: #1c14c4;
    }

    .title-head {
        font-size: 13px;
        color: white;
    }

    .text-bold {
        font-weight: bold;
        color: black;
    }

    .w-3 {
        width: 33%;
        float: left;
    }

    .w-4 {
        width: 45%;
        float: left;
    }

    .w-5 {
        width: 50%;
        float: left;
    }

    .w-6 {
        width: 55%;
        float: left;
    }

    .text-medium {
        font-size: 12pt !important;
        color: black;
    }

    .text-large {
        font-size: 14pt !important;
        color: black;
    }

    .m-end {
        margin-left: 20px;
    }

    #laporan {
        font-size: 10pt !important;
    }

    .text-white {
        color: #fff;
    }

    .text-small {
        font-size: 8pt;
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control datepicker nottyping" id="filterym" placeholder="Tanggal" aria-label="Tanggal" value="<?= $tanggal ?>">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    <!-- <div class="col-sm-6">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control datepicker" id="tanggal-sampai" placeholder="Tanggal" aria-label="Tanggal" value="<?= $tanggal ?>">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div> -->
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-8">
                        <button type="button" class="btn btn-success" onclick="carifilter()"><i class="fa fa-search"></i> Tampilkan</button>
                    </div>
                    <div class="col-sm-4">
                        <!-- <a id="link-cetak" href="<?= site_url('report/bukubesar/pdf_bukubantuall?tglawal=' . $tanggal . '&tglakhir=' . $tanggal) ?>" target="_blank" role="button" class="btn btn-success"><i class="fa fa-print"></i> Cetak</a> -->
                        <a id="link-cetak" href="<?= site_url('report/pelanggan/pdf_daftar_pelanggan/' . $tanggal) ?>" target="_blank" role="button" class="btn btn-success"><i class="fa fa-print"></i> Cetak</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-0">
            <h4 class="text-center font-weight-bolder text-bold text-uppercase">LAPORAN DAFTAR PELANGGAN</h4>
            <!-- <p class="text-center">Periode: <b id="tanggal-awal"><?= $tanggal_indo ?></b> - <b id="tanggal-akhir"><?= $tanggal_indo ?></b></p> -->
            <p class="text-center">Per Tanggal: <b id="per-tanggal"><?= $tanggal_indo ?></b></p>
            <div id="laporan">
                <div id="container-data"></div>

                <!-- <table align="center" style="width:100%">
                    <tr class="bg-success">
                        <th class="text-white" style="text-align:center">NO</th>
                        <th class="text-white" style="text-align:center">Kode Pelanggan</th>
                        <th class="text-white" style="text-align:center">Nama Pelanggan</th>
                        <th class="text-white" style="text-align:center">Tanggal Registrasi</th>
                        <th class="text-white" style="text-align:center">Alamat</th>
                        <th class="text-white" style="text-align:center">Telepon</th>
                        <th class="text-white" style="text-align:center">Batas Kredit</th>
                        <th class="text-white" style="text-align:center">Sales</th>
                    </tr>

                    <?php
                    $s = 0;
                    foreach ($d_pelanggan as $key => $value) {
                        $s++;
                        $bataskredit = number_format($value->batas);
                        $tgl = strtotime($value->tanggal);
                        $tanggal = date('d-M-Y', $tgl);
                        if ($value->n_akun == "") {
                            $warn = 'class="bg-danger text-light"';
                        } else {
                            $warn = '';
                        }
                    ?>
                    <tr>
                        <td style="text-align:center;"><?= $s ?></td>
                        <td style="text-align:center;"><?= $value->n_pelanggan ?></td>
                        <td style="text-align:center;"><?= $value->nama ?></td>
                        <td style="text-align:center;"><?= $value->tanggal ?></td>
                        <td style="text-align:center;"><?= $value->alamat ?></td>
                        <td style="text-align:center;"><?= $value->telepon ?></td>
                        <td style="text-align:center;"><?php echo "Rp " . $bataskredit;?></td>
                        <td style="text-align:center;"><?= $value->nama_sales ?></td>
                    </tr>
                    <?php } ?>
                </table> -->

            </div>
        </div>
    </div>
</div>
<script>
    var tanggal = "<?= $tanggal ?>";
</script>
<?php $this->load->view('template/bundle/template_scripts'); ?>