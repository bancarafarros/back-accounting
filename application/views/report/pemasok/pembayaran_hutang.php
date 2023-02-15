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
                <div class="row d-flex justify-content-center">
                    <div class="col-sm-6">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control datepicker nottyping" id="tanggal-dari" placeholder="Tanggal" aria-label="Tanggal" value="<?= $tanggal ?>">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control datepicker nottyping" id="tanggal-sampai" placeholder="Tanggal" aria-label="Tanggal" value="<?= $tanggal ?>">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-8">
                        <button type="button" class="btn btn-success" onclick="carifilter()"><i class="fa fa-search"></i> Tampilkan</button>
                    </div>
                    <div class="col-sm-4">
                        <a id="link-cetak" href="<?= site_url('report/pemasok/pembayaran_hutang_pdf?tgl_awal=' . $tanggal . '&tgl_akhir=' . $tanggal) ?>" target="_blank" role="button" class="btn btn-success"><i class="fa fa-print"></i> Cetak</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-0">
            <h4 class="text-center font-weight-bolder text-bold text-uppercase">Laporan Pembayaran Hutang</h4>
            <p class="text-center">Periode: <b id="tanggal-awal"><?= $tanggal_indo ?></b> - <b id="tanggal-akhir"><?= $tanggal_indo ?></b></p>
            <div>
                <table id="pembayaran-hutang" class="table table-bordered">
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var tanggal = "<?= $tanggal ?>";
</script>
<?php $this->load->view('template/bundle/template_scripts'); ?>