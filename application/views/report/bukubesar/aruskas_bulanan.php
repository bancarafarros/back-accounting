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
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <input type="text" class="form-control datepicker-ym" id="filterym" placeholder="Tanggal" aria-label="Tanggal" value="<?= $bulan ?>" readonly>
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <button type="button" class="btn btn-success" onclick="carifilter()"><i class="fa fa-search"></i> Tampilkan</button>
            </div>
        </div>
        <div class="mt-0">
            <h4 class="text-center font-weight-bolder text-bold text-uppercase">ARUS KAS BULANAN</h4>
            <p class="text-center">Bulan : <b id="per-bulan"><?= $bulan_indo ?></b></p>
            <div id="laporan">
                <table style="width:100%;">
                    <tr class="bg-success">
                        <th></th>
                        <th class="text-white" style="text-align:left;">GRUP</th>
                        <th class="text-white" style="text-align:left;">PERKIRAAN</th>
                        <th class="text-white" style="text-align:right;">SALDO</th>
                    </tr>
                    <tr valign="top">
                        <th colspan="4">Pendapatan</th>
                    </tr>
                </table>
                <div id="container-pendapatan"></div>
                <table>
                    <tr valign="top">
                        <th colspan="4">HPP</th>
                    </tr>
                </table>
                <div id="container-hpp"></div>
                <table>
                    <tr valign="top">
                        <th colspan="4">BIAYA</th>
                    </tr>
                </table>
                <div id="container-biaya"></div>
                <table>
                    <tr style="border-bottom: 1px solid;text-align:right;">
                        <td colspan="3" style="text-align:right;"><b>Total Arus Kas: </b><b id="total-laba"></b></td>
                    </tr>
                </table>
                <div style="text-align: right;" id="total-laba"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var bulan = "<?= $bulan ?>";
</script>
<?php $this->load->view('template/bundle/template_scripts'); ?>