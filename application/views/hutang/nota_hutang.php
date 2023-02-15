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
    $jenis = getJenisTransaksiAccounting(substr($data['n_pembelian'], 0, 2));
    ?>
    <div class="mt-0">
        <h4 class="text-center font-weight-bolder text-bold text-uppercase">BUKTI TRANSAKSI <?= $jenis ?></h4>
        <div id="laporan">
            <table border="0" align="center" style="width:100%;border:none;">
                <tr>
                    <td style="width:500px;padding-left:20px; padding-top:5px;" align="right">
                        <h3>No. <?= $data['n_pembelian'] ?></h3>
                    </td>
                </tr>
            </table>
            <table border="0" align="center" style="width:100%;border:none; border-top:1px dashed;">
                <tr>
                    <th width="20%" style="text-align:left;" class="text-medium"><b>Jenis Transaksi</b></th>
                    <td width="40%" style="text-align:left;" class="text-medium">: <?= $jenis ?></td>
                    <th width="15%" style="text-align:left;"><b>Tanggal</b></th>
                    <td width="25%" style="text-align:left;">: <?= $data['tanggal_indo'] ?></td>
                </tr>
                <tr>
                    <th width="20%" style="text-align:left;" class="text-medium"><b>Nomor Transaksi</b></th>
                    <td width="40%" style="text-align:left;" class="text-medium">: <?= $data['n_pembelian'] ?></td>
                    <th width="15%" style="text-align:left;" class="text-medium"><b>Jatuh Tempo</b></th>
                    <td width="25%" style="text-align:left;" class="text-medium">: <?= $data['tempo_indo'] ?></td>
                </tr>
                <tr>
                    <th width="20%" style="text-align:left;" class="text-medium"><b>Nama Pemasok</b></th>
                    <td width="40%" style="text-align:left;" class="text-medium">: <?= $data['pemasok'] ?></td>
                    <th width="15%" style="text-align:left;" class="text-medium">Reff</th>
                    <td width="25%" style="text-align:left;" class="text-medium">: <?= $data['reff'] ?></td>
                </tr>
                <tr>
                    <th width="20%" style="text-align:left;" class="text-medium"><b>Keterangan</b></th>
                    <td width="40%" style="text-align:left;" class="text-medium">: <?= $data['keterangan'] ?></td>
                </tr>
            </table>
            <table border="1" rules="all" class="mt-3" align="center" style="width:100%;">
                <tr style="border-bottom:1px solid;">
                    <td style="text-align:left; font-size:16px;height:40px"><b>Jumlah Hutang</b></td>
                    <td style="text-align:left; font-size:16px;">: <b><i><?= currencyIDR($data['jumlah']) ?></i></b></td>
                </tr>
            </table>
        </div>
        <?php $this->load->view('template/pdf/footer'); ?>
    </div>
</body>

</html>