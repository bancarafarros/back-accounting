<!DOCTYPE html>
<html lang="in">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= FCPATH . 'public/icon-itsk.png' ?>">
    <title><?= (!empty($judul_title) ? $judul_title : 'Dokumen') ?></title>
    <link rel="stylesheet" href="<?= FCPATH . 'public/lib/bootstrap/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="<?= FCPATH . 'public/css/pdf.css'; ?>">
</head>

<body>
    <?php $this->load->view('template/pdf/header'); ?>
    <div class="mt-0">
        <div style="text-align:center;">
            <h4 class="font-weight-bolder text-bold text-uppercase">LAPORAN PENJUALAN PER PELANGGAN</h4>
            <h5>Periode : <b><?= $tgl_dari ?></b> Sampai <b><?= $tgl_sampai ?></b></h5>
        </div>
        <div id="laporan">
            <table border="1" align="center" style="width:650px;margin-bottom:20px;">
                <thead>
                    <tr style="background-color:#ccc;">
                        <th style="text-align:left;">No.</th>
                        <th style="text-align:center;">Kode</th>
                        <th style="text-align:center;">Nama</th>
                        <th style="text-align:center;">Penjualan</th>
                        <th style="text-align:center;">PPN</th>
                        <th style="text-align:center;">Biaya Kirim</th>
                        <th style="text-align:center;">Total</th>
                        <th style="text-align:center;">Bayar</th>
                        <th style="text-align:center;">Piutang</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    $total = 0;
                    $bayar = 0;
                    $totalpenjualan = 0;
                    $totalppn = 0;
                    $totalbiaya = 0;
                    $totaltotal = 0;
                    $totalbayar = 0;
                    $totalpiutang = 0;
                    foreach ($result as $key => $value) {
                        $no++;
                        $total = $value->total_penjualan + $value->ppn + $value->biaya_kirim;
                        $bayar = $value->total_penjualan - $value->piutang;
                        $totalpenjualan += $value->total_penjualan;
                        $totalppn += $value->ppn;
                        $totalbiaya += $value->biaya_kirim;
                        $totaltotal += $total;
                        $totalbayar += $bayar;
                        $totalpiutang += $value->piutang;
                    ?>
                        <tr>
                            <td style="text-align:left;"><?= $no ?></td>
                            <td style="text-align:left;"><?= $value->npelanggan ?></td>
                            <td style="text-align:left;"><?= $value->namapelanggan ?></td>
                            <td style="text-align:right;"><?= number_format($value->total_penjualan) ?></td>
                            <td style="text-align:right;"><?= number_format($value->ppn) ?></td>
                            <td style="text-align:right;"><?= number_format($value->biaya_kirim) ?></td>
                            <td style="text-align:right;"><?= number_format($total) ?></td>
                            <td style="text-align:right;"><?= number_format($bayar) ?></td>
                            <td style="text-align:right;"><?= number_format($value->piutang) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align:right;"><b>Grand Total</b></td>
                        <td style="text-align:right;"><b><?php echo number_format($totalpenjualan); ?></b></td>
                        <td style="text-align:right;"><b><?php echo number_format($totalppn); ?></b></td>
                        <td style="text-align:right;"><b><?php echo number_format($totalbiaya); ?></b></td>
                        <td style="text-align:right;"><b><?php echo number_format($totaltotal); ?></b></td>
                        <td style="text-align:right;"><b><?php echo number_format($totalbayar); ?></b></td>
                        <td style="text-align:right;"><b><?php echo number_format($totalpiutang); ?></b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php $this->load->view('template/pdf/footer'); ?>
    </div>
</body>

</html>