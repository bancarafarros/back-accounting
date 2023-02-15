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
                    <input type="text" class="form-control datepicker" id="filterym" placeholder="Tanggal" aria-label="Tanggal" value="<?= $tanggal ?>" readonly>
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-8">
                        <button type="button" class="btn btn-success" onclick="carifilter()"><i class="fa fa-search"></i> Tampilkan</button>
                    </div>
                    <div class="col-sm-4">
                        <a id="link-cetak" href="<?= site_url('report/bukubesar/pdfposisikeuangan/' . $tanggal) ?>" target="_blank" role="button" class="btn btn-success"><i class="fa fa-print"></i> Cetak</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-0">
            <h4 class="text-center font-weight-bolder text-bold text-uppercase">POSISI KEUANGAN</h4>
            <p class="text-center">Per Tanggal: <b id="per-tanggal"><?= $tanggal_indo ?></b></p>
            <div id="laporan">
                <table style="width:100%;">
                    <tr>
                        <th colspan="2" width="50%" style="text-align:left;">AKTIVA</th>
                        <th colspan="2" width="50%" style="text-align:right;">PASIVA</th>
                    </tr>
                    <tr valign="top">
                        <td colspan="2">
                            <table border="0" style="width:100%">
                                <!-- <thead>
                                    <tr class="bg-success">
                                        <th class="text-white" style="text-align:left;"><span id="aktiva-sub"></span></th>
                                        <th class="text-white" style="text-align:right;"></th>
                                    </tr>
                                </thead> -->
                            </table>
                            <div id="container-aktiva"></div>
                        </td>
                        <td colspan="2" width="50%">
                            <table border="0" style="width:100%;">
                                <!-- <thead>
                                    <tr class="bg-success">
                                        <th class="text-white" style="text-align:left;"><span id="pasivah-sub"></span></th>
                                        <th class="text-white" style="text-align:right;"></th>
                                    </tr>
                                </thead> -->
                            </table>
                            <div id="container-pasivah"></div>
                            <table border="0" style="width:100%;">
                                <!-- <thead>
                                    <tr class="bg-success">
                                        <th class="text-white" style="text-align:left;"><span id="pasivam-sub"></span></th>
                                        <th class="text-white" style="text-align:right;"></th>
                                    </tr>
                                </thead> -->
                            </table>
                            <div id="container-pasivam"></div>
                            <table border="0" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th class="text-white" style="text-align:left;"></th>
                                        <th class="text-white" style="text-align:right;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width:10%;"></td>
                                        <td style="text-align:left;"><span id="coa_laba"></span></td>
                                        <td style="text-align:right;"><span id="total-laba"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr class="bg-success">
                        <td class="text-medium text-white" style="text-align: center;"><b>Total Aktiva</b></td>
                        <td class="text-white text-medium" style="text-align: right;"><b id="total-aktiva"></b></td>
                        <td class="text-medium text-white" style="text-align: center;"><b>Total Pasiva</b></td>
                        <td class="text-white text-medium" style="text-align: right;"><b id="total-pasiva"></b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var tanggal = "<?= $tanggal ?>";
</script>
<?php $this->load->view('template/bundle/template_scripts'); ?>