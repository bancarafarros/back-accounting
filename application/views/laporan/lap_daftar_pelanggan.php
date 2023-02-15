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

<body onload="window.print()">
    <?php $this->load->view('template/pdf/header'); ?>
    <div class="mt-0">
        <div style="text-align:center;">
            <h4 class="font-weight-bolder text-bold text-uppercase">LAPORAN DAFTAR PELANGGAN</h4>
            <h5>Per : <b><?= $tanggal ?></b></h5>
        </div>
        <div id="laporan">
            <table style="width:100%;">
                <tr valign="top">
                    <td colspan="2">
                        <table style="width:100%;" class="table table-bordered">
                            <thead>
                                <tr class="bg-success">
                                    <th style="text-align:center;">No</th>
                                    <th style="text-align:center;">Kode Pelanggan</th>
                                    <th style="text-align:center;">Nama Pelanggan</th>
                                    <th style="text-align:center;">Tanggal Registrasi</th>
                                    <th style="text-align:center;">Alamat</th>
                                    <th style="text-align:center;">Telepon</th>
                                    <th style="text-align:center;">Batas Kredit</th>
                                    <th style="text-align:center;">Sales</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($data as $key => $value) {
                                    $no++;
                                    $bataskredit = number_format($value->batas);
                                    $conv_date = strtotime($value->tanggal);
                                    $tanggal = date('d-M-Y', $conv_date);
                                ?>
                                    <tr>
                                        <td style="text-align:center;"><?= $no ?></td>
                                        <td style="text-align:left;"><?= $value->n_pelanggan ?></td>
                                        <td style="text-align:left;"><?= $value->nama ?></td>
                                        <td style="text-align:left;"><?= $tanggal ?></td>
                                        <td style="text-align:left;"><?= $value->alamat ?></td>
                                        <td style="text-align:left;"><?= $value->telepon ?></td>
                                        <td style="text-align:right;"><?php echo "Rp " . $bataskredit; ?></td>
                                        <td style="text-align:left;"><?= $value->nama_sales ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </td>
            </table>
        </div>
        <?php $this->load->view('template/pdf/footer'); ?>
    </div>
</body>

</html>