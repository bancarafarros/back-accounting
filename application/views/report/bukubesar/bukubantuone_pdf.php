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
            <h4 class="font-weight-bolder text-bold text-uppercase">BUKU BANTU TIAP PERKIRAAN</h4>
            <h5>Akun : <b><?= $akun->nama ?></b></h5>
            <h5>Periode : <b><?= $tgl_dari ?></b> Sampai <b><?= $tgl_sampai ?></b></h5>
        </div>
        <div id="laporan">
            <table border="none" align="center" style="width:700px;margin-bottom:20px;">
                <?php
                $saldo_awal = 0;
                foreach ($saldoawal as $s) {
                    $saldo_awal =  $s['debet'] - $s['kredit']; ?>
                    <tr style="border-top: 1px solid;" class="bg-success text-white">
                        <td width="15%" align="center">Tanggal</td>
                        <td width="10%" align="center">Nomor Jurnal</td>
                        <td width="25%" align="center">Keterangan</td>
                        <td width="10%" align="center">No. Referensi</td>
                        <td width="12%" align="center">Debet</td>
                        <td width="12%" align="center">Kredit</td>
                        <td width="16%" align="center">Saldo</td>
                    </tr>
                    <tr style="border-bottom: 1px solid;">
                        <td colspan="5"></td>
                        <td width="10%" align="center" style="text-align:right;color:red;">Saldo Awal</td>
                        <td width="12%" style="text-align:right;color:red;"><b><?= currencyIDR($saldo_awal) ?></b></td>
                    </tr>
                    <?php }
                $urut = 0;
                $nomor = 0;
                $totaldebet = 0;
                $totalkredit = 0;
                $saldo = 0;
                $group = '-';
                foreach ($result as $d) {
                    $nomor++;
                    $urut++;
                    $tglj = strtotime($d['tanggal_jurnal']);
                    $tanggaljur = $this->tanggalindo->konversi($d['tanggal_jurnal']);
                    $debet = $d['debet_jurnal'];
                    $kredit = $d['kredit_jurnal'];
                    $namaakun = $d['nama_akun'];
                    $totaldebet += $d['debet_jurnal'];
                    $totalkredit += $d['kredit_jurnal'];
                    $saldo = $totaldebet - $totalkredit + $saldo_awal;

                    if ($group == '-' || $group != $d['akun_jurnal']) {
                    ?>
                        <tr style="padding: 1rem;">
                            <td style="text-align:center; font-size: 10px !important;" width="15%"><?= $tanggaljur ?></td>
                            <td style="text-align:left;padding-right: 10px;" width="10%"><?= $d['njurnal'] ?></td>
                            <td style="text-align:left;" width="25%"><?= $d['ket'] ?></td>
                            <td style="text-align:center;" width="10%"><?= $d['reff'] ?></td>
                            <td style="text-align:right;" width="12%"><?= currencyIDR($debet) ?></td>
                            <td style="text-align:right;" width="12%"><?= currencyIDR($kredit) ?></td>
                            <td style="text-align:right;" width="16%"><?= currencyIDR($saldo) ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                <tr>
                    <td colspan="7"></td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td width="10%" style="text-align:right;"><b>Total:</b></td>
                    <td width="10%" style="text-align:right;border-top: 1px solid;"><b><?= currencyIDR($totaldebet) ?></b>
                    </td>
                    <td width="10%" style="text-align:right;border-top: 1px solid;"><b><?= currencyIDR($totalkredit) ?></b>
                    </td>
                    <td width="12%" style="border-top: 1px solid;"></td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td width="10%" style="text-align:right;color:blue;">Mutasi</td>
                    <td width="10%" style="text-align:right;color:blue;"><b><?= currencyIDR(($totaldebet - $totalkredit)) ?></b>
                    </td>
                    <td width="12%"></td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td width="10%" style="text-align:right;color:red;">Saldo Akhir</td>
                    <td width="10%" style="text-align:right;color:red;"><b><?= currencyIDR(($totaldebet - $totalkredit + $saldo_awal)) ?></b>
                    </td>
                </tr>
            </table>
        </div>
        <?php $this->load->view('template/pdf/footer'); ?>
    </div>
</body>

</html>