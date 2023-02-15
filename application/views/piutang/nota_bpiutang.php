<!DOCTYPE html>
<html lang="in">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= FCPATH . 'public/icon-itsk.png' ?>">
    <title><?= (!empty($judul_title) ? $judul_title : null) ?></title>
    <link rel="stylesheet" href="<?php echo FCPATH . 'public/lib/bootstrap/css/bootstrap.min.css'; ?>">
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
            font-size: 12pt;
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
</head>

<body>
    <?php $this->load->view('template/pdf/header'); ?>
    <?php
    $tanggal = $data['tanggal_indo'];
    $jenis = getJenisTransaksiAccounting(substr($data['n_piutang'], 0, 2));
    ?>
    <div class="mt-0">
        <h4 class="text-center font-weight-bolder text-bold text-uppercase">BUKTI TRANSAKSI <?= $jenis ?></h4>
        <div id="laporan">
            <table border="0" align="center" style="width:100%;border:none;">
                <tr>
                    <td style="width:500px;padding-left:20px; padding-top:5px;" align="right">
                        <h3>No. <?= $data['n_piutang'] ?></h3>
                    </td>
                </tr>
            </table>
            <table border="0" align="center" style="width:100%;border:none; border-top:1px dashed;">
                <tr>
                    <th width="20%" style="text-align:left;" class="text-medium"><b>Jenis Transaksi</b></th>
                    <td width="40%" style="text-align:left;" class="text-medium">: <?= $jenis ?> <small>(<?= $data['n_piutang'] ?>)</small></td>
                    <th width="15%" style="text-align:left;"><b>Tanggal</b></th>
                    <td width="25%" style="text-align:left;">: <?= $data['tanggal_indo'] ?></td>
                </tr>
                <tr>
                    <th width="20%" style="text-align:left;" class="text-medium"><b>Nama Pelanggan</b></th>
                    <td width="40%" style="text-align:left;" class="text-medium">: <?= $data['pelanggan'] ?></td>
                    <th width="15%" style="text-align:left;" class="text-medium">Cara Bayar</th>
                    <td width="25%" style="text-align:left;" class="text-medium">: <?= $data['cara_bayar'] ?></td>
                </tr>
                <tr>
                    <th width="20%" style="text-align:left;" class="text-medium"><b>Keterangan</b></th>
                    <td width="40%" style="text-align:left;" class="text-medium">: <?= $data['keterangan'] ?></td>
                    <?php if ($data['cara_bayar'] != 'kas') : ?>
                        <th width="15%" style="text-align:left;"><b>Nama Bank</b></th>
                        <td width="25%" style="text-align:left;">: <?= strtoupper($data['nbank']) ?></td>
                    <?php endif; ?>
                </tr>
            </table>
            <table border="1" rules="all" class="mt-3" align="center" style="width:100%;">
                <thead>
                    <tr class="bg-success">
                        <th class="text-white" style="text-align:center;height:50px;">No</th>
                        <th class="text-white">No Transaksi</th>
                        <th class="text-white">Keterangan</th>
                        <th class="text-white" style="text-align:right;">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    $no = 0;
                    foreach ($datas as $i) {
                        $no++;
                        $total += $i['bayar'];
                    ?>
                        <tr>
                            <td style="text-align:center;"><?= $no ?></td>
                            <td style="text-align:left;"><?= $i['n_jual'] ?></td>
                            <td style="text-align:left;"><?= $i['ketrpiutang'] ?></td>
                            <td style="text-align:right;"><?= currencyIDR($i['bayar']) ?></td>
                        <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align:right;"><b>Total Pembayaran</b></td>
                        <td style="text-align:right;"><b><?= currencyIDR($total) ?></b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php $this->load->view('template/pdf/footer'); ?>
    </div>
</body>

</html>