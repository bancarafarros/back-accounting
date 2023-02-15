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
    <style>
        td {
            font-size: 11px !important;
        }
    </style>
</head>

<body>
    <?php $this->load->view('template/pdf/header'); ?>
    <div class="mt-0">
        <div style="text-align:center;">
            <h4 class="font-weight-bolder text-bold text-uppercase">BUKU BANTU SELURUH PERKIRAAN</h4>
            <h5>Periode : <b><?= $tgl_dari ?></b> Sampai <b><?= $tgl_sampai ?></b></h5>
        </div>
        <div id="laporan">
            <?php
            $urut = 0;
            $nomor = 0;
            $totaldebet = 0;
            $totalkredit = 0;
            $group = '-';
            foreach ($result as $d) {
                $nomor++;
                $urut++;
                $tanggaljur = $this->tanggalindo->konversi($d['tanggal_jurnal']);
                $debet = $d['debet_jurnal'];
                $kredit = $d['kredit_jurnal'];
                $noakun = $d['akun_jurnal'];
                $namaakun = $d['nama_akun'];
                $totaldebet += $d['debet_jurnal'];
                $totalkredit += $d['kredit_jurnal'];
                if ($group == '-' || $group != $d['akun_jurnal']) { ?>
                    <br>
                    <table border="none" align="center" style="width:700px;border-top:1px solid;">
                        <tr style="border-top:1px solid;">
                            <td><b>Nomor Akun</b></td>
                            <td colspan="2" style="text-align:left;">:<b><?= $noakun ?></b></td>
                            <td style="text-align:right;"><b>Nama Akun</b></td>
                            <td colspan="2" style="text-align:left;">:<b><?= $namaakun ?></b></td>
                        </tr>
                        <tr style="border-bottom:1px solid;" class="bg-success text-light">
                            <td width="20%" align="center">Tanggal</td>
                            <td width="10%" align="center">Nomor Jurnal</td>
                            <td width="25%" align="center">Keterangan</td>
                            <td width="10%" align="center">No. Referensi</td>
                            <td width="20%" align="center">Debet</td>
                            <td width="20%" align="center">Kredit</td>
                        </tr>
                    <?php
                    $nomor = 1;
                }
                $group = $d['akun_jurnal'];
                if ($urut == 500) {
                    $nomor = 0;
                    echo "<div class='pagebreak'> </div>";
                }
                    ?>
                    <tr>
                        <td style="text-align:center;"><?= $tanggaljur ?></td>
                        <td style="text-align:left;padding-right: 5px;"><?= $d['njurnal'] ?></td>
                        <td style="text-align:left;"><?= $d['ket'] ?></td>
                        <td style="text-align:center;"><?= $d['reff'] ?></td>
                        <td style="text-align:right;"><?= currencyIDR($debet) ?></td>
                        <td style="text-align:right;"><?= currencyIDR($kredit) ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="6"></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td width="10%" style="text-align:right;border-top: 1px solid;">Total</td>
                    <td width="15%" style="text-align:right;border-top: 1px solid;"><b><?= currencyIDR($totaldebet) ?></b>
                    </td>
                    <td width="15%" style="text-align:right;border-top: 1px solid;"><b><?= currencyIDR($totalkredit) ?></b>
                    </td>
                </tr>
                <table></table>
        </div>
        <?php $this->load->view('template/pdf/footer'); ?>
    </div>
</body>

</html>