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
    $jenis = getJenisTransaksiAccounting(substr($data['n_penjualan'], 0, 2));
    ?>
    <div class="mt-0">
        <h4 class="text-center font-weight-bolder text-bold text-uppercase">BUKTI TRANSAKSI <?= $jenis ?></h4>
        <div id="laporan">
            <table border="0" align="center" style="width:100%;border:none;">
                <tr>
                    <td style="width:500px;padding-left:20px; padding-top:5px;" align="right">
                        <h3>No. <?= $data['n_penjualan'] ?></h3>
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
                    <td width="40%" style="text-align:left;" class="text-medium">: <?= $data['n_penjualan'] ?></td>
                    <th width="15%" style="text-align:left;" class="text-medium"><b>Nama Pelanggan</b></th>
                    <td width="25%" style="text-align:left;" class="text-medium">: <?= $data['namapelanggan'] ?></td>
                </tr>
                <tr>
                    <th width="20%" style="text-align:left;" class="text-medium"><b>Keterangan</b></th>
                    <td width="40%" style="text-align:left;" class="text-medium">: <?= $data['keterangan'] ?></td>
                    <th width="15%" style="text-align:left;" class="text-medium">Reff</th>
                    <td width="25%" style="text-align:left;" class="text-medium">: <?= $data['reff'] ?></td>
                </tr>
                <tr>
                </tr>
            </table>
            <table border="1" rules="all" class="mt-3" align="center" style="width:100%;">
                <thead>
                    <tr class="bg-success">
                        <th class="text-white" style="text-align:center;height:50px;">No</th>
                        <th class="text-white">Nama Barang</th>
                        <th class="text-white">Satuan</th>
                        <th class="text-white">Harga Jual</th>
                        <th class="text-white">Qty</th>
                        <th class="text-white">Diskon</th>
                        <th class="text-white">SubTotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totDiskon = 0;
                    $no = 0;
                    foreach ($datas as $i) {
                        $no++;
                        $totDiskon += ($i['harganya'] - $i['hargad']);
                        $nabar = $i['nama_barang'];
                        $satuan = $i['sat'];

                        $harjul = $i['harganya'];
                        $qty = $i['jumlahnya'];

                        $diskon = $i['diskon'];
                        $total = $i['hargad'] * $i['jumlahnya'];
                    ?>
                        <tr>
                            <td style="text-align:center;"><?= $no ?></td>
                            <td style="text-align:left;"><?= $nabar ?></td>
                            <td style="text-align:center;"><?= $satuan ?></td>
                            <td style="text-align:right;"><?= currencyIDR($harjul) ?></td>
                            <td style="text-align:center;"><?= $qty; ?></td>
                            <td style="text-align:center;"><?= number_format($diskon) . ' %'; ?></td>
                            <td style="text-align:right;"><?= currencyIDR($total) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" style="text-align:right;"><b>Total</b></td>
                        <td style="text-align:right;"><b><?= currencyIDR($data['total_penjualan']) ?></b></td>
                    </tr>
                </tfoot>
            </table>
            <table align="center" style="width:100%; border:none;margin-top:5px;margin-bottom:20px;">
                <tr>
                    <td colspan="5"></td>
                    <td style="padding-left:10%;"><b>Biaya Kirim</b></td>
                    <td style="text-align:right; padding-right:5px;"><?= currencyIDR($data['biaya_kirim']) ?></td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td style="padding-left:10%;"><b>PPN</b></td>
                    <td style="text-align:right; padding-right:5px;"><?= currencyIDR($data['ppn']) ?></td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td style="padding-left:10%;"><b>Total Seluruhnya</b></td>
                    <td style="text-align:right; border-top:1px dashed; padding-right:5px;">
                        <?php
                        $totalAll = $data['biaya_kirim'] + $data['ppn'] + $data['total_penjualan'];
                        echo currencyIDR($totalAll); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td style="padding-left:10%;"><b>Jumlah Bayar</b></td>
                    <td style="text-align:right; padding-right:5px;">
                        <?php
                        $totalByr = $totalAll - $data['piutang'];
                        echo currencyIDR($totalByr); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td style="padding-left:10%;"><b>Sisa Bayar</b></td>
                    <td style="text-align:right; padding-right:5px; border-top:1px dashed;"><?php echo currencyIDR($data['piutang']); ?>
                    </td>
                </tr>
            </table>
        </div>
        <?php $this->load->view('template/pdf/footer'); ?>
    </div>
</body>

</html>