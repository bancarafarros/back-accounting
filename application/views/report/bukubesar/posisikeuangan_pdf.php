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
            <h4 class="font-weight-bolder text-bold text-uppercase">POSISI KEUANGAN</h4>
            <h5>Per : <b><?= $tanggal ?></b></h5>
        </div>
        <div id="laporan">
            <table style="width:100%;">
                <tr>
                    <th colspan="2" width="50%" style="text-align:left;">AKTIVA</th>
                    <th colspan="2" width="50%" style="text-align:right;">PASIVA</th>
                </tr>
                <tr valign="top">
                    <td colspan="2">
                        <table border="0" style="width:100%">
                            <thead>
                                <tr class="bg-success">
                                    <th class="text-white" style="text-align:left;"><?= $aktiva['subgrup'] ?></th>
                                    <th class="text-white" style="text-align:right;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ttlaktiva = 0;
                                foreach ($aktivas as $value) {
                                    $debet = number_format($value['t_debeta']);
                                    $kredit = number_format($value['t_kredita']);

                                    $nilai = $value['t_debeta'] - $value['t_kredita'];
                                    $ttlaktiva += $value['t_debeta'] - $value['t_kredita'];
                                ?>
                                    <tr>
                                        <td style="text-align:left;"><?= $value['nama'] ?></td>
                                        <td style="text-align:right;"><?= currencyIDR($nilai); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </td>
                    <td colspan="2" width="50%">
                        <table border="0" style="width:100%;">
                            <thead>
                                <tr class="bg-success">
                                    <th class="text-white" style="text-align:left;"><?= $pasiva_h['subgrup'] ?></th>
                                    <th class="text-white" style="text-align:right;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ttlpasivah = 0;
                                foreach ($pasiva_hs as $value) {
                                    $debet = number_format($value['t_debetp']);
                                    $kredit = number_format($value['t_kreditp']);

                                    $nilai = ($value['t_kreditp']) - ($value['t_debetp']);
                                    $ttlpasivah += ($value['t_kreditp']) - ($value['t_debetp']);
                                ?>
                                    <tr>
                                        <td style="text-align:left;"><?= $value['nama'] ?></td>
                                        <td style="text-align:right;"><?= currencyIDR($nilai); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <table border="0" style="width:100%;">
                            <thead>
                                <tr class="bg-success">
                                    <th class="text-white" style="text-align:left;"><?= $pasiva_m['subgrup'] ?></th>
                                    <th class="text-white" style="text-align:right;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ttlpasivam = 0;
                                foreach ($pasiva_ms as $value) {
                                    $debet = number_format($value['t_debetm']);
                                    $kredit = number_format($value['t_kreditm']);

                                    $nilai = ($value['t_kreditm']) - ($value['t_debetm']);
                                    $ttlpasivam += ($value['t_kreditm']) - ($value['t_debetm']);
                                ?>
                                    <tr>
                                        <td style="text-align:left;"><?= $value['nama'] ?></td>
                                        <td style="text-align:right;"><?= currencyIDR($nilai); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <table border="0" style="width:100%;">
                            <thead>
                                <tr>
                                    <th class="text-white" style="text-align:left;"></th>
                                    <th class="text-white" style="text-align:right;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ttlpend = 0;
                                foreach ($pendapatan as $key => $p) {
                                    $nilai =  ($p->t_kreditp) - ($p->t_debetp);
                                    $ttlpend += ($p->t_kreditp) - ($p->t_debetp);
                                }
                                ?>

                                <?php
                                $ttlhpp = 0;
                                foreach ($hpp as $key => $b) {
                                    $nilai = ($b->t_debetb) - ($b->t_kreditb);
                                    $ttlhpp += ($b->t_debetb) - ($b->t_kreditb);
                                }
                                ?>

                                <?php
                                $ttlbiaya = 0;
                                foreach ($biaya as $key => $b) {
                                    $nilai = ($b->t_debetb) - ($b->t_kreditb);
                                    $ttlbiaya += ($b->t_debetb) - ($b->t_kreditb);
                                }
                                ?>
                                <tr>
                                    <td style="text-align:left;"><?= $coa_laba['nama'] ?></td>
                                    <td style="text-align:right;"><?= currencyIDR(($ttlpend - $ttlhpp - $ttlbiaya)); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr class="bg-success">
                    <td class="text-medium text-white" style="text-align: center;"><b>Total Aktiva</b></td>
                    <td class="text-white text-medium" style="text-align: right;"><b><?= currencyIDR($ttlaktiva); ?></b></td>
                    <td class="text-medium text-white" style="text-align: center;"><b>Total Pasiva</b></td>
                    <td class="text-white text-medium" style="text-align: right;"><b><?= currencyIDR(($ttlpasivah + $ttlpasivam + ($ttlpend - $ttlhpp - $ttlbiaya))) ?></b></td>
                </tr>
            </table>
        </div>
        <?php $this->load->view('template/pdf/footer'); ?>
    </div>
</body>

</html>