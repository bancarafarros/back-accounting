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
            <h4 class="font-weight-bolder text-bold text-uppercase">LAPORAN BEST BUY</h4>
            <h5>Periode : <b><?= $tgl_dari ?></b> Sampai <b><?= $tgl_sampai ?></b></h5>
        </div>
        <div id="laporan">
            <table border="1" align="center" style="width:650px;margin-bottom:20px;">
                <thead>
                    <tr style="background-color:#ccc;">
                        <th style="text-align:center;">Frekuensi</th>
                        <th style="text-align:left;">Kode Barang</th>
                        <th style="text-align:left;">Nama Barang</th>
                        <th style="text-align:center;">Jual</th>
                        <th style="text-align:center;">Satuan</th>
                        <th style="text-align:center;">Total Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    $grandtotal = 0;
                    foreach ($result as $key => $value) {
                        $total = $value->keluar * $value->hargakm;
                        $grandtotal += $total;
                    ?>
                        <tr>
                            <td style="text-align:center;"><b><?= $value->frekuensi . " X" ?></b></td>
                            <td style="text-align:left;"><?= $value->n_barang ?></td>
                            <td style="text-align:left;"><?= $value->nama_barang ?></td>
                            <td style="text-align:center;"><?= $value->keluar ?></td>
                            <td style="text-align:center;"><?= $value->satuankm ?></td>
                            <td style="text-align:right;"><?= 'Rp ' . number_format($total) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tr>
                    <td colspan="5" style="text-align:right;"><b>Grand Total :</b></td>
                    <td style="text-align:right;"><b><?= 'Rp ' . number_format($grandtotal) ?></b></td>
                </tr>
            </table>
        </div>
        <?php $this->load->view('template/pdf/footer'); ?>
    </div>
</body>

</html>